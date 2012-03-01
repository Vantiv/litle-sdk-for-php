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

class cert5_Test extends UnitTestCase
{
	#### test token transactions with merchantid 087902 username IMPTKN, password cert3d6Z#####
	function test_50()
	{
		$token_hash = array(
		'orderId' => '50',
	      'accountNumber' => '4457119922390123');

		$initilaize = &new LitleOnlineRequest();
		$registerTokenResponse = $initilaize->registerTokenRequest($token_hash);
		$this->assertEqual('445711',XMLParser::getNode($registerTokenResponse,'bin'));
		$this->assertEqual('VI',XMLParser::getNode($registerTokenResponse,'type'));
		$this->assertEqual('801',XMLParser::getNode($registerTokenResponse,'response'));
		$this->assertEqual('1111222233330123',XMLParser::getNode($registerTokenResponse,'litleToken'));
		$this->assertEqual('Account number was successfully registered',XMLParser::getNode($registerTokenResponse,'message'));
	}
	
	function test_51()
	{
		$token_hash = array(
			'orderId' => '51',
		      'accountNumber' => '4457119999999999');
	
		$initilaize = &new LitleOnlineRequest();
		$registerTokenResponse = $initilaize->registerTokenRequest($token_hash);
		$this->assertEqual('820',XMLParser::getNode($registerTokenResponse,'response'));
		$this->assertEqual('Credit card number was invalid',XMLParser::getNode($registerTokenResponse,'message'));
	}
	
	function test_52()
	{
		$token_hash = array(
			'orderId' => '52',
		      'accountNumber' => '4457119922390123');
	
		$initilaize = &new LitleOnlineRequest();
		$registerTokenResponse = $initilaize->registerTokenRequest($token_hash);
		$this->assertEqual('445711',XMLParser::getNode($registerTokenResponse,'bin'));
		$this->assertEqual('VI',XMLParser::getNode($registerTokenResponse,'type'));
		$this->assertEqual('802',XMLParser::getNode($registerTokenResponse,'response'));
		$this->assertEqual('1111222233330123',XMLParser::getNode($registerTokenResponse,'litleToken'));
		$this->assertEqual('Account number was previously registered',XMLParser::getNode($registerTokenResponse,'message'));
	}
	
	function test_53() #merchant is not authorized for echeck tokens
	{
		$token_hash = array(
				'orderId' => '53',
			      'echeckForToken'=>array('accNum'=>'1099999998','routingNum'=>'114567895'));
	
		$initilaize = &new LitleOnlineRequest();
		$registerTokenResponse = $initilaize->registerTokenRequest($token_hash);
		$this->assertEqual('EC',XMLParser::getNode($registerTokenResponse,'type'));
		$this->assertEqual('998',XMLParser::getNode($registerTokenResponse,'eCheckAccountSuffix'));
		$this->assertEqual('801',XMLParser::getNode($registerTokenResponse,'response'));
		$this->assertEqual('111922223333000998',XMLParser::getNode($registerTokenResponse,'litleToken'));
		$this->assertEqual('Account number was successfully registered',XMLParser::getNode($registerTokenResponse,'message'));
	}
	
	function test_54() #merchant is not authorized for echeck tokens
	{
		$token_hash = array(
				'orderId' => '54',
			      'echeckForToken'=>array('accNum'=>'1022222102','routingNum'=>'1145_7895'));
	
		$initilaize = &new LitleOnlineRequest();
		$registerTokenResponse = $initilaize->registerTokenRequest($token_hash);
		$this->assertEqual('900',XMLParser::getNode($registerTokenResponse,'response'));
		$this->assertEqual('Invalid bank routing number',XMLParser::getNode($registerTokenResponse,'message'));
	}
	
	function test_55() 
	{
		$token_hash = array(
					'orderId' => '55',
	      'amount' => '15000',
	      'orderSource' => 'ecommerce',
	      'card' => array('number' => '5435101234510196', 'expDate' => '1112', 'cardValidationNum' => '987', 'type' => 'MC'));
	
		$initilaize = &new LitleOnlineRequest();
		$registerTokenResponse = $initilaize->authorizationRequest($token_hash);
		$this->assertEqual('MC',XMLParser::getNode($registerTokenResponse,'type'));
		$this->assertEqual('801',XMLParser::getNode($registerTokenResponse,'tokenResponseCode'));
		$this->assertEqual('000',XMLParser::getNode($registerTokenResponse,'response'));
		$this->assertEqual('Account number was successfully registered',XMLParser::getNode($registerTokenResponse,'tokenMessage'));
		$this->assertEqual('Approved',XMLParser::getNode($registerTokenResponse,'message'));
		$this->assertEqual('543510',XMLParser::getNode($registerTokenResponse,'bin'));
	}
	
	function test_56() 
	{
		$token_hash = array(
					'orderId' => '56',
      'amount' => '15000',
      'orderSource' => 'ecommerce',
      'card' => array('number' => '5435109999999999', 'expDate' => '1112', 'cardValidationNum' => '987', 'type' => 'MC'));
	
		$initilaize = &new LitleOnlineRequest();
		$registerTokenResponse = $initilaize->authorizationRequest($token_hash);
		$this->assertEqual('301',XMLParser::getNode($registerTokenResponse,'response'));
		$this->assertEqual('Invalid account number',XMLParser::getNode($registerTokenResponse,'message'));
	}
	
	function test_57()
	{
		$token_hash = array(
						'orderId' => '57',
	      'amount' => '15000',
	      'orderSource' => 'ecommerce',
	      'card' => array('number' => '5435101234510196', 'expDate' => '1112', 'cardValidationNum' => '987', 'type' => 'MC'));
	
		$initilaize = &new LitleOnlineRequest();
		$registerTokenResponse = $initilaize->authorizationRequest($token_hash);
		$this->assertEqual('MC',XMLParser::getNode($registerTokenResponse,'type'));
		$this->assertEqual('802',XMLParser::getNode($registerTokenResponse,'tokenResponseCode'));
		$this->assertEqual('000',XMLParser::getNode($registerTokenResponse,'response'));
		$this->assertEqual('Account number was previously registered',XMLParser::getNode($registerTokenResponse,'tokenMessage'));
		$this->assertEqual('Approved',XMLParser::getNode($registerTokenResponse,'message'));
		$this->assertEqual('543510',XMLParser::getNode($registerTokenResponse,'bin'));
	}
	
	function test_59()
	{
		$token_hash = array(
						'orderId' => '59',
	      'amount' => '15000',
	      'orderSource' => 'ecommerce',
	      'token' => array('litleToken' => '1712990000040196', 'expDate' => '1112'));
	
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($token_hash);
		$this->assertEqual('822',XMLParser::getNode($authorizationResponse,'response'));
		$this->assertEqual('Token was not found',XMLParser::getNode($authorizationResponse,'message'));
	}
	
	function test_60()
	{
		$token_hash = array(
							'orderId' => '60',
		      'amount' => '15000',
		      'orderSource' => 'ecommerce',
		      'token' => array('litleToken' => '1712999999999999', 'expDate' => '1112'));
	
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($token_hash);
		$this->assertEqual('823',XMLParser::getNode($authorizationResponse,'response'));
		$this->assertEqual('Token was invalid',XMLParser::getNode($authorizationResponse,'message'));
	}
	
	# test 61-64 need echecksale to support token. merchantid not authoried.
		function test_61()
		{
			$token_hash = array(
					'orderId' => '61',
	      'amount' => '15000',
	      'orderSource' => 'ecommerce',
	      'billToAddress'=>array(
	      'firstName' => 'Tom',
	      'lastName' => 'Black'),
	      'echeck' => array('accType' => 'Checking', 'accNum' => '1099999003', 'routingNum' => '114567895'));
	
			$initilaize = &new LitleOnlineRequest();
			$registerTokenResponse = $initilaize->echeckSaleRequest($token_hash);
			$this->assertEqual('801',XMLParser::getNode($registerTokenResponse,'tokenResponseCode'));
			$this->assertEqual('Account number was successfully registered',XMLParser::getNode($registerTokenResponse,'tokenMessage'));
			$this->assertEqual('EC',XMLParser::getNode($registerTokenResponse,'type'));
			$this->assertEqual('003',XMLParser::getNode($registerTokenResponse,'eCheckAccountSuffix'));
			$this->assertEqual('111922223333444003',XMLParser::getNode($registerTokenResponse,'litleToken'));
		}
		
		function test_62()
		{
			$token_hash = array(
							'orderId' => '62',
			      'amount' => '15000',
			      'orderSource' => 'ecommerce',
			      'billToAddress'=>array(
			      'firstName' => 'Tom',
			      'lastName' => 'Black'),
			      'echeck' => array('accType' => 'Checking', 'accNum' => '1099999999', 'routingNum' => '114567895'));
		
			$initilaize = &new LitleOnlineRequest();
			$registerTokenResponse = $initilaize->echeckSaleRequest($token_hash);
			$this->assertEqual('801',XMLParser::getNode($registerTokenResponse,'tokenResponseCode'));
			$this->assertEqual('Account number was successfully registered',XMLParser::getNode($registerTokenResponse,'tokenMessage'));
			$this->assertEqual('EC',XMLParser::getNode($registerTokenResponse,'type'));
			$this->assertEqual('999',XMLParser::getNode($registerTokenResponse,'eCheckAccountSuffix'));
			$this->assertEqual('111922223333444999',XMLParser::getNode($registerTokenResponse,'litleToken'));
		}
		
		
		function test_63()
		{
		$token_hash = array(
		'orderId' => '63',
					      'amount' => '15000',
					      'orderSource' => 'ecommerce',
					      'billToAddress'=>array(
		'firstName' => 'Tom',
					      'lastName' => 'Black'),
					      'echeck' => array('accType' => 'Checking', 'accNum' => '1099999999', 'routingNum' => '214567892'));
				
		$initilaize = &new LitleOnlineRequest();
		$registerTokenResponse = $initilaize->echeckSaleRequest($token_hash);
		$this->assertEqual('801',XMLParser::getNode($registerTokenResponse,'tokenResponseCode'));
		$this->assertEqual('Account number was successfully registered',XMLParser::getNode($registerTokenResponse,'tokenMessage'));
		$this->assertEqual('EC',XMLParser::getNode($registerTokenResponse,'type'));
		$this->assertEqual('999',XMLParser::getNode($registerTokenResponse,'eCheckAccountSuffix'));
		$this->assertEqual('111922223333555999',XMLParser::getNode($registerTokenResponse,'litleToken'));
		}
		
	
}