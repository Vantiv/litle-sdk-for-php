<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', '1');

require_once realpath(dirname(__FILE__)) . '/../lib/communication.php';
require_once realpath(dirname(__FILE__)) . '/../lib/LitleOnlineRequest.php';


$hash_in = array(
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
$retOb = $litleTest->saleRequest($hash_in);
?>