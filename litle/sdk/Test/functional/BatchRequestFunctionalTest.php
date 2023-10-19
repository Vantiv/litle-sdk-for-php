<?php
namespace litle\sdk\Test\functional;
use litle\sdk\BatchRequest;
require_once realpath(dirname(__FILE__)) . '../../../LitleOnline.php';
class BatchRequestFunctionalTest extends \PHPUnit_Framework_TestCase
{
    private $direct;
    private $preliveStatus;

    public function setUp()
    {
        $this->direct = sys_get_temp_dir() . '/test' . CURRENT_SDK_VERSION;
        if (!file_exists($this->direct)) {
            mkdir($this->direct);
        }
        $this->preliveStatus = $_SERVER['preliveStatus'];
    }

    public function test_simpleAddTransaction()
    {

        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'orderId'=> '2111',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123',
            'foreignRetailerIndicator' => 'F');
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addSale($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['sale']['count']);
        $this->assertEquals(123, $cts['sale']['amount']);

    }
        function test_addSale()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'orderId'=> '2111',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123');
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addSale($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['sale']['count']);
        $this->assertEquals(123, $cts['sale']['amount']);

    }

    public function test_addAuth()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'litleTxnId'=>'12345678000',
            'orderId'=> '2111',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123',
            'billToAddress' => array(
                'name' => 'David Berman A',
                'addressLine1' => '10 Main Street',
                'city' => 'San Jose',
                'state' => 'ca',
                'zip' => '95032',
                'country' => 'USA',
                'email' => 'dberman@phoenixProcessing.com',
                'phone' => '781-270-1111',
                'sellerId' => '21234234A1',
                'url' => 'www.google.com',
            ),
            'shipToAddress' => array(
                'name' => 'Raymond J. Johnson Jr. B',
                'addressLine1' => '123 Main Street',
                'city' => 'McLean',
                'state' => 'VA',
                'zip' => '22102',
                'country' => 'USA',
                'email' => 'ray@rayjay.com',
                'phone' => '978-275-0000',
                'sellerId' => '21234234A2',
                'url' => 'www.google.com',
            ),
            'retailerAddress' => array(
                'name' => 'John doe',
                'addressLine1' => '123 Main Street',
                'addressLine2' => '123 Main Street',
                'addressLine3' => '123 Main Street',
                'city' => 'Cincinnati',
                'state' => 'OH',
                'zip' => '45209',
                'country' => 'USA',
                'email' => 'noone@abc.com',
                'phone' => '1234562783',
                'sellerId' => '21234234A12345678910',
                'companyName' => 'Google INC',
                'url' => 'https://www.youtube.com/results?search_query',
            ),
            'additionalCOFData' => array(
                'totalPaymentCount' => 'ND',
                'paymentType' => 'Fixed Amount',
                'uniqueId' => '234GTYH654RF13',
                'frequencyOfMIT' => 'Annually',
                'validationReference' => 'ANBH789UHY564RFC@EDB',
                'sequenceIndicator' => '86',
            ),
            'merchantCategoryCode' => '5964',
            'businessIndicator' => 'walletTransfer',
            'crypto' => 'true',
            'authIndicator' => 'Estimated',
        );
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addAuth($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['auth']['count']);
        $this->assertEquals(123, $cts['auth']['amount']);

    }

    public function test_addAuthReversal()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'litleTxnId'=>'12345678000',
            'orderId'=> '2111',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123');
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addAuthReversal($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['authReversal']['count']);
        $this->assertEquals(123, $cts['authReversal']['amount']);

    }

    public function test_addCredit()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'orderId'=> '2111',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123');
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addCredit($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['credit']['count']);
        $this->assertEquals(123, $cts['credit']['amount']);

    }

    public function test_addRegisterToken()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'orderId'=> '2111',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123');
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addRegisterToken($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['tokenRegistration']['count']);

    }

    public function test_addForceCapture()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'orderId'=> '2111',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123');
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addForceCapture($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['forceCapture']['count']);
        $this->assertEquals(123, $cts['forceCapture']['amount']);

    }

    public function test_addCapture()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'orderId'=> '2111',
            'litleTxnId'=>'12345678000',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123');
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addCapture($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['capture']['count']);
        $this->assertEquals(123, $cts['capture']['amount']);

    }

    public function test_addCaptureGivenAuth()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'orderId'=> '2111',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123');
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addCaptureGivenAuth($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['captureGivenAuth']['count']);
        $this->assertEquals(123, $cts['captureGivenAuth']['amount']);

    }

    public function test_addEcheckRedeposit()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'orderId'=> '2111',
            'litleTxnId'=>'12345678000',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123');
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addEcheckRedeposit($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['echeckRedeposit']['count']);

    }

    public function test_addEcheckSale()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'orderId'=> '2111',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123');
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addEcheckSale($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['echeckSale']['count']);
        $this->assertEquals(123, $cts['echeckSale']['amount']);

    }

    public function test_addEcheckCredit()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'orderId'=> '2111',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123');
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addEcheckCredit($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['echeckCredit']['count']);
        $this->assertEquals(123, $cts['echeckCredit']['amount']);

    }

    public function test_addEcheckVerification()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'orderId'=> '2111',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123');
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addEcheckVerification($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['echeckVerification']['count']);
        $this->assertEquals(123, $cts['echeckVerification']['amount']);

    }

    public function test_addUpdateCardValidationNumOnTokenHash()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'orderId'=> '2111',
              'litleToken'=>'123456789101112',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123',
            'cardValidationNum'=>'123');
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addUpdateCardValidationNumOnToken($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['updateCardValidationNumOnToken']['count']);

    }

    public function test_addUpdateSubscriptionHash()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

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
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addUpdateSubscription($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['updateSubscription']['count']);
    }

    public function test_addCancelSubscriptionHash()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'subscriptionId'=>'1'
        );
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addCancelSubscription($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['cancelSubscription']['count']);
    }

    public function test_addCreatePlanHash()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'planCode'=>'1',
            'name'=> '2',
            'intervalType'=>'MONTHLY',
            'amount'=>'1000'
        );
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addCreatePlan($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['createPlan']['count']);
    }

    public function test_addUpdatePlanHash()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'planCode'=>'1',
            'active'=>'false'
        );
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addUpdatePlan($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['updatePlan']['count']);
    }

    public function test_addActivateHash()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'orderId'=>'1',
            'amount'=> '2',
            'orderSource'=>'ECOMMERCE',
            'card' => array (
                'type'=>'VI',
                'number'=>'4100000000000000',
                'expDate'=>'1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addActivate($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['activate']['count']);
        $this->assertEquals(2, $cts['activate']['amount']);
    }
    public function test_addDeactivateHash()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'orderId'=>'1',
            'orderSource'=>'ECOMMERCE',
            'card' => array (
                'type'=>'VI',
                'number'=>'4100000000000000',
                'expDate'=>'1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addDeactivate($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['deactivate']['count']);
    }
    public function test_addLoadHash()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'orderId'=>'1',
            'amount'=> '2',
            'orderSource'=>'ECOMMERCE',
            'card' => array (
                'type'=>'VI',
                'number'=>'4100000000000000',
                'expDate'=>'1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addLoad($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['load']['count']);
        $this->assertEquals(2, $cts['load']['amount']);
    }
    public function test_addUnloadHash()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'orderId'=>'1',
            'amount'=> '2',
            'orderSource'=>'ECOMMERCE',
            'card' => array (
                'type'=>'VI',
                'number'=>'4100000000000000',
                'expDate'=>'1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addUnload($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['unload']['count']);
        $this->assertEquals(2, $cts['unload']['amount']);
    }
    public function test_addBalanceInquiryHash()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'orderId'=>'1',
            'orderSource'=>'ECOMMERCE',
            'card' => array (
                'type'=>'VI',
                'number'=>'4100000000000000',
                'expDate'=>'1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addBalanceInquiry($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['balanceInquiry']['count']);
    }

    public function test_mechaBatch()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

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

        $this->assertEquals(13, $batch->total_txns);
        $cts = $batch->getCountsAndAmounts();
        $this->assertEquals(1, $cts['sale']['count']);
        $this->assertEquals(1, $cts['auth']['count']);
        $this->assertEquals(1, $cts['credit']['count']);
        $this->assertEquals(1, $cts['tokenRegistration']['count']);
        $this->assertEquals(1, $cts['capture']['count']);
        $this->assertEquals(1, $cts['forceCapture']['count']);
        $this->assertEquals(1, $cts['echeckRedeposit']['count']);
        $this->assertEquals(1, $cts['echeckSale']['count']);
        $this->assertEquals(1, $cts['echeckCredit']['count']);
        $this->assertEquals(1, $cts['echeckVerification']['count']);
        $this->assertEquals(1, $cts['updateCardValidationNumOnToken']['count']);

        $this->assertEquals(123, $cts['sale']['amount']);
        $this->assertEquals(123, $cts['auth']['amount']);
        $this->assertEquals(123, $cts['credit']['amount']);
        $this->assertEquals(123, $cts['capture']['amount']);
        $this->assertEquals(106, $cts['forceCapture']['amount']);
        $this->assertEquals(123456, $cts['echeckSale']['amount']);
        $this->assertEquals(123456, $cts['echeckVerification']['amount']);

    }
    public function test_addAccountUpdate()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'orderId'=> '2111',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123');
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addAccountUpdate($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['accountUpdate']['count']);

    }
    public function test_addAccountUpdate_negative_with_transaction_before_accountUpdate()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        try {
            $hash_in = array(
                'card'=>array('type'=>'VI',
                        'number'=>'4100000000000000',
                        'expDate'=>'1213',
                        'cardValidationNum' => '1213'),
                'id'=>'1211',
                'orderId'=> '2111',
                'reportGroup'=>'Planets',
                'orderSource'=>'ecommerce',
                'amount'=>'123');
            $batch_request = new BatchRequest($this->direct);
            $batch_request->addSale($hash_in);
            $batch_request->addAccountUpdate($hash_in);

        } catch (\RuntimeException $expected) {
            $this->assertEquals($expected->getMessage(),"The transaction could not be added to the batch. The transaction type accountUpdate cannot be mixed with non-Account Updates.");

            return;
        }

        $this->fail("test_addAccountUpdate_negative_with_transaction_before_accountUpdate is expected to fail");

    }
    public function test_addAccountUpdate_negative_with_transaction_after_accountUpdate()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        try {
            $hash_in = array(
                'card'=>array('type'=>'VI',
                        'number'=>'4100000000000000',
                        'expDate'=>'1213',
                        'cardValidationNum' => '1213'),
                'id'=>'1211',
                'orderId'=> '2111',
                'reportGroup'=>'Planets',
                'orderSource'=>'ecommerce',
                'amount'=>'123');
            $batch_request = new BatchRequest($this->direct);
            $batch_request->addAccountUpdate($hash_in);
            $batch_request->addSale($hash_in);

        } catch (\RuntimeException $expected) {
            $this->assertEquals($expected->getMessage(),"The transaction could not be added to the batch. The transaction type sale cannot be mixed with AccountUpdates.");

            return;
        }

        $this->fail("test_addAccountUpdate_negative_with_transaction_after_accountUpdate is expected to fail");

    }

    public function test_isFull()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

            $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'orderId'=> '2111',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123');

            $this->setExpectedException(
            'RuntimeException','The transaction could not be added to the batch. It is full.'
            );
            $batch_request = new BatchRequest($this->direct);
            $batch_request->total_txns = MAX_TXNS_PER_BATCH;
            $batch_request->addSale($hash_in);

    }
    public function test_addTooManyTransactions()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

            $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'orderId'=> '2111',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123');
            $batch_request = new BatchRequest($this->direct);
            $batch_request->total_txns = MAX_TXNS_PER_BATCH;

            $this->setExpectedException(
            'RuntimeException', 'The transaction could not be added to the batch. It is full.'
            );

            $batch_request->addSale($hash_in);
    }
    public function test_addToClosedBatch()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

            $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'orderId'=> '2111',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123');
            $batch_request = new BatchRequest($this->direct);
            $batch_request->closed = TRUE;
            $this->setExpectedException(
            'RuntimeException', 'Could not add the transaction. This batchRequest is closed.'
            );

            $batch_request->addSale($hash_in);
    }
    public function test_closeRequest()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'orderId'=> '2111',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123');
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addSale($hash_in);
        $batch_request->closeRequest();

        $data = file_get_contents($batch_request->batch_file);
        $this->assertTrue(!(!strpos($data, 'numSales="1"')));
        $this->assertTrue($batch_request->closed);

    }

    public function test_closeRequest_badFile()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $batch_request = new BatchRequest($this->direct);
        $batch_request->transaction_file = "/usr/NOPERMS";

        $this->setExpectedException(
        'RuntimeException', 'Could not open transactions file at /usr/NOPERMS. Please check your privilege.'
        );
        $batch_request->closeRequest();
    }

    public function test_getCountsAndAmounts()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array(
            'card'=>array('type'=>'VI',
                    'number'=>'4100000000000000',
                    'expDate'=>'1213',
                    'cardValidationNum' => '1213'),
            'id'=>'1211',
            'orderId'=> '2111',
            'reportGroup'=>'Planets',
            'orderSource'=>'ecommerce',
            'amount'=>'123');
        $batch_request = new BatchRequest($this->direct);
        $batch_request->addSale($hash_in);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertNotNull($cts);
    }

    public function test_auth_with_litleTxnId()
    {
        if(strtolower($this->preliveStatus) == 'down'){
            $this->markTestSkipped('Prelive is not available');
        }

        $hash_in = array('reportGroup' => 'planets', 'litleTxnId' => '1234567891234567891','authIndicator' => 'Estimated','amount' => '123');

        $batch_request = new BatchRequest($this->direct);
        $batch_request->addAuth($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts['auth']['count']);
        $this->assertEquals(123, $cts['auth']['amount']);
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
