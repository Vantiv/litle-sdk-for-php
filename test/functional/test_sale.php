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

class sale_FunctionalTest extends UnitTestCase
{
	function test_simple_salewithCard()
	{
		$hash_in = array(
			'card'=>array('type'=>'VI',
					'number'=>'4100000000000001',
					'expDate'=>'1213',
					'cardValidationNum' => '1213'),
			'id'=>'1211',
			'orderId'=> '2111',
			'reportGroup'=>'Planets',
			'orderSource'=>'ecommerce',
			'amount'=>'123');

		$initilaize = &new LitleOnlineRequest();
		$saleResponse = $initilaize->saleRequest($hash_in);
		$response = Xml_parser::get_node($saleResponse,'response');
		$this->assertEqual('000',$response);
	}

	function test_simple_sale_withpaypal()
	{
		$hash_in = array(
				'paypal'=>array("payerId"=>'123',"token"=>'12321312',
 				"transactionId" => '123123'),
				'id'=>'1211',
				'orderId'=> '2111',
				'reportGroup'=>'Planets',
				'orderSource'=>'ecommerce',
				'amount'=>'123');

		$initilaize = &new LitleOnlineRequest();
		$saleResponse = $initilaize->saleRequest($hash_in);
		$response = Xml_parser::get_node($saleResponse,'response');
		$this->assertEqual('000',$response);
	}


	function test_illegal_ordersource()
	{
		$hash_in = array(
							'paypal'=>array("payerId"=>'123',"token"=>'12321312',
			 				"transactionId" => '123123'),
							'id'=>'1211',
							'orderId'=> '2111',
							'reportGroup'=>'Planets',
							'orderSource'=>'notecommerce',
							'amount'=>'123');
		$initilaize = &new LitleOnlineRequest();
		$saleResponse = $initilaize->saleRequest($hash_in);
		$message= Xml_parser::get_attribute($saleResponse,'litleOnlineResponse','message');
		$this->assertPattern('/Error validating xml data against the schema/',$message);
	}

	function test_illegal_card_type()
	{
		$hash_in = array(
				'card'=>array('type'=>'DK',
						'number'=>'4100000000000001',
						'expDate'=>'1213',
						'cardValidationNum' => '1213'),
				'id'=>'1211',
				'orderId'=> '2111',
				'reportGroup'=>'Planets',
				'orderSource'=>'ecommerce',
				'amount'=>'123');

		$initilaize = &new LitleOnlineRequest();
		$saleResponse = $initilaize->saleRequest($hash_in);
		$message= Xml_parser::get_attribute($saleResponse,'litleOnlineResponse','message');
		$this->assertPattern('/Error validating xml data against the schema/',$message);
	}
	function no_reportGroup()
	{
		$hash_in = array(
					'card'=>array('type'=>'VI',
							'number'=>'4100000000000001',
							'expDate'=>'1213',
							'cardValidationNum' => '1213'),
					'id'=>'1211',
					'orderId'=> '2111',
					'reportGroup'=>'Planets',
					'orderSource'=>'ecommerce',
					'amount'=>'123');

		$initilaize = &new LitleOnlineRequest();
		$saleResponse = $initilaize->saleRequest($hash_in);
		$response = Xml_parser::get_node($saleResponse,'response');
		$this->assertEqual('000',$response);
	}

	function test_fields_out_of_order()
	{
		$hash_in = array(
						'paypal'=>array("payerId"=>'123',"token"=>'12321312',
		 				"transactionId" => '123123'),
						'id'=>'1211',
						'orderId'=> '2111',
						'reportGroup'=>'Planets',
						'orderSource'=>'ecommerce',
						'amount'=>'123');

		$initilaize = &new LitleOnlineRequest();
		$saleResponse = $initilaize->saleRequest($hash_in);
		$response = Xml_parser::get_node($saleResponse,'response');
		$this->assertEqual('000',$response);
	}

	function test_invalidField()
	{
		$hash_in = array(
							'paypal'=>array("payerId"=>'123',"token"=>'12321312',
			 				"transactionId" => '123123'),
							'id'=>'1211',
							'orderId'=> '2111',
							'nonexistant'=>'novalue',
							'reportGroup'=>'Planets',
							'orderSource'=>'ecommerce',
							'amount'=>'123');

		$initilaize = &new LitleOnlineRequest();
		$saleResponse = $initilaize->saleRequest($hash_in);
		$message = Xml_parser::get_node($saleResponse,'message');
		$this->assertEqual('Approved',$message);
	}

	function test_illegal_embeddedFields()
	{
		$hash_in =array(
      'litleTxnId'=>'123456',
      'orderId'=>'12344',
      'amount'=>'106',
      'orderSource'=>'ecommerce',
      'fraudCheck'=>'one',
      'cardholderAuthentication'=>'two',
      'card'=>array(
      'type'=>'VI',
      'number' =>'4100000000000002'));
		$initilaize = &new LitleOnlineRequest();
		$saleResponse = $initilaize->saleRequest($hash_in);
		$message= Xml_parser::get_attribute($saleResponse,'litleOnlineResponse','message');
		$this->assertPattern('/Error validating xml data against the schema/',$message);
	}
}
?>