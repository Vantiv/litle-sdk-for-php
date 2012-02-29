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
require_once realpath(dirname(__FILE__)) . '/../../lib/LitleOnline.php';

class xmlfields_FunctionalTest extends UnitTestCase
{
	function test_cardnoRequiredtypeortrack()
	{
		$hash_in = array(
			'merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'litleTxnId'=>'123456',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'orderSource'=>'ecommerce',
	      'card'=>array(
	      'number' =>'4100000000000001',
	      'expDate' =>'1210',
	      'cardValidationNum'=> '123'
		));

		$initilaize = &new LitleOnlineRequest();
		$saleResponse = $initilaize->saleRequest($hash_in);
		$message= XMLParser::get_attribute($saleResponse,'litleOnlineResponse','message');
		$this->assertPattern('/Error validating xml data against the schema/',$message);
	}



	function test_simpleCustomBilling()
	{
		$hash_in = array(
				'merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'litleTxnId'=>'123456',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'orderSource'=>'ecommerce',
	      'customBilling'=>array('phone'=>'123456789','descriptor'=>'good'),
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210')
		);

		$initilaize = &new LitleOnlineRequest();
		$saleResponse = $initilaize->saleRequest($hash_in);
		$message = XMLParser::get_attribute($saleResponse,'litleOnlineResponse','message');
		$this->assertEqual('Valid Format',$message);
	}



	function test_simple_Auth_withlitleTxnId()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'litleTxnId'=>'123456',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'orderSource'=>'ecommerce',
	      'billMeLaterRequest'=>array('bmlMerchantId'=>'12345','preapprovalNumber'=>'12345678909023',
	      'customerPhoneChnaged'=>'False','itemCategoryCode'=>'2'),
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000002',
	      'expDate' =>'1210'
		));

		$initilaize = &new LitleOnlineRequest();
		$saleResponse = $initilaize->saleRequest($hash_in);
		$response= XMLParser::get_attribute($saleResponse,'litleOnlineResponse','response');
		$this->assertEqual("000",$response);
	}

	function test_CustomerInfo()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'litleTxnId'=>'123456',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'orderSource'=>'ecommerce',
	      'CustomerInfo'=>array('ssn'=>'12345','incomeAmount'=>'12345','incomeCurrency'=>'dollar','yearsAtResidence'=>'2'),
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210'
		));

		$initilaize = &new LitleOnlineRequest();
		$saleResponse = $initilaize->saleRequest($hash_in);
		$message= XMLParser::get_attribute($saleResponse,'litleOnlineResponse','message');
		$this->assertEqual("Valid Format",$message);
	}

	function test_simplebilltoAddress()
	{
		$hash_in = array('merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'amount'=>'106',
      'orderSource'=>'ecommerce',
      'billToAddress'=>array('name'=>'Bob','city'=>'lowell','state'=>'MA','email'=>'litle.com'),
      'card'=>array(
      'type'=>'VI',
      'number' =>'4100000000000001',
      'expDate' =>'1210'));

		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($hash_in);
		$message= XMLParser::get_attribute($authorizationResponse,'litleOnlineResponse','message');
		$this->assertEqual("Valid Format",$message);
	}

	function test_processingInstructions()
	{
		$hash_in = array('merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'amount'=>'106',
      'orderSource'=>'ecommerce',
      'processingInstructions'=>array('bypassVelocityCheck'=>'true'),
      'card'=>array(
      'type'=>'VI',
      'number' =>'4100000000000001',
      'expDate' =>'1210'));

		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($hash_in);
		$message= XMLParser::get_attribute($authorizationResponse,'litleOnlineResponse','message');
		$this->assertEqual("Valid Format",$message);
	}

	function test_pos()
	{
		$hash_in = array('merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'amount'=>'106',
      'orderSource'=>'ecommerce',
      'pos'=>array('capability'=>'notused','entryMode'=>'track1','cardholderId'=>'pin'),
      'card'=>array(
      'type'=>'VI',
      'number' =>'4100000000000001',
      'expDate' =>'1210'));

		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($hash_in);
		$message= XMLParser::get_attribute($authorizationResponse,'litleOnlineResponse','message');
		$this->assertEqual("Valid Format",$message);
	}

	function test_poswithinvalidentryMode()
	{
		$hash_in = array(
			'merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'amount'=>'106',
      'orderSource'=>'ecommerce',
      'pos'=>array('entryMode'=>'none','cardholderId'=>'pin','capability'=>'notused'),
      'card'=>array(
      'type'=>'VI',
      'number' =>'4100000000000001',
      'expDate' =>'1210'));

		$initilaize = &new LitleOnlineRequest();
		$saleResponse = $initilaize->saleRequest($hash_in);
		$message= XMLParser::get_attribute($saleResponse,'litleOnlineResponse','message');
		$this->assertPattern('/Error validating xml data against the schema/',$message);
	}

	function test_amexData()
	{
		$hash_in = array('merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'amount'=>'106',
      'card'=>array(
      'type'=>'VI',
      'number' =>'4100000000000001',
      'expDate' =>'1210'),
      'orderSource'=>'ecommerce',
      'amexAggregatorData'=>array('sellerMerchantCategoryCode'=>'1234','sellerId'=>'1234Id'));

		$initilaize = &new LitleOnlineRequest();
		$creditResponse = $initilaize->creditRequest($hash_in);
		$message= XMLParser::get_attribute($creditResponse,'litleOnlineResponse','message');
		$this->assertEqual("Valid Format",$message);
	}

	function test_amexDatamissingsellerId()
	{
		$hash_in = array(
				  'merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'orderSource'=>'ecommerce',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210'),
	      'amexAggregatorData'=>array('sellerMerchantCategoryCode'=>'1234'));

		$initilaize = &new LitleOnlineRequest();
		$creditResponse = $initilaize->creditRequest($hash_in);
		$message= XMLParser::get_attribute($creditResponse,'litleOnlineResponse','message');
		$this->assertPattern('/Error validating xml data against the schema/',$message);
	}


	function test_simpleEnhancedData()
	{
		$hash_in = array( 'merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'amount'=>'106',
      'card'=>array(
      'type'=>'VI',
      'number' =>'4100000000000001',
      'expDate' =>'1210'),
      'orderSource'=>'ecommerce',
      'enhancedData'=>array(
      'customerReference'=>'Litle',
      'salesTax'=>'50',
      'deliveryType'=>'TBD',
      'restriction'=>'DIG',
      'shipFromPostalCode'=>'01741',
      'destinationPostalCode'=>'01742'));

		$initilaize = &new LitleOnlineRequest();
		$creditResponse = $initilaize->creditRequest($hash_in);
		$message= XMLParser::get_attribute($creditResponse,'litleOnlineResponse','message');
		$this->assertEqual("Valid Format",$message);
	}

	function test_simpleEnhancedDataincorrectEnumforCountryCode()
	{
		$hash_in = array(
					  'merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210'),
	      'orderSource'=>'ecommerce',
	      'enhancedData'=>array(
	      'destinationCountryCode'=>'001',
	      'customerReference'=>'Litle',
	      'salesTax'=>'50',
	      'deliveryType'=>'TBD',
	      'shipFromPostalCode'=>'01741',
	      'destinationPostalCode'=>'01742'));

		$initilaize = &new LitleOnlineRequest();
		$creditResponse = $initilaize->creditRequest($hash_in);
		$message= XMLParser::get_attribute($creditResponse,'litleOnlineResponse','message');
		$this->assertPattern('/Error validating xml data against the schema/',$message);
	}

	function test_EnhancedDatawithdetailtax()
	{
		$hash_in = array(  'merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210'),
	      'orderSource'=>'ecommerce',
	      'enhancedData'=>array(
	      'detailtax'=>array('taxAmount'=>'1234','tax'=>'50'),
	      'customerReference'=>'Litle',
	      'salesTax'=>'50',
	      'deliveryType'=>'TBD',
	      'restriction'=>'DIG',
	      'shipFromPostalCode'=>'01741',
	      'destinationPostalCode'=>'01742'));

		$initilaize = &new LitleOnlineRequest();
		$creditResponse = $initilaize->creditRequest($hash_in);
		$message= XMLParser::get_attribute($creditResponse,'litleOnlineResponse','message');
		$this->assertEqual("Valid Format",$message);
	}

	function test_EnhancedDatawithlineItem()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210'), 
	      'processingInstructions'=>array('bypassVelocityCheck'=>'true'),
	      'orderSource'=>'ecommerce',
	      'lineItemData'=>array(
	      'itemSequenceNumber'=>'98765',
	      'itemDescription'=>'VERYnice',
	      'productCode'=>'10010100',
	      'quantity'=>'7',
	      'unitOfMeasure'=>'pounds',
	      'enhancedData'=>array(
	      'detailtax'=>array('taxAmount'=>'1234','tax'=>'50')),
	      'customerReference'=>'Litle',
	      'salesTax'=>'50',
	      'deliveryType'=>'TBD',
	      'restriction'=>'DIG',
	      'shipFromPostalCode'=>'01741',
	      'destinationPostalCode'=>'01742'));

		$initilaize = &new LitleOnlineRequest();
		$creditResponse = $initilaize->creditRequest($hash_in);
		$message= XMLParser::get_attribute($creditResponse,'litleOnlineResponse','message');
		$this->assertEqual("Valid Format",$message);
	}

	function test_simpletoken()
	{
		$hash_in = array('merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'amount'=>'106',
      'orderSource'=>'ecommerce',
      'token'=> array(
      'litleToken'=>'123456789101112',
      'expDate'=>'1210',
      'cardValidationNum'=>'555',
      'type'=>'VI'));

		$initilaize = &new LitleOnlineRequest();
		$creditResponse = $initilaize->creditRequest($hash_in);
		$message= XMLParser::get_attribute($creditResponse,'litleOnlineResponse','message');
		$this->assertEqual("Valid Format",$message);
	}

	function test_tokenwithincorrecttokenLength()
	{
		$hash_in = array( 'merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'amount'=>'106',
      'orderSource'=>'ecommerce',
      'token'=> array(
      'litleToken'=>'123456',
      'expDate'=>'1210',
      'cardValidationNum'=>'555',
      'type'=>'VI'));

		$initilaize = &new LitleOnlineRequest();
		$creditResponse = $initilaize->creditRequest($hash_in);
		$message= XMLParser::get_attribute($creditResponse,'litleOnlineResponse','message');
		$this->assertPattern('/Error validating xml data against the schema/',$message);
	}

	function test_tokenmissingexpDatandvalidNum()
	{
		$hash_in = array('merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'amount'=>'106',
      'orderSource'=>'ecommerce',
      'token'=> array(
      'litleToken'=>'123456789101112',
      'type'=>'VI'));

		$initilaize = &new LitleOnlineRequest();
		$creditResponse = $initilaize->creditRequest($hash_in);
		$message= XMLParser::get_attribute($creditResponse,'litleOnlineResponse','message');
		$this->assertEqual("Valid Format",$message);
	}

	function test_simplePaypage()
	{
		$hash_in = array( 'merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'amount'=>'106',
      'orderSource'=>'ecommerce',
      'paypage'=> array(
      'paypageRegistrationId'=>'123456789101112',
      'expDate'=>'1210',
      'cardValidationNum'=>'555',
      'type'=>'VI'));

		$initilaize = &new LitleOnlineRequest();
		$creditResponse = $initilaize->creditRequest($hash_in);
		$message= XMLParser::get_attribute($creditResponse,'litleOnlineResponse','message');
		$this->assertEqual("Valid Format",$message);
	}

	function test_paypagemissingexpDatandvalidNum()
	{
		$hash_in = array('merchantId' => '101',
	      'version'=>'8.8',
	      'reportGroup'=>'Planets',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'orderSource'=>'ecommerce',
	      'paypage'=> array(
	      'paypageRegistrationId'=>'123456789101112',
	      'type'=>'VI'));

		$initilaize = &new LitleOnlineRequest();
		$creditResponse = $initilaize->creditRequest($hash_in);
		$message= XMLParser::get_attribute($creditResponse,'litleOnlineResponse','message');
		$this->assertEqual("Valid Format",$message);
	}


}
