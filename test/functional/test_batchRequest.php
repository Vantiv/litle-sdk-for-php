<?php


require_once realpath(dirname(__FILE__)) . '/../../lib/LitleOnline.php';
class batchRequest_FunctionalTest extends PHPUnit_Framework_TestCase
{
	private $direct;
	
	function setUp(){
		$this->direct = sys_get_temp_dir() . '/test';
		if(!file_exists($this->direct)){
			mkdir($this->direct);
		}
	}
	
	function test_simpleAddTransaction()
	{
		
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
		$batch_request = new BatchRequest($this->direct);
		$batch_request->addSale($hash_in);
		
		$this->assertTrue(file_exists($batch_request->batch_file));
		$this->assertEquals(1, $batch_request->total_txns);
		
		$cts = $batch_request->getCountsAndAmounts();
		$this->assertEquals(1, $cts['sale']['count']);
		$this->assertEquals(123, $cts['sale']['amount']);
		
	}
		function test_addSale()
	{
		
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
		$batch_request = new BatchRequest($this->direct);
		$batch_request->addSale($hash_in);
		
		$this->assertTrue(file_exists($batch_request->batch_file));
		$this->assertEquals(1, $batch_request->total_txns);
		
		$cts = $batch_request->getCountsAndAmounts();
		$this->assertEquals(1, $cts['sale']['count']);
		$this->assertEquals(123, $cts['sale']['amount']);
		
	}
	
	function test_addAuth()
	{
		
		$hash_in = array(
			'card'=>array('type'=>'VI',
					'number'=>'4100000000000000',
					'expDate'=>'1213',
					'cardValidationNum' => '1213'),
			'id'=>'1211',
			'litleTxnId'=>'12345678000',
			'orderId'=> '2111',
			'reportGroup'=>'Planets',
			'orderSource'=>'ecommerce',
			'amount'=>'123');
		$batch_request = new BatchRequest($this->direct);
		$batch_request->addAuth($hash_in);
		
		$this->assertTrue(file_exists($batch_request->batch_file));
		$this->assertEquals(1, $batch_request->total_txns);
		
		$cts = $batch_request->getCountsAndAmounts();
		$this->assertEquals(1, $cts['auth']['count']);
		$this->assertEquals(123, $cts['auth']['amount']);
		
	}
	
	function test_addAuthReversal()
	{
		
		$hash_in = array(
			'card'=>array('type'=>'VI',
					'number'=>'4100000000000000',
					'expDate'=>'1213',
					'cardValidationNum' => '1213'),
			'id'=>'1211',
			'litleTxnId'=>'12345678000',
			'orderId'=> '2111',
			'reportGroup'=>'Planets',
			'orderSource'=>'ecommerce',
			'amount'=>'123');
		$batch_request = new BatchRequest($this->direct);
		$batch_request->addAuthReversal($hash_in);
		
		$this->assertTrue(file_exists($batch_request->batch_file));
		$this->assertEquals(1, $batch_request->total_txns);
		
		$cts = $batch_request->getCountsAndAmounts();
		$this->assertEquals(1, $cts['authReversal']['count']);
		$this->assertEquals(123, $cts['authReversal']['amount']);
		
	}
	
	
	function test_addCredit()
	{
		
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
		$batch_request = new BatchRequest($this->direct);
		$batch_request->addCredit($hash_in);
		
		$this->assertTrue(file_exists($batch_request->batch_file));
		$this->assertEquals(1, $batch_request->total_txns);
		
		$cts = $batch_request->getCountsAndAmounts();
		$this->assertEquals(1, $cts['credit']['count']);
		$this->assertEquals(123, $cts['credit']['amount']);
		
	}
	
	
	function test_addRegisterToken()
	{
		
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
		$batch_request = new BatchRequest($this->direct);
		$batch_request->addRegisterToken($hash_in);
		
		$this->assertTrue(file_exists($batch_request->batch_file));
		$this->assertEquals(1, $batch_request->total_txns);
		
		$cts = $batch_request->getCountsAndAmounts();
		$this->assertEquals(1, $cts['tokenRegistration']['count']);
		
	}
	
	
	function test_addForceCapture()
	{
		
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
		$batch_request = new BatchRequest($this->direct);
		$batch_request->addForceCapture($hash_in);
		
		$this->assertTrue(file_exists($batch_request->batch_file));
		$this->assertEquals(1, $batch_request->total_txns);
		
		$cts = $batch_request->getCountsAndAmounts();
		$this->assertEquals(1, $cts['forceCapture']['count']);
		$this->assertEquals(123, $cts['forceCapture']['amount']);
		
	}
	
	
	function test_addCapture()
	{
		
		$hash_in = array(
			'card'=>array('type'=>'VI',
					'number'=>'4100000000000000',
					'expDate'=>'1213',
					'cardValidationNum' => '1213'),
			'id'=>'1211',
			'orderId'=> '2111',
			'litleTxnId'=>'12345678000',
			'reportGroup'=>'Planets',
			'orderSource'=>'ecommerce',
			'amount'=>'123');
		$batch_request = new BatchRequest($this->direct);
		$batch_request->addCapture($hash_in);
		
		$this->assertTrue(file_exists($batch_request->batch_file));
		$this->assertEquals(1, $batch_request->total_txns);
		
		$cts = $batch_request->getCountsAndAmounts();
		$this->assertEquals(1, $cts['capture']['count']);
		$this->assertEquals(123, $cts['capture']['amount']);
		
	}
	
