<?php

require_once (APPPATH.'vendor/autoload.php');

use Twilio\Rest\Client;

function get_twilio_client() {
	//$sid = "AC216b90d86eb645fcd48a2d9db4df7619"; //client
	//$token = "5cb447da1b48605f9bdf4ef4965746d6";

	//$sid = "AC724f622e2cbe1cbb3afb6c4f69a600ba"; // old developer
	//$token = "ff318cce398ed4888a1c2b90daa191ab";
	
	//$sid = "AC137f64e4d64f4f68d3a1ebb1f5806413"; // new developer
    //$token = "63a21cd5543b63c09233f62a3eae0b29";
    
    $sid = "ACb7b39a8f7ad758ee3da12a6ab4711857";  
    $token = "ea07a72a7eac808650c17a09aecc3052";

	$client = new Client($sid, $token);
	return $client;
}
