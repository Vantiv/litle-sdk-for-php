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

class echeckRedeposit_UnitTest extends UnitTestCase
{
	function test_simple_echeckRedeposit()
	{
		$hash_in = array('litleTxnId' =>'123123','reportGroup'=>'Planets');
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<litleTxnId>123123.*/')));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->echeckRedepositRequest($hash_in);
	}

	function test_no_litleTxnId()
	{
		$hash_in = array('reportGroup'=>'Planets');
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /litleTxnId/"));
		$retOb = $litleTest->echeckRedepositRequest($hash_in);
	}
	
	function test_no_routingNum_echeck()
	{
		$hash_in = array('reportGroup'=>'Planets','litleTxnId'=>'123456',
     	'echeck' => array('accType'=>'Checking','accNum'=>'12345657890','checkNum'=>'123455'));
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /routingNum/"));
		$retOb = $litleTest->echeckRedepositRequest($hash_in);
	}
	
	function test_no_routingNum_echeckToken()
	{
		$hash_in = array('reportGroup'=>'Planets','litleTxnId'=>'123456',
	    'echeckToken' => array('accType'=>'Checking','litleToken'=>'1234565789012','checkNum'=>'123455'));
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /routingNum/"));
		$retOb = $litleTest->echeckRedepositRequest($hash_in);
	}
	
	function test_bothChoices()
	{
		$hash_in = array('reportGroup'=>'Planets','litleTxnId'=>'123456',
		'echeckToken' => array('accType'=>'Checking','routingNum'=>'123123','litleToken'=>'1234565789012','checkNum'=>'123455'),
		'echeck' => array('accType'=>'Checking','routingNum'=>'123123','accNum'=>'12345657890','checkNum'=>'123455'));
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->echeckRedepositRequest($hash_in);
	}
	
}