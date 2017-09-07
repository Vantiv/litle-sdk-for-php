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

class ForceCaptureFunctionalTest extends \PHPUnit_Framework_TestCase
{
    public function test_simple_forceCapture_with_card()
    {
        $hash_in = array('id' => 'id',
            'merchantId' => '101',
            'version' => '8.8',
            'reportGroup' => 'Planets',
            'litleTxnId' => '123456',
            'orderId' => '12344',
            'amount' => '106',
            'orderSource' => 'ecommerce',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1210'
            ));

        $initialize = new LitleOnlineRequest();
        $forceCaptureResponse = $initialize->forceCaptureRequest($hash_in);
        $response = XmlParser::getAttribute($forceCaptureResponse, 'litleOnlineResponse', 'response');
        $this->assertEquals('000', $response);
    }

    public function test_simple_forceCapture_with_token()
    {
        $hash_in = array('id' => 'id',
            'merchantId' => '101',
            'version' => '8.8',
            'reportGroup' => 'Planets',
            'litleTxnId' => '123456',
            'orderId' => '12344',
            'amount' => '106',
            'orderSource' => 'ecommerce',
            'token' => array(
                'litleToken' => '123456789101112',
                'expDate' => '1210',
                'cardValidationNum' => '555',
                'type' => 'VI'
            ));

        $initialize = new LitleOnlineRequest();
        $forceCaptureResponse = $initialize->forceCaptureRequest($hash_in);
        $message = XmlParser::getAttribute($forceCaptureResponse, 'litleOnlineResponse', 'message');
        $this->assertEquals('Valid Format', $message);
    }


    public function test_simple_forceCapture_with_secondary_amount()
    {
        $hash_in = array('id' => 'id',
            'merchantId' => '101',
            'version' => '8.8',
            'reportGroup' => 'Planets',
            'litleTxnId' => '123456',
            'orderId' => '12344',
            'amount' => '106',
            'secondaryAmount' => '2000',
            'orderSource' => 'ecommerce',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1210'
            ));

        $initialize = new LitleOnlineRequest();
        $forceCaptureResponse = $initialize->forceCaptureRequest($hash_in);
        $response = XmlParser::getAttribute($forceCaptureResponse, 'litleOnlineResponse', 'response');
        $this->assertEquals('000', $response);
    }

    public function test_simple_forceCapture_with_processingType()
    {
        $hash_in = array('id' => 'id',
            'merchantId' => '101',
            'version' => '8.8',
            'reportGroup' => 'Planets',
            'litleTxnId' => '123456',
            'orderId' => '12344',
            'amount' => '106',
            'secondaryAmount' => '2000',
            'orderSource' => 'ecommerce',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1210'
            ),
            'processingType' => 'initialRecurring'
        );

        $initialize = new LitleOnlineRequest();
        $forceCaptureResponse = $initialize->forceCaptureRequest($hash_in);
        $response = XmlParser::getAttribute($forceCaptureResponse, 'litleOnlineResponse', 'response');
        $this->assertEquals('000', $response);
    }
}