	function test_addCaptureGivenAuth()
	{
		
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
		$batch_request = new BatchRequest($this->direct);
		$batch_request->addCaptureGivenAuth($hash_in);
		
		$this->assertTrue(file_exists($batch_request->batch_file));
		$this->assertEquals(1, $batch_request->total_txns);
		
		$cts = $batch_request->getCountsAndAmounts();
		$this->assertEquals(1, $cts['captureGivenAuth']['count']);
		$this->assertEquals(123, $cts['captureGivenAuth']['amount']);
		
	}
	
	
	function test_addEcheckRedeposit()
	{
		
		$hash_in = array(
			'card'=>array('type'=>'VI',
					'number'=>'4100000000000000',
					'expDate'=>'1213',
					'cardValidationNum' => '1213'),
			'id'=>'1211',
			'orderId'=> '2111',
			'litleTxnId'=>'12345678000',
			'reportGroup'=>'Planets',
			'orderSource'=>'ecommerce',
			'amount'=>'123');
		$batch_request = new BatchRequest($this->direct);
		$batch_request->addEcheckRedeposit($hash_in);
		
		$this->assertTrue(file_exists($batch_request->batch_file));
		$this->assertEquals(1, $batch_request->total_txns);
		
		$cts = $batch_request->getCountsAndAmounts();
		$this->assertEquals(1, $cts['echeckRedeposit']['count']);
		
	}
	
	function test_addEcheckSale()
	{
		
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
		$batch_request = new BatchRequest($this->direct);
		$batch_request->addEcheckSale($hash_in);
		
		$this->assertTrue(file_exists($batch_request->batch_file));
		$this->assertEquals(1, $batch_request->total_txns);
		
		$cts = $batch_request->getCountsAndAmounts();
		$this->assertEquals(1, $cts['echeckSale']['count']);
		$this->assertEquals(123, $cts['echeckSale']['amount']);
		
	}
	
	function test_addEcheckVerification()
	{
		
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
		$batch_request = new BatchRequest($this->direct);
		$batch_request->addEcheckVerification($hash_in);
		
		$this->assertTrue(file_exists($batch_request->batch_file));
		$this->assertEquals(1, $batch_request->total_txns);
		
		$cts = $batch_request->getCountsAndAmounts();
		$this->assertEquals(1, $cts['echeckVerification']['count']);
		$this->assertEquals(123, $cts['echeckVerification']['amount']);
		
	} 
	
	
	function test_addUpdateCardValidationNumOnTokenHash()
	{
		
		$hash_in = array(
			'card'=>array('type'=>'VI',
					'number'=>'4100000000000000',
					'expDate'=>'1213',
					'cardValidationNum' => '1213'),
			'id'=>'1211',
			'orderId'=> '2111',
	      	'litleToken'=>'123456789101112',
			'reportGroup'=>'Planets',
			'orderSource'=>'ecommerce',
			'amount'=>'123',
			'cardValidationNum'=>'123');
		$batch_request = new BatchRequest($this->direct);
		$batch_request->addUpdateCardValidationNumOnToken($hash_in);
		
		$this->assertTrue(file_exists($batch_request->batch_file));
		$this->assertEquals(1, $batch_request->total_txns);
		
		$cts = $batch_request->getCountsAndAmounts();
		$this->assertEquals(1, $cts['updateCardValidationNumOnToken']['count']);
		
	} 
	
	function test_mechaBatch(){
		
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
		
		# second batch
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
		
		# third batch
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
		
		# fourth batch
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
		$batch->addUpdateCardValidationNumOnTokenHash($hash_in);
		
		# fifth batch
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
	function test_addAccountUpdate()
	{
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
		$batch_request = new BatchRequest($this->direct);
		$batch_request->addAccountUpdate($hash_in);
		
		$this->assertTrue(file_exists($batch_request->batch_file));
		$cts = $batch_request->getCountsAndAmounts();
		$this->assertEquals(1, $cts['accountUpdate']['count']);
		
		
	}
	function test_addAccountUpdate_negative_with_transaction_before_accountUpdate()
	{
		try{
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
			$batch_request = new BatchRequest($this->direct);
			$batch_request->addSale($hash_in);
			$batch_request->addAccountUpdate($hash_in);
			
		}catch(RuntimeException $expected){
			$this->assertEquals($expected->getMessage(),"The transaction could not be added to the batch. The transaction type accountUpdate cannot be mixed with non-Account Updates.");
			return;
		}
		
		$this->fail("test_addAccountUpdate_negative_with_transaction_before_accountUpdate is expected to fail");
				
	}
	function test_addAccountUpdate_negative_with_transaction_after_accountUpdate()
	{

		try{
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
			$batch_request = new BatchRequest($this->direct);
			$batch_request->addAccountUpdate($hash_in);			
			$batch_request->addSale($hash_in);
			
		}catch(RuntimeException $expected){
			$this->assertEquals($expected->getMessage(),"The transaction could not be added to the batch. The transaction type sale cannot be mixed with AccountUpdates.");
			return;
		}
		
		$this->fail("test_addAccountUpdate_negative_with_transaction_after_accountUpdate is expected to fail");
				
	}	
	
	function test_isFull(){
		try{
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
			$batch_request = new BatchRequest($this->direct);
			$batch_request->total_txns = MAX_TXNS_PER_BATCH;
			$batch_request->addSale($hash_in);
		}
		catch(RuntimeException $expected){
			$this->assertEquals($expected->getMessage(), "The transaction could not be added to the batch. It is full.");
			return;
		}
		$this->fail('An excepted exception has not been raised');
	}
	function test_addTooManyTransactions()
	{
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
			$batch_request = new BatchRequest($this->direct);
			$batch_request->total_txns = MAX_TXNS_PER_BATCH;
			
			$this->setExpectedException(
			'RuntimeException', 'The transaction could not be added to the batch. It is full.'
			);
			
			$batch_request->addSale($hash_in);		
	}
	function test_addToClosedBatch()
	{
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
			$batch_request = new BatchRequest($this->direct);
			$batch_request->closed = TRUE;
			$this->setExpectedException(
			'RuntimeException', 'Could not add the transaction. This batchRequest is closed.'
			);
			
			$batch_request->addSale($hash_in);			
	}
	function test_closeRequest()
	{
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
		$batch_request = new BatchRequest($this->direct);
		$batch_request->addSale($hash_in);
		$batch_request->closeRequest();
		
		$data = file_get_contents($batch_request->batch_file);
		$this->assertTrue(!(!strpos($data, 'numSales="1"')));
		$this->assertTrue($batch_request->closed);

	}
	
	function test_closeRequest_badFile(){
		$batch_request = new BatchRequest($this->direct);
		$batch_request->transaction_file = "/usr/NOPERMS";
		
		$this->setExpectedException(
		'RuntimeException', 'Could not open transactions file at /usr/NOPERMS. Please check your privilege.'
		);
		$batch_request->closeRequest();
	}
	
	function test_getCountsAndAmounts()
	{
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
		$batch_request = new BatchRequest($this->direct);
		$batch_request->addSale($hash_in);
		
		$cts = $batch_request->getCountsAndAmounts();
		$this->assertNotNull($cts);
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
