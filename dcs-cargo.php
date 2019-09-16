<?php

require __DIR__.'/zippy/vendor/autoload.php';

require_once  __DIR__.'/media/bookingBillPdf.php';

$app = require_once __DIR__.'/zippy/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);


$booking = null;

if( $id = request('booking_id') ) {
	$booking = \App\Booking::findOrFail($id);
	$customer = $booking->customer;
	$vendor = $booking->vendor;
	
}

if( !$booking ) return;

if( request('sendEmail') ) {
	require_once 'email_template.php';

	$pdf = new bookingBillPdf();

	$inputs = get_inputs_data($booking, $customer);
	// dd($inputs);
	$inputs['econsignment'] = $id;
	$inputs['sender_sign'] = $booking->consignor_sign;
	// dd($inputs);
	$pdf->init();
	$pdf->render($inputs);

	if( request('isView') ) {
		$pdfdoc = $pdf->output();
		die;	
	}

	error_reporting(E_ALL);
    ini_set('display_errors', '1');

    // email stuff (change data below)
    // $to = "neuweg.shrikant@gmail.com";
    $to = $customer->email;//$customer->email;

    // $from = "onlineservice@cryoviva.com.in";
    $from = 'support@zippy.co.in';
    $subject = "e-Consignment Note";
    $message = template($customer);
    // a random hash will be necessary to send mixed content
    $separator = md5(time());

    // carriage return type (we use a PHP end of line constant)
    $eol = PHP_EOL;

    // attachment name
    $filename = "form.pdf";

    // encode data (puts attachment in proper format)
    $pdfdoc = $pdf->Output("", "S");
    $attachment = chunk_split( base64_encode($pdfdoc) );

    // main header
    $headers  = "From: ".$from.$eol;

	$headers  .= "Bcc: sharma08ankit@gmail.com,neuweg.shrikant@gmail.com".$eol;
    $headers  .= "Cc: zippycargo@gmail.com".$eol;

    $headers .= "MIME-Version: 1.0".$eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

    // no more headers after this, we start the body! //

    $body = "--".$separator.$eol;
    $body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
    // $body .= "This is a MIME encoded message.".$eol;

    // message
    $body .= "--".$separator.$eol;
    $body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
    $body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
    $body .= $message.$eol;

    // attachment
    $body .= "--".$separator.$eol;
    $body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
    $body .= "Content-Transfer-Encoding: base64".$eol;
    $body .= "Content-Disposition: attachment".$eol.$eol;
    $body .= $attachment.$eol;
    $body .= "--".$separator."--";

    // send message
    $status = mail($to, $subject, $body, $headers);


}

?>



<!DOCTYPE html>
<html lang="en">
<head>
<title>ZIPPY</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/png" href="zippy/public/assets/app/media/img//logos/fab_icon_zippy.png"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>

$(document).ready(function(){
	
	$(document).ajaxStart(function(){
        $(".loader, .overlay").css("display", "block");
    });
	
    $(document).ajaxComplete(function(){
		$(".loader").attr('src', 'success.gif');
		$(".loader, .overlay").css("display", "block");
		setTimeout(function(){ $('.overlay').hide(); },1500);
    });
	
	
 	$( "#sendEmail" ).click(function(event) {
		event.preventDefault();
		  var href = $(this).attr('href');
		  $.ajax({
			  url:href,
			  method:"POST",
			  success: function(data) {
				 $("body").html(data);
			  }
		});
	});
});
</script>


<style> 
       
        .loader{
			display:none;
			position: fixed;
			top: 50vh;
			left: 50vw;
			transform: translate(-50%, -50%);
		}
		
		.overlay{
			position:fixed;
			width:100%;
			height:100%;
			background:white;
			margin-top:-15px;
			display:none;
		}
	.notice {
		position: relative;
		padding-top: 40px;
	}
	.sign-area {
		position: absolute;
	    left: 25px;
		width: 45%;
		bottom: 20px;
	}
    @media screen and (max-width: 480px) {
		
		body{
			margin:1% 1% !important;
			font-size:16px !important;
		}
		div{
			width:98% !important ;
			margin-bottom:10px !important;
		}
		
		div div div{
			padding: 2px 4px !important;
		}
		
		.small-content{
			font-size:16px !important;
		}
		
		.small-note{
			font-size:14px !important; 
		}
	}
	
	
	
	@media print {
		
	    @page {size: landscape}
		
		  html, body {
			width: 270mm;
			font-size:12px;
		  }
	  
	  div{
		  background:white;
		  color:black !important;
	  }
	  
	    .consign{
			height:100px !important;
		}
		
		.consign div{
			margin-top:0 !important;
		}
		
		.notice{
			margin-top:0 !important;
			position: relative;
			padding-top: 30px;
		}
		.sign-area {
			position: absolute;
		    left: 25px;
			width: 45%;
			bottom: 18px;
		}
		span{
			font-size:10px !important;
		}
		
		.content{
			height:20px !important;
		}
		
		.receiver{
			height:36px !important;
		}
		
		table tr td{
			padding:11px;
		}
	 
	}
</style>
</head>


<body style="background:white; color:black; font-size:.8rem; font-family: sans-serif; line-height: 1.5; margin:0;">

<div class="overlay">
    <img class="loader" src="loader.gif"/>
</div>

	
<div style="margin:1% 1%;">
    <section style="overflow:hidden; width:100%">
	    <div style="float:left; width:25%">
		    <div>
		        <h2 style="margin:0;">
		        	<img src="http://zippy.co.in/zippy/public/assets/app/media/img//logos/logo.png" style="width: 20%">
		        </h2>
			    <span style="display:block; font-size:14px;"><strong>ZIPKART LOGISTICS PRIVATE LIMITED</strong></span>

			    <span  style="display:block; font-size:14px;">Corporate Office :</span>
			    <span  style="font-size:14px;">B-17, 11/56 Pal Mohan Plaza, Desh Bandhu</span>
				<span  style="font-size:14px;">Gupta Market , Karol Bagh, New Delhi - 110005</span>
				<span  style="display:block; font-size:14px;">Tel. : 41253414-15, Mobile. : 9811207128, 9311207128 </span>
				<span  style="display:block; font-size:14px;">E-mail : support@zippy.co.in, GSTIN : 07AAACD6795J2Z7</span>
			</div>
		</div>
		<div style="float:left; width:75%;">
		    <div style="overflow:hidden; width:100%;">
			    <div style="float:left; width:20%; margin-right:2%; ">
				    <div style="border:1px solid black; border-radius:5px">
					    <div style="text-align:center; font-weight:bold; font-size:14px;">DOB
						</div>
						<div style="text-align:center; padding:4%; height:50px;">
                            <?php echo getDateValue($booking->actual_booking_date);?>
						</div>
					</div>
				</div>
				<div style="float:left; width:15%; margin-right:2%;" >
				    <div style="border:1px solid black; border-radius:5px">
					    <div style="text-align:center; font-weight:bold; font-size:14px;">ORIGIN
						</div>
						<div class="small-content" style="text-align:center; padding:6%; height:50px;">
                            <?php echo \App\City::getCitiesNames($booking->pickup_city_id); ?>
						</div>
					</div>
				</div>
				<div style="float:left; width:15%; margin-right:2%;" >
				    <div style="border:1px solid black; border-radius:5px">
					    <div style="text-align:center; font-weight:bold; font-size:14px;">DESTINATION
						</div>
						<div class="small-content" style="text-align:center; padding:6%; height:50px;">
                            <?php echo \App\City::getCitiesNames($booking->drop_city_id); ?>
						</div>
					</div>
				</div>
				<div style="float:left; width:44%; ">
				    <div style="border:1px solid black; border-radius:5px">
					    <div style="text-align:center; font-weight:bold; font-size:14px;">e Consignment No
						</div>
						<div style="text-align:center; padding:2%; height:50px;">
						    <h4><?php echo $id; //echo $booking->air_way_bill; ?></h4>
						</div>
					</div>
				</div>
			</div>
			
			<div style="overflow:hidden; width:100%; margin-top:2%;">
			    <div style="float:left; width:25%; margin-right:2%; ">
				    <div style="border:1px solid black; border-radius:5px; text-align:center;">
					    <div style="text-align:center; font-weight:bold; font-size:14px;">CONTENTS
						</div>
						<div class="content" style="height:50px;">
							<?php echo $booking->content; ?>
						</div>
					</div>
				</div>
				<div style="float:left; width:27%; margin-right:2%;  ">
				    <div style="border:1px solid black; border-radius:5px; text-align:center;">
					    <div style="text-align:center; font-weight:bold; font-size:14px;">PACKAGES
						</div>
						<div class="content" style="height:50px;">
							<?php echo $booking->package; ?>
						</div>
					</div>
				</div>
				<div style="float:left; width:44%; ">
				    <div style="text-align:center; border:1px solid black;">
					    <div style="text-align:center; font-weight:bold; font-size:14px;">CHARGEABLE WEIGHT
						</div>
						<div>
						    <div style="overflow:hidden; width:100%;">
							    <div class="content"  style="float:left; width:49%; height:50px; border-right:1px solid black ">
								    ACTUAL: <?php echo $booking->actual_gross_weight; ?> TONNES
								</div>
								<div class="content" style="float:left; width:49%; height:50px;  ">
								    VOLUMETRIC: <?php echo $booking->volumetric_weight; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	
	
	<section style="overflow:hidden; width:100%; margin-top:1%;">
	    <div style="float:left; width:65%; margin-right:1%;">
		    <div style="overflow:hidden; width:100%;">
			    <div style="float:left; width:48%; margin-right:2%;" >
				    <div style="border:1px solid black; border-radius:5px;">
					    <div style="text-align:center; font-weight:bold; font-size:14px;">CONSIGNOR</div>
						<div class="consign"  style="padding:2%; height:190px;">
                                Name: <?php echo $booking->contact_person; ?>
                                <br>Company : <?php echo $booking->consignor_company; ?>
                                <br>Mobile No: <?php echo $booking->contact_person_no; ?>
                                <br>Address: <?php echo $booking->bill_pickup_address; ?>
							<div style="text-align:center; margin-top:50px;">PHONE: <?php echo $customer->mobile_no; ?></div>
						</div>
					</div>
				</div>
				<div style="float:left; width:50%;">
				    <div style="border:1px solid black; border-radius:5px;">
					    <div style="text-align:center; font-weight:bold; font-size:14px;">CONSIGNEE
						</div>
						<div class="consign" style="padding:2%; height:190px;">
                                Name: <?php echo $booking->consignee_name; ?>
                                <br>Company: <?php echo $booking->consignee_company; ?>
                                <br>Mobile No: <?php echo $booking->consignee_mobile_no; ?>
                                <br>Address: <?php echo $booking->bill_drop_address; ?>
							<div style="text-align:center; margin-top:50px;">PHONE: <?php echo $booking->consignee_mobile_no; ?></div>
						</div>
					</div>
				</div>
			</div>
			
			<div style="overflow:hidden; width:100%; margin-top:2%">
			    <div style="float:left; width:48%; margin-right:2%;" >
				    <div style="border:1px solid black; border-radius:5px; ">
						<div style="text-align:center; padding:2%;">CONSIGNOR'S GST NO
							: <?php echo $booking->consignor_gst ;?>
						</div>
					</div>
					 <div style="border:1px solid black; border-radius:5px; margin-top:2%;">
						<div style="text-align:center; padding:2%;">CONSIGNEE'S GST NO
							: <?php echo $booking->consignee_gst ;?>
						</div>
					</div>
					 <div style="border:1px solid black; border-radius:5px; margin-top:2%;">
						<div style="text-align:center; padding:2%;">EWAY BILL NO.
							: <?php echo $booking->eway_bill ;?>
						</div>
					</div>
				</div>
				<div style="float:left; width:50%;">
				    <div style="border:1px solid black; border-radius:5px; padding:1%;">
						<div>
						    <div class="receiver" style="height:50px;">YES, I/WE HAVE RECEIVED THE GOODS IN GOOD CONDITION</div>
							<div class="receiver" style="height:50px;">RECEIVER'S NAME</div>
							<div>
							    <span>Date : </span>
								<span style="margin-left:35%;">STAMP : </span>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div  style="overflow:hidden; width:100%; margin-top:2%">
			    <div style="float:left; width:63%; margin-right:2%;" >
					<div style="border:1px solid black; border-radius:5px; padding:1%;">
						<div>
							<div>
								<P  class="small-note" style="text-align:justify; font-size:12px;">
									<u>NOTE :</u>
									No GST shall be levied on the Freight costs as it comes under the Reverse charge as per the notification No.13/2017 dated 28/6/2017 of the GST Act.
	The Freight costs are inclusive of Toll charges but exclusive of parking/ labor charges.
	We accept only GST compliant materials /invoice.
	Zippy doesn't allow overloading or exceeding height limits of the vehicle.
	Loading and unloading of the vehicle shall be done by the consignor and /or consignee.
	Goods shall be delivered subject to payment realization.
	Penalty charged if any due to under-invoicing/overloading/exceeding heights etc shall be borne by the payee of the freights.
	Should you require any clarification please call Zippy Customer Care.
								</P>
							</div>
						</div>
						<div class="notice" style="">
							<span style="margin-right:10%;">Authorised Signatory</span>
							<span style="" class="sign-area">
								<?php if( isset($booking->consignor_sign) && $booking->consignor_sign ): ?>
									<img id="img_Sign" src="data:image/png;base64, <?php echo $booking->consignor_sign ?>" style="width: 20%; height: 20%">
								<?php else: ?>
									<img id="img_Sign" style="width:5%;" src="http://zippy.co.in/media/images/sign_new.png"/>
								<?php endif; ?>
							</span>
							<span style="margin-right:20%;">Date: <?php echo getDateValue(date('y-m-d'))?></span>
							
						</div>
					</div>
				</div>
				
				<div style="float:left; width:35%;" >
				    <div style="border:1px solid black; border-radius:5px; padding:1%;font-size:13px; line-height:17px;">
					    <p><strong>ZIPKART LOGISTICS PRIVATE LIMITED </strong></p>
						<p>ACCOUNT NO.<span> 600220110000751</span></p>
						<p>BANK OF INDIA </p>
						<p>BANK STREET BRANCH </p>
						<p>NEW DELHI 110005</p>
						<p>IFSC CODE BKID0006002</p>
					</div>
				</div>
			</div>
			
		</div>
		
    <!-- table section -->
		<div style="float:left; width:34%;">
		    <table style="width:100%; border-spacing:0;" border="1" cellpadding="13">
                <tr>
                    <th></th>
                    <th>PRE PAID (Rs.)</th> 
                    <th>TO PAY (Rs.)</th>
                </tr>
				<tr>
                    <td>DKT. Charges</td>
					<td><!-- <?php echo $booking->paid_dkt_charges; ?> --></td>
					<td><!-- <?php echo $booking->fod_dkt_charges; ?> --></td>
                </tr>
				<tr>
                    <td>Freight</td>
					<td><?php echo $booking->payment_type == 2 ? 'TO BE BILLED' : 0; ?></td>
					<td><?php echo $booking->payment_type == 3 ? 'TO BE BILLED' : 0; ?></td>
                </tr>
				<tr>
                    <td>Service Charges</td>
					<td><!-- <?php echo $booking->paid_service_charges; ?> --></td>
					<td><!-- <?php echo $booking->fod_service_charges; ?> --></td>
                </tr>
				<tr>
                    <td>CGST</td>
					<td><!-- <?php echo $booking->paid_fov; ?> --></td>
					<td><!-- <?php echo $booking->fod_fov; ?> --></td>
                </tr>
				<tr>
                    <td>SGST</td>
					<td><!-- <?php echo $booking->paid_cod; ?> --></td>
					<td><!-- <?php echo $booking->fod_cod; ?> --></td>
                </tr>
                <tr>
                    <td>IGST</td>
					<td><!-- <?php echo $booking->paid_igst ? $booking->paid_igst : 0; ?> --></td>
					<td><!-- <?php echo $booking->fod_igst ? $booking->fod_igst : 0; ?> --></td>
                </tr>
				<tr>
                    <td>Misc.</td>
					<td><!-- <?php echo $booking->paid_misc; ?> --></td>
					<td><!-- <?php echo $booking->fod_misc; ?> --></td>
                </tr>
				<tr>
                    <td><b>Grand Total</b></td>
					<!-- <td colspan="2">
						<?php echo $booking->paid_dkt_charges + $booking->paid_freight + $booking->paid_service_charges + $booking->paid_fov + $booking->paid_cod + $booking->paid_misc + $booking->fod_dkt_charges + $booking->fod_freight + $booking->fod_service_charges + $booking->fod_fov + $booking->fod_cod + $booking->fod_misc + $booking->paid_igst + $booking->fod_igst 
                                 ?>
					</td> -->
					<td colspan="2"></td>
                </tr>
				<tr>
                    <!-- <td colspan="3">Amount in Words : <?php echo getAmountToWord($booking->paid_dkt_charges + $booking->paid_freight + $booking->paid_service_charges + $booking->paid_fov + $booking->paid_cod + $booking->paid_misc + $booking->fod_dkt_charges + $booking->fod_freight + $booking->fod_service_charges + $booking->fod_fov + $booking->fod_cod + $booking->fod_misc + $booking->paid_igst + $booking->fod_igst ); ?>
                    	
                    	
                    </td> -->
                    <td colspan="3">Amount in Words :</td>
                </tr>
				<tr>
                    <td colspan="3">INSURED 
                    	<?php if( $booking->is_insured ): ?>
					    <span style="margin-left:10%;">YES</span>
					    <?php else: ?>
						<span style="margin-left:10%;">NO</span>
						<?php endif ?>
					</td>
                </tr>
				<tr>
                    <td colspan="3">Declared Value: <?php echo $booking->declared_value; ?></td>
                </tr>
				<tr>
                    <td colspan="3">Invoice No.: <?php echo $booking->invoice_no; ?></td>
                </tr>
            </table>
		</div>
	<!-- /table section -->
	
	    	
	</section>
	
	<div style="text-align:center; margin-top:2%;">
		<?php if(! request('showWendEmail') ): ?>
			<a id="sendEmail" style="color:black; text-decoration:none; border-radius:50px; border:1px solid black; padding:1% 6%; transition:all .5s;" href="http://zippy.co.in/dcs-cargo.php?booking_id=<?php echo $booking->id; ?>&showWendEmail=1&sendEmail=1">Mail e-Consignment Note</a>
		<?php else: ?>
			
		<?php endif; ?>
	</div>	
	
</div>
<br>
<br>

</body>
</html>
<?php 
		function get_inputs_data ($booking, $customer) {
			$inputs =  [];
			$inputs['dob'] = getDateValue($booking->actual_booking_date);
	        $inputs['origin'] = optional($booking->pickupCityRel)->title;
	        $inputs['destination'] = optional($booking->dropCityRel)->title;

	        $inputs['econsignment'] = $booking->air_way_bill;

	        $inputs['content'] = $booking->content;
	        $inputs['package'] = $booking->package;

	        $inputs['actual_weight'] = $booking->actual_gross_weight;
	        $inputs['volumetric_weight'] = $booking->volumetric_weight;

	        $inputs['consignor_name'] = $booking->contact_person;
	        $inputs['consignor_email'] = $booking->consignee_email;
	        $inputs['consignor_mobile'] = $booking->contact_person_no;

	        $inputs['consignor_address'] = $booking->bill_pickup_address;
	        $inputs['consignor_phone'] = $customer->contact_person_no;

	        $inputs['consignee_name'] = $booking->consignee_name;
	        $inputs['consignee_email'] = $booking->consignee_email;
	        $inputs['consignee_mobile'] = $booking->consignee_mobile_no;
	        $inputs['consignee_address'] = $booking->bill_drop_address;
	        $inputs['consignee_phone'] = $booking->consignee_mobile_no;

	        $inputs['consignor_gst'] = $booking->consignor_gst;
	        $inputs['consignee_gst'] = $booking->consignee_gst;
	        $inputs['eway_bill'] = $booking->eway_bill;

	        $inputs['consignee_company'] = $booking->consignee_company;
	        $inputs['consignor_company'] = $booking->consignor_company;
	         

	        $inputs['send_date'] = getDateValue(date('y-m-d'));
	        $inputs['send_time'] = '';       //paid Aamount
	        $inputs['dkt_paid'] = '';//$booking->paid_dkt_charges ? $booking->paid_dkt_charges : '';
	        $inputs['freight_paid'] = $booking->payment_type == 2 ? 'TO BE BILLED' : ''; // $booking->paid_freight;
	        $inputs['service_paid'] = ''; //$booking->paid_service_charges ? $booking->paid_service_charges : '';
	        $inputs['fov_paid'] = ''; //$booking->paid_fov ? $booking->paid_fov : '';
	       	$inputs['cod_paid'] = ''; //$booking->paid_cod ? $booking->paid_cod : '';
	        $inputs['misc_paid'] = ''; //$booking->paid_misc ? $booking->paid_misc : '';
	        $inputs['subtotal_paid'] = $booking->paid_dkt_charges + $booking->paid_freight + $booking->paid_service_charges + $booking->paid_fov + $booking->paid_cod + $booking->paid_misc;        
	        //FOD Aamount
	        $inputs['dkt_fod'] = ''; //$booking->fod_dkt_charges ? $booking->fod_dkt_charges : '';
	        $inputs['freight_fod'] = $booking->payment_type == 3 ? 'TO BE BILLED' : ''; // $booking->fod_freight;
	       	$inputs['service_fod'] = ''; //$booking->fod_service_charges ? $booking->fod_service_charges : '';
	        $inputs['fov_fod'] = ''; //$booking->fod_fov ? $booking->fod_fov : '';
	        $inputs['cod_fod'] = ''; //$booking->fod_cod ? $booking->fod_cod : '';
	       	$inputs['misc_fod'] = ''; //$booking->fod_misc ? $booking->fod_misc : '';
	       	$inputs['paid_igst'] = ''; //$booking->paid_igst ? $booking->paid_igst : '';
	       	$inputs['fod_igst'] = ''; //$booking->fod_igst ? $booking->fod_igst : '';
	        $inputs['subtotal_fod'] = $booking->fod_dkt_charges + $booking->fod_freight + $booking->fod_service_charges + $booking->fod_fov + $booking->fod_cod + $booking->fod_misc;
	        //Grand Total
	        $gt = $booking->paid_dkt_charges + $booking->paid_freight + $booking->paid_service_charges + $booking->paid_fov + $booking->paid_cod + $booking->paid_misc + $booking->fod_dkt_charges + $booking->fod_freight + $booking->fod_service_charges + $booking->fod_fov + $booking->fod_cod + $booking->fod_misc + $booking->paid_igst + $booking->fod_igst;
	        $inputs['grandtotal_paid'] = '';
	        //Amount in world
	        $inputs['amount'] = '';

	        $inputs['insured'] = $booking->is_insured ? 'Yes' : 'No';

	        $inputs['declared_value'] = $booking->declared_value;

	        $inputs['invoice_no'] = $booking->invoice_no;
	        return $inputs;
	    }


	    

?>
