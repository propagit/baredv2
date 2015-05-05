<div class="app-container">		    
    <div style="height: 20px;"></div>
    <div style="width: 100%">
	<div style="margin: 0 auto" class="hidden-xs linkbreadcrumb">
		<table align="center" cellpadding="0" cellspacing="0" class="body-copy-Font">
			<tr style="text-align: center">
				<td style="padding-bottom: 5px">Shopping Bag</td>
				<td></td>
				<td style="padding-bottom: 5px">Order Summary</td>
				<td></td>
				<td style="padding-bottom: 5px">Confirmation</td>
			</tr>
			<tr>
				<td><img src="<?=base_url()?>img/red-dot1.png" alt=""/></td>
				<td><img src="<?=base_url()?>img/red-dot1.png" alt=""/></td>
				<td><img src="<?=base_url()?>img/red-dot1.png" alt=""/></td>
				<td><img src="<?=base_url()?>img/red-dot1.png" alt=""/></td>
				<td><img src="<?=base_url()?>img/red-dot1.png" alt=""/></td>
			</tr>
			<tr style="text-align: center">
				<td></td>
				<td>Account Details</td>
				<td></td>
				<td>Payment</td>
				<td></td>
			</tr>
		</table>
		
	</div>
    <div style="margin: 0 auto" class="visible-phone">
		
       <div class="col-sm-12" style="text-align: center">
            <ul class="breadcrumb linkbreadcrumb breadcrumb-Font">
                <li class="active2">Shopping Bag <span class="divider">></span></li>
                <li class="active2">Account Details <span class="divider">></span></li>
                <li class="active2">Order Summary <span class="divider">></span></li>
                <li class="active2">Payment <span class="divider">></span></li>
                <li class="active2">Confirmation </li>
            </ul>
        </div>      
		
	</div>
	</div>
	
	<h4>COULDN'T CONNECT TO PAYPAL</h4>
    <div style="height: 20px;"></div>
    
	<div class="">
		<div class="col-sm-12">
			<div style="width:80%;">
				I'm sorry we were unable to connect to the PayPal site, this is most likely a temporary issue please click "RETURN TO PAYMENT" below to try again<br> 
			</div>
            <div style="height: 20px;"></div>
            <div class="buttonPrimary button-Font" style="width: 290px; cursor:pointer;" onclick="window.location='<?=base_url()?>cart/payment'">
                RETURN TO PAYMENT
            </div>
		</div>
	</div>
	<div style="height: 30px;"></div>

		
        
   