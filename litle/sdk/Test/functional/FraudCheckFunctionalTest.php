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

class FraudCheckFunctionalTest extends \PHPUnit_Framework_TestCase
{

    public function test_no_customAttributes()
    {
        $hash_in = array(
            'id' => 'id',
            'advancedFraudChecks' => array(
                'threatMetrixSessionId' => 128)
        );

        $initialize = new LitleOnlineRequest();
        $fraudCheckResponse = $initialize->fraudCheck($hash_in);
        $response = XmlParser::getNode($fraudCheckResponse, 'response');
        $this->assertEquals('000', $response);
    }

    public function test_one_customAttributes()
    {
        $hash_in = array(
            'id' => 'id',
            'advancedFraudChecks' => array(
                'threatMetrixSessionId' => 128,
                'customAttribute1' => 'abc')
        );

        $initialize = new LitleOnlineRequest();
        $fraudCheckResponse = $initialize->fraudCheck($hash_in);
        $message = XmlParser::getNode($fraudCheckResponse, 'deviceReviewStatus');
        $this->assertEquals('pass', $message);
    }

    public function test_two_customAttributes()
    {
        $hash_in = array(
            'id' => 'id',
            'advancedFraudChecks' => array(
                'threatMetrixSessionId' => 128,
                'customAttribute1' => 'abc',
                'customAttribute2' => 'def')
        );

        $initialize = new LitleOnlineRequest();
        $fraudCheckResponse = $initialize->fraudCheck($hash_in);
        $message = XmlParser::getNode($fraudCheckResponse, 'triggeredRule');
        $this->assertEquals('triggered_rule_default', $message);
    }

    public function test_three_customAttributes()
    {
        $hash_in = array(
            'id' => 'id',
            'advancedFraudChecks' => array(
                'threatMetrixSessionId' => 128,
                'customAttribute1' => 'abc',
                'customAttribute2' => 'def',
                'customAttribute3' => '7')
        );

        $initialize = new LitleOnlineRequest();
        $fraudCheckResponse = $initialize->fraudCheck($hash_in);
        //echo $fraudCheckResponse->advancedFraudResults->triggeredRule[0];
        $message = XmlParser::getNode($fraudCheckResponse, 'triggeredRule');
        $this->assertEquals('triggered_rule_7', $message);
    }

    public function test_four_customAttributes()
    {
        $hash_in = array(
            'id' => 'id',
            'advancedFraudChecks' => array(
                'threatMetrixSessionId' => 128,
                'customAttribute1' => 'abc',
                'customAttribute2' => 'def',
                'customAttribute3' => 'ghi',
                'customAttribute4' => 'jkl')
        );

        $initialize = new LitleOnlineRequest();
        $fraudCheckResponse = $initialize->fraudCheck($hash_in);
        $message = XmlParser::getNode($fraudCheckResponse, 'deviceReputationScore');
        $this->assertEquals('42', $message);
    }

    public function test_five_customAttributes()
    {
        $hash_in = array(
            'id' => 'id',
            'advancedFraudChecks' => array(
                'threatMetrixSessionId' => 128,
                'customAttribute1' => 'abc',
                'customAttribute2' => 'def',
                'customAttribute3' => 'ghi',
                'customAttribute4' => 'jkl',
                'customAttribute5' => 'mno')
        );

        $initialize = new LitleOnlineRequest();
        $fraudCheckResponse = $initialize->fraudCheck($hash_in);
        $response = XmlParser::getNode($fraudCheckResponse, 'response');
        $this->assertEquals('000', $response);
    }

    public function test_amount()
    {
        $hash_in = array(
            'id' => 'id',
            'advancedFraudChecks' => array(
                'threatMetrixSessionId' => 128),
            'amount' => 100
        );

        $initialize = new LitleOnlineRequest();
        $fraudCheckResponse = $initialize->fraudCheck($hash_in);
        $message = XmlParser::getNode($fraudCheckResponse, 'deviceReviewStatus');
        $this->assertEquals('pass', $message);
    }

    public function test_billToAddress()
    {
        $hash_in = array(
            'id' => 'id',
            'advancedFraudChecks' => array(
                'threatMetrixSessionId' => 128),
            'billToAddress' => array(
                'firstName' => 'Fetty',
                'lastName' => 'Wap',
                'addressLine1' => '1738 Trap Street',
                'city' => 'Queens',
                'state' => 'New York',
                'zip' => '11412'
            ),
            'shipToAddress' => array(
                'firstName' => 'Johnny',
                'lastName' => 'Appleseed',
                'addressLine1' => "16 Maple Way",
                'city' => 'Orchard',
                'state' => 'California',
                'zip' => '13579'
            )
        );

        $initialize = new LitleOnlineRequest();
        $fraudCheckResponse = $initialize->fraudCheck($hash_in);
        $message = XmlParser::getNode($fraudCheckResponse, 'deviceReputationScore');
        $this->assertEquals('42', $message);
    }

    public function test_shipToAddress()
    {
        $hash_in = array(
            'id' => 'id',
            'advancedFraudChecks' => array(
                'threatMetrixSessionId' => 128),
            'shipToAddress' => array(
                'firstName' => 'Johnny',
                'lastName' => 'Appleseed',
                'addressLine1' => "16 Maple Way",
                'city' => 'Orchard',
                'state' => 'California',
                'zip' => '13579'
            )
        );

        $initialize = new LitleOnlineRequest();
        $fraudCheckResponse = $initialize->fraudCheck($hash_in);
        $response = XmlParser::getNode($fraudCheckResponse, 'response');
        $this->assertEquals('000', $response);
    }
}