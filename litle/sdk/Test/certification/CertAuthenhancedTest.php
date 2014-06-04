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
        $auth_hash = array(
              'orderId' => '14',
          'amount' => '3000',
          'orderSource'=>'ecommerce',
          'card'=>array(
          'number' =>'4457010200000247',
          'expDate' => '0812',
          'type' => 'VI'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('PREPAID',XmlParser::getNode($authorizationResponse,'type'));
        $this->assertEquals('2000',XmlParser::getNode($authorizationResponse,'availableBalance'));
        $this->assertEquals('NO',XmlParser::getNode($authorizationResponse,'reloadable'));
        $this->assertEquals('GIFT',XmlParser::getNode($authorizationResponse,'prepaidCardType'));

    }

    public function test_15()
    {
        $auth_hash = array(
                     'orderId' => '15',
                      'amount' => '3000',
                      'orderSource'=>'ecommerce',
                      'card'=>array(
                      'number' =>'5500000254444445',
                      'expDate' => '0312',
                      'type' => 'MC'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('PREPAID',XmlParser::getNode($authorizationResponse,'type'));
        $this->assertEquals('2000',XmlParser::getNode($authorizationResponse,'availableBalance'));
        $this->assertEquals('YES',XmlParser::getNode($authorizationResponse,'reloadable'));
        $this->assertEquals('PAYROLL',XmlParser::getNode($authorizationResponse,'prepaidCardType'));

    }

    public function test_16()
    {
        $auth_hash = array(
                         'orderId' => '16',
                          'amount' => '3000',
                          'orderSource'=>'ecommerce',
                          'card'=>array(
                          'number' =>'5592106621450897',
                          'expDate' => '0312',
                          'type' => 'MC'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('PREPAID',XmlParser::getNode($authorizationResponse,'type'));
        $this->assertEquals('0',XmlParser::getNode($authorizationResponse,'availableBalance'));
        $this->assertEquals('YES',XmlParser::getNode($authorizationResponse,'reloadable'));
        $this->assertEquals('PAYROLL',XmlParser::getNode($authorizationResponse,'prepaidCardType'));

    }

    public function test_17()
    {
        $auth_hash = array(
                         'orderId' => '17',
                          'amount' => '3000',
                          'orderSource'=>'ecommerce',
                          'card'=>array(
                          'number' =>'5590409551104142',
                          'expDate' => '0312',
                          'type' => 'MC'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('PREPAID',XmlParser::getNode($authorizationResponse,'type'));
        $this->assertEquals('6500',XmlParser::getNode($authorizationResponse,'availableBalance'));
        $this->assertEquals('YES',XmlParser::getNode($authorizationResponse,'reloadable'));
        $this->assertEquals('PAYROLL',XmlParser::getNode($authorizationResponse,'prepaidCardType'));

    }

    public function test_18()
    {
        $auth_hash = array(
                         'orderId' => '18',
                          'amount' => '3000',
                          'orderSource'=>'ecommerce',
                          'card'=>array(
                          'number' =>'5587755665222179',
                          'expDate' => '0312',
                          'type' => 'MC'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('PREPAID',XmlParser::getNode($authorizationResponse,'type'));
        $this->assertEquals('12200',XmlParser::getNode($authorizationResponse,'availableBalance'));
        $this->assertEquals('YES',XmlParser::getNode($authorizationResponse,'reloadable'));
        $this->assertEquals('PAYROLL',XmlParser::getNode($authorizationResponse,'prepaidCardType'));

    }

    public function test_19()
    {
        $auth_hash = array(
                         'orderId' => '19',
                          'amount' => '3000',
                          'orderSource'=>'ecommerce',
                          'card'=>array(
                          'number' =>'5445840176552850',
                          'expDate' => '0312',
                          'type' => 'MC'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('PREPAID',XmlParser::getNode($authorizationResponse,'type'));
        $this->assertEquals('20000',XmlParser::getNode($authorizationResponse,'availableBalance'));
        $this->assertEquals('YES',XmlParser::getNode($authorizationResponse,'reloadable'));
        $this->assertEquals('PAYROLL',XmlParser::getNode($authorizationResponse,'prepaidCardType'));

    }

    public function test_20()
    {
        $auth_hash = array(
                             'orderId' => '20',
                              'amount' => '3000',
                              'orderSource'=>'ecommerce',
                              'card'=>array(
                              'number' =>'5390016478904678',
                              'expDate' => '0312',
                              'type' => 'MC'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('PREPAID',XmlParser::getNode($authorizationResponse,'type'));
        $this->assertEquals('10050',XmlParser::getNode($authorizationResponse,'availableBalance'));
        $this->assertEquals('YES',XmlParser::getNode($authorizationResponse,'reloadable'));
        $this->assertEquals('PAYROLL',XmlParser::getNode($authorizationResponse,'prepaidCardType'));

    }

    public function test_21()
    {
        $auth_hash = array(
                             'orderId' => '21',
                              'amount' => '5000',
                              'orderSource'=>'ecommerce',
                              'card'=>array(
                              'number' =>'4457010201000246',
                              'expDate' => '0912',
                              'type' => 'VI'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('AFFLUENT',XmlParser::getNode($authorizationResponse,'affluence'));

    }

    public function test_22()
    {
        $auth_hash = array(
                                 'orderId' => '22',
                                  'amount' => '5000',
                                  'orderSource'=>'ecommerce',
                                  'card'=>array(
                                  'number' =>'4457010202000245',
                                  'expDate' => '1111',
                                  'type' => 'VI'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('MASS AFFLUENT',XmlParser::getNode($authorizationResponse,'affluence'));

    }

    public function test_23()
    {
        $auth_hash = array(
                                 'orderId' => '23',
                                  'amount' => '5000',
                                  'orderSource'=>'ecommerce',
                                  'card'=>array(
                                  'number' =>'5112010201000109',
                                  'expDate' => '0412',
                                  'type' => 'MC'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('AFFLUENT',XmlParser::getNode($authorizationResponse,'affluence'));

    }

    public function test_24()
    {
        $auth_hash = array(
                                 'orderId' => '24',
                                  'amount' => '5000',
                                  'orderSource'=>'ecommerce',
                                  'card'=>array(
                                  'number' =>'5112010202000108',
                                  'expDate' => '0812',
                                  'type' => 'MC'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('MASS AFFLUENT',XmlParser::getNode($authorizationResponse,'affluence'));

    }

    public function test_25()
    {
        $auth_hash = array(
                                 'orderId' => '25',
                                  'amount' => '5000',
                                  'orderSource'=>'ecommerce',
                                  'card'=>array(
                                  'number' =>'4100204446270000',
                                  'expDate' => '1112',
                                  'type' => 'VI'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('BRA',XmlParser::getNode($authorizationResponse,'issuerCountry'));

    }

    # test 26-31 healthcare iias
    public function test_26()
    {
        $auth_hash = array(
                                 'orderId' => '26',
              'amount' => '18698',
              'orderSource'=>'ecommerce',
              'card'=>array(
              'number' =>'5194560012341234',
              'expDate' => '1212',
              'type' => 'MC'),
              'allowPartialAuth' => 'true',
              'healthcareIIAS' => array(
              'healthcareAmounts' => array(
              'totalHealthcareAmount' =>'20000'
        ),
              'IIASFlag' => 'Y'
        ));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('341',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Invalid healthcare amounts',XmlParser::getNode($authorizationResponse,'message'));

    }

    public function test_27()
    {
        $auth_hash = array(
                                     'orderId' => '27',
                  'amount' => '18698',
                  'orderSource'=>'ecommerce',
                  'card'=>array(
                  'number' =>'5194560012341234',
                  'expDate' => '1212',
                  'type' => 'MC'),
                  'allowPartialAuth' => 'true',
                  'healthcareIIAS' => array(
                  'healthcareAmounts' => array(
                  'totalHealthcareAmount' =>'15000',
                  'RxAmount' => '16000'),
                  'IIASFlag' => 'Y'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('341',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Invalid healthcare amounts',XmlParser::getNode($authorizationResponse,'message'));

    }

    public function test_28()
    {
        $auth_hash = array(
        'orderId' => '28',
        'amount' => '15000',
                      'orderSource'=>'ecommerce',
                      'card'=>array(
        'number' =>'5194560012341234',
                      'expDate' => '1212',
        'type' => 'MC'),
                      'allowPartialAuth' => 'true',
        'healthcareIIAS' => array(
                      'healthcareAmounts' => array(
        'totalHealthcareAmount' =>'15000',
        'RxAmount' => '3698'),
                      'IIASFlag' => 'Y'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));

    }

    public function test_29()
    {
        $auth_hash = array(
            'orderId' => '29',
            'amount' => '18699',
                          'orderSource'=>'ecommerce',
                          'card'=>array(
            'number' =>'4024720001231239',
                          'expDate' => '1212',
            'type' => 'VI'),
                          'allowPartialAuth' => 'true',
            'healthcareIIAS' => array(
                          'healthcareAmounts' => array(
            'totalHealthcareAmount' =>'31000',
            'RxAmount' => '1000',
            'visionAmount' => '19901',
              'clinicOtherAmount' => '9050',
              'dentalAmount' => '1049'),
                          'IIASFlag' => 'Y'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('341',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Invalid healthcare amounts',XmlParser::getNode($authorizationResponse,'message'));

    }

    public function test_30()
    {
        $auth_hash = array(
            'orderId' => '30',
            'amount' => '20000',
                          'orderSource'=>'ecommerce',
                          'card'=>array(
            'number' =>'4024720001231239',
                          'expDate' => '1212',
            'type' => 'VI'),
                          'allowPartialAuth' => 'true',
            'healthcareIIAS' => array(
                          'healthcareAmounts' => array(
            'totalHealthcareAmount' =>'20000',
            'RxAmount' => '1000',
            'visionAmount' => '19901',
              'clinicOtherAmount' => '9050',
              'dentalAmount' => '1049'),
                          'IIASFlag' => 'Y'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('341',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Invalid healthcare amounts',XmlParser::getNode($authorizationResponse,'message'));

    }

    public function test_31()
    {
        $auth_hash = array(
            'orderId' => '31',
            'amount' => '25000',
                          'orderSource'=>'ecommerce',
                          'card'=>array(
            'number' =>'4024720001231239',
                          'expDate' => '1212',
            'type' => 'VI'),
                          'allowPartialAuth' => 'true',
            'healthcareIIAS' => array(
                          'healthcareAmounts' => array(
            'totalHealthcareAmount' =>'18699',
            'RxAmount' => '1000',
            'visionAmount' => '15099'),
                          'IIASFlag' => 'Y'));
        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
        $this->assertEquals('010',XmlParser::getNode($authorizationResponse,'response'));
        $this->assertEquals('Partially Approved',XmlParser::getNode($authorizationResponse,'message'));
        $this->assertEquals('18699',XmlParser::getNode($authorizationResponse,'approvedAmount'));
    }

}
