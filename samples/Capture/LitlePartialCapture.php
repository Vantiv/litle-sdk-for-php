<?php
namespace litle\sdk;
require_once realpath(__DIR__). '/../../vendor/autoload.php';
 
#Partial Capture
#litleTxnId contains the Litle Transaction Id returned as part of the authorization
#submit the amount to capture which is less than the authorization amount
#to generate a partial capture
 
$capture_in = array(
                'partial'=>'true',
                'id'=> '456',
		'litleTxnId'=>'320000000000000001',
       		'amount'=>'5005'
		);
$initialize = new LitleOnlineRequest(); 
$captureResponse = $initialize->captureRequest($capture_in);
 
#display results
echo ("Response: " . (XmlParser::getNode($captureResponse,'response')) . "<br>");
echo ("Message: " . XmlParser::getNode($captureResponse,'message') . "<br>");
echo ("Litle Transaction ID: " . XmlParser::getNode($captureResponse,'litleTxnId'));   

if(XmlParser::getNode($captureResponse,'message')!='Approved')
 throw new \Exception('LitlePartialCapture does not get the right response');

?>