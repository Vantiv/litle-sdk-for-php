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
        $hash_in = array(
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

        $initilaize = new LitleOnlineRequest();
        $captureGivenAuthResponse = $initilaize->captureGivenAuthRequest($hash_in);
        $message = XmlParser::getNode($captureGivenAuthResponse, 'message');
        $this->assertEquals('Approved', $message);
    }

    public function test_simple_captureGivenAuth_with_token()
    {
        $hash_in = array(
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

        $initilaize = new LitleOnlineRequest();
        $captureGivenAuthResponse = $initilaize->captureGivenAuthRequest($hash_in);
        $message = XmlParser::getNode($captureGivenAuthResponse, 'message');
        $this->assertEquals('Approved', $message);
    }

    public function test_complex_captureGivenAuth()
    {
        $hash_in = array(
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

        $initilaize = new LitleOnlineRequest();
        $captureGivenAuthResponse = $initilaize->captureGivenAuthRequest($hash_in);
        $message = XmlParser::getNode($captureGivenAuthResponse, 'message');
        $this->assertEquals('Approved', $message);
    }

    public function test_authInfo()
    {
        $hash_in = array(
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

        $initilaize = new LitleOnlineRequest();
        $captureGivenAuthResponse = $initilaize->captureGivenAuthRequest($hash_in);
        $message = XmlParser::getNode($captureGivenAuthResponse, 'message');
        $this->assertEquals('Approved', $message);
    }

    public function test_simple_captureGivenAuth_secondary_amount()
    {
        $hash_in = array(
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

        $initilaize = new LitleOnlineRequest();
        $captureGivenAuthResponse = $initilaize->captureGivenAuthRequest($hash_in);
        $message = XmlParser::getNode($captureGivenAuthResponse, 'message');
        $this->assertEquals('Approved', $message);
    }

    public function test_simple_captureGivenAuth_v8_33()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4005518220000002',
                'expDate' => '0150',
                'cardValidationNum' => '987',
            ),
            'id'=>'0001',
            'orderId' => '82364_cnpApiAuth',
            'amount' => '2870',
            'authInformation' => array(
                'authDate' => '2002-10-09', 'authCode' => '543216',
                'authAmount' => '12345'),
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'David Berman A',
                'addressLine1' => '10 Main Street',
                'city' => 'San Jose',
                'state' => 'ca',
                'zip' => '95032',
                'country' => 'USA',
                'email' => 'dberman@phoenixProcessing.com',
                'phone' => '781-270-1111',
                'sellerId' => '21234234A1',
                'url' => 'www.google.com',
            ),
            'shipToAddress' => array(
                'name' => 'Raymond J. Johnson Jr. B',
                'addressLine1' => '123 Main Street',
                'city' => 'McLean',
                'state' => 'VA',
                'zip' => '22102',
                'country' => 'USA',
                'email' => 'ray@rayjay.com',
                'phone' => '978-275-0000',
                'sellerId' => '21234234A2',
                'url' => 'www.google.com',
            ),
            'retailerAddress' => array(
                'name' => 'John doe',
                'addressLine1' => '123 Main Street',
                'addressLine2' => '123 Main Street',
                'addressLine3' => '123 Main Street',
                'city' => 'Cincinnati',
                'state' => 'OH',
                'zip' => '45209',
                'country' => 'USA',
                'email' => 'noone@abc.com',
                'phone' => '1234562783',
                'sellerId' => '21234234A123456789101112',
                'companyName' => 'Google INC',
                'url' => 'https://www.youtube.com/results?search_query',
            ),
            'additionalCOFData' => array(
                'totalPaymentCount' => 'ND',
                'paymentType' => 'Fixed Amount',
                'uniqueId' => '234GTYH654RF13',
                'frequencyOfMIT' => 'Annually',
                'validationReference' => 'ANBH789UHY564RFC@EDB',
                'sequenceIndicator' => '86',
            ),
            'merchantCategoryCode' => '5964',
            'businessIndicator' => 'walletTransfer',
            'crypto' => 'true',
            'foreignRetailerIndicator' => 'F'
        );
        $initilaize = new LitleOnlineRequest();
        $captureGivenAuthResponse = $initilaize->captureGivenAuthRequest($hash_in);
        $message = XmlParser::getNode($captureGivenAuthResponse, 'message');
        $this->assertEquals('Approved', $message);
    }
}
