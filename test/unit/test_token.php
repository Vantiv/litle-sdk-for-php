<?php
// =begin
// Copyright (c) 2011 Litle & Co.

// Permission is hereby granted, free of charge, to any person
// obtaining a copy of this software and associated documentation
// files (the "Software"), to deal in the Software without
// restriction, including without limitation the rights to use,
// copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the
// Software is furnished to do so, subject to the following
// conditions:

// The above copyright notice and this permission notice shall be
// included in all copies or substantial portions of the Software.

// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
// EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
// OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
// NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
// HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
// WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
// FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
// OTHER DEALINGS IN THE SOFTWARE.
// =end

require_once("../../simpletest/autorun.php");
require_once('../../simpletest/unit_tester.php');
require_once('../../simpletest/mock_objects.php');
require_once realpath(dirname(__FILE__)) . '/../../lib/LitleOnline.php';
Mock::generate('communication');
Mock::generate('LitleXmlMapper');
class token_UnitTest extends UnitTestCase
{
// 	function test_token_with_card()
// 	{
// 		$hash_in = array('usr'=>'IMPTEST',
// 			'password'=>'cert3d6Z',
// 			'merchantId'=>'087900',
// 			'version'=>'8.8',
// 			'card'=>array('type'=>'VI',
// 					'number'=>'4100000000000001',
// 					'expDate'=>'1213',
// 					'cardValidationNum' => '1213'),
// 			'id'=>'1211',
// 			'orderId'=> '2111',
// 			'reportGroup'=>'Planets',
// 			'orderSource'=>'ecommerce',
// 			'amount'=>'123');
// 		$mappTest = &new MockLitleXmlMapper();
// 		$commTest = &new Mockcommunication();
// 		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<card><type>VI.*<number>4100000000000001.*<expDate>1213.*<cardValidationNum>1213.*/')));
// 		$litleTest = &new LitleOnlineRequest();
// 		$litleTest->newXML = $mappTest;
// 		$retOb = $litleTest->registerTokenRequest($hash_in);
// 	}

	function test_token()
	{
		$hash_in = array(
			'reportGroup'=>'Planets',
			'orderId'=>'1',
			'accountNumber'=>'123456789101112');;
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<accountNumber>123456789101112*/')));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->registerTokenRequest($hash_in);
	}


	function test_accountNumandPaypage()
	{
		$hash_in = array('merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'accountNumber'=>'1233456789101112',
      'paypageRegistrationId'=>'1233456789101112');
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->registerTokenRequest($hash_in);

	}

	function test_echeckandPaypagel()
	{
		$hash_in = array('merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'echeckForToken'=>array('accNum'=>'12344565','routingNum'=>'123476545'),
      'paypageRegistrationId'=>'1233456789101112');
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->registerTokenRequest($hash_in);

	}

	function test_echeckandPaypageandaccountnum()
	{
		$hash_in = array('merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'accountNumber'=>'1233456789101112',
      'echeckForToken'=>array('accNum'=>'12344565','routingNum'=>'123476545'),
      'paypageRegistrationId'=>'1233456789101112');
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!"));
		$retOb = $litleTest->registerTokenRequest($hash_in);

	}




}
?>