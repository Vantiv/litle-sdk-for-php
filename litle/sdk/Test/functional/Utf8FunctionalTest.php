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

class Utf8FunctionalTest extends \PHPUnit_Framework_TestCase
{
    public function test_simple_auth_with_card()
    {
        $hash_in = array(
            'card' => array('type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'PlanetsРусский中文',
            'orderSource' => 'ecommerce',
            'amount' => '0');

        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($hash_in);
        $response = XmlParser::getNode($authorizationResponse, 'response');
        $this->assertEquals('000', $response);
        $this->assertEquals('PlanetsРусский中文', XmlParser::getAttribute($authorizationResponse, 'authorizationResponse', 'reportGroup'));
        $this->assertEquals('63225578415568556365452427825', XmlParser::getNode($authorizationResponse, 'networkTransactionId'));
    }
}
