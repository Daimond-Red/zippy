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
	
	$( "#sendEmail" ).click(function() {
		myFunction(this);
	});

	 function myFunction(div) {
	 $(".loader_div").toggle();
	 $(div).toggle();
	 }
});
</script>
<style>

    .loader_div{
		  display:none;	
		  border: 5px solid black;
		  border-radius: 50%;
		  border-top: 5px solid lightgrey;
		  width: 60px;
		  height: 60px;
		  -webkit-animation: spin 2s linear infinite; /* Safari */
		  animation: spin 2s linear infinite;
		  position:absolute;
		  top:50%;
		  left:50%;
		  transform: translate(-50%, -50%);
		}
		
	
		/* Safari */
		@-webkit-keyframes spin {
		  0% { -webkit-transform: rotate(0deg); }
		  100% { -webkit-transform: rotate(360deg); }
		}

		@keyframes spin {
		  0% { transform: rotate(0deg); }
		  100% { transform: rotate(360deg); }
		}

   

    input , textarea{
		border:1px solid gray;
		width:120px;
		padding:2px;
		margin:5px;
		border-radius:5px;
		margin-right:0px;
	}
	.border-none {
 		border: none !important;
 	}
	input:focus , textarea:focus{
		outline:1px solid #dedcdc;
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
	 	.border-none {
	 		border: none !important;
	 	}
	}
</style>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
</head>


<body style="background:white; color:black; font-size:.8rem; font-family: sans-serif; line-height: 1.5; ">
<div id="loader_div" class="loader_div"></div>
<form action="dcs-cargo-form-data.php" method="POST">
<div style="margin:1% 1%;">
    <section style="overflow:hidden; width:100%">
	    <div style="float:left; width:25%">
		    <div>
		        <h2 style="margin:0;">ZIPPY</h2>
			    <span style="display:block; font-size:14px;"><strong>(A Service Brand owned by ZIPKART LOGISTICS PRIVATE LIMITED.)</strong></span>
			    <span  style="display:block; font-size:14px;">Corporate Office :</span>
			    <span  style="font-size:14px;">B-16-17, 11/56 Pal Mohan Plaza , Desh Bandhu</span>
				<span  style="font-size:14px;">Gupta Market , karol Bagh, New Delhi - 110005</span>
				<span  style="display:block; font-size:14px;">Tel. : 41253414-15, Mobile. : 9811207128, 9311207128 </span>
				<span  style="display:block; font-size:14px;">E-mail : info@zippy.co.in</span>
			</div>
		</div>
		<div style="float:left; width:75%;">
		    <div style="overflow:hidden; width:100%;">
			    <div style="float:left; width:20%; margin-right:2%; ">
				    <div style="border:1px solid black; border-radius:5px">
					    <div style="text-align:center; font-weight:bold; font-size:14px;">DOB
						</div>
						<div style="text-align:center; padding:4%; height:50px;">
                            <input type="date" name="dob" value=""/>
						</div>
					</div>
				</div>
				<div style="float:left; width:15%; margin-right:2%;" >
				    <div style="border:1px solid black; border-radius:5px">
					    <div style="text-align:center; font-weight:bold; font-size:14px;">ORIGIN
						</div>
						<div class="small-content" style="text-align:center; padding:6%; font-size:9px; height:50px;">
                            <textarea style="width:80%;" name="origin"></textarea>
						</div>
					</div>
				</div>
				<div style="float:left; width:15%; margin-right:2%;" >
				    <div style="border:1px solid black; border-radius:5px">
					    <div style="text-align:center; font-weight:bold; font-size:14px;">DESTINATION
						</div>
						<div class="small-content" style="text-align:center; padding:6%; font-size:9px; height:50px;">
                            <textarea style="width:80%;" name="destination" value=""></textarea>
						</div>
					</div>
				</div>
				<div style="float:left; width:44%; ">
				    <div style="border:1px solid black; border-radius:5px">
					    <div style="text-align:center; font-weight:bold; font-size:14px;">e Consignment No
						</div>
						<div style="text-align:center; padding:2%; height:50px;">
						    <input type="number" name="econsignment" value=""/>
						</div>
					</div>
				</div>
			</div>
			
			<div style="overflow:hidden; width:100%; margin-top:2%;">
			    <div style="float:left; width:25%; margin-right:2%; ">
				    <div style="border:1px solid black; border-radius:5px; text-align:center;">
					    <div style="text-align:center; font-weight:bold; font-size:14px;">CONTENTS
						</div>
						<div class="content" style="height:50px; text-align:center; padding:2%; ">
						    <input type="text" name="content" value=""/>
						</div>
					</div>
				</div>
				<div style="float:left; width:27%; margin-right:2%;  ">
				    <div style="border:1px solid black; border-radius:5px; text-align:center;">
					    <div style="text-align:center; font-weight:bold; font-size:14px;">PACKAGES
						</div>
						<div class="content" style="height:50px;  text-align:center; padding:2%; ">
						    <input type="text" name="package" value=""/>
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
								    ACTUAL: <input style="width:70%;" type="text" name="actual_weight" value=""/> MT
								</div>
								<div class="content" style="float:left; width:49%; height:50px;  ">
								    VOLUMETRIC: <input style="width:70%;" type="text" name="volumetric_weight" value=""/>
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
                                Name: <input type="text" name="consignor_name" value=""/>
                                <br>Email: <input type="email" name="consignor_email" value=""/>
                                <br>Mobile No: <input type="number" name="consignor_mobile" value=""/>
                                <br>Address: <textarea style="width:80%;" name="consignor_address"></textarea>
							<div style="text-align:center; margin-top:50px;">PHONE: <input type="number" name="consignor_phone" value=""/></div>
						</div>
					</div>
				</div>
				<div style="float:left; width:50%;">
				    <div style="border:1px solid black; border-radius:5px;">
					    <div style="text-align:center; font-weight:bold; font-size:14px;">CONSIGNEE
						</div>
						<div class="consign" style="padding:2%; height:190px;">
                                Name: <input type="text" name="consignee_name" value=""/>
                                <br>Email: <input type="email" name="consignee_email" value=""/>
                                <br>Mobile No: <input type="number" name="consignee_mobile" value=""/>
                                <br>Address: <textarea style="width:80%;" name="consignee_address"></textarea>
							<div style="text-align:center; margin-top:50px;">PHONE: <input type="number" name="consignee_phone" value=""/></div>
						</div>
					</div>
				</div>
			</div>
			
			<div style="overflow:hidden; width:100%; margin-top:2%">
			    <div style="float:left; width:48%; margin-right:2%;" >
				    <div style="border:1px solid black; border-radius:5px; ">
						<div style="text-align:center; padding:2%;">CONSIGNOR'S GST NO
							: <input type="text" name="consignor_gst" value=""/>
						</div>
					</div>
					 <div style="border:1px solid black; border-radius:5px; margin-top:2%;">
						<div style="text-align:center; padding:2%;">CONSIGNEE'S GST NO
							: <input type="text" name="consignee_gst" value=""/>
						</div>
					</div>
					 <div style="border:1px solid black; border-radius:5px; margin-top:2%;">
						<div style="text-align:center; padding:2%;">EWAY BILL NO.
							: <input type="text" name="eway_bill" value=""/>
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
						<div class="notice" style="margin-top:2%;">
							<span style="margin-right:5%;">Sender's Signature</span>
							<span style="margin-right:5%;">
								
							</span>
							<span style="margin-right:4%;">Date: <input type="date" name="send_date" value=""/></span>
							<span>Time: <input type="time" name="send_time" value=""/></span>
						</div>
					</div>
				</div>
				
				<div style="float:left; width:35%;" >
				    <div style="border:1px solid black; border-radius:5px; padding:1%;font-size:13px; line-height:20px;">
					    <p><strong>ZIPKART LOGISTICS PRIVATE LIMITED</strong> </p>
						<p>ACCOUNT NO.<span> 600220110000751</span></p>
						<p>BANK OF INDIA </p>
						<p>BANK STREET BRANCH </p>
						<p>NEW DELHI 110005</p>
						<p>IFSC CODE BKID0006002</p>
					</div>
				</div>
				
			</div>
			
			<div  style="overflow:hidden; width:100%; margin-top:2%">
				<div style="border:1px solid black; border-radius:5px; padding:1%;">
				    User Email : <input type="email" name="user_email" value=""/>
				</div>
			</div>	
			
		</div>
		
    <!-- table section -->
		<div style="float:left; width:34%;">
		    <table style="width:100%; border-spacing:0;" border="1" cellpadding="13">
                <tr>
                    <th></th>
                    <th>PAID (Rs.)</th> 
                    <th>FOD (Rs.)</th>
                </tr>
				<tr>
                    <td>DKT. Charges</td>
					<td><input type="number" name="dkt_paid"  onchange="paidAmount(0, this.value);" value="" /></td>
					<td><input type="number" name="dkt_fod" onchange="fodAmount(0, this.value);" value=""/></td>
                </tr>
				<tr>
                    <td>Freight</td>
					<td><input type="number" name="freight_paid"  onchange="paidAmount(1, this.value);" value=""/></td>
					<td><input type="number" name="freight_fod" onchange="fodAmount(1, this.value);" value=""/></td>
                </tr>
				<tr>
                    <td>Service Charges</td>
					<td><input type="number" name="service_paid" onchange="paidAmount(2, this.value);" value=""/></td>
					<td><input type="number" name="service_fod" onchange="fodAmount(2, this.value);" value=""/></td>
                </tr>
				<tr>
                    <td>FOV</td>
					<td><input type="number" name="fov_paid" onchange="paidAmount(3, this.value);" value=""/></td>
					<td><input type="number" name="fov_fod" onchange="fodAmount(3, this.value);" value=""/></td>
                </tr>
				<tr>
                    <td>COD / FOD</td>
					<td><input type="number" name="cod_paid" onchange="paidAmount(4, this.value);" value=""/></td>
					<td><input type="number" name="cod_fod" onchange="fodAmount(4, this.value);" value=""/></td>
                </tr>
				<tr>
                    <td>Misc.</td>
					<td><input type="number" name="misc_paid" onchange="paidAmount(5, this.value);" value=""/></td>
					<td><input type="number" name="misc_fod" onchange="fodAmount(5, this.value);" value=""/></td>
                </tr>
				<tr>
                    <td><b>Sub Total</b></td>
					<td><input type="number" readonly class="border-none" name="subtotal_paid" id="paid_amount" value=""/></td>
					<td><input type="number" readonly class="border-none" name="subtotal_fod" id="fod_amount" value=""/></td>
                </tr>
				<tr>
                    <td><b>Grand Total</b></td>
					<td colspan="2">
						<input readonly type="number" class="border-none" name="grandtotal_paid" id="grand_total" value=""/>
					</td>
                </tr>
				<tr>
                    <td colspan="3">Amount in Words : <input type="text" name="amount" value=""/></td>
                </tr>
				<tr>
                    <td colspan="3">INSURED
					    <span style="margin-left:10%;">YES</span>
						<input style="width:5%;" type="radio" name="insured" value="Yes" checked="checked"/>
						<span style="margin-left:10%;">NO</span>
						<input style="width:5%;" type="radio" name="insured" value="No"/>
					</td>
                </tr>
				<tr>
                    <td colspan="3">Declared Value: <input type="number" name="declared_value" value=""/></td>
                </tr>
				<tr>
                    <td colspan="3">Invoice No.: <input type="text" name="invoice_no" value=""/></td>
                </tr>
            </table>
		</div>
	<!-- /table section -->
	<script>
		var paid_amt = [];
		var fod_amt = [];
		function paidAmount(flag, value){
			
			paid_amt[flag] = parseInt(value);
			
			$('#paid_amount').val(sum(paid_amt)); 

			$('#grand_total').val(parseInt($('#paid_amount').val()) + parseInt($('#fod_amount').val()));
		}
		function fodAmount(flag, value){
			
			fod_amt[flag] = parseInt(value);
			
			$('#fod_amount').val(sum(fod_amt)); 
			$('#grand_total').val(parseInt($('#paid_amount').val()) + parseInt($('#fod_amount').val()));
		}
		function sum(input){
             
		 	if (toString.call(input) !== "[object Array]") return false;
		      
            var total =  0;
            for(var i=0;i < input.length; i++) {                  
                if(isNaN(input[i])){
                	continue;
                }
                total += Number(input[i]);
            }
            return total;
        }
		
		// amt.push(parseInt(value))

		// function fodAmount(value) {

		// 	var fod_amt = 0;
		// 	fod_amt += parseInt(value);

		// 	$('#fod_amount').val(fod_amt); 
		// }
	</script>
	    	
	</section>
	
	<div style="text-align:center; margin-top:2%;">
		<input id="#sendEmail" style="width:200px; color:black; text-decoration:none; border-radius:50px; border:1px solid black; padding:1%; transition:all .5s;" name="submit" type="submit" value="Mail e-Consignment Note"/>
	</div>	
	
</div>
</form>
</br>
</br>

</body>
</html>