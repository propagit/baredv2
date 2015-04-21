<?php

require_once 'includes/rest_connector.php';
require_once 'includes/session.php';

// check to see if we start a new session or maintain the current one
checksession();

$rest = new RESTConnector();

$url = "https://110.175.232.158:9637/api/products/";
$newproduct ="<product><code>TESTPRODUCT2</code><description>API Test Product</description>
<sells><sell>9.99</sell></sells></product>";

# 
$rest->createRequest($url,"GET", null, $_SESSION['cookies'][0]);

//$rest->createRequest($url,"POST", $newproduct, $_SESSION['cookies'][0]);
$rest->sendRequest();

$response = $rest->getResponse();
$error = $rest->getException();

// save our session cookies
if ($_SESSION['cookies']==null) 
	$_SESSION['cookies'] = $rest->getCookies();

// display any error message
if ($error!=null)
	echo $error;

// display the response
if ($response!=null){
	print_r( $response);
	
	$xmlNew2 = new SimpleXMLElement($response);

	foreach ($xmlNew2 as $purge){
		$id[] = (string)$purge->attributes()->id;
		$inventory[] = (string)$purge->inventory->available;
		
	}
	print_r($id);
		echo '<br><br>';
		
	print_r($inventory);
		echo '<br><br>';		
	echo '<br><br>';
	$xml=$response;
	$xml = simplexml_load_string( $xml);
	echo '<br><br>';
	 foreach( $xml as $item)
	 {
		 print_r($item);		 
		 echo '<br><br>';
		 echo 'ID : ';
		 print_r($item->attributes);		 
		 echo '<br>';
		 echo 'Code : ';
		 print_r($item->code);		 
		 echo '<br>';
		 echo 'Inventory : ';
		 print_r($item->inventory->available);		 
		 echo '<br><br>';
	 }
}
else
	echo "There was no response.";	

?>