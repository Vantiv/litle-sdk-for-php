<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', '1');
require_once("../../simpletest/autorun.php");
require_once('../../simpletest/unit_tester.php');
require_once('../../simpletest/mock_objects.php');
require_once realpath(dirname(__FILE__)) . '/../../lib/communication.php';
require_once realpath(dirname(__FILE__)) . '/../../lib/LitleOnlineRequest.php';
Mock::generate('communication');
Mock::generate('LitleXmlMapper');
class auth_UnitTest extends UnitTestCase
{
	function test_auth_with_card()
	{
		$hash_in = array('usr'=>'IMPTEST',
			'password'=>'cert3d6Z',
			'merchantId'=>'087900',
			'version'=>'8.8',
			'card'=>array('type'=>'VI',
					'number'=>'4100000000000001',
					'expDate'=>'1213',
					'cardValidationNum' => '1213'),
			'id'=>'1211',
			'orderId'=> '2111',
			'reportGroup'=>'Planets',
			'orderSource'=>'ecommerce',
			'amount'=>'123');
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<card><type>VI.*<number>4100000000000001.*<expDate>1213.*<cardValidationNum>1213.*/')));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->authorizationRequest($hash_in);
	}

	
	function test_noOrderId()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'litleTxnId'=>'123456',
	      'amount'=>'106',
	      'orderSource'=>'ecommerce',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210')
	      );
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /orderId/"));
		$retOb = $litleTest->authorizationRequest($hash_in);
		
		
	}
	
	function test_noAmount()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'litleTxnId'=>'123456',
	      'orderId'=>'12344',
	      'orderSource'=>'ecommerce',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210')
		);
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /amount/"));
		$retOb = $litleTest->authorizationRequest($hash_in);
	
	}
	
	function test_noOrderSource()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'litleTxnId'=>'123456',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210')
		);
		$litleTest = &new LitleOnlineRequest();
	$this->expectException(new Exception("Missing Required Field: /orderSource/"));
		$retOb = $litleTest->authorizationRequest($hash_in);
	
	}
	
	function test_BothChoicesCardandPaypal()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'orderSource'=>'ecommerce',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210'
	      ),
	      'paypal'=>array(
	      'payerId'=>'1234',
	      'token'=>'1234',
	      'transactionId'=>'123456')
		);
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->authorizationRequest($hash_in);
	
	}
	
	function test_threeChoicesCardandPaypageandPaypal()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'orderSource'=>'ecommerce',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210'
	      ),
	      'paypage'=> array(
	      'paypageRegistrationId'=>'1234',
	      'expDate'=>'1210',
	      'cardValidationNum'=>'555',
	      'type'=>'VI'),
	      'paypal'=>array(
	      'payerId'=>'1234',
	      'token'=>'1234',
	      'transactionId'=>'123456')
		);
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->authorizationRequest($hash_in);
	
	}
	
	function test_allChoicesCardandPaypageandPaypalandToken()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'litleTxnId'=>'123456',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'orderSource'=>'ecommerce',
	      'fraudCheck'=>array('authenticationTransactionId'=>'123'),
	      'bypassVelocityCheckcardholderAuthentication'=>array('authenticationTransactionId'=>'123'),
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210'
	      ),
	      'paypage'=> array(
	      'paypageRegistrationId'=>'1234',
	      'expDate'=>'1210',
	      'cardValidationNum'=>'555',
	      'type'=>'VI'),
	      'paypal'=>array(
	      'payerId'=>'1234',
	      'token'=>'1234',
	      'transactionId'=>'123456'),
	      'token'=> array(
	      'litleToken'=>'1234',
	      'expDate'=>'1210',
	      'cardValidationNum'=>'555',
	      'type'=>'VI')
		);
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->authorizationRequest($hash_in);
	
	}
	

	

}
?>