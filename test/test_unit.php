<?php
#require_once("../simpletest/autorun.php");
#header("Content-Type:text/xml");
require_once('../simpletest/unit_tester.php');
require_once('../simpletest/mock_objects.php');
require_once realpath(dirname(__FILE__)) . "/../lib/XMLFields.php";
require_once realpath(dirname(__FILE__)) . "/../lib/Checker.php";
require_once realpath(dirname(__FILE__)) . "/../lib/communication.php";
require_once realpath(dirname(__FILE__)) . '/../lib/createObj.php';
require_once realpath(dirname(__FILE__)) . '/../lib/Obj2xml.php';
require_once realpath(dirname(__FILE__)) . '/../lib/LitleXmlMapper.php';
#Mock::generate('communication');

#class LitleUnitTest extends UnitTestCase
#{
#function setup_test()
#{
#$connection = &new Mockcommunication;
#$connection->setReturnValue('httpRequest',$req,$req);
$config = array('usr'=>'IMPTEST',
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
#$ob=createObj::createVoid($config);
#$rob = LitleXmlMapper::request($ob,'void',$config);
$returned = LitleOnlineRequest::authorizationRequest($config);
#echo Xml_parser::get_node($rob,'litleTxnId')
#echo $rob->saveXML();

#echo Xml_parser::get_node($rob,'litleTxnId')

#$x = $rob->documentElement;

#$this->assertEqual($responseArray["usr"],"IMPTEST");
#}

#}
?>