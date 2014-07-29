<?php
namespace litle\sdk;
require_once realpath(__DIR__). '/../../vendor/autoload.php';
 
# this is a really big request
 
$request = new LitleRequest();
 
# first batch
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
 
$hash_in = array('litleTxnId'=> '1234567890','reportGroup'=>'Planets', 'amount'=>'5000');
$batch->addAuthReversal($hash_in);
 
$hash_in = array('litleTxnId'=> '12312312', 'amount'=>'123');
$batch->addCapture($hash_in);
 
$request->addBatchRequest($batch);
 
# second batch
$batch = new BatchRequest();
$hash_in = array(
   'amount'=>'123',
   'orderId'=>'12344',
   'authInformation' => array(
   'authDate'=>'2002-10-09','authCode'=>'543216',
   'authAmount'=>'12345'),
   'orderSource'=>'ecommerce',
   'card'=>array(
   'type'=>'VI',
   'number' =>'4100000000000001',
   'expDate' =>'1210'));
$batch->addCaptureGivenAuth($hash_in);
 
$hash_in = array('litleTxnId'=> '12312312','reportGroup'=>'Planets', 'amount'=>'123');
$batch->addCredit($hash_in);
 
$hash_in = array('litleTxnId' =>'123123');
$batch->addEcheckCredit($hash_in);
 
$request->addBatchRequest($batch);
 
# third batch
$batch = new BatchRequest();
$hash_in = array('litleTxnId' =>'123123');
$batch->addEcheckRedeposit($hash_in);
 
$hash_in = array(
    'amount'=>'123456',
    'verify'=>'true',
    'orderId'=>'12345',
    'orderSource'=>'ecommerce',
    'echeck' => array('accType'=>'Checking','accNum'=>'12345657890','routingNum'=>'123456789','checkNum'=>'123455'),
  		'billToAddress'=>array('name'=>'Bob','city'=>'lowell','state'=>'MA','email'=>'litle.com'));
$batch->addEcheckSale($hash_in);
 
$hash_in = array(
    'amount'=>'123456',
    'verify'=>'true',
    'orderId'=>'12345',
    'orderSource'=>'ecommerce',
    'echeck' => array('accType'=>'Checking','accNum'=>'12345657890','routingNum'=>'123456789','checkNum'=>'123455'),
    'billToAddress'=>array('name'=>'Bob','city'=>'lowell','state'=>'MA','email'=>'litle.com'));
$batch->addEcheckVerification($hash_in);
 
$request->addBatchRequest($batch);
 
# fourth batch
$batch = new BatchRequest();
$hash_in = array(
	 'orderId'=>'123',
      'litleTxnId'=>'123456',
      'amount'=>'106',
      'orderSource'=>'ecommerce',
      'token'=> array(
      'litleToken'=>'123456789101112',
      'expDate'=>'1210',
      'cardValidationNum'=>'555',
      'type'=>'VI'));
$batch->addForceCapture($hash_in);
 
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
 
$hash_in = array(
    	'orderId'=>'1',
	'accountNumber'=>'123456789101112');
$batch->addRegisterToken($hash_in);
 
$hash_in = array(
	'orderId'=>'1',
	'litleToken'=>'123456789101112',
	'cardValidationNum'=>'123');
$batch->addUpdateCardValidationNumOnToken($hash_in);
 
$request->addBatchRequest($batch);
 
# fifth batch
$batch = new BatchRequest();
$hash_in = array(
	'card'=>array('type'=>'VI',
			'number'=>'4100000000000000',
			'expDate'=>'1213',
			'cardValidationNum' => '1213'),
	'orderId'=>'8675309');
$batch->addAccountUpdate($hash_in);
 
$request->addBatchRequest($batch);
 
$resp = new LitleResponseProcessor($request->sendToLitle());
 
while($txn = $resp->nextTransaction()){
  echo "Transaction Type : " . $txn->getName() . "\n";
  echo "Transaction Id: " . $txn->litleTxnId ." \n";
}