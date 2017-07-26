<?php
namespace litle\sdk;
require_once realpath(__DIR__). '/../../vendor/autoload.php';
 
#Force Capture
$capture_info = array(
  'id'=> '456',
  'merchantId' => '101',
  'version'=>'8.8',
  'reportGroup'=>'Planets',
  'litleTxnId'=>'123456',
  'orderId'=>'12344',
  'amount'=>'106',
  'orderSource'=>'ecommerce',
  'card'=>array(
    'type'=>'VI',
    'number' =>'4100000000000001',
    'expDate' =>'1210'
  )
);
 
$initialize = new LitleOnlineRequest();
$response = $initialize->forceCaptureRequest($capture_info);
 
#display results
echo ("Response: " . (XmlParser::getNode($response,'response')) . "<br>");
echo ("Message: " . XmlParser::getNode($response,'message') . "<br>");
echo ("Litle Transaction ID: " . XmlParser::getNode($response,'litleTxnId'));

if(XmlParser::getNode($response,'message')!='Approved')
 throw new \Exception('LitleForceCaptureTransaction does not get the right response');
