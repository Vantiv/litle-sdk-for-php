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
require_once realpath(__DIR__). '/../../../../vendor/autoload.php';
class CertAlphaTest extends \PHPUnit_Framework_TestCase
{
        function test_1_Auth()
        {
            $auth_hash = array(
              #'user'=> '12312',
              'orderId' => '1',
              'amount' => '10010',
              'orderSource'=>'ecommerce',
              'billToAddress'=>array(
              'name' => 'John Smith',
              'addressLine1' => '1 Main St.',
              'city' => 'Burlington',
              'state' => 'MA',
              'zip' => '01803-3747',
              'country' => 'US'),
              'card'=>array(
              'number' =>'4457010000000009',
              'expDate' => '0112',
              'cardValidationNum' => '349',
              'type' => 'VI'));
            $initilaize = new LitleOnlineRequest();
            $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
            $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
            $this->assertEquals('11111 ',XmlParser::getNode($authorizationResponse,'authCode'));
            $this->assertEquals('1',XmlParser::getNode($authorizationResponse,'avsResult'));
            $this->assertEquals('M',XmlParser::getNode($authorizationResponse,'cardValidationResult'));

            //test 1A
            $capture_hash =  array(
            'litleTxnId' =>(XmlParser::getNode($authorizationResponse,'litleTxnId')),
            'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $captureResponse = $initilaize->captureRequest($capture_hash);
            $this->assertEquals('000',XmlParser::getNode($captureResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($captureResponse,'message'));

            //test 1B
            $credit_hash =  array(
            'litleTxnId' =>(XmlParser::getNode($captureResponse,'litleTxnId')),
            'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $creditResponse = $initilaize->creditRequest($credit_hash);
            $this->assertEquals('000',XmlParser::getNode($creditResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($creditResponse,'message'));

            //test 1C
            $void_hash =  array(
            'litleTxnId' =>(XmlParser::getNode($creditResponse,'litleTxnId')),
            'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $voidResponse = $initilaize->voidRequest($void_hash);
            $this->assertEquals('000',XmlParser::getNode($voidResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($voidResponse,'message'));
        }

        function test_1_avs()
        {
            $auth_hash = array(
                      'orderId' => '1',
                      'amount' => '0',
                      'orderSource'=>'ecommerce',
                      'billToAddress'=>array(
                      'name' => 'John Smith',
                      'addressLine1' => '1 Main St.',
                      'city' => 'Burlington',
                      'state' => 'MA',
                      'zip' => '01803-3747',
                      'country' => 'US'),
                      'card'=>array(
                      'number' =>'4457010000000009',
                      'expDate' => '0112',
                      'cardValidationNum' => '349',
                      'type' => 'VI'));
            $initilaize = new LitleOnlineRequest();
            $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
            $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
            $this->assertEquals('11111 ',XmlParser::getNode($authorizationResponse,'authCode'));
            $this->assertEquals('1',XmlParser::getNode($authorizationResponse,'avsResult'));
            $this->assertEquals('M',XmlParser::getNode($authorizationResponse,'cardValidationResult'));
        }

        function test_1_sale()
        {
            $sale_hash = array(
                  'orderId' => '1',
                  'amount' => '10010',
                  'orderSource'=>'ecommerce',
                  'billToAddress'=>array(
                  'name' => 'John Smith',
                  'addressLine1' => '1 Main St.',
                  'city' => 'Burlington',
                  'state' => 'MA',
                  'zip' => '01803-3747',
                  'country' => 'US'),
                  'card'=>array(
                  'number' =>'4457010000000009',
                  'expDate' => '0112',
                  'cardValidationNum' => '349',
                  'type' => 'VI'));
            $initilaize = new LitleOnlineRequest();
            $saleResponse = $initilaize->saleRequest($sale_hash);
            $this->assertEquals('000',XmlParser::getNode($saleResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($saleResponse,'message'));
            $this->assertEquals('11111 ',XmlParser::getNode($saleResponse,'authCode'));
            $this->assertEquals('1',XmlParser::getNode($saleResponse,'avsResult'));
            $this->assertEquals('M',XmlParser::getNode($saleResponse,'cardValidationResult'));

            $credit_hash =  array(
                'litleTxnId' =>(XmlParser::getNode($saleResponse,'litleTxnId')),
                'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $creditResponse = $initilaize->creditRequest($credit_hash);
            $this->assertEquals('000',XmlParser::getNode($creditResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($creditResponse,'message'));

            $void_hash =  array(
                'litleTxnId' =>(XmlParser::getNode($creditResponse,'litleTxnId')),
                'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $voidResponse = $initilaize->voidRequest($void_hash);
            $this->assertEquals('000',XmlParser::getNode($voidResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($voidResponse,'message'));
        }

        function test_2_Auth()
        {
            $auth_hash = array(
            'orderId' => '2',
            'amount' => '20020',
            'orderSource'=>'ecommerce',
            'billToAddress'=> array(
                'name' => 'Mike J. Hammer',
                'addressLine1' => '2 Main St.',
                'addressLine2' => 'Apt. 222',
                'city' => 'Riverside',
                'state' => 'RI',
                'zip' => '02915',
                'country' => 'US'),
            'card'=> array(
            'number' =>'5112010000000003',
            'expDate' => '0212',
            'cardValidationNum' => '261',
            'type' => 'MC'),
            'cardholderAuthentication' => array('authenticationValue'=>'BwABBJQ1AgAAAAAgJDUCAAAAAAA=' ));

            $initilaize = new LitleOnlineRequest();
            $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
            $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
            $this->assertEquals('22222',XmlParser::getNode($authorizationResponse,'authCode'));
            $this->assertEquals('10',XmlParser::getNode($authorizationResponse,'avsResult'));
            $this->assertEquals('M',XmlParser::getNode($authorizationResponse,'cardValidationResult'));

            //test 2A
            $capture_hash =  array(
                'litleTxnId' =>(XmlParser::getNode($authorizationResponse,'litleTxnId')),
                'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $captureResponse = $initilaize->captureRequest($capture_hash);
            $this->assertEquals('000',XmlParser::getNode($captureResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($captureResponse,'message'));

            //test 2B
            $credit_hash =  array(
                'litleTxnId' =>(XmlParser::getNode($captureResponse,'litleTxnId')),
                'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $creditResponse = $initilaize->creditRequest($credit_hash);
            $this->assertEquals('000',XmlParser::getNode($creditResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($creditResponse,'message'));

            //test 2C
            $void_hash =  array(
                'litleTxnId' =>(XmlParser::getNode($creditResponse,'litleTxnId')),
                'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $voidResponse = $initilaize->voidRequest($void_hash);
            $this->assertEquals('000',XmlParser::getNode($voidResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($voidResponse,'message'));
        }

        function test_2_avs()
        {
            $auth_hash = array(
                'orderId' => '2',
                'amount' => '0',
                'orderSource'=>'ecommerce',
                'billToAddress'=> array(
                    'name' => 'Mike J. Hammer',
                    'addressLine1' => '2 Main St.',
                    'addressLine2' => 'Apt. 222',
                    'city' => 'Riverside',
                    'state' => 'RI',
                    'zip' => '02915',
                    'country' => 'US'),
                'card'=> array(
                'number' =>'5112010000000003',
                'expDate' => '0212',
                'cardValidationNum' => '261',
                'type' => 'MC'),
                'cardholderAuthentication' => array('authenticationValue'=>'BwABBJQ1AgAAAAAgJDUCAAAAAAA=' ));

            $initilaize = new LitleOnlineRequest();
            $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
            $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
            $this->assertEquals('22222',XmlParser::getNode($authorizationResponse,'authCode'));
            $this->assertEquals('10',XmlParser::getNode($authorizationResponse,'avsResult'));
            $this->assertEquals('M',XmlParser::getNode($authorizationResponse,'cardValidationResult'));
        }

        function test_2_sale()
        {
            $sale_hash = array(
                'orderId' => '2',
                'amount' => '20020',
                'orderSource'=>'ecommerce',
                'billToAddress'=> array(
                    'name' => 'Mike J. Hammer',
                    'addressLine1' => '2 Main St.',
                    'addressLine2' => 'Apt. 222',
                    'city' => 'Riverside',
                    'state' => 'RI',
                    'zip' => '02915',
                    'country' => 'US'),
                'card'=> array(
                'number' =>'5112010000000003',
                'expDate' => '0212',
                'cardValidationNum' => '261',
                'type' => 'MC'),
                'cardholderAuthentication' => array('authenticationValue'=>'BwABBJQ1AgAAAAAgJDUCAAAAAAA=' ));

            $initilaize = new LitleOnlineRequest();
            $saleResponse = $initilaize->saleRequest($sale_hash);
            $this->assertEquals('000',XmlParser::getNode($saleResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($saleResponse,'message'));
            $this->assertEquals('22222',XmlParser::getNode($saleResponse,'authCode'));
            $this->assertEquals('10',XmlParser::getNode($saleResponse,'avsResult'));
            $this->assertEquals('M',XmlParser::getNode($saleResponse,'cardValidationResult'));

            //test 2B
            $credit_hash =  array(
                    'litleTxnId' =>(XmlParser::getNode($saleResponse,'litleTxnId')),
                    'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $creditResponse = $initilaize->creditRequest($credit_hash);
            $this->assertEquals('000',XmlParser::getNode($creditResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($creditResponse,'message'));

            //test 2C
            $void_hash =  array(
                    'litleTxnId' =>(XmlParser::getNode($creditResponse,'litleTxnId')),
                    'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $voidResponse = $initilaize->voidRequest($void_hash);
            $this->assertEquals('000',XmlParser::getNode($voidResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($voidResponse,'message'));
        }

        function test_3_Auth()
        {
            $auth_hash = array(
                'orderId' => '3',
                'amount' => '30030',
                'orderSource'=>'ecommerce',
                'billToAddress'=>array(
                'name' => 'Eileen Jones',
                'addressLine1' => '3 Main St.',
                'city' => 'Bloomfield',
                'state' => 'CT',
                'zip' => '06002',
                'country' => 'US'),
                'card'=>array(
                'number' =>'6011010000000003',
                   'expDate' => '0312',
                'type' => 'DI',
                'cardValidationNum' => '758'));

            $initilaize = new LitleOnlineRequest();
            $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
            $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
            $this->assertEquals('33333',XmlParser::getNode($authorizationResponse,'authCode'));
            $this->assertEquals('10',XmlParser::getNode($authorizationResponse,'avsResult'));
            $this->assertEquals('M',XmlParser::getNode($authorizationResponse,'cardValidationResult'));

            //test 3A
            $capture_hash =  array(
                    'litleTxnId' =>(XmlParser::getNode($authorizationResponse,'litleTxnId')),
                    'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $captureResponse = $initilaize->captureRequest($capture_hash);
            $this->assertEquals('000',XmlParser::getNode($captureResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($captureResponse,'message'));

            //test 3B
            $credit_hash =  array(
                    'litleTxnId' =>(XmlParser::getNode($captureResponse,'litleTxnId')),
                    'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $creditResponse = $initilaize->creditRequest($credit_hash);
            $this->assertEquals('000',XmlParser::getNode($creditResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($creditResponse,'message'));

            //test 3C
            $void_hash =  array(
                    'litleTxnId' =>(XmlParser::getNode($creditResponse,'litleTxnId')),
                    'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $voidResponse = $initilaize->voidRequest($void_hash);
            $this->assertEquals('000',XmlParser::getNode($voidResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($voidResponse,'message'));
        }

        function test_3_avs()
        {
            $auth_hash = array(
                        'orderId' => '3',
                        'amount' => '0',
                        'orderSource'=>'ecommerce',
                        'billToAddress'=>array(
                        'name' => 'Eileen Jones',
                        'addressLine1' => '3 Main St.',
                        'city' => 'Bloomfield',
                        'state' => 'CT',
                        'zip' => '06002',
                        'country' => 'US'),
                        'card'=>array(
                        'number' =>'6011010000000003',
                           'expDate' => '0312',
                        'type' => 'DI',
                        'cardValidationNum' => '758'));
            $initilaize = new LitleOnlineRequest();
            $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
            $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
            $this->assertEquals('33333',XmlParser::getNode($authorizationResponse,'authCode'));
            $this->assertEquals('10',XmlParser::getNode($authorizationResponse,'avsResult'));
            $this->assertEquals('M',XmlParser::getNode($authorizationResponse,'cardValidationResult'));
        }

        function test_3_sale()
        {
            $sale_hash = array(
                        'orderId' => '3',
                        'amount' => '30030',
                        'orderSource'=>'ecommerce',
                        'billToAddress'=>array(
                        'name' => 'Eileen Jones',
                        'addressLine1' => '3 Main St.',
                        'city' => 'Bloomfield',
                        'state' => 'CT',
                        'zip' => '06002',
                        'country' => 'US'),
                        'card'=>array(
                        'number' =>'6011010000000003',
                           'expDate' => '0312',
                        'type' => 'DI',
                        'cardValidationNum' => '758'));

            $initilaize = new LitleOnlineRequest();
            $saleResponse = $initilaize->saleRequest($sale_hash);
            $this->assertEquals('000',XmlParser::getNode($saleResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($saleResponse,'message'));
            $this->assertEquals('33333',XmlParser::getNode($saleResponse,'authCode'));
            $this->assertEquals('10',XmlParser::getNode($saleResponse,'avsResult'));
            $this->assertEquals('M',XmlParser::getNode($saleResponse,'cardValidationResult'));

            //test 3B
            $credit_hash =  array(
                            'litleTxnId' =>(XmlParser::getNode($saleResponse,'litleTxnId')),
                            'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $creditResponse = $initilaize->creditRequest($credit_hash);
            $this->assertEquals('000',XmlParser::getNode($creditResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($creditResponse,'message'));

            //test 3C
            $void_hash =  array(
                            'litleTxnId' =>(XmlParser::getNode($creditResponse,'litleTxnId')),
                            'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $voidResponse = $initilaize->voidRequest($void_hash);
            $this->assertEquals('000',XmlParser::getNode($voidResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($voidResponse,'message'));
        }

        function test_4_Auth()
        {
            $auth_hash = array(
            'orderId' => '4',
            'amount' => '40040',
            'orderSource'=>'ecommerce',
            'billToAddress'=>array(
            'name' => 'Bob Black',
            'addressLine1' => '4 Main St.',
            'city' => 'Laurel',
            'state' => 'MD',
            'zip' => '20708',
            'country' => 'US'),
            'card'=> array(
            'number' =>'375001000000005',
            'expDate' => '0412',
            'type' => 'AX'));

            $initilaize = new LitleOnlineRequest();
            $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
            $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
            $this->assertEquals('44444',XmlParser::getNode($authorizationResponse,'authCode'));
            $this->assertEquals('12',XmlParser::getNode($authorizationResponse,'avsResult'));

            //test 4A
            $capture_hash =  array(
                            'litleTxnId' =>(XmlParser::getNode($authorizationResponse,'litleTxnId')),
                            'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $captureResponse = $initilaize->captureRequest($capture_hash);
            #$this->assertEquals('000',XmlParser::getNode($captureResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($captureResponse,'message'));

            //test 4B
            $credit_hash =  array(
                            'litleTxnId' =>(XmlParser::getNode($captureResponse,'litleTxnId')),
                            'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $creditResponse = $initilaize->creditRequest($credit_hash);
            $this->assertEquals('000',XmlParser::getNode($creditResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($creditResponse,'message'));

            //test 4C
            $void_hash =  array(
                            'litleTxnId' =>(XmlParser::getNode($creditResponse,'litleTxnId')),
                            'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $voidResponse = $initilaize->voidRequest($void_hash);
            $this->assertEquals('000',XmlParser::getNode($voidResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($voidResponse,'message'));
        }

        function test_4_avs()
        {
            $auth_hash = array(
                    'orderId' => '4',
                    'amount' => '0',
                    'orderSource'=>'ecommerce',
                    'billToAddress'=>array(
                    'name' => 'Bob Black',
                    'addressLine1' => '4 Main St.',
                    'city' => 'Laurel',
                    'state' => 'MD',
                    'zip' => '20708',
                    'country' => 'US'),
                    'card'=> array(
                    'number' =>'375001000000005',
                    'expDate' => '0412',
                    'type' => 'AX'));

            $initilaize = new LitleOnlineRequest();
            $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
            $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
            $this->assertEquals('44444',XmlParser::getNode($authorizationResponse,'authCode'));
            $this->assertEquals('12',XmlParser::getNode($authorizationResponse,'avsResult'));

        }

        function test_4_sale()
        {
            $sale_hash = array(
                    'orderId' => '4',
                    'amount' => '40040',
                    'orderSource'=>'ecommerce',
                    'billToAddress'=>array(
                    'name' => 'Bob Black',
                    'addressLine1' => '4 Main St.',
                    'city' => 'Laurel',
                    'state' => 'MD',
                    'zip' => '20708',
                    'country' => 'US'),
                    'card'=> array(
                    'number' =>'375001000000005',
                    'expDate' => '0412',
                    'type' => 'AX'));

            $initilaize = new LitleOnlineRequest();
            $saleResponse = $initilaize->saleRequest($sale_hash);
            $this->assertEquals('000',XmlParser::getNode($saleResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($saleResponse,'message'));
            $this->assertEquals('44444',XmlParser::getNode($saleResponse,'authCode'));
            $this->assertEquals('12',XmlParser::getNode($saleResponse,'avsResult'));

            //test 4B
            $credit_hash =  array(
                                    'litleTxnId' =>(XmlParser::getNode($saleResponse,'litleTxnId')),
                                    'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $creditResponse = $initilaize->creditRequest($credit_hash);
            $this->assertEquals('000',XmlParser::getNode($creditResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($creditResponse,'message'));

            //test 4C
            $void_hash =  array(
                                    'litleTxnId' =>(XmlParser::getNode($creditResponse,'litleTxnId')),
                                    'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $voidResponse = $initilaize->voidRequest($void_hash);
            $this->assertEquals('000',XmlParser::getNode($voidResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($voidResponse,'message'));
        }

        function test_5_auth()
        {
            $auth_hash = array(
                'orderId' => '5',
                'amount' => '50050',
                'orderSource'=>'ecommerce',
                'card'=>array(
                'number' =>'4457010200000007',
                'expDate' => '0512',
                'cardValidationNum' => '463',
                'type' => 'VI'),
                'cardholderAuthentication' => array('authenticationValue'=> 'BwABBJQ1AgAAAAAgJDUCAAAAAAA='));

            $initilaize = new LitleOnlineRequest();
            $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
            $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
            $this->assertEquals('55555 ',XmlParser::getNode($authorizationResponse,'authCode'));
            $this->assertEquals('32',XmlParser::getNode($authorizationResponse,'avsResult'));
            $this->assertEquals('N',XmlParser::getNode($authorizationResponse,'cardValidationResult'));

            //test 5A
            $capture_hash =  array(
                                    'litleTxnId' =>(XmlParser::getNode($authorizationResponse,'litleTxnId')),
                                    'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $captureResponse = $initilaize->captureRequest($capture_hash);
            $this->assertEquals('000',XmlParser::getNode($captureResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($captureResponse,'message'));

            //test 5B
            $credit_hash =  array(
                                    'litleTxnId' =>(XmlParser::getNode($captureResponse,'litleTxnId')),
                                    'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $creditResponse = $initilaize->creditRequest($credit_hash);
            $this->assertEquals('000',XmlParser::getNode($creditResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($creditResponse,'message'));

            //test 5C
            $void_hash =  array(
                                    'litleTxnId' =>(XmlParser::getNode($creditResponse,'litleTxnId')),
                                    'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $voidResponse = $initilaize->voidRequest($void_hash);
            $this->assertEquals('000',XmlParser::getNode($voidResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($voidResponse,'message'));
        }

        function test_5_avs()
        {
            $auth_hash = array(
                        'orderId' => '5',
                        'amount' => '0',
                        'orderSource'=>'ecommerce',
                        'card'=>array(
                        'number' =>'4457010200000007',
                        'expDate' => '0512',
                        'cardValidationNum' => '463',
                        'type' => 'VI'),
                        'cardholderAuthentication' => array('authenticationValue'=> 'BwABBJQ1AgAAAAAgJDUCAAAAAAA='));

            $initilaize = new LitleOnlineRequest();
            $authorizationResponse = $initilaize->authorizationRequest($auth_hash);
            $this->assertEquals('000',XmlParser::getNode($authorizationResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($authorizationResponse,'message'));
            $this->assertEquals('55555 ',XmlParser::getNode($authorizationResponse,'authCode'));
            $this->assertEquals('32',XmlParser::getNode($authorizationResponse,'avsResult'));
            $this->assertEquals('N',XmlParser::getNode($authorizationResponse,'cardValidationResult'));
        }

        function test_5_sale()
        {
            $sale_hash = array(
                        'orderId' => '5',
                        'amount' => '50050',
                        'orderSource'=>'ecommerce',
                        'card'=>array(
                        'number' =>'4457010200000007',
                        'expDate' => '0512',
                        'cardValidationNum' => '463',
                        'type' => 'VI'),
                        'cardholderAuthentication' => array('authenticationValue'=> 'BwABBJQ1AgAAAAAgJDUCAAAAAAA='));

            $initilaize = new LitleOnlineRequest();
            $saleResponse = $initilaize->saleRequest($sale_hash);
            $this->assertEquals('000',XmlParser::getNode($saleResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($saleResponse,'message'));
            $this->assertEquals('55555 ',XmlParser::getNode($saleResponse,'authCode'));
            $this->assertEquals('32',XmlParser::getNode($saleResponse,'avsResult'));
            $this->assertEquals('N',XmlParser::getNode($saleResponse,'cardValidationResult'));

            //test 5B
            $credit_hash =  array(
                                'litleTxnId' =>(XmlParser::getNode($saleResponse,'litleTxnId')),
                                'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $creditResponse = $initilaize->creditRequest($credit_hash);
            $this->assertEquals('000',XmlParser::getNode($creditResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($creditResponse,'message'));

            //test 5C
            $void_hash =  array(
                                'litleTxnId' =>(XmlParser::getNode($creditResponse,'litleTxnId')),
                                'reportGroup'=>'planets');
            $initilaize = new LitleOnlineRequest();
            $voidResponse = $initilaize->voidRequest($void_hash);
            $this->assertEquals('000',XmlParser::getNode($voidResponse,'response'));
            $this->assertEquals('Approved',XmlParser::getNode($voidResponse,'message'));
        }
}
