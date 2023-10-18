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

class aaaaSaleFunctionalTest extends \PHPUnit_Framework_TestCase
{
    public function test_simple_sale_with_card()
    {
        $hash_in = array(
            'card' => array('type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123');

        $initialize = new LitleOnlineRequest();
        $saleResponse = $initialize->saleRequest($hash_in);
        $response = XmlParser::getNode($saleResponse, 'response');
        $this->assertEquals('000', $response);
    }

    public function test_simple_sale_with_paypal()
    {
        $hash_in = array(
            'paypal' => array("payerId" => '123', "token" => '12321312',
                "transactionId" => '123123'),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123');

        $initialize = new LitleOnlineRequest();
        $saleResponse = $initialize->saleRequest($hash_in);
        $response = XmlParser::getNode($saleResponse, 'response');
        $this->assertEquals('000', $response);
    }

    public function test_illegal_orderSource()
    {
        $hash_in = array(
            'paypal' => array("payerId" => '123', "token" => '12321312',
                "transactionId" => '123123'),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'notecommerce',
            'amount' => '123');
        $initialize = new LitleOnlineRequest();
        $saleResponse = $initialize->saleRequest($hash_in);
        $message = XmlParser::getAttribute($saleResponse, 'litleOnlineResponse', 'message');
        $this->assertRegExp('/Error validating xml data against the schema/', $message);
    }

    public function test_illegal_card_type()
    {
        $hash_in = array(
            'card' => array('type' => 'DK',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123');

        $initialize = new LitleOnlineRequest();
        $saleResponse = $initialize->saleRequest($hash_in);
        $message = XmlParser::getAttribute($saleResponse, 'litleOnlineResponse', 'message');
        $this->assertRegExp('/Error validating xml data against the schema/', $message);
    }

    public function no_reportGroup()
    {
        $hash_in = array(
            'card' => array('type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123');

        $initialize = new LitleOnlineRequest();
        $saleResponse = $initialize->saleRequest($hash_in);
        $response = XmlParser::getNode($saleResponse, 'response');
        $this->assertEquals('000', $response);
    }

    public function test_fields_out_of_order()
    {
        $hash_in = array(
            'paypal' => array("payerId" => '123', "token" => '12321312',
                "transactionId" => '123123'),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123');

        $initialize = new LitleOnlineRequest();
        $saleResponse = $initialize->saleRequest($hash_in);
        $response = XmlParser::getNode($saleResponse, 'response');
        $this->assertEquals('000', $response);
    }

    public function test_invalid_field()
    {
        $hash_in = array(
            'paypal' => array("payerId" => '123', "token" => '12321312',
                "transactionId" => '123123'),
            'id' => '1211',
            'orderId' => '2111',
            'nonexistant' => 'novalue',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123');

        $initialize = new LitleOnlineRequest();
        $saleResponse = $initialize->saleRequest($hash_in);
        $message = XmlParser::getNode($saleResponse, 'message');
        $this->assertEquals('Approved', $message);
    }

    public function test_simple_sale_with_applepay()
    {
        $hash_in = array(
            'applepay' => array(
                'data' => 'string data here',
                'header' => array('applicationData' => '454657413164',
                    'ephemeralPublicKey' => '1',
                    'publicKeyHash' => '1234',
                    'transactionId' => '12345'),
                'signature' => 'signature',
                'version' => 'version 1'),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '12334');

        $initialize = new LitleOnlineRequest();
        $saleResponse = $initialize->saleRequest($hash_in);
        $response = XmlParser::getNode($saleResponse, 'response');
        $this->assertEquals('000', $response);
    }

    public function test_simple_sale_with_applepay_insufficient_funds()
    {
        $hash_in = array(
            'applepay' => array(
                'data' => 'string data here',
                'header' => array('applicationData' => '454657413164',
                    'ephemeralPublicKey' => '1',
                    'publicKeyHash' => '1234',
                    'transactionId' => '12345'),
                'signature' => 'signature',
                'version' => 'version 1'),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '1110');

        $initialize = new LitleOnlineRequest();
        $saleResponse = $initialize->saleRequest($hash_in);
        $response = XmlParser::getNode($saleResponse, 'response');
        $this->assertEquals('110', $response);
    }

    public function test_sale_with_processingType()
    {
        echo('hello');
        $hash_in = array(
            'card' => array('type' => 'VI',
                'number' => '4100200300011000',
                'expDate' => '0521',),
            'orderId' => '2111',
            'amount' => '4999',
            'orderSource' => 'ecommerce',
            'processingType' => 'initialRecurring');

        $initilaize = new LitleOnlineRequest();
        $saleResponse = $initilaize->saleRequest($hash_in);
        $response = XmlParser::getNode($saleResponse, 'response');
        $this->assertEquals('000', $response);
        $message = XmlParser::getNode($saleResponse, 'message');
        $this->assertEquals('Approved', $message);
        $networkTransactionId = XmlParser::getNode($saleResponse, 'networkTransactionId');
        $this->assertNotNull($networkTransactionId);
    }

    public function test_sale_with_originalNetworkTransactionId()
    {
        $hash_in = array(
            'card' => array('type' => 'VI',
                'number' => '4100200300011000',
                'expDate' => '0521',
                'cardValidationNum' => '463',),
            'orderId' => '2111',
            'amount' => '4999',
            'orderSource' => 'recurring',
            'originalNetworkTransactionId' => 'Value from Net_Id1 response',);

        $initilaize = new LitleOnlineRequest();
        $saleResponse = $initilaize->saleRequest($hash_in);
        $response = XmlParser::getNode($saleResponse, 'response');
        $this->assertEquals('000', $response);
    }

    public function test_sale_with_originalTransactionAmount()
    {
        $hash_in = array(
            'card' => array('type' => 'VI',
                'number' => '4100200300011000',
                'expDate' => '0521',
                'cardValidationNum' => '463',),
            'orderId' => '2111',
            'amount' => '4999',
            'orderSource' => 'recurring',
            'originalNetworkTransactionId' => 'Value from Net_Id1 response',
            'originalTransactionAmount' => '4999',);

        $initilaize = new LitleOnlineRequest();
        $saleResponse = $initilaize->saleRequest($hash_in);
        $response = XmlParser::getNode($saleResponse, 'response');
        $this->assertEquals('000', $response);
    }

    public function test_changes_for_v8_33()
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
                'orderSource' => 'telephone',
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

        $initialize = new LitleOnlineRequest();
        $saleResponse = $initialize->saleRequest($hash_in);
        $message = XmlParser::getAttribute($saleResponse, 'litleOnlineResponse', 'message');
        $message = XmlParser::getNode($saleResponse, 'message');
        $this->assertEquals('Approved', $message);
    }
}
