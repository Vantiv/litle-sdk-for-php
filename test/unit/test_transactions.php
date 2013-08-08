<?php

require_once realpath(dirname(__FILE__)) . '/../../lib/LitleOnline.php';

class transactions_UnitTest extends PHPUnit_Framework_TestCase {
	
	function test_auth_with_card()
	{
		$hash_in = array(
			'card'=>array('type'=>'VI',
					'number'=>'4100000000000001',
					'expDate'=>'1213',
					'cardValidationNum' => '1213'),
			'orderId'=> '2111',
			'orderSource'=>'ecommerce',
			'amount'=>'123');

		$hash_out = Transactions::createAuthHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
	}
	
	
}


?>