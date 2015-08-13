<script>
var choose = 0;
var count=1;
</script>

<script type="text/javascript" src="<?=base_url()?>js/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jquery.lightbox-0.5.css" media="screen" />

<script type="text/javascript" src="<?=base_url()?>js/jquery.prettyPhoto.js"></script>
<link type='text/css' rel='stylesheet' href='<?=base_url()?>css/prettyPhoto.css' />

<script>


var new_style = '';
if (navigator.userAgent.search("MSIE") >= 0){
    //alert('"MS Internet Explorer ');
    var position = navigator.userAgent.search("MSIE") + 5;0
    var end = navigator.userAgent.search("; Windows");
    var version = navigator.userAgent.substring(position,end);
    if(version < 9)
    {
    	alert(version + '"');
    }
}
else if (navigator.userAgent.search("Chrome") >= 0){
	//alert('"Google Chrome ');// For some reason in the bser identification Chrome contains the word "Safari" so when detecting for Safari you need to include Not Chrome
	
	// new_style += '<style> ';
	// new_style += '.app-container {margin-top: 30px;} ';
	// new_style += 'body{margin-top:-65px;} ';
	// new_style += 'html{padding-top: 0px ! important;} ';
	// new_style += '</style>';
	
	new_style += '<style> ';
	new_style += '.chrome_button{line-height:inherit} ';
	new_style += '</style>';
	
	document.write(new_style);
    
}
else if (navigator.userAgent.search("Firefox") >= 0){
    //alert('"Mozilla Firefox ');
    
}
else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0){//<< Here
    //alert('"Apple Safari ');
    
    new_style += '<style> ';
	new_style += '.chrome_button{line-height:inherit} ';
	new_style += '</style>';
	
	document.write(new_style);
}
else if (navigator.userAgent.search("Opera") >= 0){
    //alert('"Opera ');
    
}
else{
    //alert('"Other"');
}



jQuery(function() {
  jQuery('.img_display').lightBox();
	
  <? if($this->session->userdata('gift')=='Y')
  { ?>
  
	jQuery('#is_gift').toggle('slow');
  <? } ?>	

	

});

function delete_cart(id)
{
	choose = id;
	//alert(choose);
	jQuery('#deleteModal').modal('show');
}

function deletecart(id)
{
	jQuery('#deleteModal').modal('hide');
	//alert(id);
	
	jQuery.ajax({
		url: '<?=base_url()?>store/removeitem',
		type: 'POST',
		data: ({id:id}),
		dataType: "html",
		success: function(html) {
			jQuery('#cart-'+id).fadeOut('slow');
			//jQuery('#any_message').html("This coupon has been successfully deleted");
			//$('#anyModal').modal('show');
			
		}
	})
}

function paypal_payment()
{
	
	jQuery.ajax({
		url: '<?=base_url()?>cart/save_note_b4_paypal',
		type: 'POST',
		data: ({pmsg:$('#pmsg').val()}),
		dataType: "html",
		success: function(html) {
			window.location="<?=base_url()?>cart/paypal";			
		}
	});
	
	
	//window.location="<?=base_url()?>cart/paypal";	
	/*var gift = jQuery('#gift').val();
	
	var ecard_no = jQuery("input:radio[name=ecard_no]").val();
	var rname = jQuery('#rname').val();
	var yname=jQuery('#yname').val();
	var remail = jQuery('#remail').val();
	var send_gift = jQuery('#send_gift').val();
	var gnote = jQuery('#gnote').val();
	
	jQuery.ajax({
		url: '<?=base_url()?>store/pre_paypal',
		type: 'POST',
		data: ({yname:yname,gift:gift,ecard_no:ecard_no,rname:rname,remail:remail,send_gift:send_gift,gnote:gnote}),
		dataType: "html",
		success: function(html) {
			window.location="<?=base_url()?>cart/paypal";			
		}
	})*/
}

function show_ecard()
{
	
	if(jQuery('#ecard_nos_1').is(':checked'))
	{
		var img = jQuery('#ecard_nos_1').val();
	}
	if(jQuery('#ecard_nos_2').is(':checked'))
	{
		var img = jQuery('#ecard_nos_2').val();
	}
	if(jQuery('#ecard_nos_3').is(':checked'))
	{
		var img = jQuery('#ecard_nos_3').val();
	}
	
	var sender = jQuery('#yname').val();
	var recipient = jQuery('#rname').val();
	var notes = jQuery('#gnote').val();
	
	//alert(img);
	
	jQuery.ajax({
		url: '<?=base_url()?>store/set_ecard_data',
		type: 'POST',
		data: ({img:img,sender:sender,recipient:recipient,notes:notes}),
		dataType: "html",
		success: function(html) {
			open_window('<?=base_url()?>store/ecard_preview');			
		}
	})
	
	//open_window('<?=base_url()?>store/ecard_preview');
}
function check_payment()
{
	var valid=true;
	if(jQuery('#cardtype').val()==''){valid=false;}
	if(jQuery('#cardnumber').val()==''){valid=false;}
	if(jQuery('#cardname').val()==''){valid=false;}
	if(jQuery('#cvvnumber').val()==''){valid=false;}
	
	if (valid) {
		if(count <=1)
		{
			count ++;
			document.payment_form.submit();
		}
		else
		{
			alert('Please wait, your order is being procced');
		}
	}
	else
	{
		alert('Please fill in the required fields');
	}
}
</script>

<div class="app-container content-wrap">
	
	
    
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
		
       <div class="col-sm-12" style="text-align: center">
            <ul class="breadcrumb linkbreadcrumb breadcrumb-Font">
                <li class="active2">Shopping Bag <span class="divider">></span></li>
                <li class="active2">Account Details <span class="divider">></span></li>
                <li class="active2">Order Summary <span class="divider">></span></li>
                <li class="active2">Payment <span class="divider">></span></li>
                <li>Confirmation </li>
            </ul>
        </div>      
		
	</div>
	</div>
	
	<form method="post" action="<?=base_url()?>cart/save_payment" id="payment_form" name="payment_form">
    <!--<h4 class="header-center">Payment</h4>-->
	<div style="height: 20px;"></div>
    <div class="">
			<!-- <div class="col-sm-6">
				<div class="body-copy-Font account-header" style="border-bottom: 1px solid #59595C;">Is this a gift?</div>
				<div class="p-margin-left label-form-Font">
					<div>
						Would you like to advise the recipient that a gift is on the way to them?<br/> <?=$this->session->userdata('rname')?>
						Yes&nbsp;&nbsp;<input onclick="$('#is_gift').toggle('slow');" style="margin-top: 0px" type="checkbox" value="Y" name="gift" id="gift"  <? if($this->session->userdata('gift')=='Y')  { ?> checked="checked"  <? } ?>	>
					</div>
					<div style="clear: both; height: 15px;"></div>
					
					<div id="is_gift" style="display: none">
						<div style="float: left" class="plabel label-form-Font">
							Select ecard
						</div>
						<div class="input-space">
							<table>
	                    		<tr>
	                    			<td>
	                    				<a class="img_display" href="<?=base_url()?>img/ecard/large1.jpg"  title="E-Card">
                                        <img src="<?=base_url()?>img/ecard/ecard1.jpg" alt=""/>
                                        </a>
	                    			</td>
	                    			<td style="padding-left: 10px; padding-right: 10px;">
	                    				<a class="img_display" href="<?=base_url()?>img/ecard/large2.jpg"  title="E-Card">
                                        <img src="<?=base_url()?>img/ecard/ecard2.jpg" alt=""/>
                                        </a>
	                    			</td>
	                    			<td>
	                    				<a class="img_display" href="<?=base_url()?>img/ecard/large3.jpg"  title="E-Card">
                                        <img src="<?=base_url()?>img/ecard/ecard3.jpg" alt=""/>
                                        </a>
	                    			</td>
	                    		</tr>
	                    		<tr>
	                    			<td style="text-align: center; padding-top: 10px"><input style="margin-top: -2px;" type="radio" name="ecard_no"  id="ecard_nos_1" value="1" <? if($this->session->userdata('gift_bg')==1) { ?> checked="checked" <? } ?>	  />&nbsp;#1</td>
	                    			<td style="text-align: center; padding-top: 10px"><input style="margin-top: -2px;" type="radio" name="ecard_no" id="ecard_nos_2" value="2" <? if($this->session->userdata('gift_bg')==2) { ?> checked="checked" <? } ?>/>&nbsp;#2</td>
	                    			<td style="text-align: center; padding-top: 10px"><input style="margin-top: -2px;" type="radio" name="ecard_no" id="ecard_nos_3" value="3" <? if($this->session->userdata('gift_bg')==3) { ?> checked="checked" <? } ?>/>&nbsp;#3</td>
	                    		</tr>
	                    	</table>
						</div>
						<div style="clear: both; height: 10px"></div>
						<div style="float: left" class="plabel label-form-Font">
							Your Name
						</div>
						<div class="input-space">
							<input class="input-form-Font" type="text" name="yname" id="yname" <? if($this->session->userdata('yname')){?> value="<?=$this->session->userdata('yname')?>" <? }?>/>
						</div>
						<div style="clear: both; height: 0px"></div>
                        <div style="float: left" class="plabel label-form-Font">
							Recipient Name
						</div>
						<div class="input-space">
							<input class="input-form-Font" type="text" name="rname" id="rname" <? if($this->session->userdata('rname')){?> value="<?=$this->session->userdata('rname')?>" <? }?>/>
						</div>
						<div style="clear: both; height: 0px"></div>
						<div style="float: left" class="plabel label-form-Font">
							Recipient Email 
						</div>
						<div class="input-space">
							<input class="input-form-Font" type="text" name="remail" id="remail" <? if($this->session->userdata('remail')){?> value="<?=$this->session->userdata('remail')?>" <? }?>/>
						</div>
						<div style="clear: both; height: 0px"></div>
						<div style="float: left" class="plabel label-form-Font">
							Send eCard on
						</div>
						<div class="input-space">
							<div id="dob1" class="input-append">
							<input data-format="dd-MM-yyyy" type="text" name="send_gift" id="send_gift" class="input-form-Font" style="width: 180px;" <? if($this->session->userdata('send_gift')){?> value="<?=$this->session->userdata('send_gift')?>" <? }?>></input>
							<span style="cursor: pointer" class="add-on">
							  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
							  </i>
							</span>
							</div>
							<script type="text/javascript">
							var date = new Date();
							date.setDate(date.getDate());
							
							  jQuery(function() {
							    jQuery('#dob1').datetimepicker({
							      pickTime: false,
							      startDate:date
							    });
							  });
							</script>
						</div>
						<div style="clear: both; height: 0px"></div>
						<div style="float: left" class="plabel label-form-Font">
							Your Message
						</div>
						<div class="input-space">
							<textarea class="input-form-Font" name="gnote" id="gnote" s="3"><? if($this->session->userdata('gnote')){?> <?=$this->session->userdata('gnote')?> <? }?></textarea>
						</div>
						<div style="clear: both"></div>
                        <button onclick="show_ecard();" class="input-space button_primary button-Font" type="button" style="width: 195px;">
						Preview Ecard
						</button>
						<div style="clear: both"></div>
					</div>
				</div>
				
			</div> -->
			<div class="col-sm-6 x-gutters center-wrap">
				<div class="body-copy-Font account-header" id="need_spacing" style="border-bottom: 1px solid #59595C;">Payment Details </div>
				<? if($this->session->userdata('stotal')>0){?>
                
                <div>
                <p class="note-Font pleasenote" style="margin-bottom:20px;">
                Please note: You will be charged in Australian dollars No surcharge on VISA and MASTERCARD<br />
                credit cards. All credit cards are charged at time of order process confirmation. 
                </p>
                </div>
                
                <div style="clear: both; height: 5px; border-bottom: 1px solid #59595C; margin-bottom: 15px"></div>
					
					<div style="float: left; width:50%" class="plabel label-form-Font">
						<strong>Notes</strong> - Please give us information about your feet. For example; I have wide feet, I wear a full length orthotic etc. This will ensure that we send you the right fitting options for your feet.
					</div>
                    
					<div class="input-space col-sm-6 col-xs-12 x-gutters">
						<textarea class="input-form-Font form-control" name="pmsg" id="pmsg" s="3"></textarea>
					</div>
					
                 <div style="clear: both; height: 5px; border-bottom: 1px solid #59595C; margin-bottom: 25px; margin-top:10px;"></div>
                <div class="p-margin-left">
					
                     <div style="display:block;">
                        <div style="float: left; height: 28px; line-height: 28px;" class="hidden-xs label-form-Font">
                            Pay with Paypal
                        </div>
                        <a onclick="paypal_payment();" style="cursor:pointer;">
                        <button type="button" class="input-space button_primary chrome_button button-Font" style="width: 245px;"  >
                            Checkout With Paypal
                        </button>
                        </a>
                    </div>
                    
					<div style="clear: both; border-bottom: 1px solid #59595C; height: 15px"></div>
                   
					<div style="clear: both; height: 15px"></div>
					<div style="float: left" class="plabel label-form-Font">
						Pay by Credit Card*
					</div>
					<div class="input-space col-sm-6 col-xs-12 x-gutters">
						<select class="selectpicker input-form-Font form-control" name="cardtype" id="cardtype" required>
							<option value="">Select card</option>
							<option value="Visa Card">Visa Card</option>
		                    <option value="Master Card">Master Card</option>       
						</select>
					</div>
					<div style="clear: both; height: 0px"></div>
					<div style="float: left" class="plabel label-form-Font">
						Card number*
					</div>
					<div class="input-space col-sm-6 col-xs-12 x-gutters">
						<input class="input-form-Font form-control" type="text" name="cardnumber" id="cardnumber" required/>
					</div>
					<div style="clear: both; height: 0px"></div>
					<div style="float: left" class="plabel label-form-Font">
						Cardholder's name*
					</div>
					<div class="input-space col-sm-6 col-xs-12 x-gutters">
						<input class="input-form-Font form-control" type="text" name="cardname" id="cardname" required/>
					</div>
					<div style="clear: both; height: 0px"></div>
					<div style="float: left" class="plabel label-form-Font">
						Expiration date*
					</div>
					<div class="input-space col-sm-6 col-xs-12 x-gutters">
                    	<div class="col-sm-5 x-gutters">
						<select class="selectpicker month input-form-Font form-control fw" style="width:100%;" name="expmonth" id="expmonth" required>
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
                        </div>
                        <div class="col-sm-5 col-sm-offset-2 col-xs-12 x-gutters">
		                <select class="selectpicker year input-form-Font form-control fw" style="width:100%;" name="expyear" id="expyear"  required>
		                    <?php for($i=date('Y');$i<(date('Y')+10);$i++) { ?>
		                    <option value="<?=$i?>"><?=$i?></option>
		                    <?php } ?>                                                     
		                </select>
                        </div>
					</div>
					<div style="clear: both; height: 0px"></div>
					<div style="float: left" class="plabel label-form-Font">
						Security Code (3-4 Digits)* <a class="body-copy-Font" href='#' onclick="jQuery('#cvv').modal('show');	" data-toggle="modal" style="font-size:10px; font-style:italic;">(What is this?)</a>
					</div>
					<div class="input-space col-sm-6 col-xs-12 x-gutters">
						<input type="text" name="cvvnumber" id="cvvnumber" class="form-control" required/>
					</div>
					
                    <div style="clear: both;"></div>
					
					
                    <div style="height:56px;margin-top:21px;">
					<button class="input-space button_primary chrome_button button-Font" type="button" onclick="check_payment()" style="width:190px">
						Place Order
					</button>
                    </div>
					<div style="clear: both"></div>
				</div>
                
                <? } else {?>
                	<button class="input-space button_primary chrome_button button-Font" type="button" onclick="check_payment()" style="width:190px">
						Place Order
					</button>
                
                <? }?>
			</div>
            
		</div>
	</form>
	<div style="height: 30px;"></div>
	
    
<div id="cvv" class="popup-Font modal mymodal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="mytop-modal" onclick="jQuery('#cvv').modal('hide');">
    <img src="<?=base_url()?>img/close_sign.png" alt=""/>
</div>
<div class="modal-body mybody-modal">
<p>The Card Verification Value (CVV*) is an extra code printed on your debit or credit card.</p><br/>
<p>CVV for Visa is the final three digits of the number printed on the signature strip on the back of your card.</p><br/>
<p align="left"><img src="<?=base_url()?>img/cvv-visa.gif" alt="" width=331 height=82></p><br/>
<p>As the CVV is not embossed (like the card number) the CVV is not printed on any receipts, hence it is not likely to be known by anyone other than the card owner.</p><br/>
<p>CVV is an anti-fraud measure being introduced by credit card companies worldwide. You are required to enter the CVV each time a payment is made and you are not present to sign a receipt, as for on-line transactions. We ask you to fill out the CVV here to verify that you actually hold the card you are using for this transaction, and to avoid anyone other than you from shopping with your card number. All information you submit is transferred over secure SSL connections.</p>
</div>

</div>	
</div>
    

		
        
   