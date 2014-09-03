<?php
namespace litle\sdk;
require_once realpath(__DIR__). '/../../vendor/autoload.php'; 
# use Auth batch to get the session Id
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
	$request->addBatchRequest($batch);
	$responseFileLoc=$request->sendToLitleStream();
	$resp = new LitleResponseProcessor($responseFileLoc);
	$xmlReader=$resp->getXmlReader();
	$sessionId=$xmlReader->getAttribute("litleSessionId");
	echo ("sessionId:" +$sessionId);
	
	
	
     #Process RFR request
	 $request = new LitleRequest();
	 $request->createRFRRequest(array('litleSessionId' => $sessionId));
	 $response_file = $request->sendToLitleStream();
	 $processor = new LitleResponseProcessor($response_file);
	 $res=$processor->nextTransaction(true);
	 echo $res;
	 $xml = simplexml_load_string($res);
	if($xml->message[0]!='Approved')
     throw new \Exception('RfrRequest does not get the right response');
	
  

	 // if($xmlReader->getAttribute("message")!='Approved')
 	  // throw new \Exception('RfrRequest does not get the right response');
//  


