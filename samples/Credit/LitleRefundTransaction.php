<?php
namespace litle\sdk;
require_once realpath(__DIR__). '/../../vendor/autoload.php';
 
# standalone credit
$credit_info = array(
        'id'=> '456',
	'card'=>array('type'=>'VI',
			'number'=>'4100000000000001',
			'expDate'=>'1213',
			'cardValidationNum' => '1213'),
        'orderSource'=>'ecommerce',
        'orderId'=>'12321',
        'amount'=>'123'
	);
 
$initialize = new LitleOnlineRequest();
$creditResponse = $initialize->creditRequest($credit_info);
 
#display results
echo ("Response: " . (XmlParser::getNode($creditResponse,'response')) . "<br>");
echo ("Message: " . XmlParser::getNode($creditResponse,'message') . "<br>");
echo ("Litle Transaction ID: " . XmlParser::getNode($creditResponse,'litleTxnId'));

if(XmlParser::getNode($creditResponse,'message')!='Approved')
 throw new \Exception('LitleRefundTransaction does not get the right response');

