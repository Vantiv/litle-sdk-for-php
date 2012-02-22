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

class forceCapture_UnitTest extends UnitTestCase
{
	function test_simple_forcCapture()
	{
		$hash_in = array(
	 'orderId'=>'123',
      'reportGroup'=>'Planets',
      'litleTxnId'=>'123456',
      'amount'=>'106',
      'orderSource'=>'ecommerce',
      'token'=> array(
      'litleToken'=>'123456789101112',
      'expDate'=>'1210',
      'cardValidationNum'=>'555',
      'type'=>'VI'));
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<token><litleToken>123456789101112.*<expDate>1210.*/')));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->forceCaptureRequest($hash_in);
	}
	function test_no_orderId()
	{
		$hash_in = array(
       'reportGroup'=>'Planets',
       'litleTxnId'=>'123456',
       'amount'=>'107',
       'orderSource'=>'ecommerce',
       'token'=> array(
       'litleToken'=>'123456789101112',
       'expDate'=>'1210',
       'cardValidationNum'=>'555',
       'type'=>'VI'));
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /orderId/"));
		$retOb = $litleTest->forceCaptureRequest($hash_in);
	}
	function test_no_orderSource()
	{
		$hash_in = array(
	       'reportGroup'=>'Planets',
	       'litleTxnId'=>'123456',
	       'amount'=>'107',
	       'orderId'=>'123',
	       'token'=> array(
	       'litleToken'=>'123456789101112',
	       'expDate'=>'1210',
	       'cardValidationNum'=>'555',
	       'type'=>'VI'));
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /orderSource/"));
		$retOb = $litleTest->forceCaptureRequest($hash_in);
	}
	function test_both_card_and_token()
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
      'token'=> array(
      'litleToken'=>'1234',
      'expDate'=>'1210',
      'cardValidationNum'=>'555',
      'type'=>'VI'));
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->forceCaptureRequest($hash_in);
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
		$retOb = $litleTest->forceCaptureRequest($hash_in);
	}
}