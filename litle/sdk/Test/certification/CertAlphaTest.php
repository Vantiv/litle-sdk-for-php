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
        //TODO: getting blank auth code
        //$this->assertEquals('11111', trim(XmlParser::getNode($authorizationResponse, 'authCode')));
        //$this->assertEquals('1', XmlParser::getNode($authorizationResponse, 'avsResult'));
        //$this->assertEquals('M', XmlParser::getNode($authorizationResponse, 'cardValidationResult'));

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
        //TODO: Getting blank authCode
        //$this->assertEquals('11111', trim(XmlParser::getNode($authorizationResponse, 'authCode')));
        //$this->assertEquals('1', XmlParser::getNode($authorizationResponse, 'avsResult'));
        //$this->assertEquals('M', XmlParser::getNode($authorizationResponse, 'cardValidationResult'));
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
        //$this->assertEquals('000', XmlParser::getNode($saleResponse, 'response'));
       // $this->assertEquals('Approved', XmlParser::getNode($saleResponse, 'message'));
        //TODO: Getting 05890 as authcode
        //$this->assertEquals('11111', trim(XmlParser::getNode($saleResponse, 'authCode')));
        //$this->assertEquals('1', XmlParser::getNode($saleResponse, 'avsResult'));
        //$this->assertEquals('M', XmlParser::getNode($saleResponse, 'cardValidationResult'));

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
       // $this->assertEquals('000', XmlParser::getNode($voidResponse, 'response'));
      //  $this->assertEquals('Approved', XmlParser::getNode($voidResponse, 'message'));
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
        //TODO: getting empty authcode
        //$this->assertEquals('22222', trim(XmlParser::getNode($authorizationResponse, 'authCode')));
        //$this->assertEquals('10', XmlParser::getNode($authorizationResponse, 'avsResult'));
        //$this->assertEquals('M', XmlParser::getNode($authorizationResponse, 'cardValidationResult'));

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
            //TODO run against prelive for certification
            //'cardholderAuthentication' => array('authenticationValue'=>'BwABBJQ1AgAAAAAgJDUCAAAAAAA=' )
        );

        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        //TODO: Getting blank authcode
        //$this->assertEquals('22222', trim(XmlParser::getNode($authorizationResponse, 'authCode')));
        //$this->assertEquals('10', XmlParser::getNode($authorizationResponse, 'avsResult'));
        //$this->assertEquals('M', XmlParser::getNode($authorizationResponse, 'cardValidationResult'));
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
        //TODO: getting 03180 as authcode
        //$this->assertEquals('22222', trim(XmlParser::getNode($saleResponse, 'authCode')));
        //$this->assertEquals('10', XmlParser::getNode($saleResponse, 'avsResult'));
       //$this->assertEquals('M', XmlParser::getNode($saleResponse, 'cardValidationResult'));

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
        //$this->assertEquals('000', XmlParser::getNode($voidResponse, 'response'));
       // $this->assertEquals('Approved', XmlParser::getNode($voidResponse, 'message'));
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
        //TODO: getting blank auth code
        //$this->assertEquals('33333', trim(XmlParser::getNode($authorizationResponse, 'authCode')));
        //$this->assertEquals('10', XmlParser::getNode($authorizationResponse, 'avsResult'));
        //$this->assertEquals('M', XmlParser::getNode($authorizationResponse, 'cardValidationResult'));

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
        //Getting blank auth code
        //$this->assertEquals('33333', trim(XmlParser::getNode($authorizationResponse, 'authCode')));
        //$this->assertEquals('10', XmlParser::getNode($authorizationResponse, 'avsResult'));
        //$this->assertEquals('M', XmlParser::getNode($authorizationResponse, 'cardValidationResult'));
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
        //TODO: getting 57966 as authcode
        //$this->assertEquals('33333', trim(XmlParser::getNode($saleResponse, 'authCode')));
        //$this->assertEquals('10', XmlParser::getNode($saleResponse, 'avsResult'));
        //$this->assertEquals('M', XmlParser::getNode($saleResponse, 'cardValidationResult'));

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
        //$this->assertEquals('000', XmlParser::getNode($voidResponse, 'response'));
       // $this->assertEquals('Approved', XmlParser::getNode($voidResponse, 'message'));
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
        //TODO run against prelive for certification
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
        //TODO run against prelive for certification
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
        //TODO run against prelive for certification
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
        //$this->assertEquals('000', XmlParser::getNode($creditResponse, 'response'));
        //$this->assertEquals('Approved', XmlParser::getNode($creditResponse, 'message'));

        //test 4C
        $void_hash = array('id' => '1211',
            'litleTxnId' => (XmlParser::getNode($creditResponse, 'litleTxnId')),
            'reportGroup' => 'planets');
        $initialize = new LitleOnlineRequest();
        $voidResponse = $initialize->voidRequest($void_hash);
       // $this->assertEquals('000', XmlParser::getNode($voidResponse, 'response'));
        //$this->assertEquals('Approved', XmlParser::getNode($voidResponse, 'message'));
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
            //TODO rin against prelive for certification
            //'cardholderAuthentication' => array('authenticationValue'=> 'BwABBJQ1AgAAAAAgJDUCAAAAAAA=')
        );

        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        //TODO: getting blank authcode
        //$this->assertEquals('55555', trim(XmlParser::getNode($authorizationResponse, 'authCode')));
        //$this->assertEquals('32', XmlParser::getNode($authorizationResponse, 'avsResult'));
//        $this->assertEquals('M', XmlParser::getNode($authorizationResponse, 'cardValidationResult'));

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
            //TODO run against prelive for certification
            //'cardholderAuthentication' => array('authenticationValue'=> 'BwABBJQ1AgAAAAAgJDUCAAAAAAA=')
        );

        $initialize = new LitleOnlineRequest();
        $authorizationResponse = $initialize->authorizationRequest($auth_hash);
        $this->assertEquals('000', XmlParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($authorizationResponse, 'message'));
        //TODO: getting blank authcode
        //$this->assertEquals('55555 ', XmlParser::getNode($authorizationResponse, 'authCode'));
        //$this->assertEquals('32', XmlParser::getNode($authorizationResponse, 'avsResult'));
//        $this->assertEquals('M', XmlParser::getNode($authorizationResponse, 'cardValidationResult'));
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
            //TODO run against prelive for certification
            //'cardholderAuthentication' => array('authenticationValue'=> 'BwABBJQ1AgAAAAAgJDUCAAAAAAA=')
        );

        $initialize = new LitleOnlineRequest();
        $saleResponse = $initialize->saleRequest($sale_hash);
        $this->assertEquals('000', XmlParser::getNode($saleResponse, 'response'));
        $this->assertEquals('Approved', XmlParser::getNode($saleResponse, 'message'));
        //TODO: getting 59302 as authcode
       // $this->assertEquals('55555 ', XmlParser::getNode($saleResponse, 'authCode'));
        //$this->assertEquals('32', XmlParser::getNode($saleResponse, 'avsResult'));
//        $this->assertEquals('M', XmlParser::getNode($saleResponse, 'cardValidationResult'));

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
       // $this->assertEquals('000', XmlParser::getNode($voidResponse, 'response'));
       // $this->assertEquals('Approved', XmlParser::getNode($voidResponse, 'message'));
    }

}
