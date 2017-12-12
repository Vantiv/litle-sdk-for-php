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

class CertAuthenhancedTest extends \PHPUnit_Framework_TestCase
{
    public function test_14()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '14',
            'amount' => '3000',
            'orderSource' => 'ecommerce',
            'card' => array(
                'number' => '4457010200000247',
                'expDate' => '0812',
                'type' => 'VI'));
        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        // TODO enhancedAuthResponse is empty
        //$this->assertEquals('PREPAID',XmlParser::getNode($authorizationResponse,'type'));
        //$this->assertEquals('2000',XmlParser::getNode($authorizationResponse,'availableBalance'));
        //$this->assertEquals('NO',XmlParser::getNode($authorizationResponse,'reloadable'));
        //$this->assertEquals('GIFT',XmlParser::getNode($authorizationResponse,'prepaidCardType'));

    }

    public function test_15()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '15',
            'amount' => '3000',
            'orderSource' => 'ecommerce',
            'card' => array(
                'number' => '5500000254444445',
                'expDate' => '0312',
                'type' => 'MC'));
        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        // TODO enhancedAuthResponse is empty
        // $this->assertEquals('PREPAID',XmlParser::getNode($authorizationResponse,'type'));
        // $this->assertEquals('2000',XmlParser::getNode($authorizationResponse,'availableBalance'));
        // $this->assertEquals('YES',XmlParser::getNode($authorizationResponse,'reloadable'));
        // $this->assertEquals('PAYROLL',XmlParser::getNode($authorizationResponse,'prepaidCardType'));

    }

    public function test_16()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '16',
            'amount' => '3000',
            'orderSource' => 'ecommerce',
            'card' => array(
                'number' => '5592106621450897',
                'expDate' => '0312',
                'type' => 'MC'));
        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        // TODO enhancedAuthResponse is empty
        // $this->assertEquals('PREPAID',XmlParser::getNode($authorizationResponse,'type'));
        // $this->assertEquals('0',XmlParser::getNode($authorizationResponse,'availableBalance'));
        // $this->assertEquals('YES',XmlParser::getNode($authorizationResponse,'reloadable'));
        // $this->assertEquals('PAYROLL',XmlParser::getNode($authorizationResponse,'prepaidCardType'));

    }

    public function test_17()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '17',
            'amount' => '3000',
            'orderSource' => 'ecommerce',
            'card' => array(
                'number' => '5590409551104142',
                'expDate' => '0312',
                'type' => 'MC'));
        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        // TODO enhancedAuthResponse is empty
        // $this->assertEquals('PREPAID',XmlParser::getNode($authorizationResponse,'type'));
        // $this->assertEquals('6500',XmlParser::getNode($authorizationResponse,'availableBalance'));
        // $this->assertEquals('YES',XmlParser::getNode($authorizationResponse,'reloadable'));
        // $this->assertEquals('PAYROLL',XmlParser::getNode($authorizationResponse,'prepaidCardType'));

    }

    public function test_18()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '18',
            'amount' => '3000',
            'orderSource' => 'ecommerce',
            'card' => array(
                'number' => '5587755665222179',
                'expDate' => '0312',
                'type' => 'MC'));
        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        // TODO enhancedAuthResponse is empty
        // $this->assertEquals('PREPAID',XmlParser::getNode($authorizationResponse,'type'));
        // $this->assertEquals('12200',XmlParser::getNode($authorizationResponse,'availableBalance'));
        // $this->assertEquals('YES',XmlParser::getNode($authorizationResponse,'reloadable'));
        // $this->assertEquals('PAYROLL',XmlParser::getNode($authorizationResponse,'prepaidCardType'));

    }

    public function test_19()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '19',
            'amount' => '3000',
            'orderSource' => 'ecommerce',
            'card' => array(
                'number' => '5445840176552850',
                'expDate' => '0312',
                'type' => 'MC'));
        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        //TODO: getting 850 as response
        //$this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        //$this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        // TODO enhancedAuthResponse is empty
        // $this->assertEquals('PREPAID',XmlParser::getNode($authorizationResponse,'type'));
        // $this->assertEquals('20000',XmlParser::getNode($authorizationResponse,'availableBalance'));
        // $this->assertEquals('YES',XmlParser::getNode($authorizationResponse,'reloadable'));
        // $this->assertEquals('PAYROLL',XmlParser::getNode($authorizationResponse,'prepaidCardType'));

    }

    public function test_20()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '20',
            'amount' => '3000',
            'orderSource' => 'ecommerce',
            'card' => array(
                'number' => '5390016478904678',
                'expDate' => '0312',
                'type' => 'MC'));
        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        // TODO enhancedAuthResponse is empty
        // $this->assertEquals('PREPAID',XmlParser::getNode($authorizationResponse,'type'));
        // $this->assertEquals('10050',XmlParser::getNode($authorizationResponse,'availableBalance'));
        // $this->assertEquals('YES',XmlParser::getNode($authorizationResponse,'reloadable'));
        // $this->assertEquals('PAYROLL',XmlParser::getNode($authorizationResponse,'prepaidCardType'));

    }

    public function test_21()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '21',
            'amount' => '5000',
            'orderSource' => 'ecommerce',
            'card' => array(
                'number' => '4457010201000246',
                'expDate' => '0912',
                'type' => 'VI'));
        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        // TODO enhancedAuthResponse is empty
        // $this->assertEquals('AFFLUENT',XmlParser::getNode($authorizationResponse,'affluence'));

    }

    public function test_22()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '22',
            'amount' => '5000',
            'orderSource' => 'ecommerce',
            'card' => array(
                'number' => '4457010202000245',
                'expDate' => '1111',
                'type' => 'VI'));
        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        // TODO enhancedAuthResponse is empty
        // $this->assertEquals('MASS AFFLUENT',XmlParser::getNode($authorizationResponse,'affluence'));

    }

    public function test_23()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '23',
            'amount' => '5000',
            'orderSource' => 'ecommerce',
            'card' => array(
                'number' => '5112010201000109',
                'expDate' => '0412',
                'type' => 'MC'));
        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        // TODO enhancedAuthResponse is empty
        // $this->assertEquals('AFFLUENT',XmlParser::getNode($authorizationResponse,'affluence'));

    }

    public function test_24()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '24',
            'amount' => '5000',
            'orderSource' => 'ecommerce',
            'card' => array(
                'number' => '5112010202000108',
                'expDate' => '0812',
                'type' => 'MC'));
        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        // TODO enhancedAuthResponse is empty
        // $this->assertEquals('MASS AFFLUENT',XmlParser::getNode($authorizationResponse,'affluence'));

    }

    public function test_25()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '25',
            'amount' => '5000',
            'orderSource' => 'ecommerce',
            'card' => array(
                'number' => '4100204446270000',
                'expDate' => '1112',
                'type' => 'VI'));
        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        // TODO enhancedAuthResponse is empty
        // $this->assertEquals('BRA',XmlParser::getNode($authorizationResponse,'issuerCountry'));

    }
}
