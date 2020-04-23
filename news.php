<?php
require_once('./nusoap/nusoap.php');

$wsdl = "http://www.SoapClient.com/xml/SQLDataSoap.wsdl";

$client = new nusoap_client($wsdl, 'wsdl');
$params = array("SRLFile"=>"/xml/NEWS.SRI","RequestName"=> "Yahoo");

$err = $client->getError();
if ($err) {
   echo '<h2>Constructor error</h2>' . $err;
   exit();
}

$result1=$client->call("response",array(""));

// print_r($client);
print_r($result1);