<script type="text/javascript" src="<?=base_url();?>js/jsr_class.js"></script>
<script>


function register() 
{		
	
	var ps1 = jQuery("#password").val();
	var ps2 = jQuery("#password2").val();
	var valid = 1;
	if(ps1 != ps2)
	{
		valid = 0;
		jQuery('#any_message').html('Your password are not same');
		jQuery('#anyModal').modal('show');
	}
	
	if(valid)
	{
		var firstname=jQuery("#firstname").val();
		var lastname=jQuery("#lastname").val();
		var email=jQuery("#email").val();
		//var dob=jQuery("#dob").val();
		var month_dob = jQuery("#month_dob").val();
		var date_dob = jQuery("#date_dob").val();
		var password=jQuery("#password").val();
		var address1=jQuery("#address1").val();
		var address2=jQuery("#address2").val();
		var suburb=jQuery("#suburb").val();
		var country=jQuery("#country").val();
		var state=jQuery("#province").val();
		var postcode=jQuery("#postcode").val();
		var mobile=jQuery("#mobile").val();
		var phone=jQuery("#phone").val();
		var heardus=jQuery("#heardus").val();
		var personal_referral = jQuery("#personal_referral").val();
		var title = jQuery('#title').val();
		
		if(email!='' && firstname!='' && lastname!='' && password!='' && state!='' && phone!='' && title!='')
		{
		
			jQuery.ajax({
				url: '<?=base_url()?>store/traderegister2',
				type: 'POST',
				data: ({firstname:firstname,lastname:lastname, month_dob:month_dob, date_dob:date_dob, email:email, password:password, address1:address1, address2:address2, suburb:suburb, country:country, state:state, postcode:postcode,phone:phone,mobile:mobile,heardus:heardus,personal_referral:personal_referral,title:title}),
				dataType: "html",
				success: function(data) {					
					if(data==1)
					{						
						window.location="<?=base_url()?>cart/account_page";
					}
					else if(data==2)
					{								
						jQuery('#any_message').html('Account creation unsuccessful. We already have an account with this email address. Please use the forgot password function to retrieve your account password');
						jQuery('#anyModal').modal('show');
					}
				}
			});
		}
		else
		{
			jQuery('#any_message').html('Please enter all the required fields');
			jQuery('#anyModal').modal('show');
		}
	}
}

function country_change()
{
	var new_c = $('#country').val();
	//alert(new_c);
	
	if(new_c != 'Australia')
	{
		$('#province').val(0);
	}
	else
	{
		$('#province').val(1);
	}
}

function check_heardus()
{
	var heard = $('#heardus').val();
	//alert(heard);
	if(heard == 'Professional Referral')
	{
		$('#when_personal_referral').show();
	}
	else
	{
		$('#when_personal_referral').hide();
	}
}

</script>

<div class="app-container">
	
	
    
    <div style="height: 20px;"></div>
    <h4 class="content-wrap">Create an Account With Bared</h4>
    <div style="height: 20px;"></div>
    <div class="signup-background">
    <span class="body-copy-Font">
        <!-- Unlock the door to a world of beautiful opportunities exclusively for you. Sign up to start enjoying the glamourous benefits of <a class="primarylink" style="font-weight:400;" href="<?=base_url()?>store/page/26" target="_blank">The Divine Society of Glamour Devotees</a>
        <br /><br /> -->
    	<span class="body-copy-Font mandatory">*All form fields are mandatory</span>
    </span>
    <div style="margin-top: 20px"></div>
    <form class="form-horizontal" id="registerForm"  name="registerForm" method="post" action="javascript:register();" autocomplete="off">
    
    <div class="form-group">
        <label class="col-sm-3 control-label">Email Address*</label>
        <div class="col-sm-6">
          <input type="email" id="email" class="form-control" id="email" value="<?=$sub_email?>" required>
        </div>
  	</div>
    
    <div class="form-group">
        <label class="col-sm-3 control-label">Title*</label>
        <div class="col-sm-6">
          <select class="form-control" name="title" id="title" required>
        	<option value="">Select One</option>
			<option value="Mr">Mr</option>
            <option value="Miss" >Miss</option>
            <option value="Mrs">Mrs</option>
            <option value="Ms">Ms</option>
		</select>
        </div>
  	</div>
    
    <div class="form-group">
        <label class="col-sm-3 control-label">First Name*</label>
        <div class="col-sm-6">
          <input type="text" id="firstname" class="form-control" required>
        </div>
  	</div>
    
    <div class="form-group">
        <label class="col-sm-3 control-label">Surname*</label>
        <div class="col-sm-6">
          <input type="text" id="lastname" class="form-control" required>
        </div>
  	</div>
    
    <div class="form-group">
        <label class="col-sm-3 control-label">Date of Birth</label>
        <div class="col-sm-6">
           <div class="col-sm-6 x-l-gutter">	
              <select class="form-control" name="date_dob" id="date_dob" required>
                <?php for($i=1;$i<=31;$i++){?>
                    <option value="<?=$i?>"><?=$i?></option>
                <? }?>
              </select>
            </div>
            <div class="col-sm-6 x-r-gutter">
                <select class="form-control" name="month_dob" id="month_dob" required>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>  
            </div>
        </div>
  	</div>
  	
    
    <div class="form-group">
        <label class="col-sm-3 control-label">Passowrd*</label>
        <div class="col-sm-6">
          <input type="password" id="password" class="form-control" required>
        </div>
  	</div>
    
    <div class="form-group">
        <label class="col-sm-3 control-label">Retype your password*</label>
        <div class="col-sm-6">
          <input type="password" id="password2" class="form-control" required>
        </div>
  	</div>
    
    <div class="form-group">
        <label class="col-sm-3 control-label">Phone*</label>
        <div class="col-sm-6">
          <input type="text" id="phone" class="form-control" required>
        </div>
  	</div>
    
    <div class="form-group">
        <label class="col-sm-3 control-label">Mobile*</label>
        <div class="col-sm-6">
          <input type="text" id="mobile" class="form-control" required>
        </div>
  	</div>
    
    <div class="form-group">
        <label class="col-sm-3 control-label">Address1</label>
        <div class="col-sm-6">
          <input type="text" id="address1" class="form-control">
        </div>
  	</div>
    
    <div class="form-group">
        <label class="col-sm-3 control-label">Address2</label>
        <div class="col-sm-6">
          <input type="text" id="address2" class="form-control">
        </div>
  	</div>
    
    <div class="form-group">
        <label class="col-sm-3 control-label">Select your country</label>
        <div class="col-sm-6">
          <select class="form-control" onchange="country_change();" name="country" id="country" >
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
        </div>
  	</div>
    
    <div class="form-group">
        <label class="col-sm-3 control-label">Select your state*</label>
        <div class="col-sm-6">
          <select class="form-control" name="province" id="province" required>
			<option value="" selected="selected">Select State</option>
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
        </div>
  	</div>
    
    <div class="form-group">
        <label class="col-sm-3 control-label">Suburb</label>
        <div class="col-sm-6">
          <input type="text" id="suburb" class="form-control" >
        </div>
  	</div>
   
    <div class="form-group">
        <label class="col-sm-3 control-label">Postcode</label>
        <div class="col-sm-6">
          <input type="text" id="postcode" class="form-control" >
        </div>
  	</div>
    
    <div class="form-group">
        <label class="col-sm-3 control-label">Heard about us</label>
        <div class="col-sm-6">
          <select onchange="check_heardus();" class="form-control" name="heardus" id="heardus">
    		<option value="Google">Google</option>
    		<option value="Facebook">Facebook</option>
    		<option value="Instagram">Instagram</option>
    		<option value="Professional Referral">Professional Referral</option>
    		<option value="Personal Referral">Personal Referral</option>
    		<!-- <option value="Other">Other</option> -->
    	</select>
        </div>
  	</div>
   
    <div class="form-group" style="display:none;" id="when_personal_referral">
        <label class="col-sm-3 control-label">Personal Referral</label>
        <div class="col-sm-6">
          <input type="text" id="personal_referral" class="form-control" >
        </div>
  	</div>

	<div class="form-group">
        <label class="col-sm-3 control-label">&nbsp;</label>
        <div class="col-sm-6">
          <input type="submit" value="Register Now" class="button_primary button_size_fb button-Font"/>
        </div>
  	</div>
    
    
    <div style="clear: both; height: 10px;"></div>
    </form>
    </div>
    
    
   
		
        
   