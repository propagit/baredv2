<script src="<?=base_url()?>js/bootstrap-select.js"></script>
<link href="<?=base_url()?>css/bootstrap-select.css" rel="stylesheet" media="screen">
<script>
var choose = 0;

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
	updatememberdiscountcost();
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
		 if(html==0){
		 	//jQuery('#discount-tr').css('visibility','hidden');
		 	jQuery('#discount-tr').css('display','none');
		 	jQuery('#price-gap').css('display','none');
		 }
		 else
		 {
		 	jQuery('#discount-cost').html(html);
			jQuery('#discount-tr').css('display','table-');
			jQuery('#price-gap').css('display','table-');
		 }
	  }
	})
}

function updatememberdiscountcost()
{	
	jQuery.ajax({
	  url: '<?= base_url() ?>cart/get_updatememberdiscount/',
	  type: 'POST',
	  success: function(html) {
		 if(html==0){
		 	//jQuery('#memberdiscount-tr').css('visibility','hidden');
		 	jQuery('#memberdiscount-tr').css('display','none');
		 	jQuery('#price-gap2').css('display','none');
		 }
		 else
		 {
		 	jQuery('#memberdiscount-cost').html(html);
		 }
	  }
	})
}

function updateshippingmethod() {
	
	var country_id ='<?=$this->session->userdata('scountry');?>'; //jQuery('#country').val();
	var state_id = '<?=$this->session->userdata('sstate');?>';
	 var postcode ='<?=$this->session->userdata('spostcode');?>';
	 
	jQuery.ajax({
	  url: '<?= base_url() ?>cart/updateshippingmethod/',
	  type: 'POST',
	  data: ({country_id:country_id,state_id:state_id,postcode:postcode}),
	  success: function(html) {
		jQuery('#shipping-method').html(html);
		jQuery('#shippingmethod').val(jQuery('#method').val());
		jQuery('#shipping-method-iphone').html(html);
		jQuery('#shippingmethod-iphone').val(jQuery('#method').val());
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
	var country_id = '<?=$this->session->userdata('scountry');?>';//jQuery('#country').val();
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
	
	$('#button_update').html('loading');
	if($("#coupon-code-phone").is(":visible"))
	{
		var code = jQuery('#coupon-code-phone').val();
	}
	else
	{
		var code = jQuery('#coupon-code').val();
	}
	
	
	
	if (code != '') {
	  jQuery.ajax({
		url: '<?= base_url() ?>cart/checkcoupon/',
		type: 'POST',
		data: ({code:code}),
		success: function(html) {
		  $('#button_update').html('Update');
		  if(html=="Err01") { alert('The coupon code is not valid'); }
		  else if(html=="Err02") { alert('The coupon code is not actived'); }
		  else if(html=="Err03") { alert('The coupon code has been used its allowed times of used'); }
		  else if(html=="Err04") { alert('The coupon was expired'); }
		  else 
		  { 
			//alert(html);
			if(html!="CODEOK")
			{
				jQuery('#discount-tr').html(html);	
				//addcoupon(code); 
				gettotalprice(code);
				jQuery('#discount-tr').css('display','table-');
			}
			else if(html=="CODEOK")
			{
				//jQuery('#discount-area').html(html);
				addcoupon(code); 
				gettotalprice(code);
				jQuery('#discount-tr').css('display','table-');
			}
			
		  }
		}
	  })
	} else {
	  	
		if(jQuery('#discount-cost').html()!='')
		{
			location.reload();
		}else{
			alert('Please enter a coupon code');
		}
	}
} // Check if a coupon is valid, and if so then add the coupon// Check if a coupon is valid, and if so then add the coupon
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
			//jQuery('.items-list .list').css('height','240px');
			//jQuery('#discount-info').html(html);					
			jQuery('#discount-tr').html(html);					
	  }
	})
}
function gettotalprice(code) {
	var method_id = jQuery('#method').val();
	var country_id = '<?=$this->session->userdata('scountry');?>';//jQuery('#country').val();
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
function checkout()
{
	<? if($cart == NULL)
	  {
		  ?>
		  alert('Your shopping basket is empty. Please update your shopping basket');
		  return false;
		  <?
	  }
	?>
	document.orderForm.submit();
}

</script>

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
				<td><img src="<?=base_url()?>img/grey-dot1.png" alt=""/></td>
				<td><img src="<?=base_url()?>img/grey-dot1.png" alt=""/></td>
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
    
    <div style="margin: 0 auto" class="visible-xs">
		
       <div class="col-sm-12 " style="text-align: center">
            <ul class="breadcrumb linkbreadcrumb breadcrum-Font">
                <li class="active2">Shopping Bag <span class="divider">></span></li>
                <li class="active2">Account Details <span class="divider">></span></li>
                <li class="active2">Order Summary <span class="divider">></span></li>
                <li>Payment <span class="divider">></span></li>
                <li>Confirmation </li>
            </ul>
        </div>     
		
	</div>
	</div>
    <div style="height: 20px;"></div>
	<h4>Order Summary </h4>
	<form name="orderForm" method="post" <? if($this->session->userdata('userloggedin')==1){?> action="<?=base_url()?>store_admin/checkout_order" <? }else{ ?> action="<?=base_url()?>cart/checkout_order"<? }?> > 
	<div style="clear: both;"></div>
	<div class="hidden-xs">
    <table class="table" cellpadding="0" cellspacing="0">		
		<tbody class="header-cart">

            <tr class="header-cart-Font header-cart">
				<td style="width: 3%">&nbsp;</td>
                <td style="width: 40%">
					<div class="header-cart" style="margin-top:10px;">PRODUCT NAME</div>
				</td>
				<td style="width: 22%">
					<div class="header-cart" style="margin-top:10px;">QTY</div>
				</td>
				<td style="width: 25%; text-align:center">
					<div class="header-cart" style="margin-top:10px;">PRICE</div>
				</td>
                <td style="text-align:right">
					<div class="header-cart" style="margin-top:10px;">SUBTOTAL</div>
				</td>

			</tr>
            
			<?php
		    	$ttl = 0;
		    	foreach($cart as $c)
				{
					
					$itemprice = $c['price'] * $c['quantity'];
					$ttl += $itemprice;
					$pro = $this->Product_model->identify($c['product_id']);
					$hero = $this->Product_model->get_hero($c['product_id']);
					$var = json_decode($c['attributes'],true);
					if($pro['deleted'] == 0)
					{
				?>
				<tr class="detail-cart-Font detail-cart" id="cart-<?=$c['id']?>">
					<td style="width: 20">&nbsp;</td>
					
					</td>
                    <td>						
						<div class="detail-cart" style="margin-top: 0px;">
							<?=$pro['title']?> <?=$pro['short_desc']?>
							<?
							if($pro['multiplesize'] == 1)
						 	{
						 	  ?>&nbsp;Size: <span style="text-transform: uppercase">
								<?php
                                if($var['Size'] == '65us')
								{
									$size_text = '6.5us';
								}
								elseif($var['Size'] == '75us')
								{
									$size_text = '7.5us';
								}
								elseif($var['Size'] == '85us')
								{
									$size_text = '8.5us';
								}
								elseif($var['Size'] == '95us')
								{
									$size_text = '9.5us';
								}
								elseif($var['Size'] == '105us')
								{
									$size_text = '10.5us';
								}
								else
								{
									$size_text = $var['Size'];
								}
						 		echo $size_text;
							}
							?></span>
						</div>
					</td>															
					<td style="text-align:left"><span style="margin-left:20px;"><?=$c['quantity']?></span></td>
					<td style="text-align:center">
                    	<?php echo number_format( $c['price'] * $cur_val,2,'.',',');?>
                    </td>
                    <td style="text-align: left">
						
						<?=$sign?> <?php echo number_format($itemprice * $cur_val,2,'.',',');?>
                        
					</td>
                    
				</tr>
                
				<?php
					}
					else
					{
						$this->$Cart_model->delete($c['id']);
					}
				}
			?>
			
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr><td colspan="5">&nbsp;</td></tr>
		</tbody>
	</table>
    </div>
    
    
    <div class="visible-xs">
    
		<table class="table " cellpadding="0" cellspacing="0">		
		<tbody class="font12normal">

            <tr class="header-cart-Font">
				
                <td style="width: 40%">
					<div class="header-cart" style="margin-top:10px;">PRODUCT NAME</div>
				</td>
				<td style="width: 10%">
					<div class="header-cart" style="margin-top:10px;">QTY</div>
				</td>
				<td style="width: 32%; text-align:center">
					<div class="header-cart" style="margin-top:10px;">PRICE</div>
				</td>
                <td style=" text-align:left">
					<div class="header-cart" style="margin-top:10px;">SUBTOTAL</div>
				</td>

			</tr>
            
			<?php
		    	$ttl = 0;
		    	foreach($cart as $c)
				{
					$itemprice = $c['price'] * $c['quantity'];
					$ttl += $itemprice;
					$pro = $this->Product_model->identify($c['product_id']);
					$hero = $this->Product_model->get_hero($c['product_id']);
					$var = json_decode($c['attributes'],true);
					if($pro['deleted'] == 0)
					{
				?>
				<tr class="detail-cart-Font" id="cart-<?=$c['id']?>">
					
					
					</td>
                    <td>						
						<div class="font12normal" style="margin-top: 0px;">
							<?=$pro['title']?> <?=$pro['short_desc']?>
							&nbsp;Size: <span style="text-transform: uppercase">
							<?php
							if($pro['multiplesize'] == 1)
						 	{
						 		if($var['Size'] == '65us')
								{
									$size_text = '6.5us';
								}
								elseif($var['Size'] == '75us')
								{
									$size_text = '7.5us';
								}
								elseif($var['Size'] == '85us')
								{
									$size_text = '8.5us';
								}
								elseif($var['Size'] == '95us')
								{
									$size_text = '9.5us';
								}
								elseif($var['Size'] == '105us')
								{
									$size_text = '10.5us';
								}
								else
								{
									$size_text = $var['Size'];
								}
						 		echo $size_text;
							}
							?></span>
						</div>
					</td>															
					<td style="text-align:left"><span style="margin-left:20px;"><?=$c['quantity']?></span></td>
					<td style="text-align:center">
                    	<?php echo number_format( $c['price'] * $cur_val,2,'.',',');?>
                    </td>
                    <td style="text-align: left; font-size:12px;">
						
						<?=$sign?> <?php echo number_format($itemprice * $cur_val,2,'.',',');?>
                        
					</td>
                    
				</tr>
                
				<?php
					}
					else
					{
						$this->$Cart_model->delete($c['id']);
					}
				}
			?>
			
            
            <tr><td colspan="5">&nbsp;</td></tr>
		</tbody>
		</table>	
			
            
    </div>
    
    
    
    <div style="height: 20px;" class="hidden-xs"></div>
    <div class=" ">
    	<div class="span7">
    		<div style="height: 90px; padding-top: 40px; ">
		    	<table>
                	
                    <tr>
                    	<td><div class="info-cart-Font"> <span class="info-cart">Shipping Method <!-- (</span>
                        		<a href="#" onclick="open_window('<?=base_url()?>store/page/47')">
                                <span class="note-Font note">How is this calculated? </span></a><span class="info-cart">) --></span></div></td>
                        <td width="20"></td>
                        <td>
                        	<div class="controls input-form-Font" id="shipping-method" style="padding-top:-5px;">                        
                    		</div>
                    	</td>
                    </tr>
                    <tr>
                    	<td>
                        	<input type="text" id="coupon-code" name="coupon-code" placeholder="Promo Code " class="col-sm-2 iipad inputp input-form-Font" style="height:33px;margin-bottom:0px!important; width:100%;">	
                        </td>
                        <td width="20"></td>
                        <td>
                        	<div onclick="checkcoupon();" class="button_primary button-Font" style="width: 290px; text-align:center;">
								Update
							</div>
                            
                        </td>
                    </tr>
                </table>                                
		    </div>
    	</div>
        
        
        <!--<div class="span7 visible-xs">
    		<div style="height: 90px; padding-top: 5px; margin-bottom:5px;" class="secondFont">
		    	<span class="info-cart-Font info-cart">Shipping Method </span>
                <div class="controls input-form-Font" id="shipping-method-iphone" style="padding-top:-5px;">                        
                </div>
                <style>
					#method{
						width:100%!important;
					}
				</style>
                <input type="text" id="coupon-code-phone" name="coupon-code-phone" placeholder="Promo Code " class="col-sm-2 inputp input-form-Font" style="width:100%;height:33px;">	
                <button onclick="checkcoupon();" class="button_primary button-Font button_size_full" >
					Update
				</button>

		    </div>
    	</div>
        -->
        
    	<div class="col-sm-2">
        	&nbsp;
    	</div>
    	<div class="col-sm-3 ">
    		<div style="text-align:right;margin-top: 10px; width: 238px;" class="payment_shopping info-cart-Font info-cart">
            
		    	<table width="100%">
                	<tr>
                    	<td width="50%" align="left">SUB TOTAL</td>
                        <td width="10%">&nbsp;</td>
                        <td width="10%"><?=$sign?></td>
                        <td width="10%">&nbsp;</td>
                        <td width="20%">
                        <?php
							$ttl1 = 0;
							foreach($cart as $c)
							{
								$itemprice = $c['price'] * $c['quantity'];
								$ttl1 += $itemprice;
							}
						?>
                        <div id="totalitem"><?php echo number_format($ttl1 * $cur_val,2,'.',',');?></div></td>
                    </tr>
                    <tr height="20">
                    	<td colspan="5">&nbsp;&nbsp;</td>
                    </tr> 
                    <tr>
                    	<td width="50%" align="left">Shipping </td>
                        <td width="8%">&nbsp;</td>
                        <td width="9%"><?=$sign?></td>
                        <td width="8%">&nbsp;</td>
                        <td width="20%"><div id="shipping-cost"></div></td>
                    </tr>                   
                    
                    <tr height="20">
                    	<td colspan="5">&nbsp;&nbsp;</td>
                    </tr>
                    <tr id="discount-tr">
                    	<td width="50%" align="left">Discount </td>
                        <td width="8%">&nbsp;</td>
                        <td width="9%"><?=$sign?></td>
                        <td width="8%">&nbsp;</td>
                        <td width="20%"><div id="discount-cost"></div></td>
                    </tr>
                    <tr id="price-gap" height="20">
                    	<td colspan="5">&nbsp;&nbsp;</td>
                    </tr>
                    <? 
					$user = $this->session->userdata('userloggedin');
					$customer = $this->Customer_model->identify($user['customer_id']); 
					if($customer['membership_status']>1){
						if($customer['membership_status']==2){$vr='0%';}//$vr='5%';}
						if($customer['membership_status']==3){$vr='0%';}//$vr='10%';}
						?>
					<!-- <tr id="discountmember-tr">
                    	<td width="50%" align="left">Member Discount (<?=$vr?>) </td>
                        <td width="8%">&nbsp;</td>
                        <td width="9%"><?=$sign?></td>
                        <td width="8%">&nbsp;</td>
                        <td width="20%"><div id="memberdiscount-cost"></div></td>
                    </tr>     -->                
                    <? } ?>
                    <!-- <tr id="price-gap2" height="20">
                    	<td colspan="5">&nbsp;&nbsp;</td>
                    </tr> -->
                    <tr style="border-top: 1px solid #333;">
                    	<td width="45%" align="left"><div style="margin-top:5px;margin-bottom:5px;">TOTAL </div></td>
                        <td width="10%">&nbsp;</td>
                        <td width="10%"><div style="margin-top:5px;margin-bottom:5px;"><?=$sign?></div></td>
                        <td width="10%">&nbsp;</td>
                        <td width="20%"><div id="totalprice" style="margin-top:5px;margin-bottom:5px;"></div></td>
                    </tr>
                    <tr height="1" style="border-top:4px solid #333;">
                    	<td colspan="5">&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="50%" align="left">TAX / GST </td>
                        <td width="8%">&nbsp;</td>
                        <td width="9%"><?=$sign?></td>
                        <td width="8%">&nbsp;</td>
                        <td width="20%"><div id="tax"></div></td>
                    </tr>
                    
                    
                </table>				
		    </div>
            
    	</div>
    </div>
    
    </form>
    <div style="clear: both">
    </div>
    <div style="height: 30px" class="hidden-xs"></div>
    <div class="">
    	<div class="col-sm-8 hidden-xs">
    		&nbsp;
    	</div>
    	<div class="span4 hidden-xs">
    		<div class="payment_shopping" style="width:100%;">
	    		<button onclick="checkout();" class="cnt_btt button_primary button-Font" style="width:235px;float:right;">
					Continue
				</button>
				
			</div>
    	</div>
        <div class="span4 visible-xs">
    		<div  style="width:100%;">
	    		<button onclick="checkout();" class="cnt_btt button_primary button-Font button_size_full">
					Continue
				</button>
				
			</div>
    	</div>
    </div>
    <!-- <div style="float: left">
    	
    	
    </div> -->
    <!-- <div style="float: right; font-family: open sans">
		
	</div> -->
    <div style="height: 10px; clear: both"></div>
    
    
    <div style="height: 40px;"></div>
    
    <!-- Menu for phone mode -->
    
    
    <div id="deleteModal" class="popup-Font modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
	<button type="button button-Font" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h3 id="myModalLabel">Delete Cart Item</h3>
	</div>
	<div class="modal-body body-copy-Font">
	    <p>Are you sure to delete this item?</p>
	</div>
	<div class="modal-footer">
	<button class="btn button-Font" data-dismiss="modal" aria-hidden="true">Close</button>
	<button class="btn btn-primary button-Font" onclick="deletecart(choose)">Delete</button>
	
	</div>
	</div>
	
	<div id="anyModal" class="popup-Font modal mymodal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="mytop-modal" onclick="$('#anyModal').modal('hide');">
        <img src="<?=base_url()?>img/close_sign.png" alt=""/>
    </div>
    <div class="modal-body mybody-moda body-copy-Font">
        <p id="any_message"></p>
    </div>
    </div>
    
    
    <div id="shipping-modal" class="popup-Font modal mymodal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="mytop-modal" onclick="$('#shipping-modal').modal('hide');">
        <img src="<?=base_url()?>img/close_sign.png" alt=""/>
    </div>
    <div class="modal-body mybody-modal body-copy-Font">
    <p>How is this calculated?</p>
    <div>
	    	<button class="btn btn-primary button-Font" data-dismiss="modal" aria-hidden="true">Close</button>
	    </div>
    </div>
    
    </div>
    
    
    <!-- Menu Phone End-->
    
    <!-- Menu and Product List for desktop and Ipad version -->
   	
    
    <!-- Menu for desktop and Ipad end -->
    
    <!-- Product for IPhone -->   
    
    <!-- End Product for Iphone -->
		
        
   