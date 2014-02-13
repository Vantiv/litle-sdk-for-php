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

class LitleOnlineRequest_UnitTest extends PHPUnit_Framework_TestCase
{
	function test_set_merchant_sdk_integration()
	{
		$hash_in = array(
			'merchantSdk'=>'Magento;8.14.3',
			'orderId'=> '2111',
			'id'=>'654',
			'orderSource'=>'ecommerce',
			'amount'=>'123');
		$mock = $this->getMock('LitleXmlMapper');
		$mock->expects($this->once())
		->method('request')
		->with($this->matchesRegularExpression('/.*merchantSdk="Magento;8.14.3".*/'));

		$litleTest = new LitleOnlineRequest();
		$litleTest->newXML = $mock;
		$litleTest->authorizationRequest($hash_in);
	}

	function test_set_merchant_sdk_default()
	{
		$hash_in = array(
				'orderId'=> '2111',
				'id'=>'654',
				'orderSource'=>'ecommerce',
				'amount'=>'123');
		$mock = $this->getMock('LitleXmlMapper');
		$mock->expects($this->once())
		->method('request')
 		->with($this->matchesRegularExpression('/.*merchantSdk="PHP;8.24.0".*/'));
		
		$litleTest = new LitleOnlineRequest();
		$litleTest->newXML = $mock;
		$litleTest->authorizationRequest($hash_in);
	}

}
