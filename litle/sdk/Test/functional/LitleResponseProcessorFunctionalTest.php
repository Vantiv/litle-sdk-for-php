<?php

namespace litle\sdk\Test\functional;

use litle\sdk\Obj2xml;
use litle\sdk\LitleResponseProcessor;
use litle\sdk\LitleRequest;
use litle\sdk\BatchRequest;

class LitleResponseProcessorFunctionalTest extends \PHPUnit_Framework_TestCase
{
    private $direct;
    private $config;
    private $sale;

    public function setUp()
    {
        $this->direct = sys_get_temp_dir() . '/test';
        if (!file_exists($this->direct)) {
            mkdir($this->direct);
        }
        $this->config = Obj2xml::getConfig(array(
            'batch_requests_path' => $this->direct,
            'litle_requests_path' => $this->direct
        ));
        $this->sale = array('id' => 'id',
            'orderId' => '1864',
            'amount' => '10010',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'name' => 'John Smith',
                'addressLine1' => '1 Main St.',
                'city' => 'Burlington',
                'state' => 'MA',
                'zip' => '01803-3747',
                'country' => 'US'
            ),
            'card' => array(
                'number' => '4457010000000009',
                'expDate' => '0112',
                'cardValidationNum' => '349',
                'type' => 'VI'
            ),
            'reportGroup' => 'Planets'
        );
    }

    public function test_badResponse()
    {
        $malformed_resp = '<litleResponse version="8.20" xmlns="http://www.litle.com/schema" response="1" message="Test test tes test" litleSessionId="819799340147507212">
            <batchResponse litleBatchId="819799340147507220" merchantId="07103229">
            <saleResponse reportGroup="Planets">
                <litleTxnId>819799340147507238</litleTxnId>
                <orderId>1864</orderId>
                <response>000</response>
                <responseTime>2013-08-08T13:11:01</responseTime>
                <message>Approved</message>
            </saleResponse>
            </batchResponse>
            </litleResponse>';

        file_put_contents($this->direct . '/pizza.tmp', $malformed_resp);

        $this->setExpectedException('RuntimeException', "Response file $this->direct/pizza.tmp indicates error: Test test tes test");
        $proc = new LitleResponseProcessor ($this->direct . '/pizza.tmp');
    }

    public function test_processRaw()
    {
        $request = new LitleRequest ($this->config);

        // first batch
        $batch = new BatchRequest ($this->direct);
        $hash_in = array('id' => '1211',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000001',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'orderId' => '2111',
            'orderSource' => 'ecommerce',
            'id' => '654',
            'amount' => '123'
        );
        $batch->addAuth($hash_in);

        $request->addBatchRequest($batch);

        $resp = $request->sendToLitleStream();
        $proc = new LitleResponseProcessor ($resp);
        $res = $proc->nextTransaction(true);
        $this->assertTrue(strpos($res, "authorizationResponse") !== FALSE);
    }

    public function test_processMecha()
    {
        $request = new LitleRequest ($this->config);

        // first batch
        $batch = new BatchRequest ($this->direct);
        $hash_in = array('id' => '1211',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000001',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'orderId' => '2111',
            'orderSource' => 'ecommerce',
            'id' => '654',
            'amount' => '123'
        );
        $batch->addAuth($hash_in);

        $hash_in = array('id' => '1211',
            'litleTxnId' => '1234567890',
            'reportGroup' => 'Planets',
            'amount' => '5000'
        );
        $batch->addAuthReversal($hash_in);

        $hash_in = array('id' => '1211',
            'litleTxnId' => '12312312',
            'amount' => '123'
        );
        $batch->addCapture($hash_in);

        $request->addBatchRequest($batch);

        // second batch
        $batch = new BatchRequest ($this->direct);
        $hash_in = array('id' => '1211',
            'amount' => '123',
            'orderId' => '12344',
            'authInformation' => array(
                'authDate' => '2002-10-09',
                'authCode' => '543216',
                'authAmount' => '12345'
            ),
            'orderSource' => 'ecommerce',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000001',
                'expDate' => '1210'
            )
        );
        $batch->addCaptureGivenAuth($hash_in);

        $hash_in = array('id' => '1211',
            'litleTxnId' => '12312312',
            'reportGroup' => 'Planets',
            'amount' => '123'
        );
        $batch->addCredit($hash_in);

        $hash_in = array('id' => '1211',
            'litleTxnId' => '123123'
        );
        $batch->addEcheckCredit($hash_in);

        $request->addBatchRequest($batch);

        // third batch
        $batch = new BatchRequest ($this->direct);
        $hash_in = array('id' => '1211',
            'litleTxnId' => '123123'
        );
        $batch->addEcheckRedeposit($hash_in);

        $hash_in = array('id' => '1211',
            'amount' => '123456',
            'verify' => 'true',
            'orderId' => '12345',
            'orderSource' => 'ecommerce',
            'echeck' => array(
                'accType' => 'Checking',
                'accNum' => '12345657890',
                'routingNum' => '123456789',
                'checkNum' => '123455'
            ),
            'billToAddress' => array(
                'name' => 'Bob',
                'city' => 'lowell',
                'state' => 'MA',
                'email' => 'litle.com'
            )
        );
        $batch->addEcheckSale($hash_in);

        $hash_in = array('id' => '1211',
            'amount' => '123456',
            'verify' => 'true',
            'orderId' => '12345',
            'orderSource' => 'ecommerce',
            'echeck' => array(
                'accType' => 'Checking',
                'accNum' => '12345657890',
                'routingNum' => '123456789',
                'checkNum' => '123455'
            ),
            'billToAddress' => array(
                'name' => 'Bob',
                'city' => 'lowell',
                'state' => 'MA',
                'email' => 'litle.com'
            )
        );
        $batch->addEcheckVerification($hash_in);

        $request->addBatchRequest($batch);

        // fourth batch
        $batch = new BatchRequest ($this->direct);
        $hash_in = array('id' => '1211',
            'orderId' => '123',
            'litleTxnId' => '123456',
            'amount' => '106',
            'orderSource' => 'ecommerce',
            'token' => array(
                'litleToken' => '123456789101112',
                'expDate' => '1210',
                'cardValidationNum' => '555',
                'type' => 'VI'
            )
        );
        $batch->addForceCapture($hash_in);

        $hash_in = array('id' => '1211',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000001',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '654',
            'orderId' => '2111',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch->addSale($hash_in);

        $hash_in = array('id' => '1211',
            'orderId' => '1',
            'accountNumber' => '123456789101112'
        );
        $batch->addRegisterToken($hash_in);

        $hash_in = array('id' => '1211',
            'orderId' => '1',
            'litleToken' => '123456789101112',
            'cardValidationNum' => '123'
        );
        $batch->addUpdateCardValidationNumOnToken($hash_in);

        $request->addBatchRequest($batch);

        // fifth batch - recurring
        $batch = new BatchRequest ($this->direct);
        $hash_in = array(
            'subscriptionId' => '1',
            'planCode' => '2',
            'billToAddress' => array(
                'addressLine1' => '3'
            ),
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'billingDate' => '2013-12-17'
        );
        $batch->addUpdateSubscription($hash_in);
        $hash_in = array(
            'subscriptionId' => '2'
        );
        $batch->addCancelSubscription($hash_in);
        $hash_in = array(
            'planCode' => '1',
            'name' => '2',
            'intervalType' => 'MONTHLY',
            'amount' => '1000'
        );
        $batch->addCreatePlan($hash_in);
        $hash_in = array(
            'planCode' => '1',
            'active' => 'false'
        );
        $batch->addUpdatePlan($hash_in);
        $request->addBatchRequest($batch);

        // sixth batch - au
        $batch = new BatchRequest ($this->direct);
        $hash_in = array('id' => '1211',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'orderId' => '8675309'
        );
        $batch->addAccountUpdate($hash_in);
        $request->addBatchRequest($batch);

        // seventh batch - gift card
        $batch = new BatchRequest ($this->direct);
        $hash_in = array('id' => '1211',
            'orderId' => '1',
            'amount' => '2',
            'orderSource' => 'ecommerce',
            'card' => array(
                'type' => 'GC',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch->addActivate($hash_in);
        $hash_in = array('id' => '1211',
            'orderId' => '1',
            'orderSource' => 'ecommerce',
            'card' => array(
                'type' => 'GC',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch->addDeactivate($hash_in);
        $hash_in = array('id' => '1211',
            'orderId' => '1',
            'amount' => '2',
            'orderSource' => 'ecommerce',
            'card' => array(
                'type' => 'GC',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch->addLoad($hash_in);
        $hash_in = array('id' => '1211',
            'orderId' => '1',
            'amount' => '2',
            'orderSource' => 'ecommerce',
            'card' => array(
                'type' => 'GC',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch->addUnload($hash_in);
        $hash_in = array('id' => '1211',
            'orderId' => '1',
            'orderSource' => 'ecommerce',
            'card' => array(
                'type' => 'GC',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch->addBalanceInquiry($hash_in);
        $request->addBatchRequest($batch);

        $resp = $request->sendToLitleStream();
        $respProcessor = new LitleResponseProcessor ($resp);

        $txnResponse = $respProcessor->nextTransaction();
        $responses = array();
        while ($txnResponse != FALSE) {
            $txnResponseName = $txnResponse->getName();
            array_push($responses, $txnResponseName);
            $txnResponse = $respProcessor->nextTransaction();
        }

        $this->assertTrue(in_array("authorizationResponse", $responses));
        $this->assertTrue(in_array("captureResponse", $responses));
        $this->assertTrue(in_array("authReversalResponse", $responses));
        $this->assertTrue(in_array("captureGivenAuthResponse", $responses));
        $this->assertTrue(in_array("creditResponse", $responses));
        $this->assertTrue(in_array("echeckCreditResponse", $responses));
        $this->assertTrue(in_array("echeckRedepositResponse", $responses));
        $this->assertTrue(in_array("echeckSalesResponse", $responses));
        $this->assertTrue(in_array("echeckVerificationResponse", $responses));
        $this->assertTrue(in_array("forceCaptureResponse", $responses));
        $this->assertTrue(in_array("saleResponse", $responses));
        $this->assertTrue(in_array("registerTokenResponse", $responses));
        $this->assertTrue(in_array("updateCardValidationNumOnTokenResponse", $responses));
        $this->assertTrue(in_array("updateSubscriptionResponse", $responses));
        $this->assertTrue(in_array("cancelSubscriptionResponse", $responses));
        $this->assertTrue(in_array("createPlanResponse", $responses));
        $this->assertTrue(in_array("updatePlanResponse", $responses));
        $this->assertTrue(in_array("accountUpdateResponse", $responses));
        $this->assertTrue(in_array("activateResponse", $responses));
        $this->assertTrue(in_array("deactivateResponse", $responses));
        $this->assertTrue(in_array("loadResponse", $responses));
        $this->assertTrue(in_array("unloadResponse", $responses));
        $this->assertTrue(in_array("balanceInquiryResponse", $responses));
    }

    public function test_echeckPreNote_all()
    {

        $request = new LitleRequest ($this->config);

        // first batch
        $batch_request = new BatchRequest ($this->direct);

        $billToAddress = array(
            'addressLine1' => '3',
            'name' => 'PreNote Co.',
            'city' => 'lowell',
            'state' => 'MA',
            'email' => 'litle.com'
        );

        $echeckSuccess = array(
            'accType' => 'Corporate',
            'accNum' => '1092969901',
            'routingNum' => '011075150'
        );
        $echeckRoutErr = array(
            'accType' => 'Checking',
            'accNum' => '6099999992',
            'routingNum' => '053133052'
        );
        $echeckAccErr = array(
            'accType' => 'Corporate',
            'accNum' => '10@2969901',
            'routingNum' => '011100012'
        );

        $echeckPreNoteSaleHashSuccess = array(
            'id' => '000',
            'orderId' => '000',
            'orderSource' => 'ecommerce',
            'billToAddress' => $billToAddress,
            'echeck' => $echeckSuccess
        );
        $batch_request->addEcheckPreNoteSale($echeckPreNoteSaleHashSuccess);

        $echeckPreNoteSaleHashRoutErr = array(
            'id' => '900',
            'orderId' => '900',
            'orderSource' => 'ecommerce',
            'billToAddress' => $billToAddress,
            'echeck' => $echeckRoutErr
        );
        $batch_request->addEcheckPreNoteSale($echeckPreNoteSaleHashRoutErr);

        $echeckPreNoteSaleHashAccErr = array('id' => '301',
            'orderId' => '301',
            'orderSource' => 'ecommerce',
            'billToAddress' => $billToAddress,
            'echeck' => $echeckAccErr
        );
        $batch_request->addEcheckPreNoteSale($echeckPreNoteSaleHashAccErr);

        $echeckPreNoteCreditHashSuccess = array('id' => '000',
            'orderId' => '000',
            'orderSource' => 'ecommerce',
            'billToAddress' => $billToAddress,
            'echeck' => $echeckSuccess
        );
        $batch_request->addEcheckPreNoteCredit($echeckPreNoteCreditHashSuccess);

        $echeckPreNoteCreditHashRoutErr = array('id' => '900',
            'orderId' => '900',
            'orderSource' => 'ecommerce',
            'billToAddress' => $billToAddress,
            'echeck' => $echeckRoutErr
        );
        $batch_request->addEcheckPreNoteCredit($echeckPreNoteCreditHashRoutErr);

        $echeckPreNoteCreditHashAccErr = array('id' => '301',
            'orderId' => '301',
            'orderSource' => 'ecommerce',
            'billToAddress' => $billToAddress,
            'echeck' => $echeckAccErr
        );
        $batch_request->addEcheckPreNoteCredit($echeckPreNoteCreditHashAccErr);

        $request->addBatchRequest($batch_request);

        $response = $request->sendToLitleStream();
        $respProcessor = new LitleResponseProcessor ($response);

        $txnResponse = $respProcessor->nextTransaction();
        $txnCount = 0;

        while ($txnResponse != FALSE) {
            $this->assertEquals($txnResponse->id, $txnResponse->orderId);
            $txnCount++;
            $txnResponse = $respProcessor->nextTransaction();
        }

        $this->assertEquals($txnCount, 6);
    }

    public function test_PFIF_instruction_txn()
    {

        $request = new LitleRequest ($this->config);

        // first batch
        $batch_request = new BatchRequest ($this->direct);


        $submerchantCreditHash = array('id' => '1211',
            'fundingSubmerchantId' => '2111',
            'submerchantName' => '001',
            'fundsTransferId' => '12345678',
            'amount' => '13',
            'accountInfo' => array(
                'accType' => 'Checking',
                'accNum' => '1092969901',
                'routingNum' => '011075150',
                'checkNum' => '123455'
            )
        );
        $batch_request->addSubmerchantCredit($submerchantCreditHash);

        $payFacCreditHash = array('id' => '1211',
            'fundingSubmerchantId' => '2111',
            'fundsTransferId' => '12345678',
            'amount' => '13'
        );
        $batch_request->addPayFacCredit($payFacCreditHash);

        $vendorCreditHash = array('id' => '1211',
            'fundingSubmerchantId' => '2111',
            'vendorName' => '001',
            'fundsTransferId' => '12345678',
            'amount' => '13',
            'accountInfo' => array(
                'accType' => 'Checking',
                'accNum' => '1092969901',
                'routingNum' => '011075150',
                'checkNum' => '123455'
            )
        );
        $batch_request->addVendorCredit($vendorCreditHash);

        $reserveCreditHash = array('id' => '1211',
            'fundingSubmerchantId' => '2111',
            'fundsTransferId' => '12345678',
            'amount' => '13'
        );
        $batch_request->addReserveCredit($reserveCreditHash);

        $physicalCheckCreditHash = array('id' => '1211',
            'fundingSubmerchantId' => '2111',
            'fundsTransferId' => '12345678',
            'amount' => '13'
        );
        $batch_request->addPhysicalCheckCredit($physicalCheckCreditHash);

        $submerchantDebitHash = array('id' => '1211',
            'fundingSubmerchantId' => '2111',
            'submerchantName' => '001',
            'fundsTransferId' => '12345678',
            'amount' => '13',
            'accountInfo' => array(
                'accType' => 'Checking',
                'accNum' => '1092969901',
                'routingNum' => '011075150',
                'checkNum' => '123455'
            )
        );
        $batch_request->addSubmerchantDebit($submerchantDebitHash);

        $payFacDebitHash = array('id' => '1211',
            'fundingSubmerchantId' => '2111',
            'fundsTransferId' => '12345678',
            'amount' => '13'
        );
        $batch_request->addPayFacDebit($payFacDebitHash);

        $vendorDebitHash = array('id' => '1211',
            'fundingSubmerchantId' => '2111',
            'vendorName' => '001',
            'fundsTransferId' => '12345678',
            'amount' => '13',
            'accountInfo' => array(
                'accType' => 'Checking',
                'accNum' => '1092969901',
                'routingNum' => '011075150',
                'checkNum' => '123455'
            )
        );
        $batch_request->addVendorDebit($vendorDebitHash);

        $reserveDebitHash = array('id' => '1211',
            'fundingSubmerchantId' => '2111',
            'fundsTransferId' => '12345678',
            'amount' => '13'
        );
        $batch_request->addReserveDebit($reserveDebitHash);

        $physicalCheckDebitHash = array('id' => '1211',
            'fundingSubmerchantId' => '2111',
            'fundsTransferId' => '12345678',
            'amount' => '13'
        );
        $batch_request->addPhysicalCheckDebit($physicalCheckDebitHash);

        $request->addBatchRequest($batch_request);

        $response = $request->sendToLitleStream();
        $respProcessor = new LitleResponseProcessor ($response);

        $txnResponse = $respProcessor->nextTransaction();
        $txnCount = 0;

        while ($txnResponse != FALSE) {
            $this->assertEquals($txnResponse->response, '000');
            $txnCount++;
            $txnResponse = $respProcessor->nextTransaction();
        }

        $this->assertEquals($txnCount, 10);
    }

}
