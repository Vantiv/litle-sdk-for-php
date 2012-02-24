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

class cert2_Test extends UnitTestCase
{
	function test_14()
	{
		$auth_hash = array(
		      'orderId' => '14',
	      'amount' => '3000',
	      'orderSource'=>'ecommerce',
	      'card'=>array(
	      'number' =>'4457010200000247',
	      'expDate' => '0812',
	      'type' => 'VI'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('000',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('PREPAID',Xml_parser::get_node($authorizationResponse,'type'));
		$this->assertEqual('2000',Xml_parser::get_node($authorizationResponse,'availableBalance'));
		$this->assertEqual('NO',Xml_parser::get_node($authorizationResponse,'reloadable'));
		$this->assertEqual('GIFT',Xml_parser::get_node($authorizationResponse,'prepaidCardType'));

	}

	function test_15()
	{
		$auth_hash = array(
				     'orderId' => '15',
				      'amount' => '3000',
				      'orderSource'=>'ecommerce',
				      'card'=>array(
				      'number' =>'5500000254444445',
				      'expDate' => '0312',
				      'type' => 'MC'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('000',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('PREPAID',Xml_parser::get_node($authorizationResponse,'type'));
		$this->assertEqual('2000',Xml_parser::get_node($authorizationResponse,'availableBalance'));
		$this->assertEqual('YES',Xml_parser::get_node($authorizationResponse,'reloadable'));
		$this->assertEqual('PAYROLL',Xml_parser::get_node($authorizationResponse,'prepaidCardType'));

	}

	function test_16()
	{
		$auth_hash = array(
					     'orderId' => '16',
					      'amount' => '3000',
					      'orderSource'=>'ecommerce',
					      'card'=>array(
					      'number' =>'5592106621450897',
					      'expDate' => '0312',
					      'type' => 'MC'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('000',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('PREPAID',Xml_parser::get_node($authorizationResponse,'type'));
		$this->assertEqual('0',Xml_parser::get_node($authorizationResponse,'availableBalance'));
		$this->assertEqual('YES',Xml_parser::get_node($authorizationResponse,'reloadable'));
		$this->assertEqual('PAYROLL',Xml_parser::get_node($authorizationResponse,'prepaidCardType'));

	}

	function test_17()
	{
		$auth_hash = array(
					     'orderId' => '17',
					      'amount' => '3000',
					      'orderSource'=>'ecommerce',
					      'card'=>array(
					      'number' =>'5590409551104142',
					      'expDate' => '0312',
					      'type' => 'MC'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('000',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('PREPAID',Xml_parser::get_node($authorizationResponse,'type'));
		$this->assertEqual('6500',Xml_parser::get_node($authorizationResponse,'availableBalance'));
		$this->assertEqual('YES',Xml_parser::get_node($authorizationResponse,'reloadable'));
		$this->assertEqual('PAYROLL',Xml_parser::get_node($authorizationResponse,'prepaidCardType'));

	}

	function test_18()
	{
		$auth_hash = array(
					     'orderId' => '18',
					      'amount' => '3000',
					      'orderSource'=>'ecommerce',
					      'card'=>array(
					      'number' =>'5587755665222179',
					      'expDate' => '0312',
					      'type' => 'MC'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('000',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('PREPAID',Xml_parser::get_node($authorizationResponse,'type'));
		$this->assertEqual('12200',Xml_parser::get_node($authorizationResponse,'availableBalance'));
		$this->assertEqual('YES',Xml_parser::get_node($authorizationResponse,'reloadable'));
		$this->assertEqual('PAYROLL',Xml_parser::get_node($authorizationResponse,'prepaidCardType'));

	}

	function test_19()
	{
		$auth_hash = array(
					     'orderId' => '19',
					      'amount' => '3000',
					      'orderSource'=>'ecommerce',
					      'card'=>array(
					      'number' =>'5445840176552850',
					      'expDate' => '0312',
					      'type' => 'MC'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('000',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('PREPAID',Xml_parser::get_node($authorizationResponse,'type'));
		$this->assertEqual('20000',Xml_parser::get_node($authorizationResponse,'availableBalance'));
		$this->assertEqual('YES',Xml_parser::get_node($authorizationResponse,'reloadable'));
		$this->assertEqual('PAYROLL',Xml_parser::get_node($authorizationResponse,'prepaidCardType'));

	}

	function test_20()
	{
		$auth_hash = array(
						     'orderId' => '20',
						      'amount' => '3000',
						      'orderSource'=>'ecommerce',
						      'card'=>array(
						      'number' =>'5390016478904678',
						      'expDate' => '0312',
						      'type' => 'MC'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('000',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('PREPAID',Xml_parser::get_node($authorizationResponse,'type'));
		$this->assertEqual('10050',Xml_parser::get_node($authorizationResponse,'availableBalance'));
		$this->assertEqual('YES',Xml_parser::get_node($authorizationResponse,'reloadable'));
		$this->assertEqual('PAYROLL',Xml_parser::get_node($authorizationResponse,'prepaidCardType'));

	}

	function test_21()
	{
		$auth_hash = array(
						     'orderId' => '21',
						      'amount' => '5000',
						      'orderSource'=>'ecommerce',
						      'card'=>array(
						      'number' =>'4457010201000246',
						      'expDate' => '0912',
						      'type' => 'VI'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('000',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('AFFLUENT',Xml_parser::get_node($authorizationResponse,'affluence'));

	}

	function test_22()
	{
		$auth_hash = array(
							     'orderId' => '22',
							      'amount' => '5000',
							      'orderSource'=>'ecommerce',
							      'card'=>array(
							      'number' =>'4457010202000245',
							      'expDate' => '1111',
							      'type' => 'VI'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('000',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('MASS AFFLUENT',Xml_parser::get_node($authorizationResponse,'affluence'));

	}

	function test_23()
	{
		$auth_hash = array(
							     'orderId' => '23',
							      'amount' => '5000',
							      'orderSource'=>'ecommerce',
							      'card'=>array(
							      'number' =>'5112010201000109',
							      'expDate' => '0412',
							      'type' => 'MC'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('000',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('AFFLUENT',Xml_parser::get_node($authorizationResponse,'affluence'));

	}

	function test_24()
	{
		$auth_hash = array(
							     'orderId' => '24',
							      'amount' => '5000',
							      'orderSource'=>'ecommerce',
							      'card'=>array(
							      'number' =>'5112010202000108',
							      'expDate' => '0812',
							      'type' => 'MC'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('000',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('MASS AFFLUENT',Xml_parser::get_node($authorizationResponse,'affluence'));

	}

	function test_25()
	{
		$auth_hash = array(
							     'orderId' => '25',
							      'amount' => '5000',
							      'orderSource'=>'ecommerce',
							      'card'=>array(
							      'number' =>'4100204446270000',
							      'expDate' => '1112',
							      'type' => 'VI'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('000',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('BRA',Xml_parser::get_node($authorizationResponse,'issuerCountry'));

	}


	# test 26-31 healthcare iias
	function test_26()
	{
		$auth_hash = array(
							     'orderId' => '26',
		      'amount' => '18698',
		      'orderSource'=>'ecommerce',
		      'card'=>array(
		      'number' =>'5194560012341234',
		      'expDate' => '1212',
		      'type' => 'MC'),
		      'allowPartialAuth' => 'true',
		      'healthcareIIAS' => array(
		      'healthcareAmounts' => array(
		      'totalHealthcareAmount' =>'20000'
		),
		      'IIASFlag' => 'Y'
		));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('341',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Invalid healthcare amounts',Xml_parser::get_node($authorizationResponse,'message'));

	}

	function test_27()
	{
		$auth_hash = array(
								     'orderId' => '27',
			      'amount' => '18698',
			      'orderSource'=>'ecommerce',
			      'card'=>array(
			      'number' =>'5194560012341234',
			      'expDate' => '1212',
			      'type' => 'MC'),
			      'allowPartialAuth' => 'true',
			      'healthcareIIAS' => array(
			      'healthcareAmounts' => array(
			      'totalHealthcareAmount' =>'15000',
			      'RxAmount' => '16000'),
			      'IIASFlag' => 'Y'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('341',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Invalid healthcare amounts',Xml_parser::get_node($authorizationResponse,'message'));

	}



	function test_28()
	{
		$auth_hash = array(
		'orderId' => '28',
		'amount' => '15000',
				      'orderSource'=>'ecommerce',
				      'card'=>array(
		'number' =>'5194560012341234',
				      'expDate' => '1212',
		'type' => 'MC'),
				      'allowPartialAuth' => 'true',
		'healthcareIIAS' => array(
				      'healthcareAmounts' => array(
		'totalHealthcareAmount' =>'15000',
		'RxAmount' => '3698'),
				      'IIASFlag' => 'Y'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('000',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Approved',Xml_parser::get_node($authorizationResponse,'message'));

	}

	function test_29()
	{
		$auth_hash = array(
			'orderId' => '29',
			'amount' => '18699',
					      'orderSource'=>'ecommerce',
					      'card'=>array(
			'number' =>'4024720001231239',
					      'expDate' => '1212',
			'type' => 'VI'),
					      'allowPartialAuth' => 'true',
			'healthcareIIAS' => array(
					      'healthcareAmounts' => array(
			'totalHealthcareAmount' =>'31000',
			'RxAmount' => '1000',
			'visionAmount' => '19901',
		      'clinicOtherAmount' => '9050',
		      'dentalAmount' => '1049'),
					      'IIASFlag' => 'Y'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('341',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Invalid healthcare amounts',Xml_parser::get_node($authorizationResponse,'message'));

	}

	function test_30()
	{
		$auth_hash = array(
			'orderId' => '30',
			'amount' => '20000',
					      'orderSource'=>'ecommerce',
					      'card'=>array(
			'number' =>'4024720001231239',
					      'expDate' => '1212',
			'type' => 'VI'),
					      'allowPartialAuth' => 'true',
			'healthcareIIAS' => array(
					      'healthcareAmounts' => array(
			'totalHealthcareAmount' =>'20000',
			'RxAmount' => '1000',
			'visionAmount' => '19901',
		      'clinicOtherAmount' => '9050',
		      'dentalAmount' => '1049'),
					      'IIASFlag' => 'Y'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('341',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Invalid healthcare amounts',Xml_parser::get_node($authorizationResponse,'message'));

	}

	function test_31()
	{
		$auth_hash = array(
			'orderId' => '31',
			'amount' => '25000',
					      'orderSource'=>'ecommerce',
					      'card'=>array(
			'number' =>'4024720001231239',
					      'expDate' => '1212',
			'type' => 'VI'),
					      'allowPartialAuth' => 'true',
			'healthcareIIAS' => array(
					      'healthcareAmounts' => array(
			'totalHealthcareAmount' =>'18699',
			'RxAmount' => '1000',
			'visionAmount' => '15099'),
					      'IIASFlag' => 'Y'));
		$initilaize = &new LitleOnlineRequest();
		$authorizationResponse = $initilaize->authorizationRequest($auth_hash);
		$this->assertEqual('010',Xml_parser::get_node($authorizationResponse,'response'));
		$this->assertEqual('Partially Approved',Xml_parser::get_node($authorizationResponse,'message'));
		$this->assertEqual('18699',Xml_parser::get_node($authorizationResponse,'approvedAmount'));
	}





}
?>