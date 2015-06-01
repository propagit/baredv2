<?php

# Controller: Lightspeed

class Lightspeed extends Controller {
	function __construct() {
		parent::Controller();		
		$this->load->model('Lightspeed_model');   		
		$this->load->model('Product_model');   		
		$this->load->model('Customer_model');  
		$this->load->model('System_model'); 		
	}
	
	function update_lightspeed_customer()
	{
		
		$custs= $this->Lightspeed_model->get_all_customer();
		foreach($custs as $cus)
		{
			$l_id = $this->Lightspeed_model->get_customer_lightspeed($cus['email']);			
			if(count($l_id)>0){
				$light_id = $l_id['lightspeed_id'];
				$data =  array('lightspeed_id' => $light_id);
				$this->Customer_model->update($cus['id'],$data);
			}
			
			
		}
		
	}
	
	function update_stock()
	{
		$lists = $this->Lightspeed_model->list_stock_lightspeed();
		foreach($lists as $list)
		{
			$stock_id='#'.$list['stock_id'].'#';
			$stock_num = $list['num'];
			
			#ID Product
			$products = $this->Lightspeed_model->get_product_stock_lightspeed($stock_id);
			if(isset($products['size_stock_id'])){
				$multiple_stock_id = json_decode($products['size_stock_id'],true);
				if($multiple_stock_id){
					#get size
					foreach ($multiple_stock_id as $key => $value){
						if($value==$stock_id){
							echo  $key . ':' . $value."<br>";
							$size = $key;
						}
					}
					$multiple_stock = json_decode($products['size'],true);
					$multiple_stock[$size]=$stock_num;
					$multiple_stock_json= json_encode($multiple_stock, JSON_FORCE_OBJECT);
					$data=array(
							'size' => $multiple_stock_json
						);
					$this->Product_model->update($products['id'],$data);
				}
			}
		}
	}
	function get_md5()
	{
		//echo md5(816);
		echo date('Y-m-d H:i:');
	}
	
	function get_stock_id($prod_id,$size)
	{
		$products=$this->Lightspeed_model->get_product_stock_id_lightspeed($size,$prod_id);
		if(isset($products['size_stock_id']))	
		{
			$multiple_stock_id = json_decode($products['size_stock_id'],true);
			if($multiple_stock_id){
				#get size
				foreach ($multiple_stock_id as $key => $value){
					if($key==$size){
						#echo  $key . ':' . $value;
						$id = $key;
					}
				}
				
			}
		}
		return $id;
	}
	
	function get_stock()
	{
		$stock_id='#34#';
		$stock_num = 120;
		
		#ID Product
		$products = $this->Lightspeed_model->get_product_stock_lightspeed($stock_id);
		$multiple_stock_id = json_decode($products['size_stock_id'],true);
		
		#get size
		foreach ($multiple_stock_id as $key => $value){
			if($value==$stock_id){
				echo  $key . ':' . $value;
				$size = $key;
			}
		}
		$multiple_stock = json_decode($products['size'],true);
		$multiple_stock[$size]=$stock_num;
		$multiple_stock_json= json_encode($multiple_stock, JSON_FORCE_OBJECT);
		$data=array(
				'size' => $multiple_stock_json
			);
		$this->Product_model->update($products['id'],$data);
		
	}
	
	
	function export_order()
	{
		#exit();
		$orders=$this->Lightspeed_model->get_order_last(3);
		#$message=count($orders);
		$message = "";
		
		if(count($orders)>0)
		{
			foreach($orders as $o)
			{
				$this->set_order($o['id']);
				$message .= $o['id'].','; 
			}
			
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);		
			$this->email->from('no@bared.com.au','Export Order');        		
			$this->email->to('kaushtuv@propagate.com.au');				
			$this->email->subject('Lightspeed @ Bared Online Store');
			$this->email->message($message);
			#$this->email->send();
		}
		
	}
	
	function push_order($customer_id=0)
	{
		#error_reporting(E_ALL);
		$orders=$this->Lightspeed_model->get_order_push($customer_id,3);

		if(count($orders)>0)
		{
			
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);		
			$this->email->from('no@bared.com.au','Push Order');        		
			$this->email->to('kaushtuv@propagate.com.au');				
			$this->email->subject('Push Lightspeed @ Bared Online Store');
			$message='';
			foreach($orders as $o)
			{
				$this->set_order($o['id']); //--> need to open once the changing of payment type and employee id are correct.
				$message = $message.' '.$o['id'];
			}
			
			$this->email->message($message);
			$this->email->send();
			$this->session->set_flashdata('push_order','push');
		}
		else{
			$this->session->set_flashdata('push_order','nopush');
		}
		redirect('admin/customer/list_all/edit/'.$customer_id);
	}

	# clean string
	function _clean_string($string) {
	   $string = str_replace(' ', '-', $string); # Replaces all spaces with hyphens.
	
	   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); # Removes special chars.
	}
	
	
	function set_order($id)
	{
		#die();
		//error_reporting(E_ALL);
		$orders=$this->Lightspeed_model->get_order($id);
		
		$carts=$this->Lightspeed_model->get_cart($orders['session_id']);
		
		$customers = $this->Lightspeed_model->get_customer($orders['customer_id']);
		$lightspeed_id = $customers['lightspeed_id'];
		$email = $customers['email'];
		$firstname = $customers['firstname'];
		$lastname = $customers['lastname'];
		$address = $this->_clean_string($customers['address']);
		$suburb = $customers['suburb'];
		#$state_id = $customers['state'];
		# this is actually be passed on as state name not id, old code was modified but to make sure it affected all the changes the var name was kept as state_id
		if($customers['state']){
			$state_id = $this->System_model->get_state($customers['state']);
		}else{
			$state_id = 'Not Set';	
		}
		$country = $customers['country'];
		$postcode = $customers['postcode'];
		$phone = $customers['phone'];
		$mobile = $customers['mobile'];
		$MOStimestamp = date('Y-m-d H:i:s');
		
		
		# changing state
		
		
		
		
		$xml_create_customer = 
		"<?xml version='1.0'?>
		<Customer>
		  <firstName>$firstname</firstName>
		  <lastName>$lastname</lastName>		  
		  <timeStamp>$MOStimestamp</timeStamp>

		  <taxCategoryID>1</taxCategoryID>
		  <Contact>
			<timeStamp>$MOStimestamp</timeStamp>
			<Addresses>
			  <ContactAddress>
				<address1>$address</address1>
				<city>$suburb</city>
				<state>$state_id</state>
				<zip>$postcode</zip>
				<country>$country</country>
			  </ContactAddress>
			</Addresses>
			<Phones>
			  <ContactPhone>
				<number>$phone</number>
				<useType readonly='true'>Home</useType>
			  </ContactPhone>
			</Phones>
			<Emails>
			  <ContactEmail>
				<address>$email</address>
				<useType readonly='true'>Primary</useType>
			  </ContactEmail>
			</Emails>
		  </Contact>
		</Customer>";
		#echo $xml_create_customer;exit;
		
		$additionalHeaders='';
		
		/*$apikey = '0c58a74d684a750b0a5d2bb55d65362303f4af04110210d7f7d44255131c9a17';
		$password = 'apikey';
		$account_id = 57839;*/
		
		$apikey = '3726fc8d2ff21887004e264b8acd5fed4863220a98cd85eb49aa868e014ff48b';
		$password = 'apikey';
		$account_id = 61853;

		
		
		$cust_id=0;
		$cust_id=$lightspeed_id;
		// Create cURL resource
		
		$curl = curl_init();
		
		// Set URL
		//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/$account_id/Category.xml?nodeDepth=0");
		//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account");
		curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/".$account_id."/Customer?load_relations=[\"Contact\"]");
		//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/".$account_id."/Customer?load_relations=[\"Contact\"]&Emails.ContactEmail.address='raqel@yahoo.com'");
		//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/$account_id/Item.xml?load_relations=all&archived=0&limit=5&offset=2");
		//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/".$account_id."/Sale");
		
		// Authenticate
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, $apikey . ":" . $password); 
		
		// Send content in proper format
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', $additionalHeaders));              
		
		// Set Request Type 
		// (you'll need to change this depending on what you're doing)
		curl_setopt($curl,CURLOPT_HTTPGET, 1);
		//curl_setopt($curl,CURLOPT_POST, 1);  // POST (Create)
		// curl_setopt($curl,CURLOPT_PUT, 1); // PUT (Update)
		// curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'DELETE') // DELETE
		
		// To send parameters (data)
		//curl_setopt($curl, CURLOPT_POSTFIELDS, $xml_create_customer);
		
		
		// Return the transfer as a string
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		
		// $output contains the output string
		$output = curl_exec($curl);
		
		// Close cURL resource to free up system resources
		curl_close($curl);
		
		$xml = simplexml_load_string($output);
		//print_r($xml);
		$emails = $xml->xpath('//Emails');
		
		$customer_ids = $xml->xpath('//customerID');
		
		//print_r($emails);die();

		$i=0;
		$pos=-1;
		foreach($emails as  $purge) { 							
			//echo $purge->ContactEmail->address.' = '.$email.'<br>';
			if($purge->ContactEmail->address==$email)
			{
				$pos=$i;
			}
			$i++;
			
		}		
		//echo $pos.'<br>';

		$j=0;
		if($pos > -1){
			foreach($customer_ids as  $purge) { 				
				//echo $purge.'<br>';
				if($j==$pos)
				{
					$cust_id=$purge;
				}
				$j++;
				
			}
		}

		//exit;
		$cust_id=$lightspeed_id;
		if($cust_id==0)
		{
			
			//echo'create';
			// Create cURL resource
			
			$curl = curl_init();
			
			// Set URL
			//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/$account_id/Category.xml?nodeDepth=0");
			//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account");
			curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/".$account_id."/Customer");
			//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/$account_id/Item.xml?load_relations=all&archived=0&limit=5&offset=2");
			//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/".$account_id."/Sale");
			
			// Authenticate
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($curl, CURLOPT_USERPWD, $apikey . ":" . $password); 
			
			// Send content in proper format
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', $additionalHeaders));              
			
			// Set Request Type 
			// (you'll need to change this depending on what you're doing)
			//curl_setopt($curl,CURLOPT_HTTPGET, 1);
			curl_setopt($curl,CURLOPT_POST, 1);  // POST (Create)
			// curl_setopt($curl,CURLOPT_PUT, 1); // PUT (Update)
			// curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'DELETE') // DELETE
			
			// To send parameters (data)
			curl_setopt($curl, CURLOPT_POSTFIELDS, $xml_create_customer);
			
			
			// Return the transfer as a string
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

			// $output contains the output string
			$output = curl_exec($curl);
			//print_r($output);die();
			// Close cURL resource to free up system resources
			curl_close($curl);
			
			$xml = simplexml_load_string($output);
			//print_r($xml);
			$customer_ids = $xml->xpath('//customerID');
			foreach($customer_ids as $cs)
			{
				$cust_id= $cs;
			}
			$data =  array('lightspeed_id' => $cust_id);
			$this->Customer_model->update($orders['customer_id'],$data);
			
		}
		

		
		if($cust_id > 0)
		{
			//$amount = $orders['total'];
			$amount=0;
			$tx=$orders['tax'];
			$disc=$orders['member_discount']+$orders['discount'];
			
			$shipping=$orders['shipping_cost'];
			
			$paymentTypeID =7; // website order
			if($orders['msg']=='Paypal'){$paymentTypeID =13;} // website order paypal
			
			$employeeID =35; //website order
			
			$k=1;
			$dd=0;
			$salelineArray='';
			foreach ($carts as $cart) {
				
				
				$unitPrice = $cart['price'];
				//$unitPrice=money_format('%i',$cart['price'] * 10/11);
				#$tax=money_format('%i',$unitPrice * 0.10);
				//$unitPrice=round($cart['price'] / 1.1, 2);
				$tax=round($unitPrice / 10,2);
				$unitQuantity =1;
				
				
				
				$itemID = $cart['stock_id'];
				$k=$k+2;
				/*<tax1Rate>$tax</tax1Rate>
					  <taxClassID>1</taxClassID>
					  <taxCategoryID>1</taxCategoryID>*/
				$salelineArray .= "
					<SaleLine>
					  <taxClassID>0</taxClassID>
					  <unitQuantity>$unitQuantity</unitQuantity>
					  <unitPrice>$unitPrice</unitPrice>					  
					  <tax>false</tax>  					  
  					  <customerID>$cust_id</customerID>
					  <itemID>$itemID</itemID>";					  
					  $salelineArray .= "	  					  
					</SaleLine>
				 ";
			}
			
			
			$salelineArray .= "
					<SaleLine>
					  <taxClassID>0</taxClassID>
					  <unitQuantity>1</unitQuantity>
					  <unitPrice>$shipping</unitPrice>					  
					  <tax>false</tax>  					  
  					  <customerID>$cust_id</customerID>
					  <avgCost>$shipping</avgCost>
					  <fifoCost>$shipping</fifoCost>
					  <Note>
    					
    					<note>Shipping Cost</note>
    					<isPublic>false</isPublic>
    					<timeStamp>$MOStimestamp</timeStamp>
						<employeeID>$employeeID</employeeID>
  						</Note>
		
					</SaleLine>
				";
			if($disc>0)
			{
			$salelineArray .= "
					<SaleLine>
					  <taxClassID>0</taxClassID>
					  <unitQuantity>1</unitQuantity>
					  <unitPrice>-$disc</unitPrice>					  
					  <tax>false</tax>  					  
  					  <customerID>$cust_id</customerID>
					  <avgCost>$disc</avgCost>
					  <fifoCost>$disc</fifoCost>
					  <Note>
    					
    					<note>Discount Cost</note>
    					<isPublic>false</isPublic>
    					<timeStamp>$MOStimestamp</timeStamp>
						<employeeID>$employeeID</employeeID>
  					  </Note>
		
					</SaleLine>
				";
			}
			
			$amount=$orders['subtotal']+$orders['tax'];
			$amount=$amount+$shipping;
			
			$amount=$amount-$disc;
			$shipnote='';
			$sfirstName = $orders['firstname'];
			$slastName = $orders['lastname'];
			$saddress1 = $this->_clean_string($orders['address']);
			$scity = $orders['city'];
			#$sstate = $orders['state'];
			if($orders['state']){
				$sstate = $this->System_model->get_state($orders['state']);
			}else{
				$sstate = 'Not Set';	
			}
			$scountry = $orders['country'];
			$szip = $orders['postcode'];
			$sContactPhone='';
			$xml_create_sale = 
				"<?xml version='1.0'?>
				<Sale>
				  <timeStamp>$MOStimestamp</timeStamp>
				  <employeeID>$employeeID</employeeID>
				  <discountID>2</discountID>
				  
				  <completed>true</completed>
				  <customerID>$cust_id</customerID>	
				  <shopID>1</shopID>		  
				  <registerID>1</registerID>
				  <taxCategoryID>1</taxCategoryID>
				  <ShipTo>
					<shipped>false</shipped>
					<timeStamp>$MOStimestamp</timeStamp>
					<shipNote>$shipnote</shipNote>
					<firstName>$sfirstName</firstName>
					<lastName>$slastName</lastName>				
					<Contact>
					  <timeStamp>$MOStimestamp</timeStamp>
					  <Addresses>
						<ContactAddress>
						  <address1>$saddress1</address1>					 
						  <city>$scity</city>
						  <state>$sstate</state>
						  <zip>$szip</zip>
						  <country>$scountry</country>
						</ContactAddress>
					  </Addresses>
					  <Phones>
						<ContactPhone>
						  <number>$sContactPhone</number>
						  <useType readonly='true'>Home</useType>
						</ContactPhone>
					  </Phones>
					</Contact>
				  </ShipTo>
				  <SaleLines>
				  $salelineArray
				  </SaleLines>
				  <SalePayments>
					<SalePayment>
					  <amount currency='AUD'>$amount</amount>
					  <paymentTypeID>$paymentTypeID</paymentTypeID>
					  <registerID>1</registerID>
					</SalePayment>
				  </SalePayments>
				</Sale>";
	
			// Create cURL resource
			# echo print_r($xml_create_sale,true);die();
			$xml2 = simplexml_load_string($xml_create_sale);
			//print_r($xml2);die();	
			$curl = curl_init();


			
			// Set URL		
			curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/".$account_id."/Sale");
			
			// Authenticate
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($curl, CURLOPT_USERPWD, $apikey . ":" . $password); 
			
			// Send content in proper format
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', $additionalHeaders));              
			
			// Set Request Type 
			// (you'll need to change this depending on what you're doing)
			//curl_setopt($curl,CURLOPT_HTTPGET, 1);
			curl_setopt($curl,CURLOPT_POST, 1);  // POST (Create)
			// curl_setopt($curl,CURLOPT_PUT, 1); // PUT (Update)
			// curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'DELETE') // DELETE
			
			// To send parameters (data)
			curl_setopt($curl, CURLOPT_POSTFIELDS, $xml_create_sale);
			
			
			// Return the transfer as a string
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			
			// $output contains the output string
			$output = curl_exec($curl);
			//print_r($output);die();
			
			// Close cURL resource to free up system resources
			curl_close($curl);
			
			$xml = simplexml_load_string($output);
			
			# echo '<pre>'.print_r($xml,true).'</pre>';die();
			
			$saleID = $xml->xpath('//saleID');
			//print_r($saleID);
			foreach($saleID as $si)
			{
				$sale_id= $si;
			}
			echo '<br>';
			echo $si;
			if($si==''){$si='open';}
			$data=array(
					'lightspeed_order_id' => $si,
					'lightspeed_date' => date('Y-m-d H:i:s')
				);
			$this->Lightspeed_model->update($orders['id'],$data);
			
		}
		
		/*$time_stamp='';
		$discountPercent='';
		$completed='';
		$tax1Rate='';
		$calcDiscount='';
		$calcTotal='';
		$calcSubtotal='';
		$calcTaxable='';
		$calcNonTaxable='';
		$calcTax1='';
		$customerID='';
		$employeeID='';
		$registerID='';
		$shopID='';
		$taxCategoryID='';
		$Customer='';
		$sale_xml='
		<?xml version="1.0"?>
		<Sale>
		  <timeStamp>2013-08-15T02:23:55+00:00</timeStamp>
		  <completed>true</completed>
		  <change currency="USD">1.11</change>
		  <customerID>1</customerID>
		  <discountID>1</discountID>
		  <employeeID>1</employeeID>
		  <quoteID>1</quoteID>
		  <registerID>1</registerID>
		  <shipToID>1</shipToID>
		  <shopID>1</shopID>
		  <taxCategoryID>1</taxCategoryID>
		  <ShipTo>
			<shipToID>1</shipToID>
			<shipped>true</shipped>
			<timeStamp>2013-08-15T02:23:55+00:00</timeStamp>
			<shipNote>Example string value.</shipNote>
			<firstName>Example string value.</firstName>
			<lastName>Example string value.</lastName>
			<company>Example string value.</company>
			<customerID>1</customerID>
			<saleID>1</saleID>
			<Contact>
			  <custom>Example string value.</custom>
			  <noEmail>true</noEmail>
			  <noPhone>true</noPhone>
			  <noMail>true</noMail>
			  <timeStamp>2013-08-15T02:23:55+00:00</timeStamp>
			  <Addresses>
				<ContactAddress>
				  <address1>Example string value.</address1>
				  <address2>Example string value.</address2>
				  <city>Example string value.</city>
				  <state>Example string value.</state>
				  <zip>Example string value.</zip>
				  <country>Example string value.</country>
				</ContactAddress>
			  </Addresses>
			  <Phones>
				<ContactPhone>
				  <number>Example string value.</number>
				  <useType readonly="true">Home</useType>
				</ContactPhone>
				<ContactPhone>
				  <number>Example string value.</number>
				  <useType readonly="true">Work</useType>
				</ContactPhone>
				<ContactPhone>
				  <number>Example string value.</number>
				  <useType readonly="true">Pager</useType>
				</ContactPhone>
				<ContactPhone>
				  <number>Example string value.</number>
				  <useType readonly="true">Mobile</useType>
				</ContactPhone>
				<ContactPhone>
				  <number>Example string value.</number>
				  <useType readonly="true">Fax</useType>
				</ContactPhone>
			  </Phones>
			  <Emails>
				<ContactEmail>
				  <address>Example string value.</address>
				  <useType readonly="true">Primary</useType>
				</ContactEmail>
				<ContactEmail>
				  <address>Example string value.</address>
				  <useType readonly="true">Secondary</useType>
				</ContactEmail>
			  </Emails>
			  <Websites>
				<ContactWebsite>
				  <url>Example string value.</url>
				</ContactWebsite>
			  </Websites>
			</Contact>
		  </ShipTo>
		  <TaxCategory>
			<taxCategoryID>1</taxCategoryID>
			<tax1Name>Example string value.</tax1Name>
			<tax2Name>Example string value.</tax2Name>
			<tax1Rate>1.11</tax1Rate>
			<tax2Rate>1.11</tax2Rate>
			<timeStamp>2013-08-15T02:23:55+00:00</timeStamp>
			<TaxCategoryClasses>
			  <TaxCategoryClass>
				<taxCategoryClassID>1</taxCategoryClassID>
				<tax1Rate>1.11</tax1Rate>
				<tax2Rate>1.11</tax2Rate>
				<timeStamp>2013-08-15T02:23:55+00:00</timeStamp>
				<taxCategoryID>1</taxCategoryID>
				<taxClassID>1</taxClassID>
			  </TaxCategoryClass>
			</TaxCategoryClasses>
		  </TaxCategory>
		  <SaleLines>
			<SaleLine>
			  <saleLineID>1</saleLineID>
			  <createTime>2013-08-15T02:23:55+00:00</createTime>
			  <timeStamp>2013-08-15T02:23:55+00:00</timeStamp>
			  <unitQuantity>1</unitQuantity>
			  <unitPrice currency="USD">1.11</unitPrice>
			  <normalUnitPrice currency="USD">1.11</normalUnitPrice>
			  <tax>true</tax>
			  <taxClassID>1</taxClassID>
			  <customerID>1</customerID>
			  <discountID>1</discountID>
			  <employeeID>1</employeeID>
			  <itemID>1</itemID>
			  <noteID>1</noteID>
			  <shopID>1</shopID>
			  <saleID>1</saleID>
			  <Note>
				<noteID>1</noteID>
				<note>Example string value.</note>
				<isPublic>true</isPublic>
				<timeStamp>2013-08-15T02:23:55+00:00</timeStamp>
			  </Note>
			</SaleLine>
		  </SaleLines>
		  <SalePayments>
			<SalePayment>
			  <salePaymentID>1</salePaymentID>
			  <amount currency="USD">1.11</amount>
			  <createTime>2013-08-15T02:23:55+00:00</createTime>
			  <saleID>1</saleID>
			  <paymentTypeID>1</paymentTypeID>
			  <registerID>1</registerID>
			  <employeeID>1</employeeID>
			  <creditAccountID>1</creditAccountID>
			  <PaymentType>
				<paymentTypeID>1</paymentTypeID>
				<name>Example string value.</name>
				<requireCustomer>true</requireCustomer>
				<archived>true</archived>
				<internalReserved>true</internalReserved>
				<refundAsPaymentTypeID>1</refundAsPaymentTypeID>
			  </PaymentType>
			</SalePayment>
		  </SalePayments>
		</Sale>
				';
		*/
		
	}

}