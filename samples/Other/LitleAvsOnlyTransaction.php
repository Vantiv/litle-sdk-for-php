<?php
namespace litle\sdk;
require_once realpath(__DIR__). '/../../vendor/autoload.php';
 
#AVS Only
$auth_info = array(
  'orderId' => '1',
  'id'=> '456',
  'amount' => '10010',
  'orderSource'=>'ecommerce',
  'billToAddress'=>array(
    'name' => 'John Smith',
    'addressLine1' => '1 Main St.',
    'city' => 'Burlington',
    'state' => 'MA',
    'zip' => '01803-3747',
    'country' => 'US'
  ),
  'card'=>array(
    'number' =>'4457010000000009',
    'expDate' => '0112',
    'cardValidationNum' => '349',
    'type' => 'VI'
  )
);
 
$initialize = new LitleOnlineRequest();
$avsResponse = $initialize->authorizationRequest($auth_info);
 
#display results
echo ("Response: " . (XmlParser::getNode($avsResponse,'response')) . "<br>");
echo ("Message: " . XmlParser::getNode($avsResponse,'message') . "<br>");
echo ("Litle Transaction ID: " . XmlParser::getNode($avsResponse,'litleTxnId'));
echo ("AVS Result: " . XmlParser::getNode($avsResponse,'avsResult'));

if(XmlParser::getNode($avsResponse,'message')!='Approved')
 throw new \Exception('LitleAvsOnlyTransaction does not get the right response');
