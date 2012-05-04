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

class forceCapture_UnitTest extends UnitTestCase
{
	function test_simple_forcCapture()
	{
		$hash_in = array(
	 'orderId'=>'123',
      'litleTxnId'=>'123456',
      'amount'=>'106',
      'orderSource'=>'ecommerce',
      'token'=> array(
      'litleToken'=>'123456789101112',
      'expDate'=>'1210',
      'cardValidationNum'=>'555',
      'type'=>'VI'));
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<token><litleToken>123456789101112.*<expDate>1210.*/'),array("user"=>NULL,"password"=>NULL,"merchantId"=>NULL,"reportGroup"=>NULL,"version"=>NULL,"url"=>NULL,"timeout"=>NULL,"proxy"=>NULL)));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->forceCaptureRequest($hash_in);
	}
	function test_no_orderId()
	{
		$hash_in = array(
       'reportGroup'=>'Planets',
       'litleTxnId'=>'123456',
       'amount'=>'107',
       'orderSource'=>'ecommerce',
       'token'=> array(
       'litleToken'=>'123456789101112',
       'expDate'=>'1210',
       'cardValidationNum'=>'555',
       'type'=>'VI'));
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /orderId/"));
		$retOb = $litleTest->forceCaptureRequest($hash_in);
	}
	function test_no_orderSource()
	{
		$hash_in = array(
	       'reportGroup'=>'Planets',
	       'litleTxnId'=>'123456',
	       'amount'=>'107',
	       'orderId'=>'123',
	       'token'=> array(
	       'litleToken'=>'123456789101112',
	       'expDate'=>'1210',
	       'cardValidationNum'=>'555',
	       'type'=>'VI'));
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /orderSource/"));
		$retOb = $litleTest->forceCaptureRequest($hash_in);
	}
	function test_both_card_and_token()
	{
		$hash_in = array(

      'reportGroup'=>'Planets',
      'litleTxnId'=>'123456',
      'orderId'=>'12344',
      'amount'=>'106',
      'orderSource'=>'ecommerce',
      'fraudCheck'=>array('authenticationTransactionId'=>'123'),
      'cardholderAuthentication'=>array('authenticationTransactionId'=>'123'),
      'card'=>array(
      'type'=>'VI',
      'number' =>'4100000000000001',
      'expDate' =>'1210'),
      'token'=> array(
      'litleToken'=>'1234',
      'expDate'=>'1210',
      'cardValidationNum'=>'555',
      'type'=>'VI'));
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->forceCaptureRequest($hash_in);
	}
	function test_all_choices()
	{
		$hash_in = array(

	      'reportGroup'=>'Planets',
	      'litleTxnId'=>'123456',
	      'orderId'=>'12344',
	      'amount'=>'106',
	      'orderSource'=>'ecommerce',
	      'fraudCheck'=>array('authenticationTransactionId'=>'123'),
	      'cardholderAuthentication'=>array('authenticationTransactionId'=>'123'),
	      'card'=>array(
	      'type'=>'VI',
	      'number' =>'4100000000000001',
	      'expDate' =>'1210'),
		  'paypage'=> array(
		  'paypageRegistrationId'=>'1234',
		  'expDate'=>'1210',
		  'cardValidationNum'=>'555',
		  'type'=>'VI'),
	      'token'=> array(
	      'litleToken'=>'1234',
	      'expDate'=>'1210',
	      'cardValidationNum'=>'555',
	      'type'=>'VI'));
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->forceCaptureRequest($hash_in);
	}
}