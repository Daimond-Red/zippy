<?php

	

	// error_reporting(E_ALL);
	// ini_set('display_errors', 1);


	require_once './media/bookingBillPdf.php';
	// echo "Hello";die;
	# echo realpath(__DIR__.'/zippy/');die;
	
	$path = __DIR__. "/zippy/";

	require $path . 'vendor/autoload.php'; $app = require_once $path . 'bootstrap/app.php';

	$kernel = $app->make('Illuminate\Contracts\Http\Kernel');

	$response = $kernel->handle( $request = Illuminate\Http\Request::capture() );

	if(isset($_POST['submit'])){
		$pdf = new bookingBillPdf();
		
		$inputs = set_data($_POST);

		$pdf->init();
		$pdf->render($inputs);

		$path = 'media/pdfs/econsignment_'.time().'.pdf';
		$pdf->Output($path, 'F');

		try {
			\Mail::send('emails.notifications', array('msg' => 'Please see the attachment.'), function($message) use( $_POST, $path ) {

			   	$message
			           ->to($_POST['user_email'], 'Zippy Support')
			           ->subject('New Notification')->attach($path);

			});	

			header('Location: http://zippy.co.in/dcs-cargo-form.php?message="Mail Sent"');
		} catch(Exception $e) {
			// echo $e->getMessage();
		}

		
		
		// $pdf = new bookingBillPdf();

		// $inputs = set_data($_POST);
		// $pdf->init();
		// $pdf->render($inputs);

		// // email stuff (change data below)
		// $to = $inputs['user_email']; 
		// $from = "me@example.com"; 
		// $subject = "Booking Bill"; 
		// $message = "<p>Please see the attachment.</p>";
		// // print_r($to);die;
		// // a random hash will be necessary to send mixed content
		// $separator = md5(time());

		// // carriage return type (we use a PHP end of line constant)
		// $eol = PHP_EOL;

		// // attachment name
		// $filename = "econsignment.pdf";

		// // encode data (puts attachment in proper format)
		// $pdfdoc = $pdf->Output("", "S");
		// $attachment = chunk_split(base64_encode($pdfdoc));

		// // main header
		// $headers  = "From: ".$from.$eol;
		// $headers .= "MIME-Version: 1.0".$eol; 
		// $headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";
		// $headers .= 'Bcc: pleasefindphp@gmail.com\r\n';
		
		// // no more headers after this, we start the body! //

		// $body = "--".$separator.$eol;
		// $body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
		// $body .= "This is a MIME encoded message.".$eol;

		// // message
		// $body .= "--".$separator.$eol;
		// $body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
		// $body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
		// $body .= $message.$eol;

		// // attachment
		// $body .= "--".$separator.$eol;
		// $body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
		// $body .= "Content-Transfer-Encoding: base64".$eol;
		// $body .= "Content-Disposition: attachment".$eol.$eol;
		// $body .= $attachment.$eol;
		// $body .= "--".$separator."--";

		// // send message
		// if(mail($to, $subject, $body, $headers)) {
		// 	header('Location: http://zippy.co.in/dcs-cargo-form.php?message="Mail Sent"');
		// } else {
		// 	header('Location: http://zippy.co.in/dcs-cargo-form.php?message="Mail not Sent"');
		// }
		

		// echo "Hello<pre>"; print_r($data);die;
		// $dob = $_POST['dob'];
		// $origin = $_POST['origin'];
		// $destination = $_POST['destination'];
		// $econsignment = $_POST['econsignment'];

		// $content = $_POST['content'];
		// $package = $_POST['package'];
		// $actual_weight = $_POST['actual_weight'];
		// $volumetric_weight = $_POST['volumetric_weight'];

		// $consignor_name = $_POST['consignor_name'];
		// $consignor_email = $_POST['consignor_email'];
		// $consignor_mobile = $_POST['consignor_mobile'];
		// $consignor_address = $_POST['consignor_address'];
		// $consignor_phone = $_POST['consignor_phone'];

		// $consignee_name = $_POST['consignee_name'];
		// $consignee_email = $_POST['consignee_email'];
		// $consignee_mobile = $_POST['consignee_mobile'];
		// $consignee_address = $_POST['consignee_address'];
		// $consignee_phone = $_POST['consignee_phone'];

		// $consignor_gst = $_POST['consignor_gst'];
		// $consignee_gst = $_POST['consignee_gst'];
		// $eway_bill = $_POST['eway_bill'];

		// $send_date = $_POST['send_date'];
		// $send_time = $_POST['send_time'];
		// $user_email = $_POST['user_email'];

		// $dkt_paid = $_POST['dkt_paid'];
		// $dkt_fod = $_POST['dkt_fod'];

		// $freight_paid = $_POST['freight_paid'];
		// $freight_fod = $_POST['freight_fod'];

		// $service_paid = $_POST['service_paid'];
		// $service_fod = $_POST['service_fod'];

		// $fov_paid = $_POST['fov_paid'];
		// $fov_fod = $_POST['fov_fod'];

		// $cod_paid = $_POST['cod_paid'];
		// $cod_fod = $_POST['cod_fod'];

		// $misc_paid = $_POST['misc_paid'];
		// $misc_fod = $_POST['misc_fod'];

		// $subtotal_paid = $_POST['subtotal_paid'];
		// $subtotal_fod = $_POST['subtotal_fod'];

		// $grandtotal_paid = $_POST['grandtotal_paid'];

		// $insured = $_POST['insured'];
		// $declared_value = $_POST['declared_value'];
		// $invoice_no = $_POST['invoice_no'];

	}


	function set_data($data = []) {
		$res = [];

		foreach ($data as $key => $value) {
			if( !$value ) {
				$res[$key] = '';
			} else {
				$res[$key] = $value;
			}
		}		
		return $res;
	}
?>