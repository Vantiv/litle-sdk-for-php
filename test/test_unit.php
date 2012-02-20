<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', '1');
require_once("../simpletest/autorun.php");
require_once('../simpletest/unit_tester.php');
require_once('../simpletest/mock_objects.php');
require_once realpath(dirname(__FILE__)) . '/../lib/communication.php';
require_once realpath(dirname(__FILE__)) . '/../lib/LitleOnlineRequest.php';
Mock::generate('communication');

class LitleUnitTest extends UnitTestCase
{
	function test_auth()
	{
		$connection = &new Mockcommunication();
		$connection->expectOnce('httpRequest');
		$connection->setReturnValue('httpRequest',$req);
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
			'amount'=>'123', 
			'litleTxnId'=>'2234567890');
	$retOb = LitleOnlineRequest::authorizationRequest($hash_in);
	$user =  Xml_parser::get_node($retOb,'message');
	$this->assertEqual($user,'Approved');
	}
}
?>