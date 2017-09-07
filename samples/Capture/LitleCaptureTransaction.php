<?php
namespace litle\sdk;
require_once realpath(__DIR__). '/../../vendor/autoload.php';
 
#Capture
#litleTxnId contains the Litle Transaction Id returned on the authorization
 
$capture_info = array(
        'litleTxnId'=>'100000000000000001',
        'id'=> '456',
	);
 
$initialize = new LitleOnlineRequest(); 
$captureResponse = $initialize->captureRequest($capture_info);
 
#display results
echo ("Response: " . (XmlParser::getNode($captureResponse,'response')) . "<br>");
echo ("Message: " . XmlParser::getNode($captureResponse,'message') . "<br>");
echo ("Litle Transaction ID: " . XmlParser::getNode($captureResponse,'litleTxnId'));

if(XmlParser::getNode($captureResponse,'message')!='Approved')
 throw new \Exception('LitleCaptureTransaction does not get the right response');
