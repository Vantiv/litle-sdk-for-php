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
class token_UnitTest extends UnitTestCase
{
// 	function test_token_with_card()
// 	{
// 		$hash_in = array('usr'=>'IMPTEST',
// 			'password'=>'cert3d6Z',
// 			'merchantId'=>'087900',
// 			'version'=>'8.8',
// 			'card'=>array('type'=>'VI',
// 					'number'=>'4100000000000001',
// 					'expDate'=>'1213',
// 					'cardValidationNum' => '1213'),
// 			'id'=>'1211',
// 			'orderId'=> '2111',
// 			'reportGroup'=>'Planets',
// 			'orderSource'=>'ecommerce',
// 			'amount'=>'123');
// 		$mappTest = &new MockLitleXmlMapper();
// 		$commTest = &new Mockcommunication();
// 		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<card><type>VI.*<number>4100000000000001.*<expDate>1213.*<cardValidationNum>1213.*/')));
// 		$litleTest = &new LitleOnlineRequest();
// 		$litleTest->newXML = $mappTest;
// 		$retOb = $litleTest->registerTokenRequest($hash_in);
// 	}




	function test_accountNumandPaypage()
	{
		$hash_in = array('merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'accountNumber'=>'1233456789101112',
      'paypageRegistrationId'=>'1233456789101112');
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->registerTokenRequest($hash_in);

	}

	function test_echeckandPaypagel()
	{
		$hash_in = array('merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'echeckForToken'=>array('accNum'=>'12344565','routingNum'=>'123476545'),
      'paypageRegistrationId'=>'1233456789101112');
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->registerTokenRequest($hash_in);

	}

	function test_echeckandPaypageandaccountnum()
	{
		$hash_in = array('merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'accountNumber'=>'1233456789101112',
      'echeckForToken'=>array('accNum'=>'12344565','routingNum'=>'123476545'),
      'paypageRegistrationId'=>'1233456789101112');
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->registerTokenRequest($hash_in);

	}




}
?>