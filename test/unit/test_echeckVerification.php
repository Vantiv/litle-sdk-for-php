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

class echeckVerification_UnitTest extends UnitTestCase
{
	function test_simple_echeckVerification()
	{
	     $hash_in = array('reportGroup'=>'Planets','amount'=>'123','orderId'=>'123','orderSource'=>'ecommerce',
		'echeckToken' => array('accType'=>'Checking','routingNum'=>'123123','litleToken'=>'1234565789012','checkNum'=>'123455'));
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<echeckToken>.*<accType>Checking.*/')));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->echeckVerificationRequest($hash_in);
	}
	function test_no_amount()
	{
		$hash_in = array(
		'reportGroup'=>'Planets',
		'orderId'=>'12344');
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /amount/"));
		$retOb = $litleTest->echeckVerificationRequest($hash_in);
	}
	function test_no_orderId()
	{
		$hash_in = array(
			'reportGroup'=>'Planets',
			'amount'=>'123');
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /orderId/"));
		$retOb = $litleTest->echeckVerificationRequest($hash_in);
	}
	function test_no_orderSounce()
	{
		$hash_in = array(
			'reportGroup'=>'Planets',
			'amount'=>'123',
			'orderId'=>'12344');
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /orderSource/"));
		$retOb = $litleTest->echeckVerificationRequest($hash_in);
	}
	function test_both_Choices()
	{
		$hash_in = array('reportGroup'=>'Planets','amount'=>'123','orderId'=>'123','orderSource'=>'ecommerce',
		'echeckToken' => array('accType'=>'Checking','routingNum'=>'123123','litleToken'=>'1234565789012','checkNum'=>'123455'),
		'echeck' => array('accType'=>'Checking','routingNum'=>'123123','accNum'=>'12345657890','checkNum'=>'123455'));
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->echeckVerificationRequest($hash_in);
	}
	
}