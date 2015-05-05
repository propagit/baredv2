<script type="text/javascript" src="<?=base_url();?>js/jsr_class.js"></script>
<script>


function register() 
{		
	
	var firstname=jQuery("#firstname").val();
	var lastname=jQuery("#lastname").val();
	var email=jQuery("#email").val();
	var dob=jQuery("#dob").val();	
	var password=jQuery("#password").val();
	var address1=jQuery("#address1").val();
	var address2=jQuery("#address2").val();
	var suburb=jQuery("#suburb").val();
	var country=jQuery("#country").val();
	var state=jQuery("#province").val();
	var postcode=jQuery("#postcode").val();
	//var mobile=jQuery("#mobile").val();
	var title = jQuery('#title').val();
	jQuery.ajax({
		url: '<?=base_url()?>cart/traderegister2',
		type: 'POST',
		data: ({firstname:firstname,lastname:lastname, dob:dob, email:email, password:password, address1:address1, address2:address2, suburb:suburb, country:country, state:state, postcode:postcode,title:title}),
		dataType: "html",
		success: function(data) {
			
			if(data==1)
			{
				//clear();
				//jQuery('#alert-welcome').show();			
				//$(':input').not(':button, :submit, :reset, :hidden').val('');
				window.location="<?=base_url()?>cart/checkout";
			}
			else if(data==2)
			{
				//clear();
				jQuery('#alert-register').show();			
			}
			
			
			
		}
	});
	
}

</script>





<div class="app-container">
<script>
function check_form()
{
	var ps1 = jQuery("#password").val();
	var ps2 = jQuery("#password2").val();
	var title = jQuery('#title').val();
	var msg = '';
	var valid = true;
	if(ps1 != ps2)
	{
		msg = 'Your new password and retyped new password do not match';
		valid = false;
	}
	
	if(!title){
		msg = 'Please select your title';
		valid = false;	
	}
	
	
	if(valid){
		return true;	
	}else{
		jQuery('#any_message_footer').html(msg);
		jQuery('#anyModalFooter').modal('show');
		return false;
	}
}
</script>
	
    
    <div style="height: 20px;"></div>
    <h4>My Account</h4>
    <!-- <span >
    	Once you create an account at Spencer &amp; Rutherford, you can personalize your address book and add favorites to your<br/>
    	Wish list with easel What are you you waiting for?<br/><br/>
    	<span style="font-style: italic">*All form field are mandatory</span>
    </span> -->
     <div style="height: 20px;"></div>
    <div class="edit_retail_bg">
    	<div id="left-side" style="float: left">
		    <form class="form-horizontal" id="registerForm" onsubmit="return check_form();"  name="registerForm" method="post" action="<?=base_url()?>store/update_retail" autocomplete="off">
		    <input type="hidden" name="id" value="<?=$cust['id']?>"/>
		    <div class="body-copy-Font mandatory" style="">
		    	*Mandatory Field
		    </div>
            
		    <div style="clear: both; height: 20px;"></div>
		    <div class="label-form-Font signup-label">
		    	Title*
		    </div>
		    <div class="signup-input-space">
		    	<select class="input-form-Font" style="width: 105%; float: left;" name="title" id="title" required>
                	<?php if($cust['title'] == '') { ?>
                	<option value="">Select One</option>
                    <?php } ?>
                    <option value="Mr" <?=$cust['title'] == 'Mr' ? 'selected="selected"' : '';?>>Mr</option>
                     <option value="Miss" <?=$cust['title'] == 'Miss' ? 'selected="selected"' : '';?>>Miss</option>
                    <option value="Mrs" <?=$cust['title'] == 'Mrs' ? 'selected="selected"' : '';?>>Mrs</option>
                    <option value="Ms" <?=$cust['title'] == 'Ms' ? 'selected="selected"' : '';?>>Ms</option>
                </select>
		    </div>
            
		    <div style="clear: both; height: 10px;"></div>
		    <div class="label-form-Font signup-label">
		    	First Name*
		    </div>
		    <div class="signup-input-space">
		    	<input type="text" id="firstname" name="firstname" class="signup-input input-form-Font" value="<?=$cust['firstname']?>" required/>
		    </div>
		    <div style="clear: both; height: 10px;"></div>
		    <div class="label-form-Font signup-label">
		    	Surname*
		    </div>
		    <div class="signup-input-space">
		    	<input type="text" id="lastname" name="lastname" class="signup-input input-form-Font" value="<?=$cust['lastname']?>" required/>
		    </div>
		    <div style="clear: both; height: 10px;"></div>
		    <div class="label-form-Font signup-label">
		    	Date of Birth
		    </div>
		    <div class="signup-input-space-birth">
		    	<!-- <div id="dob1" class="input-append">
				<input data-format="dd-MM-yyyy" type="text" name="birthday" id="dob" style="width: 273px;" value="<?=date('d-m-Y',strtotime($cust['birthday']))?>" required></input>
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
				</script> -->
				<select class="input-form-Font" style="width: 50%; float: left; margin-right: 3.5%" name="date_dob" id="date_dob" required>
					<?php
						for($i=1;$i<=31;$i++)
						{
						?>
						<option <?php if($cust['date_dob'] == $i) {echo "selected='selected'";}?> value="<?=$i?>"><?=$i?></option>
						<?
						}
					?>
				</select>
				<select class="input-form-Font" style="width: 45%; float: left;" name="month_dob" id="month_dob" required>
					<option <?php if($cust['month_dob'] == 1) {echo "selected='selected'";}?> value="1">January</option>
					<option <?php if($cust['month_dob'] == 2) {echo "selected='selected'";}?> value="2">February</option>
					<option <?php if($cust['month_dob'] == 3) {echo "selected='selected'";}?> value="3">March</option>
					<option <?php if($cust['month_dob'] == 4) {echo "selected='selected'";}?> value="4">April</option>
					<option <?php if($cust['month_dob'] == 5) {echo "selected='selected'";}?> value="5">May</option>
					<option <?php if($cust['month_dob'] == 6) {echo "selected='selected'";}?> value="6">June</option>
					<option <?php if($cust['month_dob'] == 7) {echo "selected='selected'";}?> value="7">July</option>
					<option <?php if($cust['month_dob'] == 8) {echo "selected='selected'";}?> value="8">August</option>
					<option <?php if($cust['month_dob'] == 9) {echo "selected='selected'";}?> value="9">September</option>
					<option <?php if($cust['month_dob'] == 10) {echo "selected='selected'";}?> value="10">October</option>
					<option <?php if($cust['month_dob'] == 11) {echo "selected='selected'";}?> value="11">November</option>
					<option <?php if($cust['month_dob'] == 12) {echo "selected='selected'";}?> value="12">December</option>
				</select>
				
		    </div>
		    <div style="clear: both; height: 10px;"></div>
		    <div class="label-form-Font signup-label">
		    	Email Address*
		    </div>
		    <div class="signup-input-space">
		    	<input type="text" id="email" name="email" class="signup-input input-form-Font" value="<?=$cust['email']?>" required/>
		    </div>
		    <div style="clear: both; height: 10px;"></div>
		    
		    <div class="label-form-Font signup-label">
		    	Password
		    </div>
		    <div class="signup-input-space">
		    	<input id="password" name="password" type="password" class="signup-input input-form-Font"/>
		    </div>
		    <div style="clear: both; height: 10px;"></div>
		    <div class="label-form-Font signup-label">
		    	Retype your password
		    </div>
		    <div class="signup-input-space">
		    	<input id="password2" name="password2" type="password" class="signup-input input-form-Font"/>
		    </div>
		    <div style="clear: both; height: 30px;"></div>
		    <div class="label-form-Font signup-label">
		    	Phone*
		    </div>
		    <div class="signup-input-space">
		    	<input placeholder="+61 3 9536 8777" type="text" id="phone" name="phone" class="signup-input input-form-Font" value="<?=$cust['phone']?>" required/>
		    </div>
		    <div style="clear: both; height: 10px;"></div>
		    <div class="label-form-Font signup-label">
		    	Mobile
		    </div>
		    <div class="signup-input-space">
		    	<input placeholder="0400 111 222" type="text" id="mobile" name="mobile" class="signup-input input-form-Font" value="<?=$cust['mobile']?>"/>
		    </div>
		    <div style="clear: both; height: 10px;"></div>
		    <div class="label-form-Font signup-label">
		    	Address1*
		    </div>
		    <div class="signup-input-space">
		    	<input type="text" id="address1" name="address1" class="signup-input input-form-Font" value="<?=$cust['address']?>" required/>
		    </div>
		    <div style="clear: both; height: 10px;"></div>
		    <div class="label-form-Font signup-label">
		    	Address2
		    </div>
		    <div class="signup-input-space">
		    	<input type="text" id="address2" name="address2" class="signup-input input-form-Font" value="<?=$cust['address2']?>"/>
		    </div>
		    <div style="clear: both; height: 10px;"></div>
		    <div class="label-form-Font signup-label">
		    	Suburb*
		    </div>
		    <div class="signup-input-space">
		    	<input id="suburb" name="suburb" type="text" class="signup-input input-form-Font" value="<?=$cust['suburb']?>" required/>
		    </div>
		    <div style="clear: both; height: 10px;"></div>
		    <div class="label-form-Font signup-label">
		    	Postcode*
		    </div>
		    <div class="signup-input-space">
		    	<input id="postcode" name="postcode" type="text" class="signup-input input-form-Font" value="<?=$cust['postcode']?>" required/>
		    </div>
		    <div style="clear: both; height: 10px;"></div>
		    <div class="label-form-Font signup-label">
		    	Select your country*
		    </div>
		    <div class="signup-input-space">
		    	<select class="input-form-Font" style="width: 105%" name="country" id="country" required>
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
					<option value="Australia">Australia</option> 
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
					$('#country').val('<?=$cust['country']?>');
				</script>
		    </div>
		    <div style="clear: both; height: 10px;"></div>
		    <div class="label-form-Font signup-label">
		    	Select your state*
		    </div>
		    <div class="signup-input-space">
			    <select class="input-form-Font" style="width: 105%" name="province" id="province" required>
					<option value="" selected="selected">Select State</option>
					<?php
						foreach($states as $state)
						{
						?>
						<option <?php if($state['id'] == $cust['state']){echo "selected='selected'";}?> value="<?=$state['id']?>"><?=$state['name']?></option>		
						<?php
						}
					?>
					<option value="0">Other</option>
				</select>	
		    </div>
		    <div style="clear: both; height: 10px;"></div>
		    
		    <!-- <div style="float: left; width: 260px; height: 30px; line-height: 30px">
		    	Total Spend
		    </div>
		    <div style="float: left; width: 300px">
		    	<?php
		    	echo "$". $this->Customer_model->get_total_spend($cust['id']);
		    	?>
		    </div>
		    <div style="clear: both; height: 10px;"></div> -->
		    <div class="label-form-Font signup-label">
		    	&nbsp;
		    </div>
		    <div class="signup-input-space" >
		    	<input type="submit" value="Update" class="button_primary button_size_full_plus5 button-Font" />
		    </div>
		    <div style="clear: both; height: 10px;"></div>
		    </form>
	    </div>
	    <div class="status_box" id="phone_h" style="display: none">
	    	<div class="status_box_cont">
	    		<div style="height:33px"></div>
	    		<div class="status_label body-copy-Font" >Membership Status:</div>
	    		<div class="color_active body-copy-Font status_text" >
	    			Active
	    		</div>
	    		<div style="clear: both; height: 7px; border-bottom: 1px solid #000; margin-left: 35px; margin-right: 31px; margin-bottom: 7px;"></div>
	    		
	    		<div class="status_label body-copy-Font">Total Spend:</div>
	    		<div class="body-copy-Font status_text">
	    			<?php
	    			echo "$". number_format($this->Customer_model->get_total_spend($cust['id']),2,'.',',');
	    			?>
	    		</div>
	    		<div style="clear: both; height: 7px; border-bottom: 2px solid #000; margin-left: 35px; margin-right: 31px; margin-bottom: 17px;"></div>
	    		
	    		
	    		<div style="clear: both"></div>
	    	</div>
	    </div>
	    
	    <div class="status_box" id="phone_v" style="display: none">
	    	<div class="status_box_cont">
	    		<div style="height:33px"></div>
	    		<div class="status_label body-copy-Font" >Membership Status:</div>
	    		<div class="color_active body-copy-Font status_text" >
	    			Active
	    		</div>
	    		<div style="clear: both; height: 7px; border-bottom: 1px solid #000; margin-left: 15px; margin-right: 15px; margin-bottom: 7px;"></div>
	    		
	    		<div class="status_label body-copy-Font">Total Spend:</div>
	    		<div class="body-copy-Font status_text">
	    			<?php
	    			echo "$". number_format($this->Customer_model->get_total_spend($cust['id']),2,'.',',');
	    			?>
	    		</div>
	    		<div style="clear: both; height: 7px; border-bottom: 2px solid #000; margin-left: 15px; margin-right: 15px; margin-bottom: 17px;"></div>
	    		
	    		
	    		<div style="clear: both"></div>
	    	</div>
	    </div>
	    <div style="clear: both"></div>
    </div>
    
    
    
    <!-- Menu Phone End-->
    
    <!-- Menu and Product List for desktop and Ipad version -->
   	
    
    <!-- Menu for desktop and Ipad end -->
    
    <!-- Product for IPhone -->   
    
    <!-- End Product for Iphone -->
		
        
   