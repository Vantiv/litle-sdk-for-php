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
class capture_UnitTest extends UnitTestCase
{
	function test_simple_capture()
	{
		$config = array(
			'reportGroup'=>'Planets',
			'litleTxnId'=>'1234567890',
			'amount'=>'5000');
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<litleTxnId>1234567890.*<amount>5000.*/')));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->captureRequest($hash_in);
	}
	function test_simple_capture()
	{
		$config = array('reportGroup'=>'Planets','amount'=>'106');
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /litleTxnId/"));
		$retOb = $litleTest->captureRequest($hash_in);
	}

}
?>