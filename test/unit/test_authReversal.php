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
class authReversal_UnitTest extends UnitTestCase
{
	function test_capture()
	{
		$hash_in = array('litleTxnId'=> '1234567890','reportGroup'=>'Planets', 'amount'=>'5000');
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<litleTxnId>1234567890.*<amount>5000.*/')));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->authReversalRequest($hash_in);
	}
	
	function test_no_txnid()
	{
		$hash_in =array('reportGroup'=>'Planets','amount'=>'106');
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /litleTxnId/"));
		$retOb = $litleTest->authReversalRequest($hash_in);
	}
}
?>