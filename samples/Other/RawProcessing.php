<?php
namespace litle\sdk;
require_once realpath(__DIR__). '/../../vendor/autoload.php';  
$request = new LitleRequest();
$batch = new BatchRequest();
$sale_info = array(
        	  'orderId' => '1',
		      'amount' => '10010',
		      'orderSource'=>'ecommerce',
		      'billToAddress'=>array(
		      'name' => 'John Smith',
		      'addressLine1' => '1 Main St.',
		      'city' => 'Burlington',
		      'state' => 'MA',
		      'zip' => '01803-3747',
		      'country' => 'US'),
		      'card'=>array(
		      'number' =>'5112010000000003',
		      'expDate' => '0112',
		      'cardValidationNum' => '349',
		      'type' => 'MC')
			);
$batch->addSale($sale_info);
$request->addBatchRequest($batch);
$response_file = $request->sendToLitleStream();
 
$proc = new LitleResponseProcessor($response_file);
 
$raw_response = $proc->nextTransaction(true);

$sxe = new \SimpleXMLElement($raw_response);
echo "name:" .$sxe->message[0]."\n";
echo "Response Raw XML: " . $raw_response;

if($sxe->message[0]!='Approved')
 throw new \Exception('RawProcessing does not get the right response');

