<?php


require_once realpath(dirname(__FILE__)) . '/lib/LitleOnline.php';

$request = new LitleRequest();

$hash_in = array(
			'card'=>array('type'=>'VI',
					'number'=>'4100000000000000',
					'expDate'=>'1213',
					'cardValidationNum' => '1213'),
			'orderId'=>'8675309',
					);
			

$batch_request = new BatchRequest('/usr/local/litle-home/ahammond/');
$batch_request->addAccountUpdate($hash_in);
$request->addBatchRequest($batch_request);
$proc = new LitleResponseProcessor($request->sendToLitleStream());

// while($response = $proc->nextTransaction()){
	// if($response->getName() == "saleResponse"){
		// print $response->litleTxnId . "\n";
		// print $response->message . "\n";
	// }
// }

while($response = $proc->nextTransaction(true)){
	print $response;
}
