<?php

require_once 'includes/rest_connector.php';
require_once 'includes/session.php';

// check to see if we start a new session or maintain the current one
checksession();

$rest = new RESTConnector();

$url = "https://localhost:9630/api/products/";
$rest->createRequest($url,"GET", null, $_SESSION['cookies'][0]);
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
if ($response!=null)
	echo $response;
else
	echo "There was no response.";	

?>