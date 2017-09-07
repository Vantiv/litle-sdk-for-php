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
namespace litle\sdk\Test\functional;

use litle\sdk\LitleOnlineRequest;
use litle\sdk\XmlParser;

class EcheckCreditFunctionalTest extends \PHPUnit_Framework_TestCase
{
    public function test_simple_echeckCredit()
    {
        $hash_in = array('id' => 'id',
            'litleTxnId' => '123456789012345678',
            'amount' => '1000');

        $initialize = new LitleOnlineRequest();
        $echeckCreditResponse = $initialize->echeckCreditRequest($hash_in);
        $response = XmlParser::getNode($echeckCreditResponse, 'response');
        $this->assertEquals('000', $response);
    }

    public function test_no_amount()
    {
        $hash_in = array('id' => 'id');
        $initialize = new LitleOnlineRequest();
        $echeckCreditResponse = $initialize->echeckCreditRequest($hash_in);
        $message = XmlParser::getAttribute($echeckCreditResponse, 'litleOnlineResponse', 'message');
        $this->assertRegExp('/Error validating xml data against the schema/', $message);
    }

    public function test_echeckCredit_with_echeck()
    {
        $hash_in = array('id' => 'id',
            'amount' => '123456',
            'verify' => 'true',
            'orderId' => '12345',
            'orderSource' => 'ecommerce',
            'echeck' => array('accType' => 'Checking', 'accNum' => '12345657890', 'routingNum' => '123456789', 'checkNum' => '123455'),
            'billToAddress' => array('name' => 'Bob', 'city' => 'lowell', 'state' => 'MA', 'email' => 'litle.com'));

        $initialize = new LitleOnlineRequest();
        $echeckCreditResponse = $initialize->echeckCreditRequest($hash_in);
        $response = XmlParser::getNode($echeckCreditResponse, 'response');
        $this->assertEquals('000', $response);
    }

    public function test_echeckCredit_with_echeckToken()
    {
        $hash_in = array('id' => 'id',
            'amount' => '123456',
            'verify' => 'true',
            'orderId' => '12345',
            'orderSource' => 'ecommerce',
            'echeckToken' => array('accType' => 'Checking', 'litleToken' => '1234565789012', 'routingNum' => '123456789', 'checkNum' => '123455'),
            'billToAddress' => array('name' => 'Bob', 'city' => 'lowell', 'state' => 'MA', 'email' => 'litle.com'));

        $initialize = new LitleOnlineRequest();
        $echeckCreditResponse = $initialize->echeckCreditRequest($hash_in);
        $response = XmlParser::getNode($echeckCreditResponse, 'response');
        $this->assertEquals('000', $response);
    }

    public function test_echeckCredit_missing_billing()
    {
        $hash_in = array('id' => 'id',
            'amount' => '123456',
            'verify' => 'true',
            'orderId' => '12345',
            'orderSource' => 'ecommerce',
            'echeckToken' => array('accType' => 'Checking', 'litleToken' => '1234565789012', 'routingNum' => '123456789', 'checkNum' => '123455'));

        $initialize = new LitleOnlineRequest();
        $echeckCreditResponse = $initialize->echeckCreditRequest($hash_in);
        $message = XmlParser::getAttribute($echeckCreditResponse, 'litleOnlineResponse', 'message');
        $this->assertRegExp('/Error validating xml data against the schema/', $message);
    }

    public function test_simple_echeckCredit_secondaryAmount()
    {
        $hash_in = array('amount' => '5000', 'id' => 'id',
            'secondaryAmount' => '2000',
            'verify' => 'true',
            'orderId' => '12345',
            'orderSource' => 'ecommerce',
            'echeck' => array('accType' => 'Checking', 'accNum' => '12345657890', 'routingNum' => '123456789', 'checkNum' => '123455'),
            'billToAddress' => array('name' => 'Bob', 'city' => 'lowell', 'state' => 'MA', 'email' => 'litle.com'));

        $initialize = new LitleOnlineRequest();
        $echeckCreditResponse = $initialize->echeckCreditRequest($hash_in);
        $response = XmlParser::getNode($echeckCreditResponse, 'response');
        $this->assertEquals('000', $response);
    }

    public function test_simple_echeckCredit_With_SecondaryAmount()
    {
        $hash_in = array('id' => 'id',
            'litleTxnId' => '123456789012345678',
            'secondaryAmount' => '100',
            'amount' => '1000');

        $initialize = new LitleOnlineRequest();
        $echeckCreditResponse = $initialize->echeckCreditRequest($hash_in);
        $response = XmlParser::getNode($echeckCreditResponse, 'response');
        $this->assertEquals('000', $response);
    }


}
