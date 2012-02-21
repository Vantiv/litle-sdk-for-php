<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', '1');

require_once realpath(dirname(__FILE__)) . '/../lib/communication.php';
require_once realpath(dirname(__FILE__)) . '/../lib/LitleOnlineRequest.php';


$hash_in = array('usr'=>'IMPTEST',
			'password'=>'cert3d6Z',
			'merchantId'=>'087900',
			'version'=>'8.8',
			'card'=>array('type'=>'VI',
					'number'=>'4100000000000001',
					'expDate'=>'1213',
					'cardValidationNum' => '1213'),
// 					'paypal'=>array("payerId"=>'123',"token"=>'12321312',
// 		"transactionId" => '123123'),
			'id'=>'1211',
			'orderId'=> '2111',
			'reportGroup'=>'Planets',
			'orderSource'=>'ecommerce',
			'amount'=>'123');
$litleTest = &new LitleOnlineRequest();
$retOb = $litleTest->authorizationRequest($hash_in);
?>