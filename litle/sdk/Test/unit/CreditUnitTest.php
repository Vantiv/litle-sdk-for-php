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
class CreditUnitTest extends \PHPUnit_Framework_TestCase
{
    public function test_credit()
    {
        $hash_in = array('litleTxnId'=> '12312312','reportGroup'=>'Planets', 'amount'=>'123','id' => 'id',);
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*<litleTxnId>12312312.*<amount>123.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->creditRequest($hash_in);
    }

    public function test_both_choices_card_and_paypal()
    {
        $hash_in = array(
          'reportGroup'=>'Planets',
          'orderId'=>'12344',
          'id' => 'id',
          'amount'=>'106',
          'orderSource'=>'ecommerce',
          'card'=>array(
          'type'=>'VI',
          'number' =>'4100000000000001',
          'expDate' =>'1210'
        ),
          'paypal'=>array(
          'payerId'=>'1234',
          'token'=>'1234',
          'transactionId'=>'123456')
        );
        $litleTest = new LitleOnlineRequest();
        $this->setExpectedException('InvalidArgumentException',"Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!");
        $retOb = $litleTest->creditRequest($hash_in);
    }

    public function test_three_choices_card_and_paypage_and_paypal()
    {
        $hash_in = array(
          'reportGroup'=>'Planets',
          'orderId'=>'12344',
          'amount'=>'106',
          'id' => 'id',
          'orderSource'=>'ecommerce',
          'card'=>array(
          'type'=>'VI',
          'number' =>'4100000000000001',
          'expDate' =>'1210'
        ),
          'paypage'=> array(
          'paypageRegistrationId'=>'1234',
          'expDate'=>'1210',
          'cardValidationNum'=>'555',
          'type'=>'VI'),
          'paypal'=>array(
          'payerId'=>'1234',
          'token'=>'1234',
          'transactionId'=>'123456')
        );
        $litleTest = new LitleOnlineRequest();
        $this->setExpectedException('InvalidArgumentException',"Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!");
        $retOb = $litleTest->creditRequest($hash_in);

    }

    public function test_all_choices_card_and_paypage_and_paypal_and_token()
    {
        $hash_in = array(
          'reportGroup'=>'Planets',
          'id' => 'id',
          'litleTxnId'=>'123456',
          'orderId'=>'12344',
          'amount'=>'106',
          'orderSource'=>'ecommerce',
          'fraudCheck'=>array('authenticationTransactionId'=>'123'),
          'bypassVelocityCheckcardholderAuthentication'=>array('authenticationTransactionId'=>'123'),
          'card'=>array(
          'type'=>'VI',
          'number' =>'4100000000000001',
          'expDate' =>'1210'
        ),
          'paypage'=> array(
          'paypageRegistrationId'=>'1234',
          'expDate'=>'1210',
          'cardValidationNum'=>'555',
          'type'=>'VI'),
          'paypal'=>array(
          'payerId'=>'1234',
          'token'=>'1234',
          'transactionId'=>'123456'),
          'token'=> array(
          'litleToken'=>'1234',
          'expDate'=>'1210',
          'cardValidationNum'=>'555',
          'type'=>'VI')
        );
        $litleTest = new LitleOnlineRequest();
        $this->setExpectedException('InvalidArgumentException',"Entered an Invalid Amount of Choices for a Field, please only fill out one Choice!!!!");
        $retOb = $litleTest->creditRequest($hash_in);
    }

    public function test_action_reason_on_orphaned_refund()
    {
        $hash_in = array(
                    'orderId'=> '2111',
        		     'id' => 'id',
                    'orderSource'=>'ecommerce',
                    'amount'=>'123',
                    'actionReason'=>'SUSPECT_FRAUD'
        );
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*<actionReason>SUSPECT_FRAUD<\/actionReason>.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->creditRequest($hash_in);
    }

    public function test_loggedInUser()
    {
        $hash_in = array(
                'litleTxnId'=> '12312312',
        		'id' => 'id',
                'reportGroup'=>'Planets',
                'amount'=>'123',
                'merchantSdk'=>'PHP;10.1.0',
                'loggedInUser'=>'gdake');
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*merchantSdk="PHP;10.1.0".*loggedInUser="gdake" xmlns=.*>.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->creditRequest($hash_in);
    }

    public function test_surchargeAmount_tied()
    {
        $hash_in = array(
                'amount'=>'2',
        		'id' => 'id',
                'surchargeAmount'=>'1',
                'litleTxnId'=>'3',
                'processingInstructions'=>array(),
        );
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock
        ->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*<litleTxnId>3<\/litleTxnId><amount>2<\/amount><surchargeAmount>1<\/surchargeAmount><processing.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->creditRequest($hash_in);
    }

    public function test_surchargeAmount_tied_optional()
    {
        $hash_in = array(
                'amount'=>'2',
        		'id' => 'id',
                'litleTxnId'=>'3',
                'processingInstructions'=>array(),
        );
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock
        ->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*<litleTxnId>3<\/litleTxnId><amount>2<\/amount><processing.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->creditRequest($hash_in);
    }

    public function test_surchargeAmount_orphan()
    {
        $hash_in = array(
                'amount'=>'2',
        		'id' => 'id',
                'surchargeAmount'=>'1',
                'orderId'=>'3',
                'orderSource'=>'ecommerce',
        );
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock
        ->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*<amount>2<\/amount><surchargeAmount>1<\/surchargeAmount><orderSource>ecommerce<\/orderSource>.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->creditRequest($hash_in);
    }

    public function test_surchargeAmount_orphan_optional()
    {
        $hash_in = array(
                'amount'=>'2',
        		'id' => 'id',
                'orderId'=>'3',
                'orderSource'=>'ecommerce',
        );
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock
        ->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*<amount>2<\/amount><orderSource>ecommerce<\/orderSource>.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->creditRequest($hash_in);
    }

    public function test_pos_tied()
    {
        $hash_in = array(
                'amount'=>'2',
        		'id' => 'id',
                'pos'=>array(
                    'terminalId'=>'abc123',
                    'capability'=>'a',
                    'entryMode'=>'b',
                    'cardholderId'=>'c'
                ),
                'litleTxnId'=>'3',
                'payPalNotes'=>'notes',
        );
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock
        ->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*<litleTxnId>3<\/litleTxnId><amount>2<\/amount><pos>.*<terminalId>abc123<\/terminalId><\/pos><payPalNotes>.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->creditRequest($hash_in);
    }

    public function test_pos_tied_optional()
    {
        $hash_in = array(
                'amount'=>'2',
        		'id' => 'id',
                'litleTxnId'=>'3',
                'payPalNotes'=>'notes',
        );
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock
        ->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*<litleTxnId>3<\/litleTxnId><amount>2<\/amount><payPalNotes>.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->creditRequest($hash_in);
    }
    
    public function test_credit_with_secondaryAmount()
    {
    	$hash_in = array('litleTxnId'=> '12312312','reportGroup'=>'Planets', 'amount'=>'123', 'secondaryAmount' => '3214','id' => 'id',);
    	$mock = $this->getMock('litle\sdk\LitleXmlMapper');
    	$mock->expects($this->once())
    	->method('request')
    	->with($this->matchesRegularExpression('/.*<litleTxnId>12312312.*<amount>123.*/'));
    
    	$litleTest = new LitleOnlineRequest();
    	$litleTest->newXML = $mock;
    	$litleTest->creditRequest($hash_in);
    }
    
    public function test_pin_tied()
    {
    	$hash_in = array(
    			'litleTxnId'=> '1234567890',
    			'id' => 'id',
    			'reportGroup'=>'Planets', 
    			'amount'=>'123', 
    			'secondaryAmount' => '3214',
    			'surchargeAmount'=>'1',
    			'pin' => '3333'
    	);
    	$mock = $this->getMock('litle\sdk\LitleXmlMapper');
    	$mock
    	->expects($this->once())
    	->method('request')
    	->with($this->matchesRegularExpression('/.*<pin>3333*/'));
    
    	$litleTest = new LitleOnlineRequest();
    	$litleTest->newXML = $mock;
    	$litleTest->creditRequest($hash_in);
    }
    
    public function test_pin_tied_optional()
    {
    	$hash_in = array(
    			'litleTxnId'=> '1234567890',
    			'id' => 'id',
    			'reportGroup'=>'Planets',
    			'amount'=>'123',
    			'secondaryAmount' => '3214',
    			'surchargeAmount'=>'1'
    	);
    	$mock = $this->getMock('litle\sdk\LitleXmlMapper');
    	$mock
    	->expects($this->once())
    	->method('request')
    	->with($this->matchesRegularExpression('/.*<litleTxnId>1234567890.*<amount>123.*<secondaryAmount>3214.*<surchargeAmount>1.*/'));
    
    	$litleTest = new LitleOnlineRequest();
    	$litleTest->newXML = $mock;
    	$litleTest->creditRequest($hash_in);
    }

}
