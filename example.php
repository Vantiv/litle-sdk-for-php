<?php


require_once realpath(dirname(__FILE__)) . '/lib/LitleOnline.php';

$hash_in = array(
			'card'=>array('type'=>'VI',
					'number'=>'4100000000000000',
					'expDate'=>'1213',
					'cardValidationNum' => '1213'),
			'id'=>'1211',
			'orderId'=> '2111',
			'reportGroup'=>'Planets',
			'orderSource'=>'ecommerce',
			'amount'=>'123');

$batch_request = new BatchRequest('/usr/local/litle-home/ahammond/');
$batch_request->addSale($hash_in);


