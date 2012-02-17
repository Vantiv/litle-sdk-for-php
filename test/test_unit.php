<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

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
			'id'=>'12',
			'reportGroup'=>'Planets',
			'litleTxnId'=>'1234567890');
$ob=createObj::createVoid($config);
$rob = LitleXmlMapper::request($ob,'void',$config);
#echo $rob->saveXML();

$books = $rob->getElementsByTagName("litleTxnId");
#echo $books->nodeValue, PHP_EOL;
foreach ($books as $book) {
	echo $book->nodeValue;
}
#$x = $rob->documentElement;

#$this->assertEqual($responseArray["usr"],"IMPTEST");
#}

#}
?>