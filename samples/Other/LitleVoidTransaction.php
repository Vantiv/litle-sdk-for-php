<?php
namespace litle\sdk;
require_once realpath(__DIR__). '/../../vendor/autoload.php';
 
#Void
 
$void_info = array(
        'litleTxnId'=>'100000000000000001',
        'id'=> '456'
	);
 
$initialize = new LitleOnlineRequest();
$voidResponse = $initialize->voidRequest($void_info);
 
#display results
echo ("Response: " . (XmlParser::getNode($voidResponse ,'response')) . "<br>");
echo ("Message: " . XmlParser::getNode($voidResponse ,'message') . "<br>");
echo ("Litle Transaction ID: " . XmlParser::getNode($voidResponse ,'litleTxnId'));

if(XmlParser::getNode($voidResponse,'message')!='Approved')
 throw new \Exception('LitleVoidTransaction does not get the right response');
