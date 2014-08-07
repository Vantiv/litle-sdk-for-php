<?php
namespace litle\sdk;
require_once realpath(__DIR__). '/../../vendor/autoload.php';
 
# this is a really big request
 
$request = new LitleRequest();
 
	$batch = new BatchRequest();
	$hash_in = array(
		'card'=>array('type'=>'VI',
				'number'=>'4100000000000001',
				'expDate'=>'1213',
				'cardValidationNum' => '1213'),
		'orderId'=> '2111',
		'orderSource'=>'ecommerce',
		'id'=>'654',
		'amount'=>'123');
	$batch->addAuth($hash_in);

	$hash_in = array(
		'card'=>array('type'=>'VI',
				 'number'=>'4100000000000001',
				 'expDate'=>'1213',
				 'cardValidationNum' => '1213'),
		 'id'=>'654',
		 'orderId'=> '2111',
		 'orderSource'=>'ecommerce',
		 'amount'=>'123');
	$batch->addSale($hash_in); 
	$request->addBatchRequest($batch);
 
	$resp = new LitleResponseProcessor($request->sendToLitle());
	while($txn = $resp->nextTransaction()){
	  echo "Transaction Type : " . $txn->getName() . "\n";
	  echo "Transaction Id: " . $txn->litleTxnId ." \n";
	  echo "Message: " . $txn->message ." \n";
	  if($txn->message!='Approved')
	 throw new \Exception('MechaBatch does not get the right response');
	}