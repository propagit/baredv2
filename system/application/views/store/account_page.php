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
    
    <div style="margin: 0 auto" class="visible-phone">
		
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
        
		<div class="span7 shipping-tabs">
			<h4>Delivery Details</h4>
			<div style="clear:both;height:20px;"></div>
            <ul class="nav nav-tabs">
              <li class="<?=$this->session->userdata('store_pickup') ? '' : 'active';?>"><a href="#delivery" data-toggle="tab">Delivery</a></li>
              <li class="<?=$this->session->userdata('store_pickup') ? 'active' : '';?>"><a href="#pickup" data-toggle="tab">Pick Up</a></li>
            </ul>
             
            <div class="tab-content">
              <div class="tab-pane <?=$this->session->userdata('store_pickup') ? '' : 'active';?>" id="delivery">
                  	<h4 class="body-copy-Font account-header">Shipping Address (<a  class="body-copy-Font account-header-link" href="javascript:use_billing_address();">Use billing address</a>)</h4>
                    <form class="form-horizontal sa-toggle" method="post" action="<?=base_url()?>cart/save_account_page" id="form-acc" onsubmit="return check_phone();" style=" <?=$this->session->userdata('store_pickup') ? 'display:none;' : '';?>">
                        <div class="control-group">
                            <label class="label-form-Font control-label" for="stitle">
                                <div class="header-form">
                                    Title:
                                </div>
                            </label>
                            <div class="controls">
                                <div id="stitle">
                                    <input class="input-form-Font col-sm-12" type="text" id="input-stitle" name="input-stitle" placeholder="Title">
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="label-form-Font control-label" for="sfirstname">
                                <div class="header-form">
                                    First name:
                                </div>
                            </label>
                            <div class="controls">
                                <div id="sfirstname">
                                    <input class="input-form-Font col-sm-12" type="text" id="input-sfirstname" name="input-sfirstname" placeholder="First name" required>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="label-form-Font control-label" for="slastname">
                                <div class="header-form">
                                    Last name:
                                </div>
                            </label>
                            <div class="controls">
                                <div id="slastname">
                                    <input class="input-form-Font col-sm-12" type="text" id="input-slastname" name="input-slastname" placeholder="Last name" required>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="label-form-Font control-label" for="saddress">
                                <div class="header-form">
                                    Address:
                                </div>
                            </label>
                            <div class="controls">
                                <div id="saddress">
                                    <input class="input-form-Font col-sm-12" type="text" id="input-saddress" name="input-saddress" placeholder="Shipping Addres" required>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="label-form-Font control-label" for="saddress2">
                                <div class="header-form">
                                    Address Line 2:
                                </div>
                            </label>
                            <div class="controls">
                                <div id="saddress2">
                                    <input class="input-form-Font col-sm-12" type="text" id="input-saddress2" name="input-saddress2" placeholder="Shipping Address2">
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="label-form-Font control-label" for="ssuburb">
                                <div class="header-form">
                                    City/Suburb:
                                </div>
                            </label>
                            <div class="controls">
                                <div id="ssuburb">
                                    <input class="input-form-Font col-sm-12" type="text" id="input-ssuburb" name="input-ssuburb" placeholder="Suburb" required>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="label-form-Font control-label" for="scountry">
                                <div class="header-form">
                                    Country:
                                </div>
                            </label>
                            <div class="controls">
                                <div id="scountry">
                                    <select class="input-form-Font col-sm-12" name="input-scountry" id="input-scountry" required onchange="change_country()">
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
                        </div>
                        <div class="control-group" id="a_state">
                            <label class="label-form-Font control-label" for="sstate">
                                <div class="header-form">
                                    State/Province:
                                </div>
                            </label>
                            <div class="controls">
                                <div id="sstate">
                                    <select class="input-form-Font col-sm-12" name="input-sstate" id="input-sstate" required onchange="check_postcode()">
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
                        </div>
                        <div class="control-group">
                            <label class="label-form-Font  control-label" for="spostcode">
                                <div class="header-form">
                                    Postal Code/Zip:
                                </div>
                            </label>
                            <div class="controls">
                                <div id="spostcode">
                                    <input class="input-form-Font col-sm-12" type="text" id="input-spostcode" name="input-spostcode" placeholder="Postcode" required onChange="check_postcode()" >
                                </div>
                            </div>
                        </div>
                        <div style="height: 10px;"></div>
                        <div class="control-group">
                            <div class="controls">
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
        <div class="span4 offset1">
        	<h4>Account Details</h4>
			<div style="clear:both;height:20px;"></div>
            
            <div class="body-copy-Font account-header">Contact Information (<a class="body-copy-Font account-header-link" href="<?=base_url()?>store/edit_detail_retail/<?=$cust['id']?>">Change</a>)</div>
			
		    <form class="form-horizontal">
			    <div class="control-group">
				    <label class="label-form-Font control-label" for="title">
				    	<div class="header-form">
				    		Title:
				    	</div>
				    </label>
				    <div class="controls">
				    	<div id="title">
				    		<div class="input-form-Font hide-contact-information"><?=$cust['title']?></div>
				    		<input class="input-form-Font edit-contact-information col-sm-12" style="display: none" type="text" id="input-title" name="input-title" placeholder="title" value="<?=$cust['title']?>">
				    	</div>
				    </div>
			    </div>
			    <div class="control-group">
				    <label class="label-form-Font control-label" for="dob">
				    	<div class="header-form">
				    		Date of Birth:
				    	</div>
				    </label>
				    <div class="controls">
				    	<div id="dob">
				    		<div class="input-form-Font hide-contact-information"><?=$cust['date_dob']?> <?=date("F", mktime(0, 0, 0, $cust['month_dob'], 10))?></div>
				    		<div id="dob1" class="input-append edit-contact-information" style="display: none">
							<input class="input-form-Font col-sm-12" data-format="dd-MM-yyyy" type="text" name="input-dob" id="input-dob" value="<?=date('d-m-Y',strtotime($cust['birthday']))?>"></input>
							<span style="cursor: pointer" class="add-on">
							  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
							  </i>
							</span>
							</div>
							<script type="text/javascript">
							  jQuery(function() {
							    jQuery('#dob1').datetimepicker({
							      pickTime: false
							    });
							  });
							</script>
				    	</div>
				    </div>
			    </div>
			    <div class="control-group">
				    <label class="label-form-Font control-label" for="firstname">
				    	<div class="header-form">
				    		First name:
				    	</div>
				    </label>
				    <div class="controls">
				    	<div id="firstname">
				    		<div class="input-form-Font hide-contact-information"><?=$cust['firstname']?></div>
				    		<input class="input-form-Font edit-contact-information col-sm-12" style="display: none" type="text" id="input-firstname" name="input-firstname" placeholder="First name" value="<?=$cust['firstname']?>">
				    	</div>
				    </div>
			    </div>
			    <div class="control-group">
				    <label class="label-form-Font control-label" for="lastname">
				    	<div class="header-form">
				    		Last name:
				    	</div>
				    </label>
				    <div class="controls">
				    	<div id="lastname">
				    		<div class="input-form-Font hide-contact-information"><?=$cust['lastname']?></div>
				    		<input class="input-form-Font edit-contact-information col-sm-12" style="display: none" type="text" id="input-lastname" name="input-lastname" placeholder="Last name" value="<?=$cust['lastname']?>">
				    	</div>
				    </div>
			    </div>
			    <div class="control-group">
				    <label class="label-form-Font control-label" for="email">
				    	<div class="header-form">
				    		Email:
				    	</div>
				    </label>
				    <div class="controls">
				    	<div id="email">
				    		<div class="input-form-Font hide-contact-information"><?=$cust['email']?></div>
				    		<input class="input-form-Font edit-contact-information col-sm-12" style="display: none" type="email" id="input-email" name="input-email" placeholder="Email" value="<?=$cust['email']?>">
				    	</div>
				    </div>
			    </div>
			    <div class="control-group">
				    <label class="label-form-Font control-label" for="phone">
				    	<div class="header-form">
				    		Phone:
				    	</div>
				    </label>
				    <div class="controls">
				    	<div id="phone">
				    		<div class="input-form-Font hide-contact-information"><?=$cust['phone']?></div>
				    		<input class="input-form-Font edit-contact-information col-sm-12" style="display: none" type="text" id="input-phone" name="input-phone" placeholder="Phone" value="<?=$cust['phone']?>">
				    	</div>
				    </div>
			    </div>
			    <div class="control-group">
				    <label class="label-form-Font control-label" for="mobile">
				    	<div class="header-form">
				    		Mobile:
				    	</div>
				    </label>
				    <div class="controls">
				    	<div id="mobile">
				    		<div class="input-form-Font hide-contact-information"><?=$cust['mobile']?></div>
				    		<input class="input-form-Font edit-contact-information col-sm-12" style="display: none" type="text" id="input-mobile" name="input-mobile" placeholder="Mobile" value="<?=$cust['mobile']?>">
				    	</div>
				    </div>
			    </div>
			    <div class="control-group edit-contact-information" style="display: none">
				    <div class="controls">
				    	<button type="button" class="button-Font btn btn-primary">Update</button>
				    </div>
			    </div>			    
		    </form><!-- end contact info -->
            
            
        	
        	<div class="body-copy-Font account-header">Billing Address (<a class="body-copy-Font account-header-link" href="<?=base_url()?>store/edit_detail_retail/<?=$cust['id']?>">Change</a>)</div>
			
		    <form class="form-horizontal">
			    <div class="control-group">
				    <label class="label-form-Font control-label" for="title" >
				    	<div class="header-form">
				    		Title:
				    	</div>
				    </label>
				    <div class="controls">
				    	<div id="title" class="input-form-Font hide-billing-information">
				    		<?=$cust['title']?>
				    	</div>
				    </div>
			    </div>
			    <div class="control-group">
				    <label class="label-form-Font control-label" for="firstname">
				    	<div class="header-form">
				    		First name:
				    	</div>
				    </label>
				    <div class="controls">
				    	<div id="firstname" class="input-form-Font hide-billing-information">
				    		<?=$cust['firstname']?>
				    	</div>
				    </div>
			    </div>
			    <div class="control-group">
				    <label class="label-form-Font control-label" for="lastname">
				    	<div class="header-form">
				    		Last name:
				    	</div>
				    </label>
				    <div class="controls">
				    	<div id="lastname" class="input-form-Font hide-billing-information">
				    		<?=$cust['lastname']?>
				    	</div>
				    </div>
			    </div>
			    <div class="control-group">
				    <label class="label-form-Font control-label" for="baddress">
				    	<div class="header-form">
				    		Address:
				    	</div>
				    </label>
				    <div class="controls">
				    	<div id="baddress">
				    		<div class="input-form-Font hide-billing-information"><?=$cust['address']?></div>
				    		<input class="input-form-Font edit-billing-information col-sm-12" style="display: none" type="text" id="input-baddress" name="input-baddress" placeholder="Billing Addres" value="<?=$cust['address']?>">
				    	</div>
				    </div>
			    </div>
			    <div class="control-group">
				    <label class="label-form-Font control-label" for="baddress2">
				    	<div class="header-form">
				    		Address Line 2:
				    	</div>
				    </label>
				    <div class="controls">
				    	<div id="baddress2">
				    		<div class="input-form-Font hide-billing-information"><?=$cust['address2']?></div>
				    		<input class="input-form-Font edit-billing-information col-sm-12" style="display: none" type="text" id="input-baddress2" name="input-baddress2" placeholder="Billing Address2" value="<?=$cust['address2']?>">
				    	</div>
				    </div>
			    </div>
			    <div class="control-group">
				    <label class="label-form-Font control-label" for="bsuburb">
				    	<div class="header-form">
				    		City/Suburb:
				    	</div>
				    </label>
				    <div class="controls">
				    	<div id="bsuburb">
				    		<div class="input-form-Font hide-billing-information"><?=$cust['suburb']?></div>
				    		<input class="input-form-Font edit-billing-information col-sm-12" style="display: none" type="text" id="input-bsuburb" name="input-bsuburb" placeholder="Suburb" value="<?=$cust['suburb']?>">
				    	</div>
				    </div>
			    </div>
			    <div class="control-group">
				    <label class="label-form-Font control-label" for="bcountry">
				    	<div class="header-form">
				    		Country:
				    	</div>
				    </label>
				    <div class="controls">
				    	<div id="bcountry">
				    		<div class="input-form-Font hide-billing-information"><?=$cust['country']?></div>
				    		<select class="input-form-Font edit-billing-information col-sm-12" name="input-bcountry" id="input-bcountry" style="display: none">
								<option value="" selected="selected">Select Country</option> 
								<option value="United States">United States</option> 
								<option value="United Kingdom">United Kingdom</option> 
								<option value="Afghanistan">Afghanistan</option> 
								<option value="Albania">Albania</option> 
								<option value="Algeria">Algeria</option> 
								<option value="American Samoa">American Samoa</option> 
								<option value="Andorra">Andorra</option> 
								<option value="Angola">Angola</option> 
								<option value="Anguilla">Anguilla</option> 
								<option value="Antarctica">Antarctica</option> 
								<option value="Antigua and Barbuda">Antigua and Barbuda</option> 
								<option value="Argentina">Argentina</option> 
								<option value="Armenia">Armenia</option> 
								<option value="Aruba">Aruba</option> 
								<option selected="selected" value="Australia">Australia</option> 
								<option value="Austria">Austria</option> 
								<option value="Azerbaijan">Azerbaijan</option> 
								<option value="Bahamas">Bahamas</option> 
								<option value="Bahrain">Bahrain</option> 
								<option value="Bangladesh">Bangladesh</option> 
								<option value="Barbados">Barbados</option> 
								<option value="Belarus">Belarus</option> 
								<option value="Belgium">Belgium</option> 
								<option value="Belize">Belize</option> 
								<option value="Benin">Benin</option> 
								<option value="Bermuda">Bermuda</option> 
								<option value="Bhutan">Bhutan</option> 
								<option value="Bolivia">Bolivia</option> 
								<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option> 
								<option value="Botswana">Botswana</option> 
								<option value="Bouvet Island">Bouvet Island</option> 
								<option value="Brazil">Brazil</option> 
								<option value="British Indian Ocean Territory">British Indian Ocean Territory</option> 
								<option value="Brunei Darussalam">Brunei Darussalam</option> 
								<option value="Bulgaria">Bulgaria</option> 
								<option value="Burkina Faso">Burkina Faso</option> 
								<option value="Burundi">Burundi</option> 
								<option value="Cambodia">Cambodia</option> 
								<option value="Cameroon">Cameroon</option> 
								<option value="Canada">Canada</option> 
								<option value="Cape Verde">Cape Verde</option> 
								<option value="Cayman Islands">Cayman Islands</option> 
								<option value="Central African Republic">Central African Republic</option> 
								<option value="Chad">Chad</option> 
								<option value="Chile">Chile</option> 
								<option value="China">China</option> 
								<option value="Christmas Island">Christmas Island</option> 
								<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option> 
								<option value="Colombia">Colombia</option> 
								<option value="Comoros">Comoros</option> 
								<option value="Congo">Congo</option> 
								<option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option> 
								<option value="Cook Islands">Cook Islands</option> 
								<option value="Costa Rica">Costa Rica</option> 
								<option value="Cote D'ivoire">Cote D'ivoire</option> 
								<option value="Croatia">Croatia</option> 
								<option value="Cuba">Cuba</option> 
								<option value="Cyprus">Cyprus</option> 
								<option value="Czech Republic">Czech Republic</option> 
								<option value="Denmark">Denmark</option> 
								<option value="Djibouti">Djibouti</option> 
								<option value="Dominica">Dominica</option> 
								<option value="Dominican Republic">Dominican Republic</option> 
								<option value="Ecuador">Ecuador</option> 
								<option value="Egypt">Egypt</option> 
								<option value="El Salvador">El Salvador</option> 
								<option value="Equatorial Guinea">Equatorial Guinea</option> 
								<option value="Eritrea">Eritrea</option> 
								<option value="Estonia">Estonia</option> 
								<option value="Ethiopia">Ethiopia</option> 
								<option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option> 
								<option value="Faroe Islands">Faroe Islands</option> 
								<option value="Fiji">Fiji</option> 
								<option value="Finland">Finland</option> 
								<option value="France">France</option> 
								<option value="French Guiana">French Guiana</option> 
								<option value="French Polynesia">French Polynesia</option> 
								<option value="French Southern Territories">French Southern Territories</option> 
								<option value="Gabon">Gabon</option> 
								<option value="Gambia">Gambia</option> 
								<option value="Georgia">Georgia</option> 
								<option value="Germany">Germany</option> 
								<option value="Ghana">Ghana</option> 
								<option value="Gibraltar">Gibraltar</option> 
								<option value="Greece">Greece</option> 
								<option value="Greenland">Greenland</option> 
								<option value="Grenada">Grenada</option> 
								<option value="Guadeloupe">Guadeloupe</option> 
								<option value="Guam">Guam</option> 
								<option value="Guatemala">Guatemala</option> 
								<option value="Guinea">Guinea</option> 
								<option value="Guinea-bissau">Guinea-bissau</option> 
								<option value="Guyana">Guyana</option> 
								<option value="Haiti">Haiti</option> 
								<option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option> 
								<option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option> 
								<option value="Honduras">Honduras</option> 
								<option value="Hong Kong">Hong Kong</option> 
								<option value="Hungary">Hungary</option> 
								<option value="Iceland">Iceland</option> 
								<option value="India">India</option> 
								<option value="Indonesia">Indonesia</option> 
								<option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option> 
								<option value="Iraq">Iraq</option> 
								<option value="Ireland">Ireland</option> 
								<option value="Israel">Israel</option> 
								<option value="Italy">Italy</option> 
								<option value="Jamaica">Jamaica</option> 
								<option value="Japan">Japan</option> 
								<option value="Jordan">Jordan</option> 
								<option value="Kazakhstan">Kazakhstan</option> 
								<option value="Kenya">Kenya</option> 
								<option value="Kiribati">Kiribati</option> 
								<option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option> 
								<option value="Korea, Republic of">Korea, Republic of</option> 
								<option value="Kuwait">Kuwait</option> 
								<option value="Kyrgyzstan">Kyrgyzstan</option> 
								<option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option> 
								<option value="Latvia">Latvia</option> 
								<option value="Lebanon">Lebanon</option> 
								<option value="Lesotho">Lesotho</option> 
								<option value="Liberia">Liberia</option> 
								<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option> 
								<option value="Liechtenstein">Liechtenstein</option> 
								<option value="Lithuania">Lithuania</option> 
								<option value="Luxembourg">Luxembourg</option> 
								<option value="Macao">Macao</option> 
								<option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option> 
								<option value="Madagascar">Madagascar</option> 
								<option value="Malawi">Malawi</option> 
								<option value="Malaysia">Malaysia</option> 
								<option value="Maldives">Maldives</option> 
								<option value="Mali">Mali</option> 
								<option value="Malta">Malta</option> 
								<option value="Marshall Islands">Marshall Islands</option> 
								<option value="Martinique">Martinique</option> 
								<option value="Mauritania">Mauritania</option> 
								<option value="Mauritius">Mauritius</option> 
								<option value="Mayotte">Mayotte</option> 
								<option value="Mexico">Mexico</option> 
								<option value="Micronesia, Federated States of">Micronesia, Federated States of</option> 
								<option value="Moldova, Republic of">Moldova, Republic of</option> 
								<option value="Monaco">Monaco</option> 
								<option value="Mongolia">Mongolia</option> 
								<option value="Montserrat">Montserrat</option> 
								<option value="Morocco">Morocco</option> 
								<option value="Mozambique">Mozambique</option> 
								<option value="Myanmar">Myanmar</option> 
								<option value="Namibia">Namibia</option> 
								<option value="Nauru">Nauru</option> 
								<option value="Nepal">Nepal</option> 
								<option value="Netherlands">Netherlands</option> 
								<option value="Netherlands Antilles">Netherlands Antilles</option> 
								<option value="New Caledonia">New Caledonia</option> 
								<option value="New Zealand">New Zealand</option> 
								<option value="Nicaragua">Nicaragua</option> 
								<option value="Niger">Niger</option> 
								<option value="Nigeria">Nigeria</option> 
								<option value="Niue">Niue</option> 
								<option value="Norfolk Island">Norfolk Island</option> 
								<option value="Northern Mariana Islands">Northern Mariana Islands</option> 
								<option value="Norway">Norway</option> 
								<option value="Oman">Oman</option> 
								<option value="Pakistan">Pakistan</option> 
								<option value="Palau">Palau</option> 
								<option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option> 
								<option value="Panama">Panama</option> 
								<option value="Papua New Guinea">Papua New Guinea</option> 
								<option value="Paraguay">Paraguay</option> 
								<option value="Peru">Peru</option> 
								<option value="Philippines">Philippines</option> 
								<option value="Pitcairn">Pitcairn</option> 
								<option value="Poland">Poland</option> 
								<option value="Portugal">Portugal</option> 
								<option value="Puerto Rico">Puerto Rico</option> 
								<option value="Qatar">Qatar</option> 
								<option value="Reunion">Reunion</option> 
								<option value="Romania">Romania</option> 
								<option value="Russian Federation">Russian Federation</option> 
								<option value="Rwanda">Rwanda</option> 
								<option value="Saint Helena">Saint Helena</option> 
								<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
								<option value="Saint Lucia">Saint Lucia</option> 
								<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option> 
								<option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option> 
								<option value="Samoa">Samoa</option> 
								<option value="San Marino">San Marino</option> 
								<option value="Sao Tome and Principe">Sao Tome and Principe</option> 
								<option value="Saudi Arabia">Saudi Arabia</option> 
								<option value="Senegal">Senegal</option> 
								<option value="Serbia and Montenegro">Serbia and Montenegro</option> 
								<option value="Seychelles">Seychelles</option> 
								<option value="Sierra Leone">Sierra Leone</option> 
								<option value="Singapore">Singapore</option> 
								<option value="Slovakia">Slovakia</option> 
								<option value="Slovenia">Slovenia</option> 
								<option value="Solomon Islands">Solomon Islands</option> 
								<option value="Somalia">Somalia</option> 
								<option value="South Africa">South Africa</option> 
								<option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option> 
								<option value="Spain">Spain</option> 
								<option value="Sri Lanka">Sri Lanka</option> 
								<option value="Sudan">Sudan</option> 
								<option value="Suriname">Suriname</option> 
								<option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option> 
								<option value="Swaziland">Swaziland</option> 
								<option value="Sweden">Sweden</option> 
								<option value="Switzerland">Switzerland</option> 
								<option value="Syrian Arab Republic">Syrian Arab Republic</option> 
								<option value="Taiwan, Province of China">Taiwan, Province of China</option> 
								<option value="Tajikistan">Tajikistan</option> 
								<option value="Tanzania, United Republic of">Tanzania, United Republic of</option> 
								<option value="Thailand">Thailand</option> 
								<option value="Timor-leste">Timor-leste</option> 
								<option value="Togo">Togo</option> 
								<option value="Tokelau">Tokelau</option> 
								<option value="Tonga">Tonga</option> 
								<option value="Trinidad and Tobago">Trinidad and Tobago</option> 
								<option value="Tunisia">Tunisia</option> 
								<option value="Turkey">Turkey</option> 
								<option value="Turkmenistan">Turkmenistan</option> 
								<option value="Turks and Caicos Islands">Turks and Caicos Islands</option> 
								<option value="Tuvalu">Tuvalu</option> 
								<option value="Uganda">Uganda</option> 
								<option value="Ukraine">Ukraine</option> 
								<option value="United Arab Emirates">United Arab Emirates</option> 
								<option value="United Kingdom">United Kingdom</option> 
								<option value="United States">United States</option> 
								<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option> 
								<option value="Uruguay">Uruguay</option> 
								<option value="Uzbekistan">Uzbekistan</option> 
								<option value="Vanuatu">Vanuatu</option> 
								<option value="Venezuela">Venezuela</option> 
								<option value="Viet Nam">Viet Nam</option> 
								<option value="Virgin Islands, British">Virgin Islands, British</option> 
								<option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option> 
								<option value="Wallis and Futuna">Wallis and Futuna</option> 
								<option value="Western Sahara">Western Sahara</option> 
								<option value="Yemen">Yemen</option> 
								<option value="Zambia">Zambia</option> 
								<option value="Zimbabwe">Zimbabwe</option>		
							</select>
							<script>
								$('#input-bcountry').val('<?=$cust['country']?>');
							</script>
				    	</div>
				    </div>
			    </div>
			    <div class="control-group">
				    <label class="label-form-Font control-label" for="bstate" >
				    	<div class="header-form">
				    		State/Province:
				    	</div>
				    </label>
				    <div class="controls">
				    	<div id="bstate">
				    		<div class="input-form-Font hide-billing-information"><?=$state?></div>
				    		<select class="input-form-Font edit-billing-information col-sm-12" name="input-bstate" id="input-bstate" style="display: none">
								<?php
									foreach($states as $state)
									{
									?>
									<option value="<?=$state['id']?>"><?=$state['name']?></option>		
									<?php
									}
								?>
								<option value="0">Other</option>	
							</select>
							<script>
								$('#input-bstate').val('<?=$cust['state']?>');
							</script>
				    	</div>
				    </div>
			    </div>
			    <div class="control-group">
				    <label class="label-form-Font control-label" for="bpostcode">
				    	<div class="header-form">
				    		Postal Code/Zip:
				    	</div>
				    </label>
				    <div class="controls">
				    	<div id="bpostcode">
				    		<div class="input-form-Font hide-billing-information"><?=$cust['postcode']?></div>
				    		<input class="input-form-Font edit-billing-information col-sm-12" style="display: none" type="text" id="input-bpostcode" name="input-bpostcode" placeholder="Postcode" value="<?=$cust['postcode']?>">
				    	</div>
				    </div>
			    </div>
			    <div class="control-group edit-billing-information" style="display: none">
				    <div class="controls">
				    	<button type="button" class="button-Font btn btn-primary">Update</button>
				    </div>
			    </div>
			   
		    </form><!-- end billing info -->
        	
        	
			
		</div>
        <!-- end account details -->
        
        
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
	
	<div id="anyModal" class="popup-Font modal mymodal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="mytop-modal" onclick="jQuery('#anyModal').modal('hide');">
        <img src="<?=base_url()?>img/close_sign.png" alt=""/>
    </div>
    <div class="modal-body mybody-modal body-copy-Font">
        <p id="any_message"></p>
    </div>
    </div>