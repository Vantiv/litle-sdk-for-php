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
        $this->config = Obj2xml::getConfig(array('batch_requests_path' => $this->direct, 'litle_requests_path' => $this->direct));
        $this->sale = array(
                  'orderId' => '1864',
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
                  'type' => 'VI'),
                  'reportGroup' => 'Planets');

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

        $this->setExpectedException(
            'RuntimeException', "Response file $this->direct/pizza.tmp indicates error: Test test tes test"
        );
        $proc = new LitleResponseProcessor($this->direct . '/pizza.tmp');

    }

    public function test_processRaw()
    {
        $request = new LitleRequest($this->config);

        # first batch
        $batch = new BatchRequest($this->direct);
        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000001',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'orderId'=> '2111',
            'orderSource'=>'ecommerce',
            'id'=>'654',
            'amount'=>'123');
        $batch->addAuth($hash_in);

        $request->addBatchRequest($batch);

        $resp = $request->sendToLitleStream();
        $proc = new LitleResponseProcessor($resp);
        $res = $proc->nextTransaction(true);
        $this->assertTrue(strpos($res, "authorizationResponse") !== FALSE);
    }

    public function test_processMecha()
    {
        $request = new LitleRequest($this->config);

        # first batch
        $batch = new BatchRequest($this->direct);
        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000001',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'orderId'=> '2111',
            'orderSource'=>'ecommerce',
            'id'=>'654',
            'amount'=>'123');
        $batch->addAuth($hash_in);

        $hash_in = array('litleTxnId'=> '1234567890','reportGroup'=>'Planets', 'amount'=>'5000');
        $batch->addAuthReversal($hash_in);

        $hash_in = array('litleTxnId'=> '12312312', 'amount'=>'123');
        $batch->addCapture($hash_in);

        $request->addBatchRequest($batch);

        # second batch
        $batch = new BatchRequest($this->direct);
        $hash_in = array(
       'amount'=>'123',
       'orderId'=>'12344',
       'authInformation' => array(
       'authDate'=>'2002-10-09','authCode'=>'543216',
       'authAmount'=>'12345'),
       'orderSource'=>'ecommerce',
       'card'=>array(
       'type'=>'VI',
       'number' =>'4100000000000001',
       'expDate' =>'1210'));
        $batch->addCaptureGivenAuth($hash_in);

        $hash_in = array('litleTxnId'=> '12312312','reportGroup'=>'Planets', 'amount'=>'123');
        $batch->addCredit($hash_in);

        $hash_in = array('litleTxnId' =>'123123');
        $batch->addEcheckCredit($hash_in);

        $request->addBatchRequest($batch);

        # third batch
        $batch = new BatchRequest($this->direct);
        $hash_in = array('litleTxnId' =>'123123');
        $batch->addEcheckRedeposit($hash_in);

        $hash_in = array(
          'amount'=>'123456',
          'verify'=>'true',
          'orderId'=>'12345',
          'orderSource'=>'ecommerce',
          'echeck' => array('accType'=>'Checking','accNum'=>'12345657890','routingNum'=>'123456789','checkNum'=>'123455'),
              'billToAddress'=>array('name'=>'Bob','city'=>'lowell','state'=>'MA','email'=>'litle.com'));
        $batch->addEcheckSale($hash_in);

        $hash_in = array(
          'amount'=>'123456',
          'verify'=>'true',
          'orderId'=>'12345',
          'orderSource'=>'ecommerce',
          'echeck' => array('accType'=>'Checking','accNum'=>'12345657890','routingNum'=>'123456789','checkNum'=>'123455'),
          'billToAddress'=>array('name'=>'Bob','city'=>'lowell','state'=>'MA','email'=>'litle.com'));
        $batch->addEcheckVerification($hash_in);

        $request->addBatchRequest($batch);

        # fourth batch
        $batch = new BatchRequest($this->direct);
        $hash_in = array(
             'orderId'=>'123',
              'litleTxnId'=>'123456',
              'amount'=>'106',
              'orderSource'=>'ecommerce',
              'token'=> array(
              'litleToken'=>'123456789101112',
              'expDate'=>'1210',
              'cardValidationNum'=>'555',
              'type'=>'VI'));
        $batch->addForceCapture($hash_in);

        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000001',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'654',
            'orderId'=> '2111',
            'orderSource'=>'ecommerce',
            'amount'=>'123');
        $batch->addSale($hash_in);

        $hash_in = array(
              'orderId'=>'1',
            'accountNumber'=>'123456789101112');
        $batch->addRegisterToken($hash_in);

        $hash_in = array(
            'orderId'=>'1',
            'litleToken'=>'123456789101112',
            'cardValidationNum'=>'123');
        $batch->addUpdateCardValidationNumOnToken($hash_in);

        $request->addBatchRequest($batch);

        # fifth batch - recurring
        $batch = new BatchRequest($this->direct);
        $hash_in = array(
            'subscriptionId'=>'1',
            'planCode'=> '2',
            'billToAddress'=> array (
                'addressLine1' => '3'
            ),
            'card' => array (
                'type'=>'VI',
                'number'=>'4100000000000000',
                'expDate'=>'1213',
                'cardValidationNum' => '1213'
            ),
            'billingDate'=>'2013-12-17');
        $batch->addUpdateSubscription($hash_in);
        $hash_in = array(
            'subscriptionId'=>'2',
        );
        $batch->addCancelSubscription($hash_in);
        $hash_in = array(
            'planCode'=>'1',
            'name'=> '2',
            'intervalType'=>'MONTHLY',
            'amount'=>'1000'
        );
        $batch->addCreatePlan($hash_in);
        $hash_in = array(
            'planCode'=>'1',
            'active'=>'false'
        );
        $batch->addUpdatePlan($hash_in);
        $request->addBatchRequest($batch);

        # sixth batch - au
        $batch = new BatchRequest($this->direct);
        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'orderId'=>'8675309');
        $batch->addAccountUpdate($hash_in);
        $request->addBatchRequest($batch);

        # seventh batch - gift card
        $batch = new BatchRequest($this->direct);
        $hash_in = array(
            'orderId'=>'1',
            'amount'=> '2',
            'orderSource'=>'ecommerce',
            'card' => array (
                'type'=>'VI',
                'number'=>'4100000000000000',
                'expDate'=>'1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch->addActivate($hash_in);
        $hash_in = array(
            'orderId'=>'1',
            'orderSource'=>'ecommerce',
            'card' => array (
                'type'=>'VI',
                'number'=>'4100000000000000',
                'expDate'=>'1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch->addDeactivate($hash_in);
        $hash_in = array(
            'orderId'=>'1',
            'amount'=> '2',
            'orderSource'=>'ecommerce',
            'card' => array (
                'type'=>'VI',
                'number'=>'4100000000000000',
                'expDate'=>'1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch->addLoad($hash_in);
        $hash_in = array(
            'orderId'=>'1',
            'amount'=> '2',
            'orderSource'=>'ecommerce',
            'card' => array (
                'type'=>'VI',
                'number'=>'4100000000000000',
                'expDate'=>'1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch->addUnload($hash_in);
        $hash_in = array(
            'orderId'=>'1',
            'orderSource'=>'ecommerce',
            'card' => array (
                'type'=>'VI',
                'number'=>'4100000000000000',
                'expDate'=>'1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch->addBalanceInquiry($hash_in);
        $request->addBatchRequest($batch);

        $resp = $request->sendToLitleStream();
        $respProcessor = new LitleResponseProcessor($resp);

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

    public function tearDown()
    {
        $files = glob($this->direct . '/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }
        rmdir($this->direct);
    }

}
