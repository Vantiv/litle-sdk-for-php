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

class cert1_Test_beta extends UnitTestCase
{
	function test_6_Auth()
	{
		$auth_hash = array(
			'orderId' => '6',
	        'amount' => '60060',
	        'orderSource'=>'ecommerce',
	        'billToAddress'=>array(
	        'name' => 'Joe Green',
	        'addressLine1' => '6 Main St.',
	        'city' => 'Derry',
	        'state' => 'NH',
	        'zip' => '03038',
	        'country' => 'US'),
	        'card'=>array(
	        'number' =>'4457010100000008',
	        'expDate' => '0612',
	        'type' => 'VI',
	        'cardValidationNum' => '992'));

		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('110',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Insufficient Funds',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('34',Xml_parser::get_node($authorizationResponse,'avsResult'));
		$this->assertEqual('P',Xml_parser::get_node($authorizationResponse,'cardValidationResult'));
	}

	function test_6_sale()
	{
		$sale_hash = array(
			'orderId' => '6',
			'amount' => '60060',
		    'orderSource'=>'ecommerce',
		    'billToAddress'=>array(
			'name' => 'Joe Green',
			'addressLine1' => '6 Main St.',
		    'city' => 'Derry',
			'state' => 'NH',
		    'zip' => '03038',
		    'country' => 'US'),
			'card'=>array(
		    'number' =>'4457010100000008',
			'expDate' => '0612',
		    'type' => 'VI',
			'cardValidationNum' => '992'));

		$initilaize = &new LitleOnlineRequest();
		$saleResponse = $initilaize->saleRequest($sale_hash);
		$this->assertEqual('110',Xml_parser::get_node($saleResponse,'response'));
		$this->assertEqual('Insufficient Funds',Xml_parser::get_node($saleResponse,'message'));
		$this->assertEqual('34',Xml_parser::get_node($saleResponse,'avsResult'));
		$this->assertEqual('P',Xml_parser::get_node($saleResponse,'cardValidationResult'));

		$void_hash =  array(
						'litleTxnId' =>(Xml_parser::get_node($saleResponse,'litleTxnId')),
						'reportGroup'=>'planets');
		$initilaize = &new LitleOnlineRequest();
		$voidResponse = $initilaize->voidRequest($void_hash);
		$this->assertEqual('360',Xml_parser::get_node($voidResponse,'response'));
		$this->assertEqual('No transaction found with specified litleTxnId',Xml_parser::get_node($voidResponse,'message'));
	}

	function test_7_Auth()
	{
		$auth_hash = array(
			'orderId' => '7',
	        'amount' => '70070',
	        'orderSource'=>'ecommerce',
	        'billToAddress'=>array(
	        'name' => 'Jane Murray',
	        'addressLine1' => '7 Main St.',
	        'city' => 'Amesbury',
	        'state' => 'MA',
	        'zip' => '01913',
	        'country' => 'US'),
	        'card'=> array(
	        'number' =>'5112010100000002',
	        'expDate' => '0712',
	        'cardValidationNum' => '251',
	        'type' => 'MC'));

		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('301',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Invalid Account Number',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('34',Xml_parser::get_node($authorizationResponse,'avsResult'));
		$this->assertEqual('N',Xml_parser::get_node($authorizationResponse,'cardValidationResult'));
	}

	function test_7_avs()
	{
		$auth_hash = array(
					'orderId' => '7',
			        'amount' => '70070',
			        'orderSource'=>'ecommerce',
			        'billToAddress'=>array(
			        'name' => 'Jane Murray',
			        'addressLine1' => '7 Main St.',
			        'city' => 'Amesbury',
			        'state' => 'MA',
			        'zip' => '01913',
			        'country' => 'US'),
			        'card'=> array(
			        'number' =>'5112010100000002',
			        'expDate' => '0712',
			        'cardValidationNum' => '251',
			        'type' => 'MC'));

		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('301',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Invalid Account Number',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('34',Xml_parser::get_node($authorizationResponse,'avsResult'));
		$this->assertEqual('N',Xml_parser::get_node($authorizationResponse,'cardValidationResult'));
	}

	function test_7_sale()
	{
		$sale_hash = array(
					'orderId' => '7',
			        'amount' => '70070',
			        'orderSource'=>'ecommerce',
			        'billToAddress'=>array(
			        'name' => 'Jane Murray',
			        'addressLine1' => '7 Main St.',
			        'city' => 'Amesbury',
			        'state' => 'MA',
			        'zip' => '01913',
			        'country' => 'US'),
			        'card'=> array(
			        'number' =>'5112010100000002',
			        'expDate' => '0712',
			        'cardValidationNum' => '251',
			        'type' => 'MC'));

		$initilaize = &new LitleOnlineRequest();
		$saleResponse = $initilaize->authorizationRequest($sale_hash);
		$this->assertEqual('301',Xml_parser::get_node($saleResponse,'response'));
		$this->assertEqual('Invalid Account Number',Xml_parser::get_node($saleResponse,'message'));
		$this->assertEqual('34',Xml_parser::get_node($saleResponse,'avsResult'));
		$this->assertEqual('N',Xml_parser::get_node($saleResponse,'cardValidationResult'));
	}

	function test_8_Auth()
	{
		$auth_hash = array(
		'orderId' => '8',
		'amount' => '80080',
		'orderSource'=>'ecommerce',
		'billToAddress'=> array(
		'name' => 'Mark Johnson',
		'addressLine1' => '8 Main St.',
		'city' => 'Manchester',
		'state' => 'NH',
		'zip' => '03101',
		'country' => 'US'),
		'card'=> array(
		'number' =>'6011010100000002',
		'expDate' => '0812',
		'type' => 'DI',
		'cardValidationNum' => '184'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('123',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Call Discover',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('34',Xml_parser::get_node($authorizationResponse,'avsResult'));
		$this->assertEqual('P',Xml_parser::get_node($authorizationResponse,'cardValidationResult'));
	}
	
	function test_8_avs()
	{
		$auth_hash = array(
			'orderId' => '8',
			'amount' => '80080',
			'orderSource'=>'ecommerce',
			'billToAddress'=> array(
			'name' => 'Mark Johnson',
			'addressLine1' => '8 Main St.',
			'city' => 'Manchester',
			'state' => 'NH',
			'zip' => '03101',
			'country' => 'US'),
			'card'=> array(
			'number' =>'6011010100000002',
			'expDate' => '0812',
			'type' => 'DI',
			'cardValidationNum' => '184'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('123',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Call Discover',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('34',Xml_parser::get_node($authorizationResponse,'avsResult'));
		$this->assertEqual('P',Xml_parser::get_node($authorizationResponse,'cardValidationResult'));
	}
	
	function test_8_sale()
	{
		$sale_hash = array(
			'orderId' => '8',
			'amount' => '80080',
			'orderSource'=>'ecommerce',
			'billToAddress'=> array(
			'name' => 'Mark Johnson',
			'addressLine1' => '8 Main St.',
			'city' => 'Manchester',
			'state' => 'NH',
			'zip' => '03101',
			'country' => 'US'),
			'card'=> array(
			'number' =>'6011010100000002',
			'expDate' => '0812',
			'type' => 'DI',
			'cardValidationNum' => '184'));
		$initilaize = &new LitleOnlineRequest();
		$saleResponse = $initilaize->saleRequest($sale_hash);
		$this->assertEqual('123',Xml_parser::get_node($saleResponse,'response'));
		$this->assertEqual('Call Discover',Xml_parser::get_node($saleResponse,'message'));
		$this->assertEqual('34',Xml_parser::get_node($saleResponse,'avsResult'));
		$this->assertEqual('P',Xml_parser::get_node($saleResponse,'cardValidationResult'));
	}
	
	function test_9_Auth()
	{
		$auth_hash = array(
		'orderId' => '9',
		'amount' => '90090',
		'orderSource'=>'ecommerce',
		'billToAddress'=>array(
		'name' => 'James Miller',
		'addressLine1' => '9 Main St.',
		'city' => 'Boston',
	    'state' => 'MA',
		'zip' => '02134',
		'country' => 'US'),
		'card'=>array(
		'number' =>'375001010000003',
		'expDate' => '0912',
		'cardValidationNum' => '0421',
		'type' => 'AX'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('303',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Pick Up Card',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('34',Xml_parser::get_node($authorizationResponse,'avsResult'));
	}
	
	function test_9_avs()
	{
		$auth_hash = array(
			'orderId' => '9',
			'amount' => '90090',
			'orderSource'=>'ecommerce',
			'billToAddress'=>array(
			'name' => 'James Miller',
			'addressLine1' => '9 Main St.',
			'city' => 'Boston',
		    'state' => 'MA',
			'zip' => '02134',
			'country' => 'US'),
			'card'=>array(
			'number' =>'375001010000003',
			'expDate' => '0912',
			'cardValidationNum' => '0421',
			'type' => 'AX'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('303',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Pick Up Card',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('34',Xml_parser::get_node($authorizationResponse,'avsResult'));
	}
	
	function test_9_sale()
	{
		$sale_hash = array(
				'orderId' => '9',
				'amount' => '90090',
				'orderSource'=>'ecommerce',
				'billToAddress'=>array(
				'name' => 'James Miller',
				'addressLine1' => '9 Main St.',
				'city' => 'Boston',
			    'state' => 'MA',
				'zip' => '02134',
				'country' => 'US'),
				'card'=>array(
				'number' =>'375001010000003',
				'expDate' => '0912',
				'cardValidationNum' => '0421',
				'type' => 'AX'));
		$initilaize = &new LitleOnlineRequest();
		$saleResponse = $initilaize->saleRequest($sale_hash);
		$this->assertEqual('303',Xml_parser::get_node($saleResponse,'response'));
		$this->assertEqual('Pick Up Card',Xml_parser::get_node($saleResponse,'message'));
		$this->assertEqual('34',Xml_parser::get_node($saleResponse,'avsResult'));
	}

	function test_10()
	{
		$auth_hash = array(
		'orderId' => '10',
    	'amount' => '40000',
    	'orderSource'=>'ecommerce',
    	'card'=>array(
    	'number' =>'4457010140000141',
    	'expDate' => '0912',
    	'type' => 'VI'),
    	'allowPartialAuth' => 'true');
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('010',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Partially Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('32000',Xml_parser::get_node($authorizationResponse,'approvedAmount'));
	}
	
	function test_11()
	{
		$auth_hash = array(
			'orderId' => '11',
	    	'amount' => '60000',
	    	'orderSource'=>'ecommerce',
	    	'card'=>array(
	    	'number' =>'5112010140000004',
    			'expDate' => '1111',
    			'type' => 'MC'),
	    	'allowPartialAuth' => 'true');
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('010',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Partially Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('48000',Xml_parser::get_node($authorizationResponse,'approvedAmount'));
	}
	
	function test_12()
	{
		$auth_hash = array(
				'orderId' => '12',
		    	'amount' => '50000',
		    	'orderSource'=>'ecommerce',
		    	'card'=>array(
		    	'number' =>'375001014000009',
    			'expDate' => '0412',
    			'type' => 'AX'),
		    	'allowPartialAuth' => 'true');
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('010',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Partially Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('40000',Xml_parser::get_node($authorizationResponse,'approvedAmount'));
	}
	
	function test_13()
	{
		$auth_hash = array(
		'orderId' => '13',
		'amount' => '15000',
		'orderSource'=>'ecommerce',
		'card'=>array(
		'number' =>'6011010140000004',
        'expDate' => '0812',
        'type' => 'DI'),
		'allowPartialAuth' => 'true');
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('010',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Partially Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('12000',Xml_parser::get_node($authorizationResponse,'approvedAmount'));
	}
}
?>