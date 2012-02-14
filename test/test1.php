<?php
require_once('simpletest/autorun.php');
require_once realpath(dirname(__FILE__)) . '/lib/communication.php';
require_once realpath(dirname(__FILE__)) . '/lib/createObj.php';
require_once realpath(dirname(__FILE__)) . '/lib/Obj2xml.php';
require_once realpath(dirname(__FILE__)) . '/lib/tagValue.php';
class AllTests extends UnitTestCase{
                function testTesting()
                {
                $x = 'teststring';
                $this->assertEqual($x,'teststring');
                //$this->assertTrue(true);
                }
                function testSimpleAuth()
                {
                //set up request
                $config = array('usr'=>'IMPTEST',
                                'password'=>'cert3d6Z',
                                'merchantId'=>'087900',
                                'version'=>'8.8',
                                'reportGroup'=>'Planets',
                                'id'=>'NULL',
                                'orderId'=>'1',
                                'amount'=>'5000',
                                'orderSource'=>'ecommerce',
                                'name'=>'greg',
                                'addressLine1'=>'900 chelmsford st.',
				'addressLine2'=>'',
				'addressLine3'=>'',
				'email'=>'test@litle.com',
				'phone'=>'1234567890',
                                'city'=>'lowell',
                                'state'=>'MA',    
                                'zip'=>'01851',
                                'country'=>'US',
                                'number'=>'4100000000000001',
                                'type'=>'VI',
                                'expDate'=>'1012',
                                'cardValidationNum'=>'123');
                $ob=createObj::createAuth($config);
                $type = 'authorization';
                $converter=new Obj2xml("litleOnlineRequest",$config);
                $req = $converter->toXml($ob,$type,$config);
                $response = communication::httpRequest($req);
                $message= tagValue::getXmlValueByTag($response,'message');
                $this->assertEqual($message,'Approved');
                }
		function testSimpleSale()
                {
                //set up request
                $config = array('usr'=>'IMPTEST',
                                'password'=>'cert3d6Z',
                                'merchantId'=>'087900',
                                'version'=>'8.8',
                                'reportGroup'=>'Planets',
                                'id'=>'NULL',
                                'orderId'=>'1',
                                'amount'=>'5000',
                                'orderSource'=>'ecommerce',
                                'name'=>'greg',
                                'addressLine1'=>'900 chelmsford st.',
				'addressLine2'=>'',
				'addressLine3'=>'',
				'email'=>'test@litle.com',
				'phone'=>'1234567890',
                                'city'=>'lowell',
                                'state'=>'MA',    
                                'zip'=>'01851',
                                'country'=>'US',
                                'number'=>'4100000000000001',
                                'type'=>'VI',
                                'expDate'=>'1012',
                                'cardValidationNum'=>'123');
                $ob=createObj::createSale($config);
                $type = 'sale';
                $converter=new Obj2xml("litleOnlineRequest",$config);
                $req = $converter->toXml($ob,$type,$config);
                $response = communication::httpRequest($req);
                $message= tagValue::getXmlValueByTag($response,'message');
                $this->assertEqual($message,'Approved');
                }

}
?>
