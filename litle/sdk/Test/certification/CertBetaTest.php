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
namespace litle\sdk\Test\certification;

use litle\sdk\LitleOnlineRequest;
USE litle\sdk\XmlParser;

class CertBetaTest extends \PHPUnit_Framework_TestCase
{
    function test_6_auth()
    {
        $hash = array('id' => '1211',
            'orderId' => '6',
            'amount' => '10010',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Joe Green',
                'addressLine1' => '6 Main St.',
                'city' => 'Derry',
                'state' => 'NH',
                'zip' => '03038',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '4457010100000008',
                'expDate' => '0621',
                'cardValidationNum' => '992',
                'type' => 'VI'
            ),
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        //        TODO: run against for certification
//        $this->assertEquals('110', XmlParser::getNode($response, 'response'));
//        $this->assertEquals('Insufficient Funds', XmlParser::getNode($response, 'message'));
//        $this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
//        $this->assertEquals('P', XmlParser::getNode($response, 'cardValidationResult'));
    }

    function test_6_sale()
    {
        $hash = array('id' => '1211',
            'orderId' => '6',
            'amount' => '10010',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Joe Green',
                'addressLine1' => '6 Main St.',
                'city' => 'Derry',
                'state' => 'NH',
                'zip' => '03038',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '4457010100000008',
                'expDate' => '0621',
                'cardValidationNum' => '992',
                'type' => 'VI'
            ),
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->saleRequest($hash);
        //        TODO: run against for certification
//        $this->assertEquals('110', XmlParser::getNode($response, 'response'));
//        $this->assertEquals('Insufficient Funds', XmlParser::getNode($response, 'message'));
//        $this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
//        $this->assertEquals('P', XmlParser::getNode($response, 'cardValidationResult'));

        //test 6a
        $hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($response, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $response = $initialize->voidRequest($hash);
        //        TODO: run against for certification
//        $this->assertEquals('000', XmlParser::getNode($response, 'response'));
//        $this->assertEquals('Approved', XmlParser::getNode($response, 'message'));
    }

    function test_7_auth()
    {
        $hash = array('id' => '1211',
            'orderId' => '7',
            'amount' => '10010',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Jane Murray',
                'addressLine1' => '7 Main St.',
                'city' => 'Amesbury',
                'state' => 'MA',
                'zip' => '01913',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '5112010100000002',
                'expDate' => '0721',
                'cardValidationNum' => '251',
                'type' => 'MC'
            ),
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        //        TODO: run against for certification
//        $this->assertEquals('301', XmlParser::getNode($response, 'response'));
//        $this->assertEquals('Invalid Account Number', XmlParser::getNode($response, 'message'));
//        $this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
//        $this->assertEquals('N', XmlParser::getNode($response, 'cardValidationResult'));
    }

    function test_7_avs()
    {
        $hash = array('id' => '1211',
            'orderId' => '7',
            'amount' => '000',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Jane Murray',
                'addressLine1' => '7 Main St.',
                'city' => 'Amesbury',
                'state' => 'MA',
                'zip' => '01913',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '5112010100000002',
                'expDate' => '0721',
                'cardValidationNum' => '251',
                'type' => 'MC'
            ),
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        //        TODO: run against for certification
//        $this->assertEquals('301', XmlParser::getNode($response, 'response'));
//        $this->assertEquals('Invalid Account Number', XmlParser::getNode($response, 'message'));
//        $this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
//        $this->assertEquals('N', XmlParser::getNode($response, 'cardValidationResult'));
    }

    function test_7_sale()
    {
        $hash = array('id' => '1211',
            'orderId' => '7',
            'amount' => '10100',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Jane Murray',
                'addressLine1' => '7 Main St.',
                'city' => 'Amesbury',
                'state' => 'MA',
                'zip' => '01913',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '5112010100000002',
                'expDate' => '0721',
                'cardValidationNum' => '251',
                'type' => 'MC'
            ),
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->saleRequest($hash);
        //        TODO: run against for certification
//        $this->assertEquals('301', XmlParser::getNode($response, 'response'));
//        $this->assertEquals('Invalid Account Number', XmlParser::getNode($response, 'message'));
//        $this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
//        $this->assertEquals('N', XmlParser::getNode($response, 'cardValidationResult'));
    }

    function test_8_auth()
    {
        $hash = array('id' => '1211',
            'orderId' => '8',
            'amount' => '10010',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Mark Johnson',
                'addressLine1' => '8 Main St.',
                'city' => 'Manchester',
                'state' => 'NH',
                'zip' => '03101',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '6011010100000002',
                'expDate' => '0821',
                'cardValidationNum' => '184',
                'type' => 'DI'
            ),
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        //        TODO: run against for certification
//        $this->assertEquals('123', XmlParser::getNode($response, 'response'));
//        $this->assertEquals('Call Discover', XmlParser::getNode($response, 'message'));
//        $this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
//        $this->assertEquals('P', XmlParser::getNode($response, 'cardValidationResult'));
    }


    function test_8_avs()
    {
        $hash = array('id' => '1211',
            'orderId' => '8',
            'amount' => '000',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Mark Johnson',
                'addressLine1' => '8 Main St.',
                'city' => 'Manchester',
                'state' => 'NH',
                'zip' => '03101',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '6011010100000002',
                'expDate' => '0821',
                'cardValidationNum' => '184',
                'type' => 'DI'
            ),
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        //        TODO: run against for certification
//        $this->assertEquals('123', XmlParser::getNode($response, 'response'));
//        $this->assertEquals('Call Discover', XmlParser::getNode($response, 'message'));
//        $this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
//        $this->assertEquals('P', XmlParser::getNode($response, 'cardValidationResult'));
    }

    function test_8_sale()
    {
        $hash = array('id' => '1211',
            'orderId' => '8',
            'amount' => '10010',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Mark Johnson',
                'addressLine1' => '8 Main St.',
                'city' => 'Manchester',
                'state' => 'NH',
                'zip' => '03101',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '6011010100000002',
                'expDate' => '0821',
                'cardValidationNum' => '184',
                'type' => 'DI'
            ),
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->saleRequest($hash);
        //        TODO: run against prelive for certification
//        $this->assertEquals('123', XmlParser::getNode($response, 'response'));
//        $this->assertEquals('Call Discover', XmlParser::getNode($response, 'message'));
//        $this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
//        $this->assertEquals('P', XmlParser::getNode($response, 'cardValidationResult'));
    }

    function test_9_auth()
    {
        $hash = array('id' => '1211',
            'orderId' => '9',
            'amount' => '10010',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'James Miller',
                'addressLine1' => '9 Main St.',
                'city' => 'Boston',
                'state' => 'MA',
                'zip' => '02134',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '375001010000003',
                'expDate' => '0921',
                'cardValidationNum' => '0421',
                'type' => 'AX'
            ),
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        //        TODO: run against prelive for certification
        //$this->assertEquals('303', XmlParser::getNode($response, 'response'));
        //$this->assertEquals('Pick Up Card', XmlParser::getNode($response, 'message'));
        //$this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
        //$this->assertEquals('P', XmlParser::getNode($response, 'cardValidationResult'));
    }

    function test_9_avs()
    {
        $hash = array('id' => '1211',
            'orderId' => '9',
            'amount' => '000',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'James Miller',
                'addressLine1' => '9 Main St.',
                'city' => 'Boston',
                'state' => 'MA',
                'zip' => '02134',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '375001010000003',
                'expDate' => '0921',
                'cardValidationNum' => '0421',
                'type' => 'AX'
            ),
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        //        TODO: run against prelive for certification
        //$this->assertEquals('303', XmlParser::getNode($response, 'response'));
        //$this->assertEquals('Pick Up Card', XmlParser::getNode($response, 'message'));
        //$this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
        //$this->assertEquals('P', XmlParser::getNode($response, 'cardValidationResult'));
    }

    function test_9_sale()
    {
        $hash = array('id' => '1211',
            'orderId' => '9',
            'amount' => '10010',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'James Miller',
                'addressLine1' => '9 Main St.',
                'city' => 'Boston',
                'state' => 'MA',
                'zip' => '02134',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '375001010000003',
                'expDate' => '0921',
                'cardValidationNum' => '0421',
                'type' => 'AX'
            ),
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->saleRequest($hash);
        //        TODO: run against prelive for certification
        //$this->assertEquals('303', XmlParser::getNode($response, 'response'));
        //$this->assertEquals('Pick Up Card', XmlParser::getNode($response, 'message'));
        //$this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
        //$this->assertEquals('P', XmlParser::getNode($response, 'cardValidationResult'));
    }

    function test_10_auth()
    {
        $hash = array(
            'id' => 'thisisid',
            'orderId' => '10',
            'amount' => '40000',
            'orderSource' => 'ecommerce',
            'allowPartialAuth' => 'true',
            'card' => array(
                'number' => '4457010140000141',
                'expDate' => '0921',
                'type' => 'VI'
            ),
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        //        TODO: run against prelive for certification
//        $this->assertEquals('010', XmlParser::getNode($response, 'response'));
//        $this->assertEquals('Partially Approved', XmlParser::getNode($response, 'message'));
//        $this->assertEquals(32000, XmlParser::getNode($response, 'approvedAmount'));
    }

    function test_11_auth()
    {
        $hash = array(
            'id' => 'thisisid',
            'orderId' => '11',
            'amount' => '60000',
            'orderSource' => 'ecommerce',
            'allowPartialAuth' => 'true',
            'card' => array(
                'number' => '5112010140000004',
                'expDate' => '1121',
                'type' => 'MC'
            ),
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        //        TODO: run against prelive for certification
//        $this->assertEquals('010', XmlParser::getNode($response, 'response'));
//        $this->assertEquals('Partially Approved', XmlParser::getNode($response, 'message'));
//        $this->assertEquals(48000, XmlParser::getNode($response, 'approvedAmount'));
    }

    function test_12_auth()
    {
        $hash = array(
            'id' => 'thisisid',
            'orderId' => '12',
            'amount' => '50000',
            'orderSource' => 'ecommerce',
            'allowPartialAuth' => 'true',
            'card' => array(
                'number' => '375001014000009',
                'expDate' => '0421',
                'type' => 'AX'
            ),
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
//      TODO: run against prelive for certification
        //$this->assertEquals('010', XmlParser::getNode($response, 'response'));
        //$this->assertEquals('Partially Approved', XmlParser::getNode($response, 'message'));
        //$this->assertEquals(40000, XmlParser::getNode($response, 'approvedAmount'));
    }

    function test_13_auth()
    {
        $hash = array(
            'id' => 'thisisid',
            'orderId' => '13',
            'amount' => '15000',
            'orderSource' => 'ecommerce',
            'allowPartialAuth' => 'true',
            'card' => array(
                'number' => '6011010140000004',
                'expDate' => '0821',
                'type' => 'DI'
            ),
//            'url' => 'https://prelive.litle.com/vap/communicator/online'
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
//        TODO: run against prelive for certification
//        $this->assertEquals('010', XmlParser::getNode($response, 'response'));
//        $this->assertEquals('Partially Approved', XmlParser::getNode($response, 'message'));
//        $this->assertEquals(12000, XmlParser::getNode($response, 'approvedAmount'));
    }
}