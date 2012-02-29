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

class capture_FunctionalTest extends UnitTestCase
{
	function test_simple_capture()
	{
		$hash_in = array(
			'litleTxnId'=>'1234567891234567891',
			'amount'=>'123');

		$initilaize = &new LitleOnlineRequest();
		$captureResponse = $initilaize->captureRequest($hash_in);
		$message = XMLParser::get_attribute($captureResponse,'litleOnlineResponse','response');
		$this->assertEqual('1',$message);
	}

	function test_complex_capture()
	{
		$hash_in = array(
				'litleTxnId'=>'1234567891234567891',
				'amount'=>'123','enhancedData'=>array(
     		 'customerReference'=>'Litle',
     		 'salesTax'=>'50',
     		 'deliveryType'=>'TBD'),
    		  'payPalOrderComplete'=>'true');

		$initilaize = &new LitleOnlineRequest();
		$captureResponse = $initilaize->captureRequest($hash_in);
		$message = XMLParser::get_attribute($captureResponse,'litleOnlineResponse','response');
		$this->assertEqual('1',$message);
	}

	function test_simple_capture_withPartial()
	{
		$hash_in = array(
			'litleTxnId'=>'1234567891234567891',
			'patial'=>'true',
			'amount'=>'123');

		$initilaize = &new LitleOnlineRequest();
		$captureResponse = $initilaize->captureRequest($hash_in);
		$message = XMLParser::get_attribute($captureResponse,'litleOnlineResponse','response');
		$this->assertEqual('1',$message);
	}
}
