<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');


require __DIR__.'/zippy/vendor/autoload.php';

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

$pickupData = getAddressFromGoogle(null, $booking->pickup_lat, $booking->pickup_lng);
$dropData = getAddressFromGoogle(null, $booking->drop_lat, $booking->drop_lng);

$customer = $booking->customer;
$vendor = $booking->vendor;

if( request('sendEmail') ) {

	$message = file_get_contents('http://zippy.co.in/invoice.php?booking_id='.$booking->id.'');

	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	// More headers
	$headers .= 'From: <info@zippy.co.in>' . "\r\n";

	$headers .= 'Bcc: pleasefindphp@gmail.com' . "\r\n";

  
    mail($customer->email, 'Zippy: Invoice #'.$booking->id, $message,$headers);

}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<title>Booking Invoice</title>
<style type="text/css">
    @media screen and (max-width: 480px) {
        table {
        width:100% !important;
		margin:0 !important;
        }
    }
	
    table {
    table-layout: fixed;
    width: 100%;
    }

    table td {
        word-wrap: break-word;       
        overflow-wrap: break-word;    
    }
</style>
</head>

<body style="font-family:'Titillium Web', sans-serif; background-color:white;">



    <table style="margin:2% 5%; width:90%; color:black; border:1px solid #c3c3c3; border-collapse: collapse;" cellpadding="0" cellspacing="0">
	    <tr style="border-bottom:1px solid #c3c3c3;">
		    <td colspan="2" style="padding:0% 5%;">
			    <img style="margin-bottom: -4px;"  src="http://zippy.co.in/media/images/logo.png" alt="weedneed logo" width="30%"/>
				<p><small>Invoice/Consignment note</small></p>
			</td>
			<td colspan="2" align="right" style="padding:0 5%;">
			    <h2>Fare Payable : <i class="fas fa-rupee-sign"></i> 855</h2>
			</td>
		</tr>
		<tr style="border-bottom:1px solid #c3c3c3;">
		    <td align="center" style="padding:1% 5%;">
			    <small style="color:gray;">Booking ID</small>
                <h4 style="margin-top:8px;"><?php echo $booking->id; ?></h4>
			</td>
			<td align="center" style="padding:1% 5%;">
			    <small style="color:gray;">Date</small>
                <h4 style="margin-top:8px;"><?php echo getDateValue($booking->pickup_date); ?></h4>
			</td>
			<td align="center" style="padding:1% 5%;">
			    <small style="color:gray;">Distance Travelled</small>
                <h4 style="margin-top:8px;"><?php echo $booking->total_distance; ?> km</h4>
			</td>
			<td align="center" style="padding:1% 5%;">
			    <small style="color:gray;">Time Duration</small>
                <h4 style="margin-top:8px;">5 hr</h4>				
			</td>
		</tr>
		<tr style="border-bottom:1px solid #c3c3c3;">
		    <td rowspan="3" style="padding:1% 5%">
			    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.261937742028!2d77.19279901468077!3d28.6518746824102!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x3ef7f308ba7dd99a!2sJanak+Positioning+%26+Surveying+Systems+Pvt+Limited!5e0!3m2!1sen!2sin!4v1533195877098" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
			</td>
			<td colspan="3" style="padding:1% 5%; font-size:16px; border-bottom:1px solid #c3c3c3;">
			    <i style="color:green; font-size:10px; margin-left:-15px; margin-right:5px;" class="fas fa-circle"></i> <small style="color:gray;">Pickup Location</small>
				<span style="display:block; margin-top:8px;"><?php echo $pickupData['state']; ?> , <?php echo getDateValue($booking->pickup_date, 'd/M/Y'); ?> <?php echo getDateValue($booking->pickup_time, 'g:i A'); ?></span>
				<span style="display:block; margin-top:8px;"><?php echo $booking->pickup_address; ?></span>
			</td>
		</tr>
		
		<tr>
			<td colspan="3" style="padding:1% 5%; font-size:16px; border-bottom:1px solid #c3c3c3;">
			    <i style="color:red; font-size:10px; margin-left:-15px; margin-right:5px;" class="fas fa-circle"></i> <small style="color:gray;">Dropoff Location</small>
				<span style="display:block; margin-top:8px;"><?php echo $dropData['state'] ?> , <?php echo getDateValue($booking->drop_date, 'd/M/Y'); ?>   <?php echo getDateValue($booking->drop_time, 'g:i A'); ?></span>
				<span style="display:block; margin-top:8px;"><?php echo $booking->drop_address; ?></span>
			</td>
		</tr>
		
		<tr style="border-bottom:1px solid #c3c3c3;"> 
			<td colspan="3" style="padding:1% 5%; font-size:16px;">
			    <i style="color:gray; font-size:30px; float:left; margin-right:30px; border:2px solid gray; padding:10px; border-radius:50%;" class="fas fa-user"></i> 
				<span style="color:gray; line-height:25px;">Vikas Udar </br><span style="color:black;"> TATA Ace | DL-35 BW0974</span> </span>
			</td>
		</tr>
		
		<tr style="border-bottom:1px solid #c3c3c3;" >
		    <td colspan="2" align="center" style="padding:1% 2%;">
			    <h3 style="color:gray; margin:0;">Fare Payable</h3>
                <h4 style="margin-top:8px; margin-bottom: 0;"><i class="fas fa-rupee-sign"></i> 855</h4>	
			</td>
			<td colspan="2" rowspan="6" style="padding:1% 5%; border-left:1px solid #c3c3c3;">
			    <table>
				    <tr>
					    <td style="border-bottom:1px solid #c3c3c3;"><h5>Base Fare</h5></td>
						<td style="border-bottom:1px solid #c3c3c3;" align="right"><h5><i class="fas fa-rupee-sign"></i> 855</h5></td>
					</tr>
					<tr>
					    <td style="color:gray;"><h5>Distance Charge (1st km free)</h5></td>
						<td style="color:gray;" align="right"><h5><i class="fas fa-rupee-sign"></i> 855</h5></td>
					</tr>
					<tr>
					    <td style="color:gray;"><h5>Trip Time Charge (1st 60 min free)</h5></td>
						<td style="color:gray;" align="right"><h5><i class="fas fa-rupee-sign"></i> 855</h5></td>
					</tr>
					<tr>
					    <td style="border-bottom:1px solid #c3c3c3;"><h3>Fare without Tax</h3></td>
						<td style="border-bottom:1px solid #c3c3c3;" align="right"><h3><i class="fas fa-rupee-sign"></i> 855</h3></td>
					</tr>
					<tr>
					    <td style="border-bottom:1px solid #c3c3c3;" ><h3>Sub Total</h3></td>
						<td style="border-bottom:1px solid #c3c3c3;"  align="right"><h3><i class="fas fa-rupee-sign"></i> 855</h3></td>
					</tr>
					<tr>
					    <td colspan="2"  style="color:gray; font-size:14px;">
						<p>Disclaimer inputs relating to consignment consignor and consignee information are provided by the user</p>
						<p>We hereby declare the input Tax Credit of Capital Goods input and input Services used for providing transportation services has not been taken by us</p>
						<p>Please visit <a href="zippy.co.in">zippy.co.in</a> for applicatble T&c</p>
						</td>
					</tr>
					
				</table>
			</td>
		</tr>
		
		<tr style="border-bottom:1px solid #c3c3c3;">
		    <td colspan="2" align="center" style="padding:1% 5%;">
			    <h4 style="color:gray; margin:0;">Trip Fare</h4>
                <h5 style="margin-top:8px; margin-bottom: 0;"><i class="fas fa-rupee-sign"></i> 855</h5>	
			</td>
		</tr>
		
		<tr style="border-bottom:1px solid #c3c3c3;">
		    <td colspan="2" align="center" style="padding:1% 5%;">
			    <h4 style="color:gray; margin:0;">Total Zippy Credits</h4>
                <h5 style="margin-top:8px; margin-bottom: 0;"><i class="fas fa-rupee-sign"></i> 855</h5>	
			</td>
		</tr>
		
		<tr style="border-bottom:1px solid #c3c3c3;">
		    <td colspan="2" align="left" style="padding:1% 5%;">
			    <small style="color:gray;">Consignor Name</small>
                <h3 style="margin-top:8px;"><?php echo implode(' ', [$vendor->first_name, $vendor->last_name]); ?></h3>	
				<p>Guest</p>
			</td>
		</tr>
		
		<tr style="border-bottom:1px solid #c3c3c3;">
		    <td colspan="2" align="left" style="padding:1% 5%;">
			    <small style="color:gray;">Consignee Name</small>
                <h3 style="margin-top:8px; margin-bottom: 0;"><?php echo implode(' ', [$customer->first_name, $customer->last_name]); ?></h3>	
			</td>
		</tr>
		
		<tr style="border-bottom:1px solid #c3c3c3;">
		    <td colspan="2" align="left" style="padding:1% 5%;">
			    <small style="color:gray;">Nature of Goods</small>
                <h3 style="margin-top:8px; margin-bottom: 0;">House Shifting</h3>	
				<p>Loose</p>
			</td>
		</tr>
		
		<tr>
		    <td align="center" style="padding: 1% 5%;" colspan="4">
			    <small style="color:gray;">Consignor Details</small>
				<h4> ZIPKART LOGISTICS PRIVATE LIMITED</h4>
				<h4>GSTIN NO. |  07AAACD6795J2Z7 </h4>
			</td>
		</tr>
		
		<tr style="background:#ececec;">
		    <td style="padding: 1% 5%;">
				<h4>Resfever labs pvt ltd</h4>
				<h5 style="color:gray;">info@zippy.co.in</h5>
			</td>
			<td style="padding: 1% 5%;" colspan="2">
				<h4>Address</h4>
				<h5 style="color:gray;"> B-16 Palmohan Plaza</br> 11/56, D.B. Gupta Road, Karol Bagh New Delhi, Delhi, India, 110005</h5>
			</td>
			<td style="padding: 1% 5%;">
				<h5>Singnature on the behalf of zippy</h5>
			</td>
		</tr>
		
		<tr>
		    <td align="center" style="padding: 1% 5%;" colspan="4">
			    <h4 style="color:gray;">GST Category Good Transport Agency</h4>
				<h4 style="color:gray;">GSTIN NO:  07AAACD6795J2Z7 | SAC CODE: 9967 | CIN: U64120DL1998PTC095988</h4>
			</td>
		</tr>
		
		
		
	</table>
</body>
</html>