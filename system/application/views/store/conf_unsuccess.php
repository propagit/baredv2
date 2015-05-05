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
	
	<h4>CONFIRMATION FAILED</h4>
    <div style="height: 20px;"></div>
    
	<div class="">
		<div class="col-sm-12">
			<div class="body-copy-Font font18semibold checkout_result_msg">OOPS... THERE HAS BEEN AN ERROR AND YOUR ORDER IS UNSUCCESSFUL</div>
			<div style="height: 20px;"></div>
			<div style="width:80%;">
				There has been an error processing your credit card and your order has not been received. Your credit card has not been charged.
				<br/><br/><br/>
				<a class="body-copy-Font primarylink" href="<?=base_url()?>cart/payment">Click here</a> to return to the payment page to review credit card details, alternatively please contact customer service by emailing <a class="body-copy-Font primarylink" href="mailto:info@bared.com.au">info@bared.com.au</a> or calling +61 03 9509 5771 for further assistance.
			</div>
            <div style="height: 20px;"></div>
            <div class="buttonPrimary button-Font" style="width: 290px; cursor:pointer;" onclick="window.location='<?=base_url()?>cart/payment'">
                RETURN TO PAYMENT
            </div>
		</div>
	</div>
	<div style="height: 30px;"></div>

		
        
   