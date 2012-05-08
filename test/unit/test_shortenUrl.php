<?php
/*
 * Copyright (c) 2011 Litle & Co.
 * 
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

require_once("../../simpletest/autorun.php");
require_once('../../simpletest/unit_tester.php');
require_once('../../simpletest/mock_objects.php');
require_once realpath(dirname(__FILE__)) . '/../../lib/LitleOnline.php';
Mock::generate('communication');
Mock::generate('LitleXmlMapper');

class shortenUrl_UnitTest extends UnitTestCase
{
	function test_shortenUrl_1()
	{
		$hash_in = array(
			'card'=>array('type'=>'VI',
					'number'=>'4100000000000001',
					'expDate'=>'1213',
					'cardValidationNum' => '1213'),
			'id'=>'654',
			'orderId'=> '2111',
			'orderSource'=>'ecommerce',
			'customBilling'=>array('url'=>'https://www.testing123.org'),
			'amount'=>'123');
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<customBilling><url>testing123.*/'),array("user"=>NULL,"password"=>NULL,"merchantId"=>NULL,"reportGroup"=>NULL,"version"=>NULL,"url"=>NULL,"timeout"=>NULL,"proxy"=>NULL)));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->saleRequest($hash_in);
	}
	
	function test_shortenUrl_2()
	{
		$hash_in = array(
				'card'=>array('type'=>'VI',
						'number'=>'4100000000000001',
						'expDate'=>'1213',
						'cardValidationNum' => '1213'),
				'id'=>'654',
				'orderId'=> '2111',
				'orderSource'=>'ecommerce',
				'customBilling'=>array('url'=>'http://www.orders.othertesturl/payments'),
				'amount'=>'123');
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<customBilling><url>orders.other.*/'),array("user"=>NULL,"password"=>NULL,"merchantId"=>NULL,"reportGroup"=>NULL,"version"=>NULL,"url"=>NULL,"timeout"=>NULL,"proxy"=>NULL)));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->saleRequest($hash_in);
	}
	
	function test_shortenUrl_3()
	{
		$hash_in = array(
					'card'=>array('type'=>'VI',
							'number'=>'4100000000000001',
							'expDate'=>'1213',
							'cardValidationNum' => '1213'),
					'id'=>'654',
					'orderId'=> '2111',
					'orderSource'=>'ecommerce',
					'customBilling'=>array('url'=>'12345678912345'),
					'amount'=>'123');
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<customBilling><url>123456789123.*/'),array("user"=>NULL,"password"=>NULL,"merchantId"=>NULL,"reportGroup"=>NULL,"version"=>NULL,"url"=>NULL,"timeout"=>NULL,"proxy"=>NULL)));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->saleRequest($hash_in);
	}
	
	function test_shortenUrl_4()
	{
		$hash_in = array(
						'card'=>array('type'=>'VI',
								'number'=>'4100000000000001',
								'expDate'=>'1213',
								'cardValidationNum' => '1213'),
						'id'=>'654',
						'orderId'=> '2111',
						'orderSource'=>'ecommerce',
						'customBilling'=>array('url'=>'select/hompage.gov/'),
						'amount'=>'123');
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<customBilling><url>select.*/'),array("user"=>NULL,"password"=>NULL,"merchantId"=>NULL,"reportGroup"=>NULL,"version"=>NULL,"url"=>NULL,"timeout"=>NULL,"proxy"=>NULL)));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->saleRequest($hash_in);
	}
	
	function test_shortenUrl_5()
	{
		$hash_in = array(
							'card'=>array('type'=>'VI',
									'number'=>'4100000000000001',
									'expDate'=>'1213',
									'cardValidationNum' => '1213'),
							'id'=>'654',
							'orderId'=> '2111',
							'orderSource'=>'ecommerce',
							'customBilling'=>array('url'=>'test.co'),
							'amount'=>'123');
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<customBilling><url>test.co.*/'),array("user"=>NULL,"password"=>NULL,"merchantId"=>NULL,"reportGroup"=>NULL,"version"=>NULL,"url"=>NULL,"timeout"=>NULL,"proxy"=>NULL)));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->saleRequest($hash_in);
	}
	
	function test_shortenUrl_6()
	{
		$hash_in = array(
								'card'=>array('type'=>'VI',
										'number'=>'4100000000000001',
										'expDate'=>'1213',
										'cardValidationNum' => '1213'),
								'id'=>'654',
								'orderId'=> '2111',
								'orderSource'=>'ecommerce',
								'customBilling'=>array('url'=>'www.test.com/payments'),
								'amount'=>'123');
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<customBilling><url>test.*/'),array("user"=>NULL,"password"=>NULL,"merchantId"=>NULL,"reportGroup"=>NULL,"version"=>NULL,"url"=>NULL,"timeout"=>NULL,"proxy"=>NULL)));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->saleRequest($hash_in);
	}
	
	function test_shortenUrl_7()
	{
		$hash_in = array(
									'card'=>array('type'=>'VI',
											'number'=>'4100000000000001',
											'expDate'=>'1213',
											'cardValidationNum' => '1213'),
									'id'=>'654',
									'orderId'=> '2111',
									'orderSource'=>'ecommerce',
									'customBilling'=>array('url'=>'www.short.com'),
									'amount'=>'123');
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<customBilling><url>www.short.com.*/'),array("user"=>NULL,"password"=>NULL,"merchantId"=>NULL,"reportGroup"=>NULL,"version"=>NULL,"url"=>NULL,"timeout"=>NULL,"proxy"=>NULL)));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->saleRequest($hash_in);
	}
	
}