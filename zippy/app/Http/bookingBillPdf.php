<?php
use Illuminate\Support\Facades\Input;

class bookingBillPdf extends FPDF {

    public function init() {
        $this->SetTitle('PDF');
        $this->AliasNbPages();
        $this->SetFont('Arial','',7);
        $this->SetFillColor(200,220,255);
        $this->SetTextColor(31, 31, 31);
    }

    public function set_text( $y, $x, $text ) {
        $this->Sety($y);
        $this->SetX($x);
        $this->Cell(0, 0, $text, 0, 0);
    }

    public function back_image( $image ){
        $this->AddPage('L');
        $this->Image( public_path(). '/pdf/'. $image ,0,0, 300);
    }

    public function set_font() {
        $this->SetFont('Arial','',10);
        $this->SetFillColor(200,220,255);
        $this->SetTextColor(31, 31, 31);
    }

    public function _to_array($date) {
        $date = str_replace('-', '', $date);
        return str_split($date);
    }

    public function checked($x, $y) {
        $this->Image( public_path(). '/uploads/pdfs/check.jpg' , $y, $x, 3);
    }

    public function render($inputs) {

        $this->back_image('1.png');
        $this->set_text(22, 94, '22-08-1992');
        $text = 'hello all thiis is my text for world wrap.hello all thiis is my text for world wrap.';

        $this->multi_line_text(20, 130, $text, 47, 4);
        $this->multi_line_text(20, 184, $text, 47, 4);

        $this->multi_line_text(20, 239, $text, 40, 4);

        $this->multi_line_text(44, 83, 'hello all thiis is my text for world', 47, 4);
        $this->multi_line_text(44, 138, 'hello all thiis is my text for world', 47, 4);

        $this->set_text(47.5, 218, 'Actual');
        $this->set_text(47.5, 268, 'Valumet');

        $this->set_text(64, 35, 'Name');
        $this->set_text(67, 35, 'Email');
        $this->set_text(71, 35, 'Mobile Number');
        $this->set_text(82, 55, 'phone');

        $this->set_text(64, 120, 'Name');
        $this->set_text(67, 120, 'Email');
        $this->set_text(71, 120, 'Mobile Number');
        $this->set_text(75, 120, 'Address');
        $this->set_text(82, 150, 'phone');

        $this->set_text(98, 53, 'consingnor');
        $this->set_text(107, 53, 'consingnor');
        $this->set_text(116, 50, 'Eway bill');

        $this->set_text(106.5, 130, 'Receiver Name');
        $this->set_text(116.5, 110, '22-08-2018');
        $this->set_text(116.2, 153, 'stamp');

        $this->set_text(185, 40, 'Sender Signature');
        $this->set_text(185, 126, '22-01-2018');
        $this->set_text(185, 180, '02:20');
        //paid Aamount
        $this->set_text(70, 235, 'DKT Charge');
        $this->set_text(80, 235, 'Freight');
        $this->set_text(90, 235, 'Service Charge');
        $this->set_text(100, 235, 'FOV');
        $this->set_text(110, 235, 'Cod Fod');
        $this->set_text(120, 235, 'Misc');
        $this->set_text(130, 235, 'Sub total');        
        //FOD Aamount
        $this->set_text(70, 262, 'DKT Charge');
        $this->set_text(80, 262, 'Freight');
        $this->set_text(90, 262, 'Service Charge');
        $this->set_text(100, 262, 'FOV');
        $this->set_text(110, 262, 'Cod Fod');
        $this->set_text(120, 262, 'Misc');
        $this->set_text(130, 262, 'Sub total');
        //Grand Total
        $this->set_text(142, 262, 'Grand total');
        //Amount in world
        $this->set_text(152, 218, 'Amount in world');

        $this->set_text(162.4, 214, 'Insured');

        $this->set_text(172.8, 215, 'Declared');

        $this->set_text(182.8, 215, 'Invoice Number');


    }

    public function multi_line_text($y, $x, $text, $width, $height)
    {
        $this->Sety($y);
        $this->SetX($x);

        $this->MultiCell($width, $height, $text, 0);
    }
    
}

