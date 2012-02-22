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

class captureGivenAuth_UnitTest extends UnitTestCase
{
	function test_simple_captureGivenAuth()
	{
		$hash_in = array(
       'reportGroup'=>'Planets',
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
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<authInformation><authDate>2002-10-09.*<authCode>543216.*><authAmount>12345.*/')));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->captureGivenAuthRequest($hash_in);
	}

	function test_no_amount()
	{
		$hash_in = array(
       'reportGroup'=>'Planets',
       'orderId'=>'12344',
       'authInformation' => array(
       'authDate'=>'2002-10-09','authCode'=>'543216',
       'authAmount'=>'12345'),
       'orderSource'=>'ecommerce',
       'card'=>array(
       'type'=>'VI',
       'number' =>'4100000000000001',
       'expDate' =>'1210'));
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /amount/"));
		$retOb = $litleTest->captureGivenAuthRequest($hash_in);
	}

	function test_BothChoicesCardandToken()
	{
		$hash_in = array(
      	'reportGroup'=>'Planets',
      	'orderId'=>'1234',
     	'amount'=>'106',
     	'orderSource'=>'ecommerce',
      	'authInformation' => array(
      	'authDate'=>'2002-10-09','authCode'=>'543216',
     	'authAmount'=>'12345'),
      	'token'=> array(
      	'litleToken'=>'123456789101112',
     	'expDate'=>'1210',
    	'cardValidationNum'=>'555',
    	'type'=>'VI'),
     	'card'=>array(
    	'type'=>'VI',
    	'number' =>'4100000000000001',
    	'expDate' =>'1210'));
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->captureGivenAuthRequest($hash_in);
	}
	function test_allChoices()
	{
		$hash_in = array(
			      'reportGroup'=>'Planets',
			      'litleTxnId'=>'123456',
			      'orderId'=>'12344',
			      'amount'=>'106',
			      'orderSource'=>'ecommerce',
			      'fraudCheck'=>array('authenticationTransactionId'=>'123'),
			      'cardholderAuthentication'=>array('authenticationTransactionId'=>'123'),
			      'card'=>array(
			      'type'=>'VI',
			      'number' =>'4100000000000001',
			      'expDate' =>'1210'),
				  'paypage'=> array(
				  'paypageRegistrationId'=>'1234',
				  'expDate'=>'1210',
				  'cardValidationNum'=>'555',
				  'type'=>'VI'),
			      'token'=> array(
			      'litleToken'=>'1234',
			      'expDate'=>'1210',
			      'cardValidationNum'=>'555',
			      'type'=>'VI'));
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->captureGivenAuthRequest($hash_in);
	}
}
?>