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
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<litleTxnId>12312312.*<amount>123.*/')));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->captureGivenAuthRequest($hash_in);
	}

	// 	function test_no_txnid()
	// 	{
	// 		$hash_in =array('reportGroup'=>'Planets','amount'=>'106');
	// 		$litleTest = &new LitleOnlineRequest();
	// 		$this->expectException(new Exception("Missing Required Field: /litleTxnId/"));
	// 		$retOb = $litleTest->captureRequest($hash_in);
	// 	}

	}
	?>