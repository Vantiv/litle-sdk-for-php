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
use litle\sdk\XmlParser;

require_once realpath(__DIR__) . '/../../../../vendor/autoload.php';

class CertAlphaTest extends \PHPUnit_Framework_TestCase
{
    function test_1_Auth()
    {
        $auth_hash = array('id' => '1211',
            #'user'=> '12312',
            'orderId' => '1',
            'amount' => '10010',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'John Smith',
                'addressLine1' => '1 Main St.',
                'city' => 'Burlington',
                'state' => 'MA',
                'zip' => '01803-3747',
                'country' => 'US'),
            'card' => array(
                'number' => '4457010000000009',
                'expDate' => '0112',
                'cardValidationNum' => '349',
                'type' => 'VI'));
        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        $this->assertEquals('11111', trim(XmlParser::getNode($authorizationResponse, 'authCode')));
        $this->assertEquals('1', XmlParser::getNode($authorizationResponse, 'avsResult'));
        $this->assertEquals('M', XmlParser::getNode($authorizationResponse, 'cardValidationResult'));

        //test 1A
        $capture_hash = array(
            'litleTxnId' => (XmlParser::getNode($authorizationResponse, 'litleTxnId')),
            'reportGroup' => 'planets', 'id' => '1211',);
        $initialize = new LitleOnlineRequest();
        $captureResponse = $initialize->captureRequest($capture_hash);
        $this->assertEquals('000', XmlParser::getNode($captureResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($captureResponse, 'message'));

        //test 1B
        $credit_hash = array(
            'litleTxnId' => (XmlParser::getNode($captureResponse, 'litleTxnId')),
            'reportGroup' => 'planets', 'id' => '1211',);
        $initialize = new LitleOnlineRequest();
        $creditResponse = $initialize->creditRequest($credit_hash);
        $this->assertEquals('000', XmlParser::getNode($creditResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($creditResponse, 'message'));

        //test 1C
        $void_hash = array(
            'litleTxnId' => (XmlParser::getNode($creditResponse, 'litleTxnId')),
            'reportGroup' => 'planets', 'id' => '1211',);
        $initialize = new LitleOnlineRequest();
        $voidResponse = $initialize->voidRequest($void_hash);
        $this->assertEquals('000', XmlParser::getNode($voidResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($voidResponse, 'message'));
    }

    function test_1_avs()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '1',
            'amount' => '0',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'John Smith',
                'addressLine1' => '1 Main St.',
                'city' => 'Burlington',
                'state' => 'MA',
                'zip' => '01803-3747',
                'country' => 'US'),
            'card' => array(
                'number' => '4457010000000009',
                'expDate' => '0112',
                'cardValidationNum' => '349',
                'type' => 'VI'));
        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        $this->assertEquals('11111', trim(XmlParser::getNode($authorizationResponse, 'authCode')));
        $this->assertEquals('1', XmlParser::getNode($authorizationResponse, 'avsResult'));
        $this->assertEquals('M', XmlParser::getNode($authorizationResponse, 'cardValidationResult'));
    }

    function test_1_sale()
    {
        $sale_hash = array('id' => '1211',
            'orderId' => '1',
            'amount' => '10010',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'John Smith',
                'addressLine1' => '1 Main St.',
                'city' => 'Burlington',
                'state' => 'MA',
                'zip' => '01803-3747',
                'country' => 'US'),
            'card' => array(
                'number' => '4457010000000009',
                'expDate' => '0112',
                'cardValidationNum' => '349',
                'type' => 'VI'));
        $initialize = new LitleOnlineRequest();
        $saleResponse = $initialize->saleRequest($sale_hash);
        $this->assertEquals('000', XmlParser::getNode($saleResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($saleResponse, 'message'));
        $this->assertEquals('11111', trim(XmlParser::getNode($saleResponse, 'authCode')));
        $this->assertEquals('1', XmlParser::getNode($saleResponse, 'avsResult'));
        $this->assertEquals('M', XmlParser::getNode($saleResponse, 'cardValidationResult'));

        $credit_hash = array(
            'litleTxnId' => (XmlParser::getNode($saleResponse, 'litleTxnId')),
            'reportGroup' => 'planets', 'id' => '1211',);
        $initialize = new LitleOnlineRequest();
        $creditResponse = $initialize->creditRequest($credit_hash);
        $this->assertEquals('000', XmlParser::getNode($creditResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($creditResponse, 'message'));

        $void_hash = array(
            'litleTxnId' => (XmlParser::getNode($creditResponse, 'litleTxnId')),
            'reportGroup' => 'planets', 'id' => '1211',);
        $initialize = new LitleOnlineRequest();
        $voidResponse = $initialize->voidRequest($void_hash);
        $this->assertEquals('000', XmlParser::getNode($voidResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($voidResponse, 'message'));
    }

    function test_2_Auth()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '2',
            'amount' => '20020',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Mike J. Hammer',
                'addressLine1' => '2 Main St.',
                'addressLine2' => 'Apt. 222',
                'city' => 'Riverside',
                'state' => 'RI',
                'zip' => '02915',
                'country' => 'US'),
            'card' => array(
                'number' => '5112010000000003',
                'expDate' => '0212',
                'cardValidationNum' => '261',
                'type' => 'MC'),
            //TODO 3-D Secure transaction not supported by merchant
            //'cardholderAuthentication' => array('authenticationValue'=>'BwABBJQ1AgAAAAAgJDUCAAAAAAA=' )
        );

        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        $this->assertEquals('22222', trim(XmlParser::getNode($authorizationResponse, 'authCode')));
        $this->assertEquals('10', XmlParser::getNode($authorizationResponse, 'avsResult'));
        $this->assertEquals('M', XmlParser::getNode($authorizationResponse, 'cardValidationResult'));

        //test 2A
        $capture_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($authorizationResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $captureResponse = $initialize->captureRequest($capture_hash);
        $this->assertEquals('000', XmlParser::getNode($captureResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($captureResponse, 'message'));

        //test 2B
        $credit_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($captureResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $creditResponse = $initialize->creditRequest($credit_hash);
        $this->assertEquals('000', XmlParser::getNode($creditResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($creditResponse, 'message'));

        //test 2C
        $void_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($creditResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $voidResponse = $initialize->voidRequest($void_hash);
        $this->assertEquals('000', XmlParser::getNode($voidResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($voidResponse, 'message'));
    }

    function test_2_avs()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '2',
            'amount' => '0',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Mike J. Hammer',
                'addressLine1' => '2 Main St.',
                'addressLine2' => 'Apt. 222',
                'city' => 'Riverside',
                'state' => 'RI',
                'zip' => '02915',
                'country' => 'US'),
            'card' => array(
                'number' => '5112010000000003',
                'expDate' => '0212',
                'cardValidationNum' => '261',
                'type' => 'MC'),
            //TODO 3-D Secure transaction not supported by merchant
            //'cardholderAuthentication' => array('authenticationValue'=>'BwABBJQ1AgAAAAAgJDUCAAAAAAA=' )
        );

        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        $this->assertEquals('22222', trim(XmlParser::getNode($authorizationResponse, 'authCode')));
        $this->assertEquals('10', XmlParser::getNode($authorizationResponse, 'avsResult'));
        $this->assertEquals('M', XmlParser::getNode($authorizationResponse, 'cardValidationResult'));
    }

    function test_2_sale()
    {
        $sale_hash = array('id' => '1211',
            'orderId' => '2',
            'amount' => '20020',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Mike J. Hammer',
                'addressLine1' => '2 Main St.',
                'addressLine2' => 'Apt. 222',
                'city' => 'Riverside',
                'state' => 'RI',
                'zip' => '02915',
                'country' => 'US'),
            'card' => array(
                'number' => '5112010000000003',
                'expDate' => '0212',
                'cardValidationNum' => '261',
                'type' => 'MC'),
            'cardholderAuthentication' => array('authenticationValue' => 'BwABBJQ1AgAAAAAgJDUCAAAAAAA='));

        $initialize = new LitleOnlineRequest();
        $saleResponse = $initialize->saleRequest($sale_hash);
        $this->assertEquals('000', XmlParser::getNode($saleResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($saleResponse, 'message'));
        $this->assertEquals('22222', trim(XmlParser::getNode($saleResponse, 'authCode')));
        $this->assertEquals('10', XmlParser::getNode($saleResponse, 'avsResult'));
        $this->assertEquals('M', XmlParser::getNode($saleResponse, 'cardValidationResult'));

        //test 2B
        $credit_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($saleResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $creditResponse = $initialize->creditRequest($credit_hash);
        $this->assertEquals('000', XmlParser::getNode($creditResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($creditResponse, 'message'));

        //test 2C
        $void_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($creditResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $voidResponse = $initialize->voidRequest($void_hash);
        $this->assertEquals('000', XmlParser::getNode($voidResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($voidResponse, 'message'));
    }

    function test_3_Auth()
    {
        $auth_hash = array(
            'orderId' => '3', 'id' => '1211',
            'amount' => '30030',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Eileen Jones',
                'addressLine1' => '3 Main St.',
                'city' => 'Bloomfield',
                'state' => 'CT',
                'zip' => '06002',
                'country' => 'US'),
            'card' => array(
                'number' => '6011010000000003',
                'expDate' => '0312',
                'type' => 'DI',
                'cardValidationNum' => '758'));

        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        $this->assertEquals('33333', trim(XmlParser::getNode($authorizationResponse, 'authCode')));
        $this->assertEquals('10', XmlParser::getNode($authorizationResponse, 'avsResult'));
        $this->assertEquals('M', XmlParser::getNode($authorizationResponse, 'cardValidationResult'));

        //test 3A
        $capture_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($authorizationResponse, 'litleTxnId')),
            'reportGroup' => 'planets', 'id' => '1211',);
        $initialize = new LitleOnlineRequest();
        $captureResponse = $initialize->captureRequest($capture_hash);
        $this->assertEquals('000', XmlParser::getNode($captureResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($captureResponse, 'message'));

        //test 3B
        $credit_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($captureResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $creditResponse = $initialize->creditRequest($credit_hash);
        $this->assertEquals('000', XmlParser::getNode($creditResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($creditResponse, 'message'));

        //test 3C
        $void_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($creditResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $voidResponse = $initialize->voidRequest($void_hash);
        $this->assertEquals('000', XmlParser::getNode($voidResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($voidResponse, 'message'));
    }

    function test_3_avs()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '3',
            'amount' => '0',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Eileen Jones',
                'addressLine1' => '3 Main St.',
                'city' => 'Bloomfield',
                'state' => 'CT',
                'zip' => '06002',
                'country' => 'US'),
            'card' => array(
                'number' => '6011010000000003',
                'expDate' => '0312',
                'type' => 'DI',
                'cardValidationNum' => '758'));
        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        $this->assertEquals('33333', trim(XmlParser::getNode($authorizationResponse, 'authCode')));
        $this->assertEquals('10', XmlParser::getNode($authorizationResponse, 'avsResult'));
        $this->assertEquals('M', XmlParser::getNode($authorizationResponse, 'cardValidationResult'));
    }

    function test_3_sale()
    {
        $sale_hash = array('id' => '1211',
            'orderId' => '3',
            'amount' => '30030',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Eileen Jones',
                'addressLine1' => '3 Main St.',
                'city' => 'Bloomfield',
                'state' => 'CT',
                'zip' => '06002',
                'country' => 'US'),
            'card' => array(
                'number' => '6011010000000003',
                'expDate' => '0312',
                'type' => 'DI',
                'cardValidationNum' => '758'));

        $initialize = new LitleOnlineRequest();
        $saleResponse = $initialize->saleRequest($sale_hash);
        $this->assertEquals('000', XmlParser::getNode($saleResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($saleResponse, 'message'));
        $this->assertEquals('33333', trim(XmlParser::getNode($saleResponse, 'authCode')));
        $this->assertEquals('10', XmlParser::getNode($saleResponse, 'avsResult'));
        $this->assertEquals('M', XmlParser::getNode($saleResponse, 'cardValidationResult'));

        //test 3B
        $credit_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($saleResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $creditResponse = $initialize->creditRequest($credit_hash);
        $this->assertEquals('000', XmlParser::getNode($creditResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($creditResponse, 'message'));

        //test 3C
        $void_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($creditResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $voidResponse = $initialize->voidRequest($void_hash);
        $this->assertEquals('000', XmlParser::getNode($voidResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($voidResponse, 'message'));
    }

    function test_4_Auth()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '4',
            'amount' => '40040',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Bob Black',
                'addressLine1' => '4 Main St.',
                'city' => 'Laurel',
                'state' => 'MD',
                'zip' => '20708',
                'country' => 'US'),
            'card' => array(
                'number' => '375001000000005',
                'expDate' => '0412',
                'type' => 'AX'));

        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        //TODO Processing Network Unavailable
        //$this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
        //$this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
        //$this->assertEquals('44444',XmlParser::getNode($authorizationResponse,'authCode'));
        //$this->assertEquals('12',XmlParser::getNode($authorizationResponse,'avsResult'));

        //test 4A
        $capture_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($authorizationResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $captureResponse = $initialize->captureRequest($capture_hash);
        #$this->assertEquals('000',XmlParser::getNode($captureResponse,'response'));
        $this->assertEquals('Approved', XmlParser::getNode($captureResponse, 'message'));

        //test 4B
        $credit_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($captureResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $creditResponse = $initialize->creditRequest($credit_hash);
        $this->assertEquals('000', XmlParser::getNode($creditResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($creditResponse, 'message'));

        //test 4C
        $void_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($creditResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $voidResponse = $initialize->voidRequest($void_hash);
        $this->assertEquals('000', XmlParser::getNode($voidResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($voidResponse, 'message'));
    }

    function test_4_avs()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '4',
            'amount' => '0',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Bob Black',
                'addressLine1' => '4 Main St.',
                'city' => 'Laurel',
                'state' => 'MD',
                'zip' => '20708',
                'country' => 'US'),
            'card' => array(
                'number' => '375001000000005',
                'expDate' => '0412',
                'type' => 'AX'));

        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        //TODO Processing Network Unavailable
        //$this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
        //$this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
        //$this->assertEquals('44444',XmlParser::getNode($authorizationResponse,'authCode'));
        //$this->assertEquals('12',XmlParser::getNode($authorizationResponse,'avsResult'));

    }

    function test_4_sale()
    {
        $sale_hash = array('id' => '1211',
            'orderId' => '4',
            'amount' => '40040',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Bob Black',
                'addressLine1' => '4 Main St.',
                'city' => 'Laurel',
                'state' => 'MD',
                'zip' => '20708',
                'country' => 'US'),
            'card' => array(
                'number' => '375001000000005',
                'expDate' => '0412',
                'type' => 'AX'));

        $initialize = new LitleOnlineRequest();
        $saleResponse = $initialize->saleRequest($sale_hash);
        //TODO Processing Network Unavailable
        //$this->assertEquals('000',XmlParser::getNode($saleResponse,'response'));
        //$this->assertEquals('Approved',XmlParser::getNode($saleResponse,'message'));
        //$this->assertEquals('44444',XmlParser::getNode($saleResponse,'authCode'));
        //$this->assertEquals('12',XmlParser::getNode($saleResponse,'avsResult'));

        //test 4B
        $credit_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($saleResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $creditResponse = $initialize->creditRequest($credit_hash);
        $this->assertEquals('000', XmlParser::getNode($creditResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($creditResponse, 'message'));

        //test 4C
        $void_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($creditResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $voidResponse = $initialize->voidRequest($void_hash);
        $this->assertEquals('000', XmlParser::getNode($voidResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($voidResponse, 'message'));
    }

    function test_5_auth()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '5',
            'amount' => '50050',
            'orderSource' => 'ecommerce',
            'card' => array(
                'number' => '4457010200000007',
                'expDate' => '0512',
                'cardValidationNum' => '463',
                'type' => 'VI'),
            //TODO 3-D Secure transaction not supported by merchant
            //'cardholderAuthentication' => array('authenticationValue'=> 'BwABBJQ1AgAAAAAgJDUCAAAAAAA=')
        );

        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        $this->assertEquals('55555', trim(XmlParser::getNode($authorizationResponse, 'authCode')));
        $this->assertEquals('32', XmlParser::getNode($authorizationResponse, 'avsResult'));
        $this->assertEquals('M', XmlParser::getNode($authorizationResponse, 'cardValidationResult'));

        //test 5A
        $capture_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($authorizationResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $captureResponse = $initialize->captureRequest($capture_hash);
        $this->assertEquals('000', XmlParser::getNode($captureResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($captureResponse, 'message'));

        //test 5B
        $credit_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($captureResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $creditResponse = $initialize->creditRequest($credit_hash);
        $this->assertEquals('000', XmlParser::getNode($creditResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($creditResponse, 'message'));

        //test 5C
        $void_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($creditResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $voidResponse = $initialize->voidRequest($void_hash);
        $this->assertEquals('000', XmlParser::getNode($voidResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($voidResponse, 'message'));
    }

    function test_5_avs()
    {
        $auth_hash = array('id' => '1211',
            'orderId' => '5',
            'amount' => '0',
            'orderSource' => 'ecommerce',
            'card' => array(
                'number' => '4457010200000007',
                'expDate' => '0512',
                'cardValidationNum' => '463',
                'type' => 'VI'),
            //TODO 3-D Secure transaction not supported by merchant
            //'cardholderAuthentication' => array('authenticationValue'=> 'BwABBJQ1AgAAAAAgJDUCAAAAAAA=')
        );

        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        $this->assertEquals('55555 ', XmlParser::getNode($authorizationResponse, 'authCode'));
        $this->assertEquals('32', XmlParser::getNode($authorizationResponse, 'avsResult'));
        $this->assertEquals('M', XmlParser::getNode($authorizationResponse, 'cardValidationResult'));
    }

    function test_5_sale()
    {
        $sale_hash = array('id' => '1211',
            'orderId' => '5',
            'amount' => '50050',
            'orderSource' => 'ecommerce',
            'card' => array(
                'number' => '4457010200000007',
                'expDate' => '0512',
                'cardValidationNum' => '463',
                'type' => 'VI'),
            //TODO 3-D Secure transaction not supported by merchant
            //'cardholderAuthentication' => array('authenticationValue'=> 'BwABBJQ1AgAAAAAgJDUCAAAAAAA=')
        );

        $initialize = new LitleOnlineRequest();
        $saleResponse = $initialize->saleRequest($sale_hash);
        $this->assertEquals('000', XmlParser::getNode($saleResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($saleResponse, 'message'));
        $this->assertEquals('55555 ', XmlParser::getNode($saleResponse, 'authCode'));
        $this->assertEquals('32', XmlParser::getNode($saleResponse, 'avsResult'));
        $this->assertEquals('M', XmlParser::getNode($saleResponse, 'cardValidationResult'));

        //test 5B
        $credit_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($saleResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $creditResponse = $initialize->creditRequest($credit_hash);
        $this->assertEquals('000', XmlParser::getNode($creditResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($creditResponse, 'message'));

        //test 5C
        $void_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($creditResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $voidResponse = $initialize->voidRequest($void_hash);
        $this->assertEquals('000', XmlParser::getNode($voidResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($voidResponse, 'message'));
    }

    function test_6_auth()
    {
        $hash = array('id' => '1211',
            'orderId' => '6',
            'amount' => '10010',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Joe Green',
                'addressLine1' => '6 Main St.',
                'city' => 'Derry',
                'state' => 'NH',
                'zip' => '03038',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '4457010100000008',
                'expDate' => '0621',
                'cardValidationNum' => '992',
                'type' => 'VI'
            )
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        $this->assertEquals('110', XmlParser::getNode($response, 'response'));
        $this->assertEquals('Insufficient Funds', XmlParser::getNode($response, 'message'));
        $this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
        $this->assertEquals('P', XmlParser::getNode($response, 'cardValidationResult'));
    }

    function test_6_sale()
    {
        $hash = array('id' => '1211',
            'orderId' => '6',
            'amount' => '10010',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Joe Green',
                'addressLine1' => '6 Main St.',
                'city' => 'Derry',
                'state' => 'NH',
                'zip' => '03038',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '4457010100000008',
                'expDate' => '0621',
                'cardValidationNum' => '992',
                'type' => 'VI'
            )
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->saleRequest($hash);
        $this->assertEquals('110', XmlParser::getNode($response, 'response'));
        $this->assertEquals('Insufficient Funds', XmlParser::getNode($response, 'message'));
        $this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
        $this->assertEquals('P', XmlParser::getNode($response, 'cardValidationResult'));

        //test 6a
        $hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($response, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $response = $initialize->voidRequest($hash);
        $this->assertEquals('000', XmlParser::getNode($response, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($response, 'message'));
    }

    function test_7_auth()
    {
        $hash = array('id' => '1211',
            'orderId' => '7',
            'amount' => '10010',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Jane Murray',
                'addressLine1' => '7 Main St.',
                'city' => 'Amesbury',
                'state' => 'MA',
                'zip' => '01913',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '5112010100000002',
                'expDate' => '0721',
                'cardValidationNum' => '251',
                'type' => 'MC'
            )
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        $this->assertEquals('301', XmlParser::getNode($response, 'response'));
        $this->assertEquals('Invalid Account Number', XmlParser::getNode($response, 'message'));
        $this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
        $this->assertEquals('N', XmlParser::getNode($response, 'cardValidationResult'));
    }

    function test_7_avs()
    {
        $hash = array('id' => '1211',
            'orderId' => '7',
            'amount' => '000',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Jane Murray',
                'addressLine1' => '7 Main St.',
                'city' => 'Amesbury',
                'state' => 'MA',
                'zip' => '01913',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '5112010100000002',
                'expDate' => '0721',
                'cardValidationNum' => '251',
                'type' => 'MC'
            )
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        $this->assertEquals('301', XmlParser::getNode($response, 'response'));
        $this->assertEquals('Invalid Account Number', XmlParser::getNode($response, 'message'));
        $this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
        $this->assertEquals('N', XmlParser::getNode($response, 'cardValidationResult'));
    }

    function test_7_sale()
    {
        $hash = array('id' => '1211',
            'orderId' => '7',
            'amount' => '10100',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Jane Murray',
                'addressLine1' => '7 Main St.',
                'city' => 'Amesbury',
                'state' => 'MA',
                'zip' => '01913',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '5112010100000002',
                'expDate' => '0721',
                'cardValidationNum' => '251',
                'type' => 'MC'
            )
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->saleRequest($hash);
        $this->assertEquals('301', XmlParser::getNode($response, 'response'));
        $this->assertEquals('Invalid Account Number', XmlParser::getNode($response, 'message'));
        $this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
        $this->assertEquals('N', XmlParser::getNode($response, 'cardValidationResult'));
    }

    function test_8_auth()
    {
        $hash = array('id' => '1211',
            'orderId' => '8',
            'amount' => '10010',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Mark Johnson',
                'addressLine1' => '8 Main St.',
                'city' => 'Manchester',
                'state' => 'NH',
                'zip' => '03101',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '6011010100000002',
                'expDate' => '0821',
                'cardValidationNum' => '184',
                'type' => 'DI'
            )
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        $this->assertEquals('123', XmlParser::getNode($response, 'response'));
        $this->assertEquals('Call Discover', XmlParser::getNode($response, 'message'));
        $this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
        $this->assertEquals('P', XmlParser::getNode($response, 'cardValidationResult'));
    }


    function test_8_avs()
    {
        $hash = array('id' => '1211',
            'orderId' => '8',
            'amount' => '000',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Mark Johnson',
                'addressLine1' => '8 Main St.',
                'city' => 'Manchester',
                'state' => 'NH',
                'zip' => '03101',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '6011010100000002',
                'expDate' => '0821',
                'cardValidationNum' => '184',
                'type' => 'DI'
            )
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        $this->assertEquals('123', XmlParser::getNode($response, 'response'));
        $this->assertEquals('Call Discover', XmlParser::getNode($response, 'message'));
        $this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
        $this->assertEquals('P', XmlParser::getNode($response, 'cardValidationResult'));
    }

    function test_8_sale()
    {
        $hash = array('id' => '1211',
            'orderId' => '8',
            'amount' => '10010',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'Mark Johnson',
                'addressLine1' => '8 Main St.',
                'city' => 'Manchester',
                'state' => 'NH',
                'zip' => '03101',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '6011010100000002',
                'expDate' => '0821',
                'cardValidationNum' => '184',
                'type' => 'DI'
            )
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->saleRequest($hash);
        $this->assertEquals('123', XmlParser::getNode($response, 'response'));
        $this->assertEquals('Call Discover', XmlParser::getNode($response, 'message'));
        $this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
        $this->assertEquals('P', XmlParser::getNode($response, 'cardValidationResult'));
    }

    function test_9_auth()
    {
        $hash = array('id' => '1211',
            'orderId' => '9',
            'amount' => '10010',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'James Miller',
                'addressLine1' => '9 Main St.',
                'city' => 'Boston',
                'state' => 'MA',
                'zip' => '02134',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '375001010000003',
                'expDate' => '0921',
                'cardValidationNum' => '0421',
                'type' => 'AX'
            )
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        //TODO Processing Network Unavailable
        //$this->assertEquals('303', XmlParser::getNode($response, 'response'));
        //$this->assertEquals('Pick Up Card', XmlParser::getNode($response, 'message'));
        //$this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
        //$this->assertEquals('P', XmlParser::getNode($response, 'cardValidationResult'));
    }

    function test_9_avs()
    {
        $hash = array('id' => '1211',
            'orderId' => '9',
            'amount' => '000',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'James Miller',
                'addressLine1' => '9 Main St.',
                'city' => 'Boston',
                'state' => 'MA',
                'zip' => '02134',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '375001010000003',
                'expDate' => '0921',
                'cardValidationNum' => '0421',
                'type' => 'AX'
            )
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        //TODO Processing Network Unavailable
        //$this->assertEquals('303', XmlParser::getNode($response, 'response'));
        //$this->assertEquals('Pick Up Card', XmlParser::getNode($response, 'message'));
        //$this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
        //$this->assertEquals('P', XmlParser::getNode($response, 'cardValidationResult'));
    }

    function test_9_sale()
    {
        $hash = array('id' => '1211',
            'orderId' => '9',
            'amount' => '10010',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'James Miller',
                'addressLine1' => '9 Main St.',
                'city' => 'Boston',
                'state' => 'MA',
                'zip' => '02134',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '375001010000003',
                'expDate' => '0921',
                'cardValidationNum' => '0421',
                'type' => 'AX'
            )
        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->saleRequest($hash);
        //TODO Processing Network Unavailable
        //$this->assertEquals('303', XmlParser::getNode($response, 'response'));
        //$this->assertEquals('Pick Up Card', XmlParser::getNode($response, 'message'));
        //$this->assertEquals('34', XmlParser::getNode($response, 'avsResult'));
        //$this->assertEquals('P', XmlParser::getNode($response, 'cardValidationResult'));
    }

    function test_10_auth()
    {
        $hash = array(
            'id' => 'thisisid',
            'orderId' => '10',
            'amount' => '40000',
            'orderSource' => 'ecommerce',
            'allowPartialAuth' => 'true',
            'card' => array(
                'number' => '4457010140000141',
                'expDate' => '0921',
                'type' => 'VI'
            ),

        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        $this->assertEquals('010', XmlParser::getNode($response, 'response'));
        $this->assertEquals('Partially Approved', XmlParser::getNode($response, 'message'));
        $this->assertEquals(32000, XmlParser::getNode($response, 'approvedAmount'));
    }

    function test_11_auth()
    {
        $hash = array(
            'id' => 'thisisid',
            'orderId' => '11',
            'amount' => '60000',
            'orderSource' => 'ecommerce',
            'allowPartialAuth' => 'true',
            'card' => array(
                'number' => '5112010140000004',
                'expDate' => '1121',
                'type' => 'MC'
            ),

        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        $this->assertEquals('010', XmlParser::getNode($response, 'response'));
        $this->assertEquals('Partially Approved', XmlParser::getNode($response, 'message'));
        $this->assertEquals(48000, XmlParser::getNode($response, 'approvedAmount'));
    }

    function test_12_auth()
    {
        $hash = array(
            'id' => 'thisisid',
            'orderId' => '12',
            'amount' => '50000',
            'orderSource' => 'ecommerce',
            'allowPartialAuth' => 'true',
            'card' => array(
                'number' => '375001014000009',
                'expDate' => '0421',
                'type' => 'AX'
            ),

        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        //TODO Processing Network Unavailable
        //$this->assertEquals('010', XmlParser::getNode($response, 'response'));
        //$this->assertEquals('Partially Approved', XmlParser::getNode($response, 'message'));
        //$this->assertEquals(40000, XmlParser::getNode($response, 'approvedAmount'));
    }

    function test_13_auth()
    {
        $hash = array(
            'id' => 'thisisid',
            'orderId' => '13',
            'amount' => '15000',
            'orderSource' => 'ecommerce',
            'allowPartialAuth' => 'true',
            'card' => array(
                'number' => '6011010140000004',
                'expDate' => '0821',
                'type' => 'DI'
            ),

        );

        $initialize = new LitleOnlineRequest();
        $response = $initialize->authorizationRequest($hash);
        $this->assertEquals('010', XmlParser::getNode($response, 'response'));
        $this->assertEquals('Partially Approved', XmlParser::getNode($response, 'message'));
        $this->assertEquals(12000, XmlParser::getNode($response, 'approvedAmount'));
    }
}
