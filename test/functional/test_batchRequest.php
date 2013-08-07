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
		
	}
	function test_addAccountUpdate_negative()
	{
		
	}
	function test_isFull(){
		
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
