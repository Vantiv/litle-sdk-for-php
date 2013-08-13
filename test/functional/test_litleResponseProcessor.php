<?php


require_once realpath(dirname(__FILE__)) . '/../../lib/LitleOnline.php';
class litleResponseProcessor_FunctionalTest extends PHPUnit_Framework_TestCase
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
			
	}
	
	function test_badResponse(){
		$malformed_resp = '<litleResponse version="8.19" xmlns="http://www.litle.com/schema" response="1" message="Test test tes test" litleSessionId="819799340147507212">
			<batchResponse litleBatchId="819799340147507220" merchantId="07103229">
			<saleResponse reportGroup="Planets">
			    <litleTxnId>819799340147507238</litleTxnId>
			    <orderId>1864</orderId>
			    <response>000</response>
			    <responseTime>2013-08-08T13:11:01</responseTime>
			    <message>Approved</message>
			</saleResponse>
			</batchResponse>
			</litleResponse>';
		
		file_put_contents($this->direct . '/pizza.tmp', $malformed_resp);
		
		$this->setExpectedException(
			'RuntimeException', "Response file $this->direct/pizza.tmp indicates error: Test test tes test"
		);
		$proc = new LitleResponseProcessor($this->direct . '/pizza.tmp');
		
	}
	
	function test_processRaw(){
		$request = new LitleRequest($this->config);
		
		# first batch
		$batch = new BatchRequest($this->direct);
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
		
		$resp = $request->sendToLitleStream();
		$proc = new LitleResponseProcessor($resp);
		$res = $proc->nextTransaction(true);
		$this->assertTrue(strpos($res, "authorizationResponse") !== FALSE);
	}
	
	function test_processMecha(){
		$request = new LitleRequest($this->config);
		
		# first batch
		$batch = new BatchRequest($this->direct);
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
		$batch = new BatchRequest($this->direct);
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
		$batch = new BatchRequest($this->direct);
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
		$batch = new BatchRequest($this->direct);
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
		$batch = new BatchRequest($this->direct);
		$hash_in = array(
			'card'=>array('type'=>'VI',
					'number'=>'4100000000000000',
					'expDate'=>'1213',
					'cardValidationNum' => '1213'),
			'orderId'=>'8675309');
		$batch->addAccountUpdate($hash_in);
		
		$request->addBatchRequest($batch);
		
		$resp = new LitleResponseProcessor($request->sendToLitleStream());

		$responses = array();
		for($i = 0; $i < 14; $i++){
			array_push($responses, $resp->nextTransaction()->getName());
		}
		$this->assertTrue(in_array("authorizationResponse", $responses));
		$this->assertTrue(in_array("captureResponse", $responses));
		$this->assertTrue(in_array("authReversalResponse", $responses));
		$this->assertTrue(in_array("captureGivenAuthResponse", $responses));
		$this->assertTrue(in_array("creditResponse", $responses));
		$this->assertTrue(in_array("echeckCreditResponse", $responses));
		$this->assertTrue(in_array("echeckRedepositResponse", $responses));
		$this->assertTrue(in_array("echeckSalesResponse", $responses));
		$this->assertTrue(in_array("echeckVerificationResponse", $responses));
		$this->assertTrue(in_array("forceCaptureResponse", $responses));
		$this->assertTrue(in_array("saleResponse", $responses));
		$this->assertTrue(in_array("registerTokenResponse", $responses));
		$this->assertTrue(in_array("updateCardValidationNumOnTokenResponse", $responses));
		$this->assertTrue(in_array("accountUpdateResponse", $responses));
		
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
