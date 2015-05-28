<script>
var choose = 0;

jQuery(function() { 

	<? if($temp==1){?>
	jQuery('#any_message').text("Sorry, we don't have your postcode in our shipping system. Please check your postcode format or contact us.");
	jQuery('#anyModal').modal('show');
	<? } ?>
});

function change_country()
{
	if(jQuery('#input-scountry').val()!=13){
		jQuery('#a_state').hide();
		jQuery('#input-sstate').val(0);
		
	}	
	else
	{
		jQuery('#a_state').show();
		jQuery('#input-sstate').val(<?=$cust['state']?>);
	}
}
function edit_contact_information()
{
	$('.edit-contact-information').show();
	$('.hide-contact-information').hide();
}

function edit_billing_information()
{
	$('.edit-billing-information').show();
	$('.hide-billing-information').hide();
}

function use_billing_address()
{
	var cname = '<?=$cust['country']?>';
	
	jQuery.ajax({
		url: '<?=base_url()?>cart/check_valid_shipping_country',
		type: 'POST',
		data: ({name:cname}),
		dataType: "html",
		success: function(data) {
			if(data != 0)
			{
				$('#input-stitle').val('<?=$cust['title']?>');
				$('#input-sfirstname').val('<?=$cust['firstname']?>');
				$('#input-slastname').val('<?=$cust['lastname']?>');
				$('#input-saddress').val('<?=$cust['address']?>');
				$('#input-saddress2').val('<?=$cust['address2']?>');
				$('#input-ssuburb').val('<?=$cust['suburb']?>');
				$('#input-scountry').val(data);
				$('#input-sstate').val(<?=$cust['state']?>);
				$('#input-spostcode').val('<?=$cust['postcode']?>');
				check_postcode();
			}
			else
			{
				$('#any_message').text("Sorry, currently we cannot ship any item to your country");
				jQuery('#anyModal').modal('show');
			}
		}
	});
	
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
				<td><img src="<?=base_url()?>img/grey-dot1.png" alt=""/></td>
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
		
       <div class="col-sm-12" style="text-align: center">
            <ul class="breadcrumb breadcrum-Font linkbreadcrumb">
                <li class="active2">Shopping Bag <span class="divider">></span></li>
                <li class="active2">Account Details <span class="divider">></span></li>
                <li >Order Summary <span class="divider">></span></li>
                <li>Payment <span class="divider">></span></li>
                <li>Confirmation </li>
            </ul>
        </div>      
		
	</div>
	</div>
	
    
    <div class=" delivery-details-wrap">
    	 <!-- delivery details -->
        
		<div class="col-sm-6 shipping-tabs">
			<h4>Delivery Details</h4>
			<div style="clear:both;height:20px;"></div>
            <ul class="nav nav-tabs">
              <li class="<?=$this->session->userdata('store_pickup') ? '' : 'active';?>"><a href="#delivery" data-toggle="tab">Delivery</a></li>
              <li class="<?=$this->session->userdata('store_pickup') ? 'active' : '';?>"><a href="#pickup" data-toggle="tab">Pick Up</a></li>
            </ul>
             
            <div class="tab-content push fw">
              <div class="tab-pane <?=$this->session->userdata('store_pickup') ? '' : 'active';?>" id="delivery">
                  	<h4 class="body-copy-Font account-header">Shipping Address (<a  class="body-copy-Font account-header-link" href="javascript:use_billing_address();">Use billing address</a>)</h4>
                    <form class="form-horizontal sa-toggle" method="post" action="<?=base_url()?>cart/save_account_page" id="form-acc" onsubmit="return check_phone();" style=" <?=$this->session->userdata('store_pickup') ? 'display:none;' : '';?>">
                       
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Title:</label>
                            <div class="col-sm-6" id="stitle">
                              <input class="form-control" type="text" id="input-stitle" name="input-stitle" placeholder="Title">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">First Name:</label>
                            <div class="col-sm-6" id="sfirstname">
                              <input class="form-control" type="text" id="input-sfirstname" name="input-sfirstname" placeholder="First Name" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Last Name:</label>
                            <div class="col-sm-6" id="slastname">
                              <input class="form-control" type="text" id="input-slastname" name="input-slastname" placeholder="Last Name" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Address:</label>
                            <div class="col-sm-6" id="saddress">
                              <input class="form-control" type="text" id="input-saddress" name="input-saddress" placeholder="Shipping Address" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Address Line 2:</label>
                            <div class="col-sm-6" id="saddress2">
                              <input class="form-control" type="text" id="input-saddress2" name="input-saddress2" placeholder="Shipping Address 2">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">City/Suburb:</label>
                            <div class="col-sm-6" id="ssuburb">
                              <input class="form-control" type="text" id="input-ssuburb" name="input-ssuburb" placeholder="Suburb" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Country:</label>
                            <div class="col-sm-6" id="scountry">
                              <select class="form-control" name="input-scountry" id="input-scountry" required onchange="change_country()">
								  <?php 
  
                                  foreach($countries_all as $ct) {
                                      if($ct['id'] != 238) 
                                      {
                                  ?>
                                      <option value="<?=$ct['id']?>"<?php if($ct['code'] == "AU") print ' selected="selected"'; ?>><?=$ct['name']?></option>
                                  <?php }} ?>	
                              </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">State/Province:</label>
                            <div class="col-sm-6" id="sstate">
                              <select class="form-control" name="input-sstate" id="input-sstate" required onchange="check_postcode()">
								  <?php
                                      foreach($states as $state)
                                      {
                                      ?>
                                      <option value="<?=$state['id']?>"><?=$state['name']?></option>		
                                      <?php
                                      }
                                  ?>
                              </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Postal Code/Zip:</label>
                            <div class="col-sm-6" id="spostcode">
                              <input class="form-control" type="text" id="input-spostcode" name="input-spostcode" placeholder="Postcode" required onChange="check_postcode()" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">&nbsp;</label>
                            <div class="col-sm-6">
                              <button type="submit" style="float: right;" class="app-btn button-Font button_primary">
                                    Continue
                              </button>
                            </div>
                        </div>
                        
                    </form>
              
              </div>
              <div class="tab-pane <?=$this->session->userdata('store_pickup') ? 'active' : '';?>" id="pickup">
              		<div id="store-address" class="shipping-address">
                    	<?php $company_profile = $this->Company_profile_model->get_profile(); ?>
                        <h2><?=$company_profile['company_name'];?></h2>
                        <h3>
                            <?=$company_profile['address1'] . ' ' . $company_profile['address2'];?> <br>
                            <?=$company_profile['suburb'] . ', ' . $company_profile['state'] . ' ' . $company_profile['postcode'];?>
                        </h3>
                        <h3>
                        <?=$company_profile['company_phone'];?><br>
                        <?=$company_profile['company_email'];?>
                        </h3>
                        <p>Visit our <a target="_blank" href="<?=base_url();?>page/Melbourne-Shoe-Store">Contact Us</a> page to find out about our opening hours and how to find us</p>
                        
                         <div class="control-group">
                            <div class="controls">
                                <a href="<?=base_url();?>cart/save_store_pickup" class="button-Font button_primary app-btn pull" style="margin-top:10px;	">
                                    Continue
                                </a>
                            </div>
                        </div>
               		</div>
              </div>
            </div>
            
		</div>
        <!-- end delivery details -->
        
        
        <!-- account details -->
        <div class="col-sm-5 col-sm-offset-1">
        	<h4>Account Details</h4>
			<div style="clear:both;height:20px;"></div>
            
            <div class="body-copy-Font account-header">Contact Information (<a class="body-copy-Font account-header-link" href="<?=base_url()?>store/edit_detail_retail/<?=$cust['id']?>">Change</a>)</div>
			
		    <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Title:</label>
                    <div class="col-sm-6">
                      	<?=$cust['title']?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label">Date of Birth:</label>
                    <div class="col-sm-6">
                      	<?=$cust['date_dob']?> <?=date("F", mktime(0, 0, 0, $cust['month_dob'], 10))?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label">First Name:</label>
                    <div class="col-sm-6">
                      	<?=$cust['firstname']?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label">Last Name:</label>
                    <div class="col-sm-6">
                      	<?=$cust['lastname']?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label">Email:</label>
                    <div class="col-sm-6">
                      	<?=$cust['email']?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label">Phone:</label>
                    <div class="col-sm-6">
                      	<?=$cust['phone']?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label">Mobile:</label>
                    <div class="col-sm-6">
                      	<?=$cust['mobile']?>
                    </div>
                </div>
			    
			   
		    </form><!-- end contact info -->
            
            
        	
        	<div class="body-copy-Font account-header">Billing Address (<a class="body-copy-Font account-header-link" href="<?=base_url()?>store/edit_detail_retail/<?=$cust['id']?>">Change</a>)</div>
			
		    <form class="form-horizontal">
                
                <div class="form-group">
                    <label class="col-sm-4 control-label">Title:</label>
                    <div class="col-sm-6">
                      	<?=$cust['title']?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label">First Name:</label>
                    <div class="col-sm-6">
                      	<?=$cust['firstname']?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label">Last Name:</label>
                    <div class="col-sm-6">
                      	<?=$cust['lastname']?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label">Address:</label>
                    <div class="col-sm-6">
                      	<?=$cust['address']?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label">Address Line 2:</label>
                    <div class="col-sm-6">
                      	<?=$cust['address2']?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label">City/Suburb:</label>
                    <div class="col-sm-6">
                      	<?=$cust['suburb']?>
                    </div>
                </div>
                
			    <div class="form-group">
                    <label class="col-sm-4 control-label">Country:</label>
                    <div class="col-sm-6">
                      	<?=$cust['country']?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label">Postal Code/Zip:</label>
                    <div class="col-sm-6">
                      	<?=$cust['postcode']?>
                    </div>
                </div>
			    
			   
		    </form><!-- end billing info -->
        	
        	
			
	
        <!-- end account details -->
        
        
	</div>

	</div>
    </div>
    
    <script>
	function check_postcode()
	{
		var country_id = jQuery('#input-scountry').val();
		var state_id = jQuery('#input-sstate').val();
		var postcode = jQuery('#input-spostcode').val();		
		jQuery.ajax({
		  url: '<?= base_url() ?>cart/checkupdateshippingmethod/',
		  type: 'POST',
		  data: ({country_id:country_id,state_id:state_id,postcode:postcode}),
		  success: function(html) {
			  
			if(html==-1){
				jQuery('#any_message').text("Sorry, we don't have your postcode in our shipping system. Please check your postcode format and state or contact us.");
				jQuery('#anyModal').modal('show');
				jQuery('#input-spostcode').val('');
				
			}
			
		  }
		})
	}
	
    function check_phone()
    {
    	
		var phone = '<?=$cust['phone']?>';
		var mobile = '<?=$cust['mobile']?>';
		var country_id = jQuery('#input-scountry').val();
		var state_id = jQuery('#input-sstate').val();
		var postcode = jQuery('#input-spostcode').val();	
		var address = jQuery('#input-saddress').val();	
		var firstname = jQuery('#input-sfirstname').val();	
		
		
		if(phone != '' && mobile != '')
		{
			
			if(postcode !='' && address!='' && firstname!=''){
				return true;
			}
			else
			{
				jQuery('#any_message').text("Please fill up your shipping information");
				jQuery('#anyModal').modal('show');
				return false;
			}
			
		}
		else
		{
			jQuery('#any_message').text("Please update your contact information, provide us with your phone and mobile number");
			jQuery('#anyModal').modal('show');
			return false;
		}
		
		
    }
    </script>
    
    <div id="deleteModal" class="popup-Font modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
        <button type="button" class="button-Font close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Delete Cart Item</h3>
        </div>
        <div class="modal-body body-copy-Font">
            <p>Are you sure to delete this item?</p>
        </div>
        <div class="modal-footer">
        <button class="button-Font btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button class="button-Font btn btn-primary" onclick="deletecart(choose)">Delete</button>
        
        </div>
	</div>
	