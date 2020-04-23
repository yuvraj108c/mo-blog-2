<?php
require '../lib/nusoap.php';

function getPosts()
{
    $xml = simplexml_load_file('data/posts.xml') or die ("Error:Cannot create object");
    return $xml->asXML();
}


$server = new nusoap_server(); 

$server->configureWSDL("Soap Demo","urn:soapdemo"); 

$server->register(
    "getPosts", // name of function
    array(""),  // inputs
	array("return"=>"xsd:string")  
);

$server->service(file_get_contents("php://input"));