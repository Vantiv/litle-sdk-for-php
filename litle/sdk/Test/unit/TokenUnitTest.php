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
namespace litle\sdk\Test\unit;
use litle\sdk\LitleOnlineRequest;
class TokenUnitTest extends \PHPUnit_Framework_TestCase
{
    public function test_token()
    {
        $hash_in = array(
            'orderId'=>'1','id' => 'id',
            'accountNumber'=>'123456789101112');
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*<accountNumber>123456789101112*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->registerTokenRequest($hash_in);
    }

    public function test_accountNum_and_paypage()
    {
        $hash_in = array('merchantId' => '101',
      'version'=>'8.8','id' => 'id',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'accountNumber'=>'1233456789101112',
      'paypageRegistrationId'=>'1233456789101112');
        $litleTest = new LitleOnlineRequest();
        $this->setExpectedException('InvalidArgumentException',"Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!");
        $retOb = $litleTest->registerTokenRequest($hash_in);

    }

    public function test_echeck_and_paypagel()
    {
        $hash_in = array('merchantId' => '101',
      'version'=>'8.8','id' => 'id',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'echeckForToken'=>array('accNum'=>'12344565','routingNum'=>'123476545'),
      'paypageRegistrationId'=>'1233456789101112');
        $litleTest = new LitleOnlineRequest();
        $this->setExpectedException('InvalidArgumentException',"Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!");
        $retOb = $litleTest->registerTokenRequest($hash_in);

    }

    public function test_echeck_and_paypage_and_accountnum()
    {
        $hash_in = array('merchantId' => '101',
      'version'=>'8.8','id' => 'id',
      'reportGroup'=>'Planets',
      'orderId'=>'12344',
      'accountNumber'=>'1233456789101112',
      'echeckForToken'=>array('accNum'=>'12344565','routingNum'=>'123476545'),
      'paypageRegistrationId'=>'1233456789101112');
        $litleTest = new LitleOnlineRequest();
        $this->setExpectedException('InvalidArgumentException',"Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!");
        $retOb = $litleTest->registerTokenRequest($hash_in);

    }

    public function test_cardValidationNum()
    {
        $hash_in = array(
                'orderId'=>'1','id' => 'id',
                'accountNumber'=>'123456789101112',
                'cardValidationNum'=>'123');
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*<accountNumber>123456789101112.*<cardValidationNum>123.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->registerTokenRequest($hash_in);
    }

    public function test_loggedInUser()
    {
        $hash_in = array(
                'loggedInUser'=>'gdake','id' => 'id',
                'merchantSdk'=>'PHP;8.14.0',
                'orderId'=>'1',
                'accountNumber'=>'123456789101112');
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*merchantSdk="PHP;8.14.0".*loggedInUser="gdake" xmlns=.*>.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->registerTokenRequest($hash_in);
    }
    
    public function test_token_applepay()
    {
    	$hash_in = array(
    			'orderId'=>'1','id' => 'id',
    			'applepay'=>array(
    					'data'=>'string data here',
    					'header'=> 'header stuff here',
    					'signature'=>'signature',
    					'version' => 'version 1'));
    	$mock = $this->getMock('litle\sdk\LitleXmlMapper');
    	$mock->expects($this->once())
    	->method('request')
    	->with($this->matchesRegularExpression('/.*<applepay><data>string data here.*<header>header stuff here.*<signature>signature.*<version>version 1.*/'));
    
    	$litleTest = new LitleOnlineRequest();
    	$litleTest->newXML = $mock;
    	$litleTest->registerTokenRequest($hash_in);
    }
    
    public function test_token_androidpay()
    {
    	$hash_in = array(
    			'id' => 'id',
    			'orderId'=>'androidpay',
    			'accountNumber'=>'1233456789103801'
    	);
    	$mock = $this->getMock('litle\sdk\LitleXmlMapper');
    	$mock->expects($this->once())
    	->method('request')
    	->with($this->matchesRegularExpression('/.*<orderId>androidpay.*<accountNumber>1233456789103801.*/'));
    
    	$litleTest = new LitleOnlineRequest();
    	$litleTest->newXML = $mock;
    	$litleTest->registerTokenRequest($hash_in);
    }

}
