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
    public function test_6_Auth()
    {
        $auth_hash = array(
            'orderId' => '6',
            'amount' => '60060',
            'orderSource'=>'ecommerce',
            'billToAddress'=>array(
            'name' => 'Joe Green',
            'addressLine1' => '6 Main St.',
            'city' => 'Derry',
            'state' => 'NH',
            'zip' => '03038',
            'country' => 'US'),
            'card'=>array(
            'number' =>'4457010100000008',
            'expDate' => '0612',
            'type' => 'VI',
            'cardValidationNum' => '992'));

        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('110',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Insufficient Funds',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('34',XmlParser::getNode($authorizationResponse,'avsResult'));
        $this->assertEquals('P',XmlParser::getNode($authorizationResponse,'cardValidationResult'));
    }

    public function test_6_sale()
    {
        $sale_hash = array(
            'orderId' => '6',
            'amount' => '60060',
            'orderSource'=>'ecommerce',
            'billToAddress'=>array(
            'name' => 'Joe Green',
            'addressLine1' => '6 Main St.',
            'city' => 'Derry',
            'state' => 'NH',
            'zip' => '03038',
            'country' => 'US'),
            'card'=>array(
            'number' =>'4457010100000008',
            'expDate' => '0612',
            'type' => 'VI',
            'cardValidationNum' => '992'));

        $initilaize = new LitleOnlineRequest();
        $saleResponse = $initilaize->saleRequest($sale_hash);
        $this->assertEquals('110',XmlParser::getNode($saleResponse,'response'));
        $this->assertEquals('Insufficient Funds',XmlParser::getNode($saleResponse,'message'));
        $this->assertEquals('34',XmlParser::getNode($saleResponse,'avsResult'));
        $this->assertEquals('P',XmlParser::getNode($saleResponse,'cardValidationResult'));

        $void_hash =  array(
                        'litleTxnId' =>(XmlParser::getNode($saleResponse,'litleTxnId')),
                        'reportGroup'=>'planets');
        $initilaize = new LitleOnlineRequest();
        $voidResponse = $initilaize->voidRequest($void_hash);
        $this->assertEquals('360',XmlParser::getNode($voidResponse,'response'));
        $this->assertEquals('No transaction found with specified litleTxnId',XmlParser::getNode($voidResponse,'message'));
    }

    public function test_7_Auth()
    {
        $auth_hash = array(
            'orderId' => '7',
            'amount' => '70070',
            'orderSource'=>'ecommerce',
            'billToAddress'=>array(
            'name' => 'Jane Murray',
            'addressLine1' => '7 Main St.',
            'city' => 'Amesbury',
            'state' => 'MA',
            'zip' => '01913',
            'country' => 'US'),
            'card'=> array(
            'number' =>'5112010100000002',
            'expDate' => '0712',
            'cardValidationNum' => '251',
            'type' => 'MC'));

        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('301',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Invalid Account Number',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('34',XmlParser::getNode($authorizationResponse,'avsResult'));
        $this->assertEquals('N',XmlParser::getNode($authorizationResponse,'cardValidationResult'));
    }

    public function test_7_avs()
    {
        $auth_hash = array(
                    'orderId' => '7',
                    'amount' => '70070',
                    'orderSource'=>'ecommerce',
                    'billToAddress'=>array(
                    'name' => 'Jane Murray',
                    'addressLine1' => '7 Main St.',
                    'city' => 'Amesbury',
                    'state' => 'MA',
                    'zip' => '01913',
                    'country' => 'US'),
                    'card'=> array(
                    'number' =>'5112010100000002',
                    'expDate' => '0712',
                    'cardValidationNum' => '251',
                    'type' => 'MC'));

        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('301',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Invalid Account Number',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('34',XmlParser::getNode($authorizationResponse,'avsResult'));
        $this->assertEquals('N',XmlParser::getNode($authorizationResponse,'cardValidationResult'));
    }

    public function test_7_sale()
    {
        $sale_hash = array(
                    'orderId' => '7',
                    'amount' => '70070',
                    'orderSource'=>'ecommerce',
                    'billToAddress'=>array(
                    'name' => 'Jane Murray',
                    'addressLine1' => '7 Main St.',
                    'city' => 'Amesbury',
                    'state' => 'MA',
                    'zip' => '01913',
                    'country' => 'US'),
                    'card'=> array(
                    'number' =>'5112010100000002',
                    'expDate' => '0712',
                    'cardValidationNum' => '251',
                    'type' => 'MC'));

        $initilaize = new LitleOnlineRequest();
        $saleResponse = $initilaize->authorizationRequest($sale_hash);
        $this->assertEquals('301',XmlParser::getNode($saleResponse,'response'));
        $this->assertEquals('Invalid Account Number',XmlParser::getNode($saleResponse,'message'));
        $this->assertEquals('34',XmlParser::getNode($saleResponse,'avsResult'));
        $this->assertEquals('N',XmlParser::getNode($saleResponse,'cardValidationResult'));
    }

    public function test_8_Auth()
    {
        $auth_hash = array(
        'orderId' => '8',
        'amount' => '80080',
        'orderSource'=>'ecommerce',
        'billToAddress'=> array(
        'name' => 'Mark Johnson',
        'addressLine1' => '8 Main St.',
        'city' => 'Manchester',
        'state' => 'NH',
        'zip' => '03101',
        'country' => 'US'),
        'card'=> array(
        'number' =>'6011010100000002',
        'expDate' => '0812',
        'type' => 'DI',
        'cardValidationNum' => '184'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('123',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Call Discover',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('34',XmlParser::getNode($authorizationResponse,'avsResult'));
        $this->assertEquals('P',XmlParser::getNode($authorizationResponse,'cardValidationResult'));
    }

    public function test_8_avs()
    {
        $auth_hash = array(
            'orderId' => '8',
            'amount' => '80080',
            'orderSource'=>'ecommerce',
            'billToAddress'=> array(
            'name' => 'Mark Johnson',
            'addressLine1' => '8 Main St.',
            'city' => 'Manchester',
            'state' => 'NH',
            'zip' => '03101',
            'country' => 'US'),
            'card'=> array(
            'number' =>'6011010100000002',
            'expDate' => '0812',
            'type' => 'DI',
            'cardValidationNum' => '184'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('123',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Call Discover',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('34',XmlParser::getNode($authorizationResponse,'avsResult'));
        $this->assertEquals('P',XmlParser::getNode($authorizationResponse,'cardValidationResult'));
    }

    public function test_8_sale()
    {
        $sale_hash = array(
            'orderId' => '8',
            'amount' => '80080',
            'orderSource'=>'ecommerce',
            'billToAddress'=> array(
            'name' => 'Mark Johnson',
            'addressLine1' => '8 Main St.',
            'city' => 'Manchester',
            'state' => 'NH',
            'zip' => '03101',
            'country' => 'US'),
            'card'=> array(
            'number' =>'6011010100000002',
            'expDate' => '0812',
            'type' => 'DI',
            'cardValidationNum' => '184'));
        $initilaize = new LitleOnlineRequest();
        $saleResponse = $initilaize->saleRequest($sale_hash);
        $this->assertEquals('123',XmlParser::getNode($saleResponse,'response'));
        $this->assertEquals('Call Discover',XmlParser::getNode($saleResponse,'message'));
        $this->assertEquals('34',XmlParser::getNode($saleResponse,'avsResult'));
        $this->assertEquals('P',XmlParser::getNode($saleResponse,'cardValidationResult'));
    }

    public function test_9_Auth()
    {
        $auth_hash = array(
        'orderId' => '9',
        'amount' => '90090',
        'orderSource'=>'ecommerce',
        'billToAddress'=>array(
        'name' => 'James Miller',
        'addressLine1' => '9 Main St.',
        'city' => 'Boston',
        'state' => 'MA',
        'zip' => '02134',
        'country' => 'US'),
        'card'=>array(
        'number' =>'375001010000003',
        'expDate' => '0912',
        'cardValidationNum' => '0421',
        'type' => 'AX'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('303',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Pick Up Card',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('34',XmlParser::getNode($authorizationResponse,'avsResult'));
    }

    public function test_9_avs()
    {
        $auth_hash = array(
            'orderId' => '9',
            'amount' => '90090',
            'orderSource'=>'ecommerce',
            'billToAddress'=>array(
            'name' => 'James Miller',
            'addressLine1' => '9 Main St.',
            'city' => 'Boston',
            'state' => 'MA',
            'zip' => '02134',
            'country' => 'US'),
            'card'=>array(
            'number' =>'375001010000003',
            'expDate' => '0912',
            'cardValidationNum' => '0421',
            'type' => 'AX'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('303',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Pick Up Card',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('34',XmlParser::getNode($authorizationResponse,'avsResult'));
    }

    public function test_9_sale()
    {
        $sale_hash = array(
                'orderId' => '9',
                'amount' => '90090',
                'orderSource'=>'ecommerce',
                'billToAddress'=>array(
                'name' => 'James Miller',
                'addressLine1' => '9 Main St.',
                'city' => 'Boston',
                'state' => 'MA',
                'zip' => '02134',
                'country' => 'US'),
                'card'=>array(
                'number' =>'375001010000003',
                'expDate' => '0912',
                'cardValidationNum' => '0421',
                'type' => 'AX'));
        $initilaize = new LitleOnlineRequest();
        $saleResponse = $initilaize->saleRequest($sale_hash);
        $this->assertEquals('303',XmlParser::getNode($saleResponse,'response'));
        $this->assertEquals('Pick Up Card',XmlParser::getNode($saleResponse,'message'));
        $this->assertEquals('34',XmlParser::getNode($saleResponse,'avsResult'));
    }

    public function test_10()
    {
        $auth_hash = array(
        'orderId' => '10',
        'amount' => '40000',
        'orderSource'=>'ecommerce',
        'card'=>array(
        'number' =>'4457010140000141',
        'expDate' => '0912',
        'type' => 'VI'),
        'allowPartialAuth' => 'true');
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('010',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Partially Approved',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('32000',XmlParser::getNode($authorizationResponse,'approvedAmount'));
    }

    public function test_11()
    {
        $auth_hash = array(
            'orderId' => '11',
            'amount' => '60000',
            'orderSource'=>'ecommerce',
            'card'=>array(
            'number' =>'5112010140000004',
                'expDate' => '1111',
                'type' => 'MC'),
            'allowPartialAuth' => 'true');
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('010',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Partially Approved',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('48000',XmlParser::getNode($authorizationResponse,'approvedAmount'));
    }

    public function test_12()
    {
        $auth_hash = array(
                'orderId' => '12',
                'amount' => '50000',
                'orderSource'=>'ecommerce',
                'card'=>array(
                'number' =>'375001014000009',
                'expDate' => '0412',
                'type' => 'AX'),
                'allowPartialAuth' => 'true');
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('010',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Partially Approved',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('40000',XmlParser::getNode($authorizationResponse,'approvedAmount'));
    }

    public function test_13()
    {
        $auth_hash = array(
        'orderId' => '13',
        'amount' => '15000',
        'orderSource'=>'ecommerce',
        'card'=>array(
        'number' =>'6011010140000004',
        'expDate' => '0812',
        'type' => 'DI'),
        'allowPartialAuth' => 'true');
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('010',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Partially Approved',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('12000',XmlParser::getNode($authorizationResponse,'approvedAmount'));
    }
}
