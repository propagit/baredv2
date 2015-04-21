<?php

/*
 * Created on Apr 6, 2012
 * 
 * We need to load the HTTP_Request2 package
 *
 */
 
require_once 'HTTP/Request2.php';
require_once 'HTTP/Request2/Response.php';
require_once 'HTTP/Request2/CookieJar.php';

class RESTConnector {
	
	private $root_url = "";
    private $curr_url = "";
    private $exception = "";
    private $responseBody = "";
    private $cookieJar = "";
    private $req = null;
    private $res = null;
    
    
    public function __construct($root_url = "") {
        $this->root_url = $this->curr_url = $root_url;
        if ($root_url != "") {
            $this->createRequest("GET");
            $this->sendRequest();
        }
        return true;
    }
    
    public function createRequest($url, $method, $body = null, $mycookies) {
        $this->curr_url = $url;
        $this->req =& new HTTP_Request2($url);
        
        // In order to connect to LightSpeed Server, we need to set the User-Agent header to our App ID, followed by a slash and the version number of our application
		$this->req->setHeader("User-Agent", "au.com.bared.bared/3.8.1");
        
        // We also need to send our App Private ID in a header called X-PAPPID
		$this->req->setHeader("X-PAPPID", "6eb003c2-0fa7-43c4-90dd-d452b14e46bb");
        
        // A valid username and password must also be sent to connect correctly
        $this->req->setAuth("lightspeed", "adminB4R3D");
                
        // LightSpeed Server uses a custom ssl certificate, so we disable this verification.
        $this->req->setConfig('ssl_verify_peer', false);
        
        // Establish the Cookie Jar
        $this->req->setCookieJar();
    	    		
        // If a cookie already exists, add it to the Cookie Jar to maintain the session
        if ($mycookies!=null){
        	$this->req->addCookie($mycookies['name'], $mycookies['value']);
        }
        
        // Get current Cookie Jar
        $this->cookieJar = $this->req->getCookieJar();
        
    	    			
        switch($method) {
            case "GET":
                $this->req->setMethod(HTTP_Request2::METHOD_GET);
                break;
            case "POST":
                $this->req->setMethod(HTTP_Request2::METHOD_POST);
                $this->setPostBody($body);
                break;
            case "PUT":
                $this->req->setMethod(HTTP_Request2::METHOD_PUT);
                // to-do              
                break;
            case "DELETE":
                $this->req->setMethod(HTTP_Request2::METHOD_DELETE);
                // to-do
                break;
        }
    }
    
    private function setPostBody($data) {
        if ($data != null) {
            $this->req->setBody($data);
        }
    }
    
    public function sendRequest() {
    	try {
    		$this->res = $this->req->send();
    		if (200 <= $this->res->getStatus() && 206 >= $this->res->getStatus()) {
    			$this->responseBody = $this->res->getBody();
    		}
    		else {
    			$this->responseBody = "Unexpected HTTP Status: " . $this->res->getStatus() . " " . $this->res->getReasonPhrase();
    		}
    	}
    	catch (HTTP_Request2_Exception $e) {
    		$this->exception = "Error: " . $e->getMessage();
    	}
    }

    public function getResponse() {
        return $this->responseBody;
    }
    
    public function getException() {
        return $this->exception;
    }
    
    public function getCookies() {
    	return $this->cookieJar->getAll();
    }
}

?>
