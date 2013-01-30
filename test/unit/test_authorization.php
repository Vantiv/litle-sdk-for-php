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
require_once realpath(dirname(__FILE__)) . '/../../lib/LitleOnline.php';

class auth_UnitTest extends PHPUnit_Framework_TestCase
{
	function test_auth_with_card()
	{
		$hash_in = array(
			'card'=>array('type'=>'VI',
					'number'=>'4100000000000001',
					'expDate'=>'1213',
					'cardValidationNum' => '1213'),
			'orderId'=> '2111',
			'orderSource'=>'ecommerce',
			'id'=>'654',
			'amount'=>'123');
		$mock = $this->getMock('LitleXmlMapper');
		$mock	->expects($this->once())
		->method('request')
		->with($this->matchesRegularExpression('/.*<card><type>VI.*<number>4100000000000001.*<expDate>1213.*<cardValidationNum>1213.*/'));

		$litleTest = new LitleOnlineRequest();
		$litleTest->newXML = $mock;
		$litleTest->authorizationRequest($hash_in);
	}

	function test_muliple_lineItemData()
	{
		$lineItemData = array(
		array('itemSequenceNumber' => '1','itemDescription'=>'desc'),
		array('itemSequenceNumber' => '2','itemDescription'=>'desc2'));

		$hash_in = array(
					'card'=>array('type'=>'VI',
							'number'=>'4100000000000001',
							'expDate'=>'1213',
							'cardValidationNum' => '1213'),
					'orderId'=> '2111',
					'orderSource'=>'ecommerce',
					'id'=>'654',
					'enhancedData'=>array('salesTax'=> '123',
					'shippingAmount'=>'123',	
					'lineItemData'=>$lineItemData),
					'amount'=>'123');

		$mock = $this->getMock('LitleXmlMapper');
		$mock	->expects($this->once())
		->method('request')
		->with($this->matchesRegularExpression('/.*<enhancedData>.*<lineItemData>.*<itemSequenceNumber>1<\/itemSequenceNumber>.*<itemDescription>desc<\/itemDescription>.*<\/lineItemData>.*<lineItemData>.*<itemSequenceNumber>2<\/itemSequenceNumber>.*<itemDescription>desc2<\/itemDescription>.*<\/lineItemData>.*<\/enhancedData>.*/'));

		$litleTest = new LitleOnlineRequest();
		$litleTest->newXML = $mock;
		$litleTest->authorizationRequest($hash_in);
	}

	function test_muliple_detailTax()
	{
		$detailTax = array(
		array('taxAmount' => '0', 'cardAcceptorTaxId' => '0'),
		array('taxAmount' => '1', 'cardAcceptorTaxId' => '1'));

		$hash_in = array(
						'card'=>array('type'=>'VI',
								'number'=>'4100000000000001',
								'expDate'=>'1213',
								'cardValidationNum' => '1213'),
						'orderId'=> '2111',
						'orderSource'=>'ecommerce',
						'id'=>'654',
						'enhancedData'=>array('salesTax'=> '123',
						'shippingAmount'=>'123',	
						'detailTax'=>$detailTax),
						'amount'=>'123');

		$mock = $this->getMock('LitleXmlMapper');
		$mock	->expects($this->once())
		->method('request')
		->with($this->matchesRegularExpression('/.*<enhancedData>.*<detailTax>.*<taxAmount>.*<detailTax>.*<taxAmount>.*/'));

		$litleTest = new LitleOnlineRequest();
		$litleTest->newXML = $mock;
		$litleTest->authorizationRequest($hash_in);
	}


	function test_no_orderId()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'amount'=>'106',
	      'orderSource'=>'ecommerce',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210')
		);
		$litleTest = new LitleOnlineRequest();
		$this->setExpectedException('InvalidArgumentException','Missing Required Field: /orderId/');
		$retOb = $litleTest->authorizationRequest($hash_in);
	}

	function test_no_amount()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'orderId'=>'12344',
	      'orderSource'=>'ecommerce',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210')
		);
		$litleTest = new LitleOnlineRequest();
		$this->setExpectedException('InvalidArgumentException','Missing Required Field: /amount/');
		$retOb = $litleTest->authorizationRequest($hash_in);
	}

	function test_no_orderSource()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210')
		);
		$litleTest = new LitleOnlineRequest();
		$this->setExpectedException('InvalidArgumentException','Missing Required Field: /orderSource/');
		$retOb = $litleTest->authorizationRequest($hash_in);

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
		$litleTest = new LitleOnlineRequest();
		$this->setExpectedException('InvalidArgumentException','Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!');
		$retOb = $litleTest->authorizationRequest($hash_in);
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
		$litleTest = new LitleOnlineRequest();
		$this->setExpectedException('InvalidArgumentException','Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!');
		$retOb = $litleTest->authorizationRequest($hash_in);
	}

	function test_all_choices_card_and_paypage_and_paypal_and_token()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
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
		$litleTest = new LitleOnlineRequest();
		$this->setExpectedException('InvalidArgumentException','Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!');
		$retOb = $litleTest->authorizationRequest($hash_in);
	}

	function test_merchant_data()
	{
		$hash_in = array(
				'orderId'=> '2111',
				'orderSource'=>'ecommerce',
				'amount'=>'123',
				'merchantData'=>array(
					'campaign'=>'foo'
		)
		);
		$mock = $this->getMock('LitleXmlMapper');
		$mock	->expects($this->once())
		->method('request')
		->with($this->matchesRegularExpression('/.*<merchantData>.*?<campaign>foo<\/campaign>.*?<\/merchantData>.*/'));

		$litleTest = new LitleOnlineRequest();
		$litleTest->newXML = $mock;
		$litleTest->authorizationRequest($hash_in);
	}

	function test_customer_id() {
		$hash_in = array(
				'card'=>array('type'=>'VI',
						'number'=>'4100000000000001',
						'expDate'=>'1213',
						'cardValidationNum' => '1213'),
				'orderId'=> '2111',
				'orderSource'=>'ecommerce',
				'customerId'=>'gdake@litle.com',
				'amount'=>'123');
		$mock = $this->getMock('LitleXmlMapper');
		$mock	->expects($this->once())
		->method('request')
		->with($this->matchesRegularExpression('/.*customerId="gdake@litle.com"*/'));

		$litleTest = new LitleOnlineRequest();
		$litleTest->newXML = $mock;
		$litleTest->authorizationRequest($hash_in);
	}

	function test_id() {
		$hash_in = array(
					'card'=>array('type'=>'VI',
							'number'=>'4100000000000001',
							'expDate'=>'1213',
							'cardValidationNum' => '1213'),
					'orderId'=> '2111',
					'orderSource'=>'ecommerce',
					'id'=>'64575',
					'amount'=>'123');
		$mock = $this->getMock('LitleXmlMapper');
		$mock	->expects($this->once())
		->method('request')
		->with($this->matchesRegularExpression('/.*id="64575"*/'));

		$litleTest = new LitleOnlineRequest();
		$litleTest->newXML = $mock;
		$litleTest->authorizationRequest($hash_in);
	}
	
 	function test_fraud_filter_override() {
 		$hash_in = array(
 			'card'=>array(	'type'=>'VI',
 							'number'=>'4100000000000001',
 							'expDate'=>'1213',
 							'cardValidationNum' => '1213'),
 			'orderId'=> '2111',
 			'orderSource'=>'ecommerce',
 			'id'=>'64575',
 			'amount'=>'123',
 			'fraudFilterOverride'=>'true'
 		);
 		$mock = $this->getMock('LitleXmlMapper');
 		$mock	->expects($this->once())
 		->method('request')
 		->with($this->matchesRegularExpression('/.*<authorization.*?<fraudFilterOverride>true<\/fraudFilterOverride>.*?<\/authorization>.*/'));
 		
 		$litleTest = new LitleOnlineRequest();
 		$litleTest->newXML = $mock;
 		$litleTest->authorizationRequest($hash_in); 		
 	}
 	
 	function test_loggedInUser()
 	{
 		$hash_in = array(
 				'card'=>array('type'=>'VI',
 						'number'=>'4100000000000001',
 						'expDate'=>'1213',
 						'cardValidationNum' => '1213'),
 				'orderId'=> '2111',
 				'orderSource'=>'ecommerce',
 				'id'=>'654',
 				'amount'=>'123',
 				'loggedInUser'=>'gdake');
 		$mock = $this->getMock('LitleXmlMapper');
 		$mock	->expects($this->once())
 		->method('request')
 		->with($this->matchesRegularExpression('/.*merchantSdk="PHP;8.14.0".*loggedInUser="gdake" xmlns=.*>.*/'));
 	
 		$litleTest = new LitleOnlineRequest();
 		$litleTest->newXML = $mock;
 		$litleTest->authorizationRequest($hash_in);
 	}
}
