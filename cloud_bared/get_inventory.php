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

$apikey = '9ff9db515673cceb643718ac1525033d86aec82fa6134ed035a43f7bd663cc83';
$password = 'apikey';
$account_id = 58231;

#Get all Category
$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/$account_id/Category.xml?nodeDepth=1");

// Authenticate
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_USERPWD, $apikey . ":" . $password); 

// Send content in proper format
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', $additionalHeaders));              

curl_setopt($curl,CURLOPT_HTTPGET, 1);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$output = curl_exec($curl);

curl_close($curl);

$xmlCat = new SimpleXMLElement($output);

$cat=array();
foreach($xmlCat as $category) { 
	
	$idc= $category->parentID.'<br>';
	if (in_array($idc, $cat)) {
    	
	}else
	{
		$cat[]=$idc;
	}
	
}

# Query based on Category
foreach($cat as $ct)
{ 	
	
	echo $ct.'<br>';
	$ct=intval($ct);
	$curl2 = curl_init();	
	curl_setopt($curl2, CURLOPT_URL, "https://api.merchantos.com/API/Account/$account_id/Item.xml?load_relations=all&ItemShops.timeStamp=%3E,2013-08-12T08:20:58&archived=0&limit=100&offset=0&Category.parentID=$ct");
	curl_setopt($curl2, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($curl2, CURLOPT_USERPWD, $apikey . ":" . $password); 
	curl_setopt($curl2, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', $additionalHeaders));     
	curl_setopt($curl2,CURLOPT_HTTPGET, 1);    
	curl_setopt($curl2, CURLOPT_RETURNTRANSFER, 1);    
	$outputs = curl_exec($curl2); 	
	$xmlNew2 = new SimpleXMLElement($outputs);
	$item_shops_array = $xmlNew2->xpath('//ItemShop');
	$id=array();
	$inventory=array();
	foreach($xmlNew2 as  $purge) { 				
		$id[] = (string)$purge->itemID;
	} 
	foreach($item_shops_array as $pr){
		if($pr->shopID==1)
		{
			$inventory[] = (integer)$pr->qoh;
		}
	}
	$i=0;
	foreach ($id as $idp)
	{
		echo $idp.' = '.$inventory[$i].'<br>';
		$i++;
	}
	
	echo '<br><br>';
}



// Create cURL resource
$curl = curl_init();

// Set URL
//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/$account_id/Category.xml?nodeDepth=0");
//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account");
//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/".$account_id."/Item/1");

//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/$account_id/Item.xml?ItemShops.timeStamp=>2013-08-10T00:00:00&limit=2&load_relations=[\"ItemShops\"]");
$ct=7;
curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/$account_id/Item.xml?load_relations=all&ItemShops.timeStamp=%3E,2013-08-12T08:20:58&archived=0&limit=100&offset=0&Category.parentID=$ct");


//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/$account_id/Item.xml?load_relations=all");
//curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/".$account_id."/Sale");

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
$item_shops_array = $xmlNew2->xpath('//ItemShop');

?>

<?php foreach($xmlNew2 as  $purge) { 
		print_r($purge);
		echo '<br><br>';
		
		
		$id[] = (string)$purge->itemID;
} 
foreach($item_shops_array as $pr){
	if($pr->shopID==1)
	{
		$inventory[] = (integer)$pr->qoh;
	}
}
echo '<br><br>Results ID<br>';
print_r($id);
echo '<br> Results Inventory <br>';
print_r($inventory);
?>
   
    
