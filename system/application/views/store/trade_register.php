

<style>
div.vertical-big { height: 530px !important}
div.vertical-small { height: 430px !important}
div.vertical-tablet { height: 320px !important}

.accordion-group {
   border: none!important;
   border-radius: 0px;
   border-top: 1px dashed #222!important;
}

.accordion-heading .accordion-toggle {
	padding-left:0px!important;
}
a {
    color: #222;
    text-decoration: none;
	font-weight:600;

}
a:hover, a:focus {
	color: #222;
    text-decoration: none;
	font-weight:600;
	
}
.accordion-inner:first-child {
	border-top: 1px dashed #222;
	padding-top:10px;
}
.accordion-inner:last-child {

	padding-bottom:10px;
}

.accordion-inner {
	/*border-top: 1px dashed #222;*/
	border-top:none;
    padding-left: 0px;
	font-size:12px;
	padding-bottom:0px;
	padding-top:2px;
}

.breadcrumb {
    background-color: transparent;
	padding-left:0px;
	font-size:12px;
	margin-bottom:0px!important;
}
.breadcrumb > .active {
    color: #222222;
}
.prod_title{
	font-size:12px;
}

.nav > li a:hover, nav >li a:focus {
	background-color:#A7A7A7;
	
}

.nav-collapse2 .nav >li >a, .nav-collapse .dropdown-menu a{
	border-radius: 3px 3px 3px 3px;
	padding:10px;
}
.nav-collapse3 .nav >li >a, .nav-collapse .dropdown-menu a{
	border-radius: 3px 3px 3px 3px;
	padding:10px;
}
.nav-collapse4 .nav >li >a, .nav-collapse .dropdown-menu a{
	border-radius: 3px 3px 3px 3px;
	padding:10px;
}
.nav-collapse5 .nav >li >a, .nav-collapse .dropdown-menu a{
	border-radius: 3px 3px 3px 3px;
	padding:10px;
}

@media (max-width: 480px) {
.accordion-heading .accordion-toggle {
	/*padding-left:15px!important;*/
}


.vertical .carousel-inner {
  height: 100%;
}

.carousel.vertical .item {
  -webkit-transition: 0.6s ease-in-out top;
     -moz-transition: 0.6s ease-in-out top;
      -ms-transition: 0.6s ease-in-out top;
       -o-transition: 0.6s ease-in-out top;
          transition: 0.6s ease-in-out top;
}

.carousel.vertical .active {
  top: 0;
}

.carousel.vertical .next {
  top: 100%;
}

.carousel.vertical .prev {
  top: -100%;
}

.carousel.vertical .next.left,
.carousel.vertical .prev.right {
  top: 0;
}

.carousel.vertical .active.left {
  top: -100%;
}

.carousel.vertical .active.right {
  top: 100%;
}

.carousel.vertical .item {
    left: 0;
}
}

@media (min-width: 980px) and (max-width: 1199px) {
	
	div.show-small
	{
		display:block !important;
	}
	
	div.hide-small
	{
		display:none !important;
	}
	 
	 }
	 
@media (min-width: 1200px) {
	
	div.show-small
	{
		display:none !important;
	}
	
	div.hide-small
	{
		display:block !important;
	}
	 
	 }

</style>

<script>
function check()
{
	alert('aa');
	
	return false;
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
</script>



<div style="font-family: 'open sans'" class="app-container">
	
	
    
    <div style="height: 20px;"></div>
    <h4>CREATE AN ACCOUNT WITH SPENCER &amp; RUTHERFORD</h4>
    <div style="background:#F1F0F1; padding-left:40px; padding-top:20px;padding-bottom:10px;">
    <span >
    	Once you create an account at Spencer &amp; Rutherford, you can personalize your address book and add favorites to your<br/>
    	Wish list with easel What are you you waiting for?<br/><br/>
    	<span style="font-style: italic">*All form field are mandatory</span>
    </span>
    <div style="margin-top: 20px"></div>
    <form method="post" action="<?=base_url()?>cart/trade_register_new">
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Title
    </div>
    <div style="float: left; width: 300px">
    	<input type="text" style="border: 1px solid #cac5c2; width: 30%; float: right; margin-right: -5%" name="title"/>
    </div>
    <div style="clear: both; height: 10px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	First Name*
    </div>
    <div style="float: left; width: 300px">
    	<input type="text" style="border: 1px solid #cac5c2; width: 100%" name="first_name" required/>
    </div>
    <div style="clear: both; height: 10px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Surname*
    </div>
    <div style="float: left; width: 300px">
    	<input type="text" style="border: 1px solid #cac5c2; width: 100%" name="last_name" required/>
    </div>
    <div style="clear: both; height: 10px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Website Address
    </div>
    <div style="float: left; width: 300px">
    	<input type="text" style="border: 1px solid #cac5c2; width: 100%" name="website"/>
    </div>
    <div style="clear: both; height: 10px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Email Address*
    </div>
    <div style="float: left; width: 300px">
    	<input type="text" style="border: 1px solid #cac5c2; width: 100%" name="email" required/>
    </div>
    <div style="clear: both; height: 10px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Confirm Email Address*
    </div>
    <div style="float: left; width: 300px">
    	<input type="text" style="border: 1px solid #cac5c2; width: 100%" name="email_conf" required/>
    </div>
    <div style="clear: both; height: 10px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Password*
    </div>
    <div style="float: left; width: 300px">
    	<input type="password" style="border: 1px solid #cac5c2; width: 100%" name="password" required/>
    </div>
    <div style="clear: both; height: 10px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Retype your password*
    </div>
    <div style="float: left; width: 300px">
    	<input type="password" style="border: 1px solid #cac5c2; width: 100%" name="re-pass" required/>
    </div>
    <div style="clear: both; height: 50px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Registered Business Name*
    </div>
    <div style="float: left; width: 300px">
    	<input type="text" style="border: 1px solid #cac5c2; width: 100%" name="bussiness_name" required/>
    </div>
    <div style="clear: both; height: 10px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Trading As
    </div>
    <div style="float: left; width: 300px">
    	<input type="text" style="border: 1px solid #cac5c2; width: 100%" name="trading"/>
    </div>
    <div style="clear: both; height: 10px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	ABN
    </div>
    <div style="float: left; width: 300px">
    	<input type="text" style="border: 1px solid #cac5c2; width: 100%" name="abn"/>
    </div>
    <div style="clear: both; height: 10px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Telephone*
    </div>
    <div style="float: left; width: 300px">
    	<input type="text" style="border: 1px solid #cac5c2; width: 100%" name="telephone" required/>
    </div>
    <div style="clear: both; height: 10px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Fax
    </div>
    <div style="float: left; width: 300px">
    	<input type="text" style="border: 1px solid #cac5c2; width: 100%" name="fax"/>
    </div>
    <div style="clear: both; height: 10px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Mobile
    </div>
    <div style="float: left; width: 300px">
    	<input type="text" style="border: 1px solid #cac5c2; width: 100%" name="mobile"/>
    </div>
    <div style="clear: both; height: 10px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Retail Address1*
    </div>
    <div style="float: left; width: 300px">
    	<input type="text" style="border: 1px solid #cac5c2; width: 100%" name="address" required/>
    </div>
    <div style="clear: both; height: 10px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Retail Address2
    </div>
    <div style="float: left; width: 300px">
    	<input type="text" style="border: 1px solid #cac5c2; width: 100%" name="address2"/>
    </div>
    <div style="clear: both; height: 10px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Town / Suburb*
    </div>
    <div style="float: left; width: 300px">
    	<input type="text" style="border: 1px solid #cac5c2; width: 100%" name="suburb" required/>
    </div>
    <div style="clear: both; height: 10px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	State / Province*
    </div>
    <div style="float: left; width: 300px">
    	<select style="width: 105%" name="province" id="province" required>
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
    <div style="clear: both; height: 10px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Country*
    </div>
    <div style="float: left; width: 300px">
    	<select onchange="country_change();" style="width: 105%" name="country" id="country" required>
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
    <div style="clear: both; height: 10px;"></div>
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Postcode*
    </div>
    <div style="float: left; width: 300px">
    	<input type="text" style="border: 1px solid #cac5c2; width: 100%" name="postcode" required/>
    </div>
    <div style="clear: both; height: 10px;"></div>
    
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Please select appropriate business type
    </div>
    <div style="float: left; width: 200px">
    	<div style="height: 30px; line-height: 30px;">
    		<input type="checkbox" name="btype[]" value="Fashion Appreal"/> Fashion Apparel
    	</div>
    	<div style="height: 30px; line-height: 30px;">
    		<input type="checkbox" name="btype[]" value="Speciality Retail"/> Speciality Retail
    	</div>
    	<div style="height: 30px; line-height: 30px;">
    		<input type="checkbox" name="btype[]" value="Promotions"/> Promotions
    	</div>
    	<div style="height: 30px; line-height: 30px;">
    		<input type="checkbox" name="btype[]" value="Florist"/> Florist
    	</div>
    	<div style="height: 30px; line-height: 30px;">
    		<input type="checkbox" name="btype[]" value="Newsagent"/> Newsagent
    	</div>
    </div>
    <div style="float: left; width: 200px">
    	<div style="height: 30px; line-height: 30px;">
    		<input type="checkbox" name="btype[]" value="Accessories"/> Accessories
    	</div>
    	<div style="height: 30px; line-height: 30px;">
    		<input type="checkbox" name="btype[]" value="Interior Designer"/> Interior Designer
    	</div>
    	<div style="height: 30px; line-height: 30px;">
    		<input type="checkbox" name="btype[]" value="Department Store"/> Department Store
    	</div>
    	<div style="height: 30px; line-height: 30px;">
    		<input type="checkbox" name="btype[]" value="Wedding / Gift Store"/> Wedding / Gift Store
    	</div>
    	<div style="height: 30px; line-height: 30px;">
    		<input type="checkbox" name="btype[]" value="Other"/> Other
    	</div>
    </div>
    <div style="float: left; width: 200px">
    	<div style="height: 30px; line-height: 30px;">
    		<input type="checkbox" name="btype[]" value="Homewares"/> Homewares
    	</div>
    	<div style="height: 30px; line-height: 30px;">
    		<input type="checkbox" name="btype[]" value="Pharmacy"/> Pharmacy
    	</div>
    	<div style="height: 30px; line-height: 30px;">
    		<input type="checkbox" name="btype[]" value="Furniture"/> Furniture
    	</div>
    	<div style="height: 30px; line-height: 30px;">
    		<input type="checkbox" name="btype[]" value="Party Plan"/> Party Plan
    	</div>
    	<div style="height: 30px; line-height: 30px;">
    		&nbsp;
    	</div>
    </div>
    
    <div style="clear: both; height: 10px;"></div>
    
    
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	Product interested in stocking
    </div>
    <div style="float: left; width: 200px">
    	<div style="height: 30px; line-height: 30px;">
    		<input type="checkbox" name="interested[]" value="Handbags"/> Handbags
    	</div>
    	<div style="height: 30px; line-height: 30px;">
    		<input type="checkbox" name="interested[]" value="Luggage"/> Luggage
    	</div>
    	<div style="height: 30px; line-height: 30px;">
    		<input type="checkbox" name="interested[]" value="Wallets & Accessories"/> Wallets &amp; Accessories
    	</div>
    </div>
    
    
    <div style="clear: both; height: 10px;"></div>
    
    <div style="float: left; width: 300px; height: 30px; line-height: 30px">
    	&nbsp;
    </div>
    <div style="float: left; width: 300px">
    	<input type="submit" value="SEND" style="background: #000; color: #fff; width: 230px; height: 35px; border:none; margin-left: 100%; font-size: 16px;"/>
    </div>
    </div>
    <div style="clear: both; height: 10px;"></div>
    </form>
    <!-- Menu Phone End-->
    
    <!-- Menu and Product List for desktop and Ipad version -->
   	
    
    <!-- Menu for desktop and Ipad end -->
    
    <!-- Product for IPhone -->   
    
    <!-- End Product for Iphone -->
		
        
   