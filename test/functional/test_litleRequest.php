<?php


require_once realpath(dirname(__FILE__)) . '/../../lib/LitleOnline.php';
class litleRequest_FunctionalTest extends PHPUnit_Framework_TestCase
{
	private $direct;
	private $config;
	private $sale;
	function setUp(){
		$this->direct = sys_get_temp_dir() . '/test';
		if(!file_exists($this->direct)){
			mkdir($this->direct);
		}
		$this->config = Obj2xml::getConfig(array('batch_requests_path' => $this->direct, 'litle_requests_path' => $this->direct));
		$this->sale = array(
			'card'=>array('type'=>'VI',
					'number'=>'4100000000000000',
					'expDate'=>'1213',
					'cardValidationNum' => '1213'),
			'id'=>'1211',
			'orderId'=> '2111',
			'reportGroup'=>'Planets',
			'orderSource'=>'ecommerce',
			'amount'=>'123');
			
	}
	
	function test_wouldFill(){
		$request = new LitleRequest($this->config);
		$this->assertTrue($request->wouldFill(500001));
		$this->assertFalse($request->wouldFill(500000));
	}
	
	function test_fileCreation(){
		$request = new LitleRequest($this->config);
		$this->assertTrue(file_exists($request->batches_file));
		$this->assertTrue(file_exists($request->request_file));
		$this->assertTrue(file_exists($request->response_file));
	}
	
	function test_addBatch(){
		$request = new LitleRequest($this->config);
		$batch = new BatchRequest($this->direct);
		$batch->addSale($this->sale);
		
		$fn1 = $batch->batch_file;
		$fn2 = $batch->transaction_file;
		$request->addBatchRequest($batch);
		
		$this->assertFalse(isset($batch->batch_file));
		$this->assertFalse(isset($batch->transaction_file));
		$this->assertFalse(file_exists($fn1));
		$this->assertFalse(file_exists($fn2));
		
		
		$expected = '<batchRequest merchantId="07103610" merchantSdk="PHP;8.24.0" authAmount="0" numAuths="0" saleAmount="123" numSales="1" creditAmount="0" numCredits="0" numTokenRegistrations="0" 
		captureGivenAuthAmount="0" numCaptureGivenAuths="0" forceCaptureAmount="0" numForceCaptures="0" authReversalAmount="0" numAuthReversals="0" 
		captureAmount="0" numCaptures="0" echeckVerificationAmount="0" numEcheckVerification="0" echeckCreditAmount="0" numEcheckCredit="0" 
		numEcheckRedeposit="0" echeckSalesAmount="0" numEcheckSales="0" numUpdateCardValidationNumOnTokens="0" 
		numUpdateSubscriptions="0" numCancelSubscriptions="0" numCreatePlans="0" numUpdatePlans="0" 
		numActivates="0" activateAmount="0" numDeactivates="0" numLoads="0" loadAmount="0" numUnloads="0" unloadAmount="0" numBalanceInquirys="0" 
		numAccountUpdates="0">
		<sale reportGroup="Planets"><orderId>2111</orderId><amount>123</amount><orderSource>ecommerce</orderSource>
		<card><type>VI</type><number>4100000000000000</number><expDate>1213</expDate><cardValidationNum>1213</cardValidationNum></card></sale>
		</batchRequest>';
		$this->assertEquals(preg_replace("[\s]", "", $expected), preg_replace("[\s]", "", file_get_contents($request->batches_file)));
		$this->assertEquals(1, $request->total_transactions);
		$this->assertFalse($request->closed);
	}
	
	function test_addBatch_tooBig(){
		$request = new LitleRequest($this->config);
		
		for($i = 0; $i < 5; $i++){
			$batch = new BatchRequest($this->direct);
			for($j = 0; $j < 100000; $j++){
				$batch->addSale($this->sale);
			}
			$request->addBatchRequest($batch);
		}
		
		$this->assertEquals(500000, $request->total_transactions);
		$batch = new BatchRequest($this->direct);
		$batch->addSale($this->sale);
		$this->setExpectedException('RuntimeException');
		
		$request->addBatchRequest($batch);
	}
	
	function test_addRFRRequest(){
		$request = new LitleRequest($this->config);
		
		$request->createRFRRequest(array('litleSessionId' => '8675309'));
		
		
		$expected = '<litleRequest numBatchRequests="0" version="8.24" xmlns="http://www.litle.com/schema">
					<authentication><user>XXXXXX</user><password>XXXXXX</password></authentication>
					<RFRRequest><litleSessionId>8675309</litleSessionId></RFRRequest>
					</litleRequest>';
		$this->assertEquals(preg_replace(array("[\s]", '@<authentication>[<>/A-Za-z0-9]+</authentication>@'), "", $expected), 
		preg_replace(array("[\s]", '@<authentication>[<>/A-Za-z0-9]+</authentication>@'), "", file_get_contents($request->request_file)));
		$this->assertEquals(0, $request->total_transactions);
		$this->assertTrue($request->closed);
	}
	
	function test_addBatch_closed(){
		$request = new LitleRequest($this->config);
		$request->closeRequest();
		
		$batch = new BatchRequest($this->direct);
		$this->setExpectedException('RuntimeException');
		$request->addBatchRequest($batch);
	}
	
	function test_addRFRRequest_closed(){
		$request = new LitleRequest($this->config);
		$request->closeRequest();
		
		$this->setExpectedException('RuntimeException');
		$request->createRFRRequest(array('litleSessionId' => '8675309'));
	}
	
	function test_closeRequest(){
		$request = new LitleRequest($this->config);
		
		$batch = new BatchRequest($this->direct);
		$batch->addSale($this->sale);
		
		$fn1 = $request->batches_file;
		$request->addBatchRequest($batch);
		$request->closeRequest();
		
		$this->assertTrue($request->closed);
		$this->assertFalse(isset($request->batches_file));
		$this->assertFalse(file_exists($fn1));
		$this->assertTrue(file_exists($request->request_file));
		
		
		$expected = '<litleRequest numBatchRequests="1" version="8.24" xmlns="http://www.litle.com/schema">
		<authentication><user>XXXXX</user><password>XXXXX</password></authentication>
		<batchRequest merchantId="07103610" merchantSdk="PHP;8.24.0" authAmount="0" numAuths="0" saleAmount="123" numSales="1" creditAmount="0" numCredits="0" numTokenRegistrations="0" 
		captureGivenAuthAmount="0" numCaptureGivenAuths="0" forceCaptureAmount="0" numForceCaptures="0" authReversalAmount="0" numAuthReversals="0" 
		captureAmount="0" numCaptures="0" echeckVerificationAmount="0" numEcheckVerification="0" echeckCreditAmount="0" numEcheckCredit="0" 
		numEcheckRedeposit="0" echeckSalesAmount="0" numEcheckSales="0" numUpdateCardValidationNumOnTokens="0" numUpdateSubscriptions="0" 
		numCancelSubscriptions="0" numCreatePlans="0" numUpdatePlans="0" 
		numActivates="0" activateAmount="0" numDeactivates="0" numLoads="0" loadAmount="0" numUnloads="0" unloadAmount="0" numBalanceInquirys="0"
		numAccountUpdates="0">
		<sale reportGroup="Planets"><orderId>2111</orderId><amount>123</amount><orderSource>ecommerce</orderSource>
		<card><type>VI</type><number>4100000000000000</number><expDate>1213</expDate><cardValidationNum>1213</cardValidationNum></card></sale>
		</batchRequest>
		</litleRequest>';
		$this->assertEquals(preg_replace(array("[\s]", '@<authentication>[<>/A-Za-z0-9]+</authentication>@'), "", $expected), 
		preg_replace(array("[\s]", '@<authentication>[<>/A-Za-z0-9]+</authentication>@'), "", file_get_contents($request->request_file)));
	}
	
	function test_sendToLitle(){
		$request = new LitleRequest($this->config);
		
		$batch = new BatchRequest($this->direct);
		
		$sale_hash = array(
			      'orderId' => '1864',
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
			      'number' =>'4457010000000009',
			      'expDate' => '0112',
			      'cardValidationNum' => '349',
			      'type' => 'VI'),
				  'reportGroup' => 'Planets');
		
		$batch->addSale($sale_hash);
		
		$request->addBatchRequest($batch);
		
		$response = $request->sendToLitle();
		
		$this->assertTrue(file_exists($response));
		$this->assertEquals($response, $request->response_file);
		
		$proc = new LitleResponseProcessor($response);
		
		$resp = $proc->nextTransaction();
		$this->assertEquals('saleResponse', $resp->getName());
		$this->assertEquals('Planets', $resp->attributes()->reportGroup);
		$this->assertEquals('1864', $resp->orderId);
	}
	

	
	function test_sendToLitleStream(){
		$request = new LitleRequest($this->config);
		
		$batch = new BatchRequest($this->direct);
		
		$sale_hash = array(
			      'orderId' => '1864',
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
			      'number' =>'4457010000000009',
			      'expDate' => '0112',
			      'cardValidationNum' => '349',
			      'type' => 'VI'),
				  'reportGroup' => 'Planets');
		
		$batch->addSale($sale_hash);
		
		$request->addBatchRequest($batch);
		
		$response = $request->sendToLitleStream();
		
		$this->assertTrue(file_exists($response));
		$this->assertEquals($response, $request->response_file);
		
		$proc = new LitleResponseProcessor($response);
		
		$resp = $proc->nextTransaction();
		$this->assertEquals('saleResponse', $resp->getName());
		$this->assertEquals('Planets', $resp->attributes()->reportGroup);
		$this->assertEquals('1864', $resp->orderId);
	}
	
	function tearDown(){
		$files = glob($this->direct . '/*'); // get all file names
		foreach($files as $file){ // iterate files
		  if(is_file($file))
		    unlink($file); // delete file
		}
		rmdir($this->direct);
	}
	
	
	
}
