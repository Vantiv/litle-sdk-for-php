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

class VoidSettledTransactionTest extends \PHPUnit_Framework_TestCase
{
    public function test_VoidSettledTransaction()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '1',
            'amount' => '10010',
            'orderSource' => 'ecommerce',
            'card' => array(
                'number' => '375001010000003',
                'expDate' => '0112',
                'cardValidationNum' => '1313',
                'type' => 'AX'));
        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));

        $capture_hash = array('litleTxnId' => (XmlParser::getNode($authorizationResponse, 'litleTxnId')), 'id' => '1211');
        $captureResponse = $initialize->captureRequest($capture_hash);
        //echo $captureResponse;
        $this->assertEquals('000', XmlParser::getNode($captureResponse, 'response'));
        $void_hash1 = array('litleTxnId' => 362, 'id' => '1211');

        $voidResponse1 = $initialize->voidRequest($void_hash1);
        $this->assertEquals('362', XmlParser::getNode($voidResponse1, 'response'));

        $credit_hash = array('litleTxnId' => (XmlParser::getNode($captureResponse, 'litleTxnId')), 'id' => '1211',);
        $creditResponse = $initialize->creditRequest($credit_hash);
        $this->assertEquals('000', XmlParser::getNode($creditResponse, 'response'));

        $void_hash2 = array('litleTxnId' => (XmlParser::getNode($creditResponse, 'litleTxnId')), 'id' => '1211',);
        $voidResponse2 = $initialize->voidRequest($void_hash2);
        $this->assertEquals('000', XmlParser::getNode($voidResponse2, 'response'));
    }
}
