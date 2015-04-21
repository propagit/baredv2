<?php

$con = mysql_connect("localhost","baredcom_dbadmin","RZk*4oOgZ+VD");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("baredcom_db", $con);

$dbname="baredcom_db"; 




/*$apikey = '9ff9db515673cceb643718ac1525033d86aec82fa6134ed035a43f7bd663cc83';
$password = 'apikey';
$account_id = 58231;
*/

//$apikey = '0c58a74d684a750b0a5d2bb55d65362303f4af04110210d7f7d44255131c9a17';
//$account_id = 57839;
$apikey = '3726fc8d2ff21887004e264b8acd5fed4863220a98cd85eb49aa868e014ff48b';
$password = 'apikey';
$account_id = 61853;


function mysql_fetch_all($res) {
   while($row=mysql_fetch_array($res)) {
       $return[] = $row;
   }
   return $return;
}
$jk=0;
for($i=1; $i<=100; $i++)
{
	$limit=100;
	$offset=($i-1)*100;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "https://api.merchantos.com/API/Account/$account_id/Customer.xml?load_relations=all&archived=0&limit=$limit&offset=$offset");
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($curl, CURLOPT_USERPWD, $apikey . ":" . $password);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', $additionalHeaders)); 
	curl_setopt($curl,CURLOPT_HTTPGET, 1);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($curl);
	curl_close($curl);
	$xml = simplexml_load_string($output);
	$item_shops_array = $xml->xpath('//Emails');
	//$xml = simplexml_load_string($output);
	$xmlNew2 = new SimpleXMLElement($output);	
	
	if(count($xml)>0){
		$id=array();
		$first_name=array();
		$last_name=array();
		$inventory=array();
		$dt=array();
		foreach($item_shops_array as $pr)
		{
			$dt[] = (string)$pr->ContactEmail->address;
			
		}
		foreach($xmlNew2 as  $purge) { 				
			$id[] = (string)$purge->customerID;
			$first_name[] = (string)$purge->firstName;
			$last_name[] = (string)$purge->lastName;
			//print_r($purge);
			//echo '<br><br>';
			
			
		} 
		$j=0;
		
		foreach ($id as $idp)
		{									
			$flag=1;
			$result = mysql_query("SELECT * FROM lightspeed_customers where lightspeed_id = $idp");
			$row = mysql_fetch_all($result);			
			$flag=count($row);
			//echo count($row).' '.$idp.' = '.$inventory[$j].' '.$flag.'<br>';
			if($flag==0){				
				mysql_query("INSERT INTO lightspeed_customers (lightspeed_id, email, first_name,last_name, modified) VALUES (".$idp.",'".$dt[$j]."','".$first_name[$j]."','".$last_name[$j]."','".date("Y-m-d H:i:s")."')");				
			}
			else
			{
				mysql_query("UPDATE lightspeed_customers SET email='".$dt[$j]."',modified= '".date("Y-m-d H:i:s")."' WHERE lightspeed_id=$idp");			
				//echo "UPDATE lightspeed_stock SET num=".$inventory[$j].",modified= ".date("Y-m-d H:i:s")." WHERE stock_id=$idp"."<br>";
			}
			//echo $jk.' '.$dt[$j].' '.$idp.'<br>';	
			$j++;
			$jk++;
		}
		
		//echo '<br><br>';
	}
}



//header('Location: http://bared.com.au/lightspeed/update_stock');

?>