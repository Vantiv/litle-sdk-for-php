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
        $hash_in = array(
            'merchantId' => '101',
          'version'=>'8.8',
          'reportGroup'=>'Planets',
          'orderId'=>'12344',
          'accountNumber'=>'1233456789103801');

        $initilaize = new LitleOnlineRequest();
        $registerTokenResponse = $initilaize->registerTokenRequest($hash_in);
        $message = XmlParser::getAttribute($registerTokenResponse,'litleOnlineResponse','message');
        $this->assertEquals('Valid Format',$message);
    }

    public function test_simple_token_with_paypage()
    {
        $hash_in = array(
        'merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'paypageRegistrationId'=>'1233456789101112');

        $initilaize = new LitleOnlineRequest();
        $registerTokenResponse = $initilaize->registerTokenRequest($hash_in);
        $message = XmlParser::getAttribute($registerTokenResponse,'litleOnlineResponse','message');
        $this->assertEquals('Valid Format',$message);
    }

    public function test_simple_token_with_echeck()
    {
        $hash_in = array(
            'reportGroup'=>'Planets',
          'merchantId' => '101',
          'version'=>'8.8',
          'orderId'=>'12344',
          'echeckForToken'=>array('accNum'=>'12344565','routingNum'=>'123476545'));

        $initilaize = new LitleOnlineRequest();
        $registerTokenResponse = $initilaize->registerTokenRequest($hash_in);
        $message = XmlParser::getAttribute($registerTokenResponse,'litleOnlineResponse','message');
        $this->assertEquals('Valid Format',$message);
    }

    public function test_token_echeck_missing_required()
    {
        $hash_in = array('merchantId' => '101',
      'version'=>'8.8',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'echeckForToken'=>array('routingNum'=>'132344565'));

        $litleTest = new LitleOnlineRequest();
        $this->setExpectedException('InvalidArgumentException','Missing Required Field: /accNum/');
        $retOb = $litleTest->registerTokenRequest($hash_in);
    }

}
