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

class CaptureGivenAuthFunctionalTest extends \PHPUnit_Framework_TestCase
{
    public function test_simple_captureGivenAuth()
    {
        $hash_in = array('id' => 'id',
            'orderId' => '12344',
            'amount' => '106',
            'authInformation' => array(
                'authDate' => '2002-10-09', 'authCode' => '543216',
                'authAmount' => '12345'),
            'orderSource' => 'ecommerce',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1210'));

        $initialize = new LitleOnlineRequest();
        $captureGivenAuthResponse = $initialize->captureGivenAuthRequest($hash_in);
        $message = XmlParser::getNode($captureGivenAuthResponse, 'message');
        $this->assertEquals('Approved', $message);
    }

    public function test_simple_captureGivenAuth_with_token()
    {
        $hash_in = array('id' => 'id',
            'orderId' => '12344',
            'amount' => '106',
            'authInformation' => array(
                'authDate' => '2002-10-09', 'authCode' => '543216',
                'authAmount' => '12345'),
            'orderSource' => 'ecommerce',
            'token' => array(
                'type' => 'VI',
                'litleToken' => '123456789101112',
                'expDate' => '1210'));

        $initialize = new LitleOnlineRequest();
        $captureGivenAuthResponse = $initialize->captureGivenAuthRequest($hash_in);
        $message = XmlParser::getNode($captureGivenAuthResponse, 'message');
        $this->assertEquals('Approved', $message);
    }

    public function test_complex_captureGivenAuth()
    {
        $hash_in = array('id' => 'id',
            'orderId' => '12344',
            'amount' => '106',
            'authInformation' => array(
                'authDate' => '2002-10-09', 'authCode' => '543216',
                'authAmount' => '12345'),
            'billToAddress' => array('name' => 'Bob', 'city' => 'lowell', 'state' => 'MA', 'email' => 'litle.com'),
            'processingInstructions' => array('bypassVelocityCheck' => 'true'),
            'orderSource' => 'ecommerce',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1210'));

        $initialize = new LitleOnlineRequest();
        $captureGivenAuthResponse = $initialize->captureGivenAuthRequest($hash_in);
        $message = XmlParser::getNode($captureGivenAuthResponse, 'message');
        $this->assertEquals('Approved', $message);
    }

    public function test_authInfo()
    {
        $hash_in = array('id' => 'id',
            'orderId' => '12344',
            'amount' => '106',
            'authInformation' => array(
                'authDate' => '2002-10-09', 'authCode' => '543216',
                'authAmount' => '12345', 'fraudResult' => array('avsResult' => '12', 'cardValidationResult' => '123', 'authenticationResult' => '1',
                    'advancedAVSResult' => '123')),
            'orderSource' => 'ecommerce',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1210'));

        $initialize = new LitleOnlineRequest();
        $captureGivenAuthResponse = $initialize->captureGivenAuthRequest($hash_in);
        $message = XmlParser::getNode($captureGivenAuthResponse, 'message');
        $this->assertEquals('Approved', $message);
    }

    public function test_simple_captureGivenAuth_secondary_amount()
    {
        $hash_in = array('id' => 'id',
            'orderId' => '12344',
            'amount' => '106',
            'secondaryAmount' => '2000',
            'authInformation' => array(
                'authDate' => '2002-10-09', 'authCode' => '543216',
                'authAmount' => '12345'),
            'orderSource' => 'ecommerce',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1210'));

        $initialize = new LitleOnlineRequest();
        $captureGivenAuthResponse = $initialize->captureGivenAuthRequest($hash_in);
        $message = XmlParser::getNode($captureGivenAuthResponse, 'message');
        $this->assertEquals('Approved', $message);
    }

    public function test_simple_captureGivenAuth_with_processingType_orgntwtxnid_orgtxnamt()
    {
        $hash_in = array(
            'id' => 'id',
            'orderId' => '12344',
            'amount' => '106',
            'authInformation' => array(
                'authDate' => '2002-10-09',
                'authCode' => '543216',
                'authAmount' => '12345'
            ),
            'orderSource' => 'ecommerce',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1210'),
            'processingType' => 'initialRecurring',
            'originalNetworkTransactionId' => 'abcdefghijklmnopqrstuvwxyz',
            'originalTransactionAmount' => '1000'
        );

        $initialize = new LitleOnlineRequest();
        $captureGivenAuthResponse = $initialize->captureGivenAuthRequest($hash_in);
        $message = XmlParser::getNode($captureGivenAuthResponse, 'message');
        $this->assertEquals('Approved', $message);
    }


}
