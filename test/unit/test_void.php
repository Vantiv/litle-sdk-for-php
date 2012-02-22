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

class void_UnitTest extends UnitTestCase
{
	function test_simple_echeckRedeposit()
	{
		$hash_in = array('litleTxnId' =>'123123','reportGroup'=>'Planets');
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<litleTxnId>123123.*/')));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->voidRequest($hash_in);
	}
	function test_no_litleTxnId()
	{
		$hash_in = array('reportGroup'=>'Planets');
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /litleTxnId/"));
		$retOb = $litleTest->voidRequest($hash_in);
	}
}
?>