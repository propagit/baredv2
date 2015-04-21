<?php
/*
$apikey = 'YOURAPIKEYHERE';
$password = 'apikey'; // API Keys don't have a password and just use this filler string
$account_id = 'YOURACCOUNTID';

// Alternatively you can use your username and password
$apikey = 'imademo';
$password = 'thisismypass';
$account_id = 797;
*/

/*$apikey = '9ff9db515673cceb643718ac1525033d86aec82fa6134ed035a43f7bd663cc83';
$password = 'apikey';
$account_id = 58231;
*/

$apikey = '0c58a74d684a750b0a5d2bb55d65362303f4af04110210d7f7d44255131c9a17';
$password = 'apikey';
$account_id = 57839;


// Create cURL resource
$curl = curl_init();

// Set URL
//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/$account_id/Category.xml?nodeDepth=0");
//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account");
//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/".$account_id."/InventoryCountItem");
//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/".$account_id."/Sale");
curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/$account_id/Item.xml?load_relations=all");

// Authenticate
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_USERPWD, $apikey . ":" . $password); 

// Send content in proper format
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', $additionalHeaders));              

// Set Request Type 
// (you'll need to change this depending on what you're doing)
curl_setopt($curl,CURLOPT_HTTPGET, 1);
// curl_setopt($curl,CURLOPT_POST, 1);  // POST (Create)
// curl_setopt($curl,CURLOPT_PUT, 1); // PUT (Update)
// curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'DELETE') // DELETE
$params="<?xml version='1.0'?>



<Sale>



  <timeStamp>2013-07-03T19:17:13+00:00</timeStamp>



  <completed>true</completed>



  <customerID>1</customerID>

 	<employeeID type='integer'>1</employeeID>

  <shopID type='integer'>1</shopID>



  <registerID>1</registerID>



  <taxCategoryID>1</taxCategoryID>



  <ShipTo>



    <shipped>false</shipped>



    <timeStamp>2013-07-03T19:17:13+00:00</timeStamp>



    <shipNote></shipNote>



    <firstName>siptest2</firstName>



    <lastName>invisible</lastName>



    <company></company>



    <Contact>



      <timeStamp>2013-07-03T19:17:13+00:00</timeStamp>



      <Addresses>



        <ContactAddress>



          <address1>111 Main St</address1>



          <address2></address2>



          <city>Santa Cruz</city>



          <state></state>



          <zip>95060</zip>



          <country></country>



        </ContactAddress>



      </Addresses>



      <Phones>



        <ContactPhone>



          <number>example</number>



          <useType readonly='true'>Home</useType>



        </ContactPhone>



      </Phones>



    </Contact>



  </ShipTo>



  <SaleLines>



  



            <SaleLine>



              <unitQuantity>1</unitQuantity>



             <unitPrice>265.00000</unitPrice>



              <tax>true</tax>



              <customerID>1</customerID>



              <itemID>1</itemID>


            </SaleLine>



        



  </SaleLines>



  <SalePayments>



    <SalePayment>



      <amount currency='AUD'>301.792</amount>



      <paymentTypeID>1</paymentTypeID>



      <registerID>1</registerID>



    </SalePayment>



  </SalePayments>


</Sale>";
// To send parameters (data)
//curl_setopt($curl, CURLOPT_POSTFIELDS, $params);


// Return the transfer as a string
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$output = curl_exec($curl);

// Close cURL resource to free up system resources
curl_close($curl);

$xml = simplexml_load_string($output);
$xmlNew2 = new SimpleXMLElement($output);

?>

<html>
<head>
  <title>PHP Test Page</title>
</head>
<body>
	<ul id="categories">
    
    	
		<?php foreach($xmlNew2 AS $category) { ?>
		<li><?php print_r($category);echo '<br><br>'; ?></li>
		<?php } ?>
	</ul>
</body>
</html>