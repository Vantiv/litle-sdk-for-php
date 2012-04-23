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
class sale_UnitTest extends UnitTestCase
{
	function test_sale_with_card()
	{
		$hash_in = array(
			'card'=>array('type'=>'VI',
					'number'=>'4100000000000001',
					'expDate'=>'1213',
					'cardValidationNum' => '1213'),
			'id'=>'654',
			'orderId'=> '2111',
			'orderSource'=>'ecommerce',
			'amount'=>'123');
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<card><type>VI.*<number>4100000000000001.*<expDate>1213.*<cardValidationNum>1213.*/'),array("user"=>NULL,"password"=>NULL,"merchantId"=>NULL,"reportGroup"=>NULL,"version"=>NULL,"url"=>NULL,"timeout"=>NULL,"proxy"=>NULL)));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->saleRequest($hash_in);
	}

	
	function test_no_orderId()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'litleTxnId'=>'123456',
	      'amount'=>'106',
	      'orderSource'=>'ecommerce',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210')
	      );
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /orderId/"));
		$retOb = $litleTest->saleRequest($hash_in);
		
		
	}
	
	function test_no_amount()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'litleTxnId'=>'123456',
	      'orderId'=>'12344',
	      'orderSource'=>'ecommerce',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210')
		);
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /amount/"));
		$retOb = $litleTest->saleRequest($hash_in);
	
	}
	
	function test_no_orderSource()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'litleTxnId'=>'123456',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210')
		);
		$litleTest = &new LitleOnlineRequest();
	$this->expectException(new Exception("Missing Required Field: /orderSource/"));
		$retOb = $litleTest->saleRequest($hash_in);
	
	}
	
	function test_both_choices_card_and_paypal()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'orderSource'=>'ecommerce',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210'
	      ),
	      'paypal'=>array(
	      'payerId'=>'1234',
	      'token'=>'1234',
	      'transactionId'=>'123456')
		);
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->saleRequest($hash_in);
	
	}
	
	function test_three_choices_card_and_paypage_and_paypal()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'orderSource'=>'ecommerce',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210'
	      ),
	      'paypage'=> array(
	      'paypageRegistrationId'=>'1234',
	      'expDate'=>'1210',
	      'cardValidationNum'=>'555',
	      'type'=>'VI'),
	      'paypal'=>array(
	      'payerId'=>'1234',
	      'token'=>'1234',
	      'transactionId'=>'123456')
		);
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->saleRequest($hash_in);
	
	}
	
	function test_all_choices_card_and_paypage_and_paypal_and_token()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'litleTxnId'=>'123456',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'orderSource'=>'ecommerce',
	      'fraudCheck'=>array('authenticationTransactionId'=>'123'),
	      'bypassVelocityCheckcardholderAuthentication'=>array('authenticationTransactionId'=>'123'),
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210'
	      ),
	      'paypage'=> array(
	      'paypageRegistrationId'=>'1234',
	      'expDate'=>'1210',
	      'cardValidationNum'=>'555',
	      'type'=>'VI'),
	      'paypal'=>array(
	      'payerId'=>'1234',
	      'token'=>'1234',
	      'transactionId'=>'123456'),
	      'token'=> array(
	      'litleToken'=>'1234',
	      'expDate'=>'1210',
	      'cardValidationNum'=>'555',
	      'type'=>'VI')
		);
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->saleRequest($hash_in);	
	}
	
	function test_merchant_data()
	{
		$hash_in = array(
					'orderId'=> '2111',
					'orderSource'=>'ecommerce',
					'amount'=>'123',
					'merchantData'=>array(
						'affiliate'=>'bar'
		)
		);
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<merchantData>.*?<affiliate>bar<\/affiliate>.*?<\/merchantData>.*/'),array("user"=>NULL,"password"=>NULL,"merchantId"=>NULL,"reportGroup"=>NULL,"version"=>NULL,"url"=>NULL,"timeout"=>NULL,"proxy"=>NULL)));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->saleRequest($hash_in);
	}
	

}