<script src="<?=base_url()?>js/bootstrap-select.js"></script>
<link href="<?=base_url()?>css/bootstrap-select.css" rel="stylesheet" media="screen">
<style>
a, a:hover, a:focus {
    color: #222222;
    font-weight: 600;
    text-decoration: none;
}

</style>
<script type="text/javascript">
var submitcount=0;
$(function() {       	
	<? if($this->session->flashdata('error_product_quantity'))
	{ }
		?>
	<?php if($cart != NULL) { ?>
    updateshippingmethod(); // Based on change of country	
    <? } ?>
	jQuery('.selectpicker').selectpicker();
	updateshippingmethod();
	updatediscountcost();
//	clear();
	
});
function updatediscountcost()
{
	var code = jQuery('#coupon-code').val();
	jQuery.ajax({
	  url: '<?= base_url() ?>cart/get_updatediscount/',
	  type: 'POST',
	  data: ({code:code}),
	  success: function(html) {
		jQuery('#discount-cost').html(html);
	  }
	})
}
function updateshippingmethod() {
	var country_id = jQuery('#country').val();
	var state_id = jQuery('#state_id').val();
	 var postcode = jQuery('#postcode').val();
	 //alert(state_id);
	jQuery.ajax({
	  url: '<?= base_url() ?>cart/updateshippingmethod/',
	  type: 'POST',
	  data: ({country_id:country_id,state_id:state_id,postcode:postcode}),
	  success: function(html) {
		jQuery('#shipping-method').html(html);
		jQuery('#shippingmethod').val(jQuery('#method').val());
		updateshippingcost();
		gettax();
	  }
	})
} // Get the shipping methods based on country
function updateshippingcost() {
	var method_id = jQuery('#method').val();
	var code = jQuery('#coupon-code').val();
	jQuery.ajax({
	  url: '<?= base_url() ?>cart/updateshippingcost/',
	  type: 'POST',
	  data: ({method_id:method_id,code:code}),
	  success: function(html) {
		jQuery('#shipping-cost').html(html);
	  }
	})
} // Get the shipping cost based on shipping method and subtotal, which is depent on discount
  

function gettax() {
	var method_id = jQuery('#method').val();
	var country_id = jQuery('#country').val();
	var code = jQuery('#coupon-code').val();
	jQuery.ajax({
	url: '<?= base_url() ?>cart/gettax/',
	type: 'POST',
	data: ({country_id:country_id,code:code,method_id:method_id}),
	success: function(html) {			
	jQuery('#tax').html(html);
	
	var tax = jQuery('#taxamount').html();
	gettotalprice();
	}
	})
} // Calculated based on country and subtotal, which is depent on discount

function checkcoupon() {
	var code = jQuery('#coupon-code').val();
	//alert(code);
	if (code != '') {
	  jQuery.ajax({
		url: '<?= base_url() ?>cart/checkcoupon/',
		type: 'POST',
		data: ({code:code}),
		success: function(html) {
		  if(html=="Err01") { alert('The coupon code is not valid'); }
		  else if(html=="Err02") { alert('The coupon code is not actived'); }
		  else if(html=="Err03") { alert('The coupon code has been used its allowed times of used'); }
		  else if(html=="Err04") { alert('The coupon was expired'); }
		  else 
		  { 
			jQuery('#discount-area').html(html);
			addcoupon(code); 
			gettotalprice(code);
		  }
		}
	  })
	} else {
	  alert('Please enter a coupon code');
	}
} // Check if a coupon is valid, and if so then add the coupon
function addcoupon(code) {
	var code = jQuery('#coupon-code').val();
	//alert(code);
	jQuery.ajax({
	  url: '<?= base_url() ?>cart/addcoupon2/',
	  type: 'POST',
	  data: ({code:code}),
	  success: function(html) {			
		gettax();
			updateshippingcost();	
			jQuery('.items-list .list').css('height','240px');
			jQuery('#discount-info').html(html);					
	  }
	})
}
function gettotalprice(code) {
	var method_id = jQuery('#method').val();
	var country_id = jQuery('#country').val();
	var code = jQuery('#coupon-code').val();
	jQuery.ajax({
	  url: '<?= base_url() ?>cart/totalprice/',
	  type: 'POST',
	  data: ({method_id:method_id,country_id:country_id,code:code}),
	  success: function(html) {
		jQuery('#totalprice').html(html);
	  }
	})
} // Calculated total based on coupon for discount, country for tax, and shipping method

function order() {
	
	updateshippingmethod();	
	<? if($cart == NULL)
	{
		  ?>
		  alert('Your shopping basket is empty. Please update your shopping basket');
		  return false;
		  <?
	}
	?>
	
  	if(submitcount==0){
		document.orderForm.submit();
		submitcount = submitcount+1;
	}
	else 
	{
		alert("Transaction is in progress.");
		return false;
	}		
}
  
  
function clear()
{
	jQuery('#alert-login').hide();	
	jQuery('#alert-register').hide();	
	jQuery('#alert-welcome').hide();
	jQuery('#alert-forgot').hide();			
	jQuery('#alert-forgot-error').hide();			
}

function copyaddress() {
    if(jQuery('#sameaddress:checked').val()) {
      jQuery('#firstname').val('<?= $customer['firstname'] ?>');
      jQuery('#lastname').val('<?= $customer['lastname'] ?>');
      jQuery('#address').val('<?= $customer['address'] ?>');
      jQuery('#suburb').val('<?= $customer['suburb'] ?>');
      jQuery('#state_id').val('<?= $customer['state'] ?>');
      jQuery('#postcode').val('<?= $customer['postcode'] ?>');
	  jQuery('#phone').val('<?= $customer['phone'] ?>');
	  jQuery('#email').val('<?= $customer['email'] ?>');
    } 
	else 
	{
      jQuery('#firstname').val('');
      jQuery('#lastname').val('');
      jQuery('#address').val('');
      jQuery('#suburb').val('');
      jQuery('#state').val('');
      jQuery('#postcode').val('');
	  jQuery('#phone').val('');
      jQuery('#email').val('');
    }	
	//updateshippingmethod();
}
function check_postcode()
{
	var postcode = jQuery('#postcode').val();

	jQuery.ajax({
	  url: '<?= base_url() ?>cart/check_postcode/'+postcode,
	  type: 'POST',
	  success: function(html) {
		if(html==2){alert("Sorry, we don't have your postcode in our shipping system. Please check your postcode format or contact us.");}
		else{		
			updateshippingmethod();	
		}
	  }
	})
}
function buynow() {
    var valid = true;
   
	var postcode = jQuery('#postcode').val();

	jQuery.ajax({
	  url: '<?= base_url() ?>cart/check_postcode/'+postcode,
	  type: 'POST',
	  success: function(html) {
		if(html==2){alert("Sorry, we don't have your postcode in our shipping system. Please check your postcode format or contact us."); valid= false;}
		else{		
			updateshippingmethod();	
		}
	  }
	})
	
   
   	if (valid) {
	  <? if($cart == NULL)
	  {
		  ?>
		  alert('Your shopping basket is empty. Please update your shopping basket');
		  return false;
		  <?
	  }
	  ?>
	  //alert($j('#method').val());
      if(submitcount==0){
	  	document.orderForm.submit();
		submitcount = submitcount+1;
	  }
	  else 
	  {
            alert("Transaction is in progress.");
            return false;
        }

    }
	else
	{
		alert('Please check the highlighted fields to make sure you have entered the correct data.');
		return false;
	}
}
function change_country()
{
	if(jQuery('#country').val()==13)
	{
		jQuery('#state_au').show();
	}else
	{
		jQuery('#state_au').hide();
	}
}
</script>
<style>
	.money{
		font-family: buenard; 
		font-size:12px;
	}
	.month  {
    	width: 105px;
	}
	#expmonth{
		width:105px;
	}
	
	.year  {
    	width: 105px;
	}
	#expyear{
		width:105px;
	}
	
.table td {
    border-top: none;
    line-height: 20px;
    padding: 8px;
	text-align: left!important;
    vertical-align: top;
}
.table th {
	text-align: left!important;
	font-size:18px!important; font-weight: 700!important;
}
</style>
<div class="container">
	<div style="height:10px;"></div>     	
	<form method="post" action="<?=base_url()?>store/order_trade" id="orderForm" name="orderForm" >	    
        <div class="row-fluid">        	
            <div class="span12">
            	
                <div class="row-fluid">        	
            	<div class="span6">
                	<h4 style="font-family: open sans">YOUR ORDER</h4>
                    <div style="min-height:567px; background: #f5f5f5;">
                	<?php $subtotal = 0; ?>
                    <table class="table" width="100%" style="font-family: open sans;">
                    
                        <tr>
                        	<th width="50%" >PRODUCT NAME</th>
                            <th align="center"> QTY</th>
                            <th>DISCOUNT</th>
                            <th>PRICE</th>
                        </tr>
                    <?php 
					if($cart != NULL)
					{    
               			foreach ($cart as $item)
			  			{ 	$var = json_decode($item['attributes'],true); 
							$thumb = $this->Product_model->thumb_photo($item['product_id']); 
							$product = $this->Product_model->identify($item['product_id']); 
							$subtotal += intval($item['quantity']) * floatval($item['price']); ?>          
                        <tr>
                        	<td width="50%">
                            	<? $pro_category = $this->Category_model->identify_category($product['id']);
									$category = $this->Category_model->identify(2);
								?> 
                                <a style="font-weight:400!important;" href="<?=base_url()?>store/detail_product/<?=$category['name']?>/<?=$product['id_title']?>">
                                	<span style="font-family: buenard;font-size:16px;"><?php echo to_short($product['title'],34); ?> </span>
                                </a>
                           	</td>
                            <td align="center" ><?php echo $item['quantity']; ?></td>
                            <td align="center">-</td>
                            <td align="center"><span class="money"><?=$sign?> <?= number_format($item['price'] * $cur_val,2,'.',','); ?> </span></td>
                        </tr>
                        <?php } 
                    } ?>
                    </table>        
                    </div>
                    <div style="height:10px;"></div> 
                   
                    <?php 
					if($cart != NULL)
					{   ?>
                   	<div style="height: 0px; clear: both; border-top:1px solid #ccc">&nbsp;</div>  
                    <div style="height:10px;"></div>   
                    <div class="form-horizontal">
                    	
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="coupon">Discount</label>
                            <label class="controls" id="discount-cost" style="padding-top:5px;">
                                
                            </label>
                            
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="coupon">Coupon </label>
                            <div class="controls">
                                <input type="text" id="coupon-code" name="coupon-code" placeholder="Coupon ">
                                <button class="btn" type="button" onclick="checkcoupon()">Update</button>
                            </div>
                            
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="shipping">Shipping Method</label>
                            <div class="controls" id="shipping-method" style="padding-top:-5px;">
                                
                            </div>
                            
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="shippingcost">Shipping Cost</label>
                            <label class="controls" id="shipping-cost" style="padding-top:5px;">
                                
                            </label>
                            
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="tax">Tax</label>
                            <label class="controls" id="tax" style="padding-top:5px;">
                                
                            </label>                            
                        </div>
                        
                        <div class="control-group" style="margin-top:140px;">
                            <label class="control-label" style="text-align:left;font-family: open sans; font-size:18px; font-weight: 700;" for="shipping">TOTAL PRICE</label>
                            
                            <label class="controls money" id="totalprice"  style="font-size: 16px;line-height:25px;">
								<?php printf('$%01.2f',$subtotal); ?>
                            </label>
                            
                        </div>                  
                    </div>
                  <? } ?>
                </div>
                               
                
            	<div class="span6">
                    <h4 style="font-family: open sans">DELIVERY / PAYMENT</h4>
                    <form class="form-horizontal"  autocomplete="off">            
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="address">Delivery Details</label>
                            <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" name="sameaddress" id="sameaddress" onChange="javascript:copyaddress();"> Same as my member profile address
                            </label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="firstname">First Name *</label>
                            <div class="controls">
                                <input type="text" id="firstname" name="firstname" placeholder="First Name" required>
                                
                            </div>
                            
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="lastname">Last Name *</label>
                            <div class="controls">
                                <input type="text" placeholder="Last Name" name="lastname"  id="lastname" required>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="address">Address *</label>
                            <div class="controls">
                                <input type="text" placeholder="Address" name="address"  id="address" required>
                            </div>
                        </div>
                        
                        
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="suburb">Suburb *</label>
                            <div class="controls">
                                <input type="text" placeholder="Suburb" name="suburb"  id="suburb" required>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="postcode">Postcode </label>
                            <div class="controls">                            	
                                <input type="text" placeholder="Postcode" name="postcode"  id="postcode" required onblur="check_postcode()">
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="country">Country</label>
                            <div class="controls">
                                <select class="selectpicker" name="country" id="country" onchange="change_country();">
                                    <?php foreach($countries_all as $ct) { ?>
                        				<option value="<?=$ct['id']?>"<?php if($ct['code'] == "AU") print ' selected="selected"'; ?>><?=$ct['name']?></option>
                        			<?php } ?>
                        		</select>                                                               
                            </div>
                        </div>
                        <div class="control-group" id="state_au" style="display:block;">
                            <label class="control-label" style="text-align:left;" for="state_id">State</label>
                            <div class="controls">
                                <select class="selectpicker" name="state_id" id="state_id" >
                                    <?php foreach($states as $st) { ?>
                                        <option value="<?=$st['id']?>" <?php if($st['name'] == "Victoria")  print ' selected="selected"'; ?>><?=$st['name']?></option>
                                    <?php } ?>                                
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="email">Email *</label>
                            <div class="controls">
                                <input type="email" placeholder="Email" name="email"  id="email" required>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="message">Message</label>
                            <div class="controls">
                                <textarea name="message" id="message" rows="3"></textarea>
                            </div>
                        </div>
                        
                        <div style="height: 40px; ">
                        	<input onclick="$('#gift_detail').toggle();" type="checkbox" name="gift" value="Y" style="margin-top: 0px"/> This is a gift
                        </div>
                        
                        <div id="gift_detail" style="display: none">
	                        <div style="height: 0px; clear: both; border-top:1px solid #ccc">&nbsp;</div>          
	                    	<h4 style="font-family: open sans">GIFT DETAILS</h4>
	                        <div class="control-group">
	                            <label class="control-label" style="text-align:left;" for="secard">Select eCard</label>
	                            <div class="controls">
	                                <div id="secard">
	                                	<table>
	                                		<tr>
	                                			<td>
	                                				<img src="<?=base_url()?>img/ecard/ecard1.jpg" alt=""/>
	                                			</td>
	                                			<td style="padding-left: 10px; padding-right: 10px;">
	                                				<img src="<?=base_url()?>img/ecard/ecard2.jpg" alt=""/>
	                                			</td>
	                                			<td>
	                                				<img src="<?=base_url()?>img/ecard/ecard3.jpg" alt=""/>
	                                			</td>
	                                		</tr>
	                                		<tr>
	                                			<td style="text-align: center; padding-top: 10px"><input style="margin-top: -2px;" type="radio" name="ecard_no" value="1" />&nbsp;#1</td>
	                                			<td style="text-align: center; padding-top: 10px"><input style="margin-top: -2px;" type="radio" name="ecard_no" value="2" />&nbsp;#2</td>
	                                			<td style="text-align: center; padding-top: 10px"><input style="margin-top: -2px;" type="radio" name="ecard_no" value="3" />&nbsp;#3</td>
	                                		</tr>
	                                	</table>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="control-group">
	                            <label class="control-label" style="text-align:left;" for="rname">Receipt Name</label>
	                            <div class="controls">
	                                <input type="text" placeholder="Receipt Name" name="rname"  id="rname">
	                            </div>
	                        </div>
	                        <div class="control-group">
	                            <label class="control-label" style="text-align:left;" for="sthing">Something Something</label>
	                            <div class="controls">
	                                <input type="text" placeholder="Something Something" name="sthing"  id="sthing">
	                            </div>
	                        </div>
	                        <div class="control-group">
	                            <label class="control-label" style="text-align:left;" for="sthing">Send Gift On</label>
	                            <div class="controls">
	                                <div id="dob1" class="input-append">
									<input data-format="dd-MM-yyyy" type="text" name="send_gift" id="send_gift" style="width: 180px;"></input>
									<span style="cursor: pointer" class="add-on">
									  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
									  </i>
									</span>
									</div>
									<script type="text/javascript">
									  $(function() {
									    $('#dob1').datetimepicker({
									      pickTime: false
									    });
									  });
									</script>
	                            </div>
	                        </div>
	                        <div class="control-group">
	                            <label class="control-label" style="text-align:left;" for="gnote">Gift Note</label>
	                            <div class="controls">
	                                <textarea name="gnote" id="gnote" rows="3"></textarea>
	                            </div>
	                        </div>
                        </div>
                    
                    <div style="height: 0px; clear: both; border-top:1px solid #ccc">&nbsp;</div>          
                    <h4 style="font-family: open sans">PAYMENT DETAILS</h4>
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="cardtype">Payment Type *</label>
                            <div class="controls">
                                <select class="selectpicker" name="cardtype" id="cardtype">
                                    <option value="Visa Card">Visa Card</option>
                                    <option value="Master Card">Master Card</option>                                                        
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="card-name">Card Name *</label>
                            <div class="controls">
                                <input type="text" placeholder="Card Name" name="cardname" id="cardname" required>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="cardnumber">Card Number *</label>
                            <div class="controls">
                                <input type="text" placeholder="Card Name" name="cardnumber" id="cardnumber" required>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="expmonth">Expiry Date *</label>
                            <div class="controls">
                                <select class="selectpicker month" name="expmonth" id="expmonth" style="width:80px;">
                                    <option value="1">01</option>
                                    <option value="2">02</option>
                                    <option value="3">03</option>
                                    <option value="4">04</option>
                                    <option value="5">05</option>
                                    <option value="6">06</option>
                                    <option value="7">07</option>
                                    <option value="8">08</option>
                                    <option value="9">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>                                                       
                                </select>
                                <select class="selectpicker year" name="expyear" id="expyear" style="width:80px;">
                                    <?php for($i=date('Y');$i<(date('Y')+10);$i++) { ?>
                                    <option value="<?=$i?>"><?=$i?></option>
                                    <?php } ?>                                                     
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align:left;" for="cvvnumber">CVV Number *<br><a href="#cvv" data-toggle="modal" style="font-size:10px; font-style:italic;">(What is CVV number?)</a></label>
                            <div class="controls">
                                <input type="text" placeholder="CVV Number" name="cvvnumber" id="vvnumber" required>
                            </div>
                        </div>
                        <div class="control-group">
                        <div class="controls">  
                                      
                        <button type="button" onclick="buynow();" class="btn">Buy Now</button>
                        </div>
                        </div>
                        
                    </div>
                </div>                      
            </div>
        </div>
	</form>
<!-- Modal -->
<div id="cvv" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">WHAT IS MY CVV NUMBER?</h3>
</div>
<div class="modal-body">
<p>The Card Verification Value (CVV*) is an extra code printed on your debit or credit card.</p><br/>
<p>CVV for Visa, MasterCard and Diners is the final three digits of the number printed on the signature strip on the back of your card.</p><br/>
<p align="left"><img src="<?=base_url()?>img/cvv-visa.gif" alt="" width=331 height=82></p><br/>
<p>CVV for American Express appears as a separate 4-digit code printed on the front of your card.</p><br/>
<p align="left"><img src="<?=base_url()?>img/cvv-amex.gif" alt="" width=331 height=97></p><br/>
<p>As the CVV is not embossed (like the card number) the CVV is not printed on any receipts, hence it is not likely to be known by anyone other than the card owner.</p><br/>
<p>CVV is an anti-fraud measure being introduced by credit card companies worldwide. You are required to enter the CVV each time a payment is made and you are not present to sign a receipt, as for on-line transactions. We ask you to fill out the CVV here to verify that you actually hold the card you are using for this transaction, and to avoid anyone other than you from shopping with your card number. All information you submit is transferred over secure SSL connections.</p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

</div>
</div>	

<div id="popup-shopping" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">Error</h3>
</div>
<div class="modal-body">
<p><?php echo $this->session->flashdata('error_product_quantity');?></p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

</div>
</div>	