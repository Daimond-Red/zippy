<?php
require_once 'fpdf.php';


class bookingBillPdf extends FPDF {

    public function init() {

        define('FPDF_FONTPATH', dirname(__DIR__).'/media/font');

        $this->SetTitle('PDF');
        $this->AliasNbPages();
        $this->SetFont('Arial','',7);
        $this->SetFillColor(200,220,255);
        $this->SetTextColor(31, 31, 31);
    }

    public function set_text( $y, $x, $text, $fontSize = 7 ) {
        $this->set_font($fontSize);
        $this->Sety($y);
        $this->SetX($x);
        $this->Cell(0, 0, $text, 0, 0);
    }

    public function _sign( $attrs, $field, $x, $y, $w, $h = 0 ){
        if( isset($attrs[$field]) && $attrs[$field] ) {
            $decodedImg = base64_decode( $attrs[$field] );
            if( $decodedImg!==false ) {
                $imagePath = public_path(). '/uploads/tmp/'.$field. time(). '.png';
                if( file_put_contents($imagePath,$decodedImg)!==false ) {
                    try {
                        $this->Image( $imagePath, $x, $y, $w, $h,'png');
                        //  Delete image from server
                        unlink($imagePath);
                    } catch (Exception $e) {
                        $this->_sign_jpg($attrs, $field, $x, $y, $w, $h);
                    }
                }
            }
        }
    }

    public function _sign_jpg( $attrs, $field, $x, $y, $w, $h = 0 ){
        if( isset($attrs[$field]) && $attrs[$field] ) {
            $decodedImg = base64_decode( $attrs[$field] );
            if( $decodedImg!==false ) {
                $imagePath = public_path(). '/uploads/tmp/'. $field. time(). '.jpg';
                if( file_put_contents($imagePath,$decodedImg)!==false ) {
                    try {
                        $this->Image( $imagePath, $x, $y, $w, $h);
                        //  Delete image from server
                        unlink($imagePath);
                    } catch (Exception $e) {

                    }
                }
            }
        }
    }

    public function back_image( $image ){
        $this->AddPage('L');

        $this->Image( dirname(__DIR__).'/media/images/'. $image ,0,0, 300);
    }

    public function set_font($size = 10) {
        $this->SetFont('Arial','', $size);
        $this->SetFillColor(200,220,255);
        $this->SetTextColor(31, 31, 31);
    }

    public function _to_array($date) {
        $date = str_replace('-', '', $date);
        return str_split($date);
    }

    // public function checked($x, $y) {
    //     $this->Image( public_path(). '/uploads/pdfs/check.jpg' , $y, $x, 3);
    // }

    public function render($inputs) {
        
        $this->back_image('6.png');

        $this->set_text(22, 94, date('d-m-Y', strtotime($inputs['dob'])), 10);
        $text = 'hello all thiis is my text for world wrap.hello all thiis is my text for world wrap.';

        $this->multi_line_text(19, 152, $inputs['origin'], 47, 4, 10);
        $this->multi_line_text(19, 218, $inputs['destination'], 47, 4, 10);

        $this->multi_line_text(19, 268, $inputs['econsignment'], 40, 4, 10);

        $this->multi_line_text(45, 92, $inputs['content'], 47, 4);
        $this->multi_line_text(45, 163, $inputs['package'], 47, 4);

        $this->set_text(46.5, 204, 'ACTUAL : '.$inputs['actual_weight']. ' TONNES');
        $this->set_text(46.5, 244, 'VOLUMETRIC : '.$inputs['volumetric_weight']);

        $this->set_text(65, 35, $inputs['consignor_name']);
        $this->set_text(69, 35, $inputs['consignor_company']);
        $this->set_text(73, 35, $inputs['consignor_mobile']);
        $this->multi_line_text(74.8, 35, $inputs['consignor_address'], 62, 5);
        $this->set_text(94.5, 57, $inputs['consignor_mobile']);

        $this->set_text(66, 120, $inputs['consignee_name']);
        $this->set_text(69, 120, $inputs['consignee_company']);
        $this->set_text(73, 120, $inputs['consignee_mobile']);
        $this->multi_line_text(75, 120, $inputs['consignee_address'], 67, 5);
        $this->set_text(94.6, 152, $inputs['consignee_phone']);

        // $this->multi_line_text(73, 35, $inputs[''], 64, 5);
        // $this->set_text(93.5, 57, $inputs['']);

        // $this->set_text(64, 120, $inputs['']);
        // $this->set_text(67, 120, $inputs['']);
        // $this->set_text(71, 120, $inputs['']);
        // $this->multi_line_text(74, 120, $inputs[''], 67, 5);
        // $this->set_text(93.8, 152, $inputs['']);

        /*$this->set_text(111, 72, $inputs['consignor_gst']);
        $this->set_text(119, 72, $inputs['consignee_gst']);
        $this->set_text(128, 72, $inputs['eway_bill']);*/

        // $this->set_text(64, 35, $inputs['consignor_name']);
        // $this->set_text(67, 35, $inputs['consignor_email']);
        // $this->set_text(71, 35, $inputs['consignor_mobile']);
        // $this->set_text(75, 16, 'Address');
        // $this->multi_line_text(73, 35, $inputs['consignor_address'], 64, 5);
        

        // $this->set_text(64, 120, $inputs['consignee_name']);
        // $this->set_text(67, 120, $inputs['consignee_email']);
        // $this->set_text(71, 120, $inputs['consignee_mobile']);
        // $this->multi_line_text(74, 120, $inputs['consignee_address'], 67, 5);
        

        $this->set_text(111.3, 52, $inputs['consignor_gst']);
        $this->set_text(120.6, 52, $inputs['consignee_gst']);
        $this->set_text(129.8, 52, $inputs['eway_bill']);

        $this->set_text(120.8, 130, '');
        $this->set_text(130.8, 110, '');
        $this->set_text(130.8, 153, '');

        // $this->set_text(185, 40, 'Sender Signature');
        $this->_sign($inputs, 'sender_sign', 20, 170, 7);
        
        $this->set_text(183, 58, date('d-m-Y', strtotime($inputs['send_date'])));
        // $this->set_text(185, 180, $inputs['send_time']);
        //paid Aamount
        $this->set_text(70, 235, $inputs['dkt_paid']); // $inputs['dkt_paid']
        $this->set_text(80, 235, $inputs['freight_paid']); // $inputs['freight_paid']
        $this->set_text(90, 235, $inputs['service_paid']); // $inputs['service_paid']
        $this->set_text(100, 235, $inputs['fov_paid']); // $inputs['fov_paid']
        $this->set_text(110, 235, $inputs['cod_paid']); // $inputs['cod_paid']
        // $this->set_text(120, 235, ''); // $inputs['misc_paid']
        $this->set_text(120, 235, $inputs['paid_igst']); // igst      
        $this->set_text(130, 235, $inputs['misc_paid']); // $inputs['subtotal_paid']  
        //FOD Aamount
        $this->set_text(70, 262, $inputs['dkt_fod']); // $inputs['dkt_fod']
        $this->set_text(80, 262, $inputs['freight_fod']); // $inputs['freight_fod']
        $this->set_text(90, 262, $inputs['service_fod']); // $inputs['service_fod']
        $this->set_text(100, 262, $inputs['fov_fod']); // $inputs['fov_fod']
        $this->set_text(110, 262, $inputs['cod_fod']); // $inputs['cod_fod']
        // $this->set_text(120, 262, ''); // $inputs['misc_fod']
        $this->set_text(120, 262, $inputs['fod_igst']); // igst
        $this->set_text(130, 262, $inputs['misc_fod']); // $inputs['subtotal_fod']
        //Grand Total
        $this->set_text(139, 235, $inputs['grandtotal_paid']); // $inputs['grandtotal_paid']
        //Amount in world
        $this->set_text(148, 219, $inputs['amount']); //$inputs['amount']

        $this->set_text(157.5, 214, $inputs['insured']);

        $this->set_text(167, 216, $inputs['declared_value']);
        // $this->set_text(165.8, 215, '');

        $this->set_text(176.4, 215, $inputs['invoice_no']);

    }

    public function multi_line_text($y, $x, $text, $width, $height, $fontSize = 7)
    {
        $this->set_font($fontSize);
        $this->Sety($y);
        $this->SetX($x);

        $this->MultiCell($width, $height, $text, 0);
    }
    
}

