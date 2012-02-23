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
require_once realpath(dirname(__FILE__)) . '/../../lib/LitleOnline.php';

class cert1_Test extends UnitTestCase
{
	function test_1_Auth()
	{
		$auth_hash = array(
	      'orderId' => '1',
	      'amount' => '10010',
	      'orderSource'=>'ecommerce',
	      'billToAddress'=>array(
	      'name' => 'John Smith',
	      'addressLine1' => '1 Main St.',
	      'city' => 'Burlington',
	      'state' => 'MA',
	      'zip' => '01803-3747',
	      'country' => 'US'),
	      'card'=>array(
	      'number' =>'4457010000000009',
	      'expDate' => '0112',
	      'cardValidationNum' => '349',
	      'type' => 'VI'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('000',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('11111 ',Xml_parser::get_node($authorizationResponse,'authCode'));
		$this->assertEqual('1',Xml_parser::get_node($authorizationResponse,'avsResult'));
		$this->assertEqual('M',Xml_parser::get_node($authorizationResponse,'cardValidationResult'));

		//test 1A
		$capture_hash =  array(
		'litleTxnId' =>(Xml_parser::get_node($authorizationResponse,'litleTxnId')),
		'reportGroup'=>'planets');
		$initilaize = &new LitleOnlineRequest();
		$captureResponse = $initilaize->captureRequest($capture_hash);
		$this->assertEqual('000',Xml_parser::get_node($captureResponse,'response'));
		$this->assertEqual('Approved',Xml_parser::get_node($captureResponse,'message'));

		//test 1B
		$credit_hash =  array(
		'litleTxnId' =>(Xml_parser::get_node($captureResponse,'litleTxnId')),
		'reportGroup'=>'planets');
		$initilaize = &new LitleOnlineRequest();
		$creditResponse = $initilaize->creditRequest($credit_hash);
		$this->assertEqual('000',Xml_parser::get_node($creditResponse,'response'));
		$this->assertEqual('Approved',Xml_parser::get_node($creditResponse,'message'));

		//test 1C
		$void_hash =  array(
		'litleTxnId' =>(Xml_parser::get_node($creditResponse,'litleTxnId')),
		'reportGroup'=>'planets');
		$initilaize = &new LitleOnlineRequest();
		$voidResponse = $initilaize->voidRequest($void_hash);
		$this->assertEqual('000',Xml_parser::get_node($voidResponse,'response'));
		$this->assertEqual('Approved',Xml_parser::get_node($voidResponse,'message'));
	}

	function test_1_avs()
	{
		$auth_hash = array(
			      'orderId' => '1',
			      'amount' => '10010',
			      'orderSource'=>'ecommerce',
			      'billToAddress'=>array(
			      'name' => 'John Smith',
			      'addressLine1' => '1 Main St.',
			      'city' => 'Burlington',
			      'state' => 'MA',
			      'zip' => '01803-3747',
			      'country' => 'US'),
			      'card'=>array(
			      'number' =>'4457010000000009',
			      'expDate' => '0112',
			      'cardValidationNum' => '349',
			      'type' => 'VI'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('000',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('11111 ',Xml_parser::get_node($authorizationResponse,'authCode'));
		$this->assertEqual('1',Xml_parser::get_node($authorizationResponse,'avsResult'));
		$this->assertEqual('M',Xml_parser::get_node($authorizationResponse,'cardValidationResult'));
	}
// 	function test_1_sale()
// 	{
// 		$sale_hash = array(
// 		      'orderId' => '1',
// 		      'amount' => '10010',
// 		      'orderSource'=>'ecommerce',
// 		      'billToAddress'=>array(
// 		      'name' => 'John Smith',
// 		      'addressLine1' => '1 Main St.',
// 		      'city' => 'Burlington',
// 		      'state' => 'MA',
// 		      'zip' => '01803-3747',
// 		      'country' => 'US'),
// 		      'card'=>array(
// 		      'number' =>'4457010000000009',
// 		      'expDate' => '0112',
// 		      'cardValidationNum' => '349',
// 		      'type' => 'VI'));
// 		$initilaize = &new LitleOnlineRequest();
// 		$saleResponse = $initilaize->saleRequest($auth_hash);
// 		$this->assertEqual('000',Xml_parser::get_node($authorizationResponse,'response'));
// 		$this->assertEqual('Approved',Xml_parser::get_node($authorizationResponse,'message'));
// 		$this->assertEqual('11111 ',Xml_parser::get_node($authorizationResponse,'authCode'));
// 		$this->assertEqual('1',Xml_parser::get_node($authorizationResponse,'avsResult'));
// 		$this->assertEqual('M',Xml_parser::get_node($authorizationResponse,'cardValidationResult'));
	
// 		$credit_hash =  array(
// 			'litleTxnId' =>(Xml_parser::get_node($captureResponse,'litleTxnId')),
// 			'reportGroup'=>'planets');
// 		$initilaize = &new LitleOnlineRequest();
// 		$creditResponse = $initilaize->creditRequest($credit_hash);
// 		$this->assertEqual('000',Xml_parser::get_node($creditResponse,'response'));
// 		$this->assertEqual('Approved',Xml_parser::get_node($creditResponse,'message'));
	
// 		$void_hash =  array(
// 			'litleTxnId' =>(Xml_parser::get_node($captureResponse,'litleTxnId')),
// 			'reportGroup'=>'planets');
// 		$initilaize = &new LitleOnlineRequest();
// 		$voidResponse = $initilaize->voidRequest($void_hash);
// 		$this->assertEqual('000',Xml_parser::get_node($voidResponse,'response'));
// 		$this->assertEqual('Approved',Xml_parser::get_node($voidResponse,'message'));
// 	}
	
}
?>