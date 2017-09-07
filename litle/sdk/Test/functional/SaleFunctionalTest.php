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

class SaleFunctionalTest extends \PHPUnit_Framework_TestCase
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
            'amount' => '123');

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

    public function test_simple_sale_with_AdvancedFraudCheckWithCustomAttribute()
    {
        $hash_in = array(
            'card' => array('type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'),
            'id' => '654',
            'orderId' => '2111',
            'orderSource' => 'ecommerce',
            'amount' => '123',
            'advancedFraudChecks' => array(
                'threatMetrixSessionId' => 'abc123',
                'customAttribute1' => '1',
                'customAttribute2' => '2',
                'customAttribute3' => '3',
                'customAttribute4' => '4',
                'customAttribute5' => '5',
            ));
        $initialize = new LitleOnlineRequest();
        $saleResponse = $initialize->saleRequest($hash_in);
        $response = XmlParser::getNode($saleResponse, 'response');
        $this->assertEquals('000', $response);
    }

    public function test_simple_sale_with_sepaDirectDebit()
    {
        $hash_in = array(
            'sepaDirectDebit' => array(
                'mandateProvider' => 'Merchant',
                'sequenceType' => 'FirstRecurring',
                'mandateReference' => 'some string here',
                'mandateUrl' => 'some string here',
                //'mandateSignatureDate'=>'2017-01-24T09:00:00',
                'iban' => 'string with min of 15 char',
                'preferredLanguage' => 'USA'
            ),
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


    public function test_simple_sale_with_networkTransactionId()
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
        $response = XmlParser::getNode($saleResponse, 'networkTransactionId');
        $this->assertEquals('63225578415568556365452427825', $response);
    }

    public function test_sale_with_detail_tax_multiple()
    {
        $sale_info = array(
            'id' => 1,
            'orderId' => '1',
            'amount' => '10010',
            'orderSource'=>'ecommerce',
            'billToAddress'=>array(
                'name' => 'John Smith',
                'addressLine1' => '1 Main St.',
                'city' => 'Burlington',
                'state' => 'MA',
                'zip' => '01803-3747',
                'country' => 'US'),
            'card'=>array(
                'number' =>'5112010000000003',
                'expDate' => '0112',
                'cardValidationNum' => '349',
                'type' => 'MC'
            ),
            'enhancedData' => array(
                'detailTax' => array(
                    'taxAmount' => 300,
                    'taxIncludedInTotal' => true
                ),
                'salesTax' => 500,
                'taxExempt' => false
            ),
        );
        $initialize = new LitleOnlineRequest();
        $saleResponse = $initialize->saleRequest($sale_info);
        #display results
        echo ("Response: " . (XmlParser::getNode($saleResponse,'response'))) . "\n";
        echo ("Message: " . XmlParser::getNode($saleResponse,'message')) . "\n";
    }


}
