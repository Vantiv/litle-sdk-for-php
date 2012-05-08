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

class echeckRedeposit_UnitTest extends PHPUnit_Framework_TestCase
{
	function test_simple_echeckRedeposit()
	{
		$hash_in = array('litleTxnId' =>'123123');
		$mock = $this->getMock('LitleXmlMapper');
		$mock->expects($this->once())
		->method('request')
		->with($this->matchesRegularExpression('/.*<litleTxnId>123123.*/'));
		
		$litleTest = new LitleOnlineRequest();
		$litleTest->newXML = $mock;
		$litleTest->echeckRedepositRequest($hash_in);
	}

	function test_no_litleTxnId()
	{
		$hash_in = array('reportGroup'=>'Planets');
		$litleTest = new LitleOnlineRequest();
		$this->setExpectedException('InvalidArgumentException',"Missing Required Field: /litleTxnId/");
		$retOb = $litleTest->echeckRedepositRequest($hash_in);
	}
	
	function test_no_routingNum_echeck()
	{
		$hash_in = array('reportGroup'=>'Planets','litleTxnId'=>'123456',
     	'echeck' => array('accType'=>'Checking','accNum'=>'12345657890','checkNum'=>'123455'));
		$litleTest = new LitleOnlineRequest();
		$this->setExpectedException('InvalidArgumentException',"Missing Required Field: /routingNum/");
		$retOb = $litleTest->echeckRedepositRequest($hash_in);
	}
	
	function test_no_routingNum_echeckToken()
	{
		$hash_in = array('reportGroup'=>'Planets','litleTxnId'=>'123456',
	    'echeckToken' => array('accType'=>'Checking','litleToken'=>'1234565789012','checkNum'=>'123455'));
		$litleTest = new LitleOnlineRequest();
		$this->setExpectedException('InvalidArgumentException',"Missing Required Field: /routingNum/");
		$retOb = $litleTest->echeckRedepositRequest($hash_in);
	}
	
	function test_both_choices()
	{
		$hash_in = array('reportGroup'=>'Planets','litleTxnId'=>'123456',
		'echeckToken' => array('accType'=>'Checking','routingNum'=>'123123','litleToken'=>'1234565789012','checkNum'=>'123455'),
		'echeck' => array('accType'=>'Checking','routingNum'=>'123123','accNum'=>'12345657890','checkNum'=>'123455'));
		$litleTest = new LitleOnlineRequest();
		$this->setExpectedException('InvalidArgumentException',"Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!");
		$retOb = $litleTest->echeckRedepositRequest($hash_in);
	}
	
}