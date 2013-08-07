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
	function test_mechaBatch(){
		
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
	function test_addAccountUpdate_negative()
	{
		
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
		
	}
	function test_addToClosedBatch()
	{
		
	}
	function test_closeBatch()
	{
		
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
