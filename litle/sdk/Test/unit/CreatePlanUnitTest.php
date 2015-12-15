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
class CreatePlanUnitTest extends \PHPUnit_Framework_TestCase
{
    public function test_simple()
    {
        $hash_in = array(
            'planCode'=>'1',
            'name'=> '2',
        		'id' => 'id',
            'description'=>'3',
            'intervalType'=>'MONTHLY',
            'amount'=>'1000',
            'numberOfPayments'=>'5',
            'trialNumberOfIntervals'=>'6',
            'trialIntervalType'=>'WEEKLY',
            'active'=>'true'
        );
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock->expects($this->once())
        ->method('request')
        ->with($this->matchesRegularExpression('/.*planCode.*1.*name.*2.*description.*3.*intervalType.*MONTHLY.*amount.*1000.*numberOfPayments.*5.*trialNumberOfIntervals.*6.*trialIntervalType.*WEEKLY.*active.*true.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->createPlan($hash_in);
    }

    public function test_DescriptionIsOptional()
    {
        $hash_in = array(
            'planCode'=>'1',
            'name'=> '2',
        		'id' => 'id',
            'intervalType'=>'MONTHLY',
            'amount'=>'1000',
            'numberOfPayments'=>'5',
            'trialNumberOfIntervals'=>'6',
            'trialIntervalType'=>'WEEKLY',
            'active'=>'true'
        );
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock->expects($this->once())
        ->method('request')
        ->with($this->logicalNot($this->matchesRegularExpression('/.*description.*/')));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->createPlan($hash_in);
    }

    public function test_NumberOfPaymentsIsOptional()
    {
        $hash_in = array(
            'planCode'=>'1',
            'name'=> '2',
        		'id' => 'id',
            'intervalType'=>'MONTHLY',
            'amount'=>'1000',
            'trialNumberOfIntervals'=>'6',
            'trialIntervalType'=>'WEEKLY',
            'active'=>'true'
        );
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock->expects($this->once())
        ->method('request')
        ->with($this->logicalNot($this->matchesRegularExpression('/.*numberOfPayments.*/')));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->createPlan($hash_in);
    }

    public function test_TrialNumberOfIntervalsIsOptional()
    {
        $hash_in = array(
            'planCode'=>'1',
            'name'=> '2',
        		'id' => 'id',
            'intervalType'=>'MONTHLY',
            'amount'=>'1000',
            'numberOfPayments'=>'5',
            'trialIntervalType'=>'WEEKLY',
            'active'=>'true'
        );
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock->expects($this->once())
        ->method('request')
        ->with($this->logicalNot($this->matchesRegularExpression('/.*trialNumberOfIntervals.*/')));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->createPlan($hash_in);
    }

    public function test_TrialIntervalTypeIsOptional()
    {
        $hash_in = array(
            'planCode'=>'1',
            'name'=> '2',
        		'id' => 'id',
            'intervalType'=>'MONTHLY',
            'amount'=>'1000',
            'numberOfPayments'=>'5',
            'trialNumberOfIntervals'=>'6',
            'active'=>'true'
        );
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock->expects($this->once())
        ->method('request')
        ->with($this->logicalNot($this->matchesRegularExpression('/.*trialIntervalType.*/')));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->createPlan($hash_in);
    }

    public function test_ActiveIsOptional()
    {
        $hash_in = array(
            'planCode'=>'1',
            'name'=> '2',
        		'id' => 'id',
            'intervalType'=>'MONTHLY',
            'amount'=>'1000',
            'numberOfPayments'=>'5',
            'trialNumberOfIntervals'=>'6',
            'trialIntervalType'=>'WEEKLY'
        );
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock->expects($this->once())
        ->method('request')
        ->with($this->logicalNot($this->matchesRegularExpression('/.*active.*/')));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->createPlan($hash_in);
    }

}
