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

class TokenFunctionalTest extends \PHPUnit_Framework_TestCase
{
    public function test_simple_token()
    {
        $hash_in = array('id' => '1211',
            'merchantId' => '101',
            'version' => '8.8',
            'reportGroup' => 'Planets',
            'orderId' => '12344',
            'accountNumber' => '1233456789103801');

        $initialize = new LitleOnlineRequest();
        $registerTokenResponse = $initialize->registerTokenRequest($hash_in);
        $message = XmlParser::getAttribute($registerTokenResponse, 'litleOnlineResponse', 'message');
        $this->assertEquals('Valid Format', $message);
    }

    public function test_simple_token_with_paypage()
    {
        $hash_in = array('id' => '1211',
            'merchantId' => '101',
            'version' => '8.8',
            'reportGroup' => 'Planets',
            'orderId' => '12344',
            'paypageRegistrationId' => '1233456789101112');

        $initialize = new LitleOnlineRequest();
        $registerTokenResponse = $initialize->registerTokenRequest($hash_in);
        $message = XmlParser::getAttribute($registerTokenResponse, 'litleOnlineResponse', 'message');
        $this->assertEquals('Valid Format', $message);
    }

    public function test_simple_token_with_echeck()
    {
        $hash_in = array('id' => '1211',
            'reportGroup' => 'Planets',
            'merchantId' => '101',
            'version' => '8.8',
            'orderId' => '12344',
            'echeckForToken' => array('accNum' => '12344565', 'routingNum' => '123476545'));

        $initialize = new LitleOnlineRequest();
        $registerTokenResponse = $initialize->registerTokenRequest($hash_in);
        $message = XmlParser::getAttribute($registerTokenResponse, 'litleOnlineResponse', 'message');
        $this->assertEquals('Valid Format', $message);
    }

    public function test_token_echeck_missing_required()
    {
        $hash_in = array('merchantId' => '101', 'id' => '1211',
            'version' => '8.8',
            'reportGroup' => 'Planets',
            'orderId' => '12344',
            'echeckForToken' => array('routingNum' => '132344565'));

        $litleTest = new LitleOnlineRequest();
        $this->setExpectedException('InvalidArgumentException', 'Missing Required Field: /accNum/');
        $retOb = $litleTest->registerTokenRequest($hash_in);
    }

    public function test_simple_token_applepay()
    {
        $hash_in = array('id' => '1211',
            'merchantId' => '101',
            'version' => '8.8',
            'reportGroup' => 'Planets',
            'orderId' => '12344',
            'applepay' => array(
                'data' => 'string data here',
                'header' => array('applicationData' => '454657413164',
                    'ephemeralPublicKey' => '1',
                    'publicKeyHash' => '1234',
                    'transactionId' => '12345'),
                'signature' => 'signature',
                'version' => 'version 1'));

        $initialize = new LitleOnlineRequest();
        $registerTokenResponse = $initialize->registerTokenRequest($hash_in);
        $message = XmlParser::getAttribute($registerTokenResponse, 'litleOnlineResponse', 'message');
        $this->assertEquals('Valid Format', $message);
    }

    public function test_simple_token_with_androidpay()
    {
        $hash_in = array(
            'id' => 'id',
            'orderId' => 'androidpay',
            'accountNumber' => '1233456789103801'
        );

        $initialize = new LitleOnlineRequest();
        $registerTokenResponse = $initialize->registerTokenRequest($hash_in);
        $message = XmlParser::getAttribute($registerTokenResponse, 'litleOnlineResponse', 'message');
        $cryptogram = XmlParser::getNode($registerTokenResponse, 'cryptogram');
        $expMonth = XmlParser::getNode($registerTokenResponse, 'expMonth');
        $expYear = XmlParser::getNode($registerTokenResponse, 'expYear');
        $this->assertEquals('Valid Format', $message);
        $this->assertEquals('aHR0cHM6Ly93d3cueW91dHViZS5jb20vd2F0Y2g/dj1kUXc0dzlXZ1hjUQ0K', $cryptogram);
        $this->assertEquals('01', $expMonth);
        $this->assertEquals('2050', $expYear);
    }
}
