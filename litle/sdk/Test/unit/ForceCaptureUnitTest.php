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
class ForceCaptureUnitTest extends \PHPUnit_Framework_TestCase
{
    public function test_simple_forcCapture()
    {
        $hash_in = array(
     'orderId'=>'123',
      'id' => 'id',
      'litleTxnId'=>'123456',
      'amount'=>'106',
      'orderSource'=>'ecommerce',
      'token'=> array(
      'litleToken'=>'123456789101112',
      'expDate'=>'1210',
      'cardValidationNum'=>'555',
      'type'=>'VI'));
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*<token><litleToken>123456789101112.*<expDate>1210.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->forceCaptureRequest($hash_in);
    }
    public function test_no_orderId()
    {
        $hash_in = array(
       'reportGroup'=>'Planets','id' => 'id',
       'litleTxnId'=>'123456',
       'amount'=>'107',
       'orderSource'=>'ecommerce',
       'token'=> array(
       'litleToken'=>'123456789101112',
       'expDate'=>'1210',
       'cardValidationNum'=>'555',
       'type'=>'VI'));
        $litleTest = new LitleOnlineRequest();
        $this->setExpectedException('InvalidArgumentException',"Missing Required Field: /orderId/");
        $retOb = $litleTest->forceCaptureRequest($hash_in);
    }
    public function test_no_orderSource()
    {
        $hash_in = array(
           'reportGroup'=>'Planets','id' => 'id',
           'litleTxnId'=>'123456',
           'amount'=>'107',
           'orderId'=>'123',
           'token'=> array(
           'litleToken'=>'123456789101112',
           'expDate'=>'1210',
           'cardValidationNum'=>'555',
           'type'=>'VI'));
        $litleTest = new LitleOnlineRequest();
        $this->setExpectedException('InvalidArgumentException',"Missing Required Field: /orderSource/");
        $retOb = $litleTest->forceCaptureRequest($hash_in);
    }
    public function test_both_card_and_token()
    {
        $hash_in = array(

      'reportGroup'=>'Planets','id' => 'id',
      'litleTxnId'=>'123456',
      'orderId'=>'12344',
      'amount'=>'106',
      'orderSource'=>'ecommerce',
      'fraudCheck'=>array('authenticationTransactionId'=>'123'),
      'cardholderAuthentication'=>array('authenticationTransactionId'=>'123'),
      'card'=>array(
      'type'=>'VI',
      'number' =>'4100000000000001',
      'expDate' =>'1210'),
      'token'=> array(
      'litleToken'=>'1234',
      'expDate'=>'1210',
      'cardValidationNum'=>'555',
      'type'=>'VI'));
        $litleTest = new LitleOnlineRequest();
        $this->setExpectedException('InvalidArgumentException',"Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!");
        $retOb = $litleTest->forceCaptureRequest($hash_in);
    }
    public function test_all_choices()
    {
        $hash_in = array(

          'reportGroup'=>'Planets','id' => 'id',
          'litleTxnId'=>'123456',
          'orderId'=>'12344',
          'amount'=>'106',
          'orderSource'=>'ecommerce',
          'fraudCheck'=>array('authenticationTransactionId'=>'123'),
          'cardholderAuthentication'=>array('authenticationTransactionId'=>'123'),
          'card'=>array(
          'type'=>'VI',
          'number' =>'4100000000000001',
          'expDate' =>'1210'),
          'paypage'=> array(
          'paypageRegistrationId'=>'1234',
          'expDate'=>'1210',
          'cardValidationNum'=>'555',
          'type'=>'VI'),
          'token'=> array(
          'litleToken'=>'1234',
          'expDate'=>'1210',
          'cardValidationNum'=>'555',
          'type'=>'VI'));
        $litleTest = new LitleOnlineRequest();
        $this->setExpectedException('InvalidArgumentException',"Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!");
        $retOb = $litleTest->forceCaptureRequest($hash_in);
    }

    public function test_loggedInUser()
    {
        $hash_in = array(
                'loggedInUser'=>'gdake','id' => 'id',
                'merchantSdk'=>'PHP;10.1.0',
                'orderId'=>'123',
                'litleTxnId'=>'123456',
                'amount'=>'106',
                'orderSource'=>'ecommerce',
                'token'=> array(
                        'litleToken'=>'123456789101112',
                        'expDate'=>'1210',
                        'cardValidationNum'=>'555',
                        'type'=>'VI'));
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*merchantSdk="PHP;10.1.0".*loggedInUser="gdake" xmlns=.*>.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->forceCaptureRequest($hash_in);
    }

    public function test_surchargeAmount()
    {
        $hash_in = array(
            'orderId'=>'3','id' => 'id',
            'amount'=>'2',
            'surchargeAmount'=>'1',
            'orderSource'=>'ecommerce',
        );
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock
            ->expects($this->once())
            ->method('request')
            ->with($this->matchesRegularExpression('/.*<amount>2<\/amount><surchargeAmount>1<\/surchargeAmount><orderSource>ecommerce<\/orderSource>.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->forceCaptureRequest($hash_in);
    }

    public function test_surchargeAmount_optional()
    {
        $hash_in = array(
            'orderId'=>'3','id' => 'id',
            'amount'=>'2',
            'orderSource'=>'ecommerce',
        );
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock
        ->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*<amount>2<\/amount><orderSource>ecommerce<\/orderSource>.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->forceCaptureRequest($hash_in);
    }

    public function test_debtRepayment_true()
    {
        $hash_in = array(
                'amount'=>'2','id' => 'id',
                'orderSource'=>'ecommerce',
                'orderId'=>'3',
                'merchantData'=>array(
                        'campaign'=>'foo',
                ),
                'debtRepayment'=>'true'
        );
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock
        ->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*<\/merchantData><debtRepayment>true<\/debtRepayment><\/forceCapture>.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->forceCaptureRequest($hash_in);
    }

    public function test_debtRepayment_false()
    {
        $hash_in = array(
                'amount'=>'2','id' => 'id',
                'orderSource'=>'ecommerce',
                'orderId'=>'3',
                'merchantData'=>array(
                        'campaign'=>'foo',
                ),
                'debtRepayment'=>'false'
        );
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock
        ->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*<\/merchantData><debtRepayment>false<\/debtRepayment><\/forceCapture>.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->forceCaptureRequest($hash_in);
    }

    public function test_debtRepayment_optional()
    {
        $hash_in = array(
                'amount'=>'2','id' => 'id',
                'orderSource'=>'ecommerce',
                'orderId'=>'3',
                'merchantData'=>array(
                        'campaign'=>'foo',
                ),
        );
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock
        ->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*<\/merchantData><\/forceCapture>.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->forceCaptureRequest($hash_in);
    }
    public function test_simple_forceCapture_secondary_amount()
    {
    	$hash_in = array(
    			'orderId'=>'123','id' => 'id',
    			'litleTxnId'=>'123456',
    			'amount'=>'106',
    			'secondaryAmount' => '2000',
    			'orderSource'=>'ecommerce',
    			'token'=> array(
    					'litleToken'=>'123456789101112',
    					'expDate'=>'1210',
    					'cardValidationNum'=>'555',
    					'type'=>'VI'));
    	$mock = $this->getMock('litle\sdk\LitleXmlMapper');
    	$mock->expects($this->once())
    	->method('request')
    	->with($this->matchesRegularExpression('/.*<token><litleToken>123456789101112.*<expDate>1210.*/'));
    
    	$litleTest = new LitleOnlineRequest();
    	$litleTest->newXML = $mock;
    	$litleTest->forceCaptureRequest($hash_in);
    }
    
    public function test_simple_forcCapture_withProcessingType()
    {
    	$hash_in = array(
    			'orderId'=>'123',
    			'id' => 'id',
    			'litleTxnId'=>'123456',
    			'amount'=>'106',
    			'orderSource'=>'ecommerce',
    			'token'=> array(
    					'litleToken'=>'123456789101112',
    					'expDate'=>'1210',
    					'cardValidationNum'=>'555',
    					'type'=>'VI'),
    			'processingType' => 'initialRecurring'
    			);
    	$mock = $this->getMock('litle\sdk\LitleXmlMapper');
    	$mock->expects($this->once())
    	->method('request')
    	->with($this->matchesRegularExpression('/.*<processingType>initialRecurring.*/'));
    
    	$litleTest = new LitleOnlineRequest();
    	$litleTest->newXML = $mock;
    	$litleTest->forceCaptureRequest($hash_in);
    }
    
}
