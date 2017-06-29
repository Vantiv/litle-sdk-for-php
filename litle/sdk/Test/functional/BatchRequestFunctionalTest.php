<?php

namespace litle\sdk\Test\functional;

use litle\sdk\BatchRequest;

require_once realpath(dirname(__FILE__)) . '../../../LitleOnline.php';

class BatchRequestFunctionalTest extends \PHPUnit_Framework_TestCase
{
    private $direct;

    public function setUp()
    {
        $this->direct = sys_get_temp_dir() . '/test';
        if (!file_exists($this->direct)) {
            mkdir($this->direct);
        }
    }

    public function test_simpleAddTransaction()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addSale($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['sale'] ['count']);
        $this->assertEquals(123, $cts ['sale'] ['amount']);
    }

    function test_addSale()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addSale($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['sale'] ['count']);
        $this->assertEquals(123, $cts ['sale'] ['amount']);
    }

    public function test_addAuth()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'litleTxnId' => '12345678000',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addAuth($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['auth'] ['count']);
        $this->assertEquals(123, $cts ['auth'] ['amount']);
    }

    public function test_addAuthReversal()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'litleTxnId' => '12345678000',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addAuthReversal($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['authReversal'] ['count']);
        $this->assertEquals(123, $cts ['authReversal'] ['amount']);
    }

    public function test_addGiftCardAuthReversal()
    {
        $hash_in = array(
            'id' => 'id',
            'litleTxnId' => '12345678000',
            'captureAmount' => '123',
            'card' => array(
                'type' => 'GC',
                'number' => '4100000000000001',
                'expDate' => '0118',
                'pin' => '1234',
                'cardValidationNum' => '411'
            ),
            'originalRefCode' => '101',
            'originalAmount' => '123',
            'originalTxnTime' => '2017-01-24T09:00:00',
            'originalSystemTraceId' => '33',
            'originalSequenceNumber' => '111111'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addGiftCardAuthReversal($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['giftCardAuthReversal'] ['count']);
        $this->assertEquals(123, $cts ['giftCardAuthReversal'] ['amount']);
    }

    public function test_addCredit()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addCredit($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['credit'] ['count']);
        $this->assertEquals(123, $cts ['credit'] ['amount']);
    }

    public function test_addGiftCardCredit()
    {
        $hash_in = array(
            'litleTxnId' => '12312312',
            'reportGroup' => 'Planets',
            'creditAmount' => '123',
            'id' => '1211',
            'card' => array(
                'type' => 'GC',
                'number' => '4100521234567000',
                'expDate' => '0118',
                'pin' => '1234',
                'cardValidationNum' => '411'
            )
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addGiftCardCredit($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['giftCardCredit'] ['count']);
        $this->assertEquals(123, $cts ['giftCardCredit'] ['amount']);
    }

    public function test_addRegisterToken()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addRegisterToken($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['tokenRegistration'] ['count']);
    }

    public function test_addForceCapture()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addForceCapture($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['forceCapture'] ['count']);
        $this->assertEquals(123, $cts ['forceCapture'] ['amount']);
    }

    public function test_addCapture()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'orderId' => '2111',
            'litleTxnId' => '12345678000',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addCapture($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['capture'] ['count']);
        $this->assertEquals(123, $cts ['capture'] ['amount']);
    }

    public function test_addGiftCardCapture()
    {
        $hash_in = array(
            'id' => 'id',
            'litleTxnId' => '12345678000',
            'captureAmount' => '123',
            'card' => array(
                'type' => 'GC',
                'number' => '4100100000000000',
                'expDate' => '0118',
                'pin' => '1234',
                'cardValidationNum' => '411'
            ),
            'originalRefCode' => '101',
            'originalAmount' => '34561',
            'originalTxnTime' => '2017-01-24T09:00:00'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addGiftCardCapture($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['giftCardCapture'] ['count']);
        $this->assertEquals(123, $cts ['giftCardCapture'] ['amount']);
    }

    public function test_addCaptureGivenAuth()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addCaptureGivenAuth($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['captureGivenAuth'] ['count']);
        $this->assertEquals(123, $cts ['captureGivenAuth'] ['amount']);
    }

    public function test_addEcheckRedeposit()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'orderId' => '2111',
            'litleTxnId' => '12345678000',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addEcheckRedeposit($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['echeckRedeposit'] ['count']);
    }

    public function test_addEcheckSale()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addEcheckSale($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['echeckSale'] ['count']);
        $this->assertEquals(123, $cts ['echeckSale'] ['amount']);
    }

    public function test_addEcheckPreNoteSale()
    {
        $hash_in = array('id' => 'id',
            'orderId' => '2111',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'addressLine1' => '3'
            ),
            'echeck' => array(
                'accType' => 'Checking',
                'accNum' => '12345657890',
                'routingNum' => '123456789',
                'checkNum' => '123455'
            )
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addEcheckPreNoteSale($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['echeckPreNoteSale'] ['count']);
    }

    public function test_addEcheckPreNoteCredit()
    {
        $hash_in = array('id' => 'id',
            'orderId' => '2111',
            'orderSource' => 'ecommerce',
            'billToAddress' => array(
                'addressLine1' => '3'
            ),
            'echeck' => array(
                'accType' => 'Checking',
                'accNum' => '12345657890',
                'routingNum' => '123456789',
                'checkNum' => '123455'
            )
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addEcheckPreNoteCredit($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['echeckPreNoteCredit'] ['count']);
    }

    // TODO: check content
    public function test_addSubmerchantCredit()
    {
        $hash_in = array('id' => 'id',
            'fundingSubmerchantId' => '2111',
            'submerchantName' => '001',
            'fundsTransferId' => '12345678',
            'amount' => '13',
            'accountInfo' => array(
                'accType' => 'Checking',
                'accNum' => '12345657890',
                'routingNum' => '123456789',
                'checkNum' => '123455'
            ),
            'customIdentifier' => 'Identifier'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addSubmerchantCredit($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['submerchantCredit'] ['count']);
        $this->assertEquals(13, $cts ['submerchantCredit'] ['amount']);
    }

    public function test_addVendorCredit()
    {
        $hash_in = array('id' => 'id',
            'fundingSubmerchantId' => '2111',
            'vendorName' => '001',
            'fundsTransferId' => '12345678',
            'amount' => '13',
            'accountInfo' => array(
                'accType' => 'Checking',
                'accNum' => '12345657890',
                'routingNum' => '123456789',
                'checkNum' => '123455'
            )

        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addVendorCredit($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['vendorCredit'] ['count']);
        $this->assertEquals(13, $cts ['vendorCredit'] ['amount']);
    }

    public function test_addPayFacCredit()
    {
        $hash_in = array('id' => 'id',
            'fundingSubmerchantId' => '2111',
            'fundsTransferId' => '12345678',
            'amount' => '13'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addPayFacCredit($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['payFacCredit'] ['count']);
        $this->assertEquals(13, $cts ['payFacCredit'] ['amount']);
    }

    public function test_addReserveCredit()
    {
        $hash_in = array('id' => 'id',
            'fundingSubmerchantId' => '2111',
            'fundsTransferId' => '12345678',
            'amount' => '13'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addReserveCredit($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['reserveCredit'] ['count']);
        $this->assertEquals(13, $cts ['reserveCredit'] ['amount']);
    }

    public function test_addPhysicalCheckCredit()
    {
        $hash_in = array('id' => 'id',
            'fundingSubmerchantId' => '2111',
            'fundsTransferId' => '12345678',
            'amount' => '13'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addPhysicalCheckCredit($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['physicalCheckCredit'] ['count']);
        $this->assertEquals(13, $cts ['physicalCheckCredit'] ['amount']);
    }

    public function test_addSubmerchantDebit()
    {
        $hash_in = array('id' => 'id',
            'fundingSubmerchantId' => '2111',
            'submerchantName' => '001',
            'fundsTransferId' => '12345678',
            'amount' => '13',
            'accountInfo' => array(
                'accType' => 'Checking',
                'accNum' => '12345657890',
                'routingNum' => '123456789',
                'checkNum' => '123455'
            ),
            'customIdentifier' => 'Identifier'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addSubmerchantDebit($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['submerchantDebit'] ['count']);
        $this->assertEquals(13, $cts ['submerchantDebit'] ['amount']);
    }

    public function test_addVendorDebit()
    {
        $hash_in = array('id' => 'id',
            'fundingSubmerchantId' => '2111',
            'vendorName' => '001',
            'fundsTransferId' => '12345678',
            'amount' => '13',
            'accountInfo' => array(
                'accType' => 'Checking',
                'accNum' => '12345657890',
                'routingNum' => '123456789',
                'checkNum' => '123455'
            )
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addVendorDebit($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['vendorDebit'] ['count']);
        $this->assertEquals(13, $cts ['vendorDebit'] ['amount']);
    }

    public function test_addPayFacDebit()
    {
        $hash_in = array('id' => 'id',
            'fundingSubmerchantId' => '2111',
            'fundsTransferId' => '12345678',
            'amount' => '13'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addPayFacDebit($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['payFacDebit'] ['count']);
        $this->assertEquals(13, $cts ['payFacDebit'] ['amount']);
    }

    public function test_addReserveDebit()
    {
        $hash_in = array('id' => 'id',
            'fundingSubmerchantId' => '2111',
            'fundsTransferId' => '12345678',
            'amount' => '13'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addReserveDebit($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['reserveDebit'] ['count']);
        $this->assertEquals(13, $cts ['reserveDebit'] ['amount']);
    }

    public function test_addPhysicalCheckDebit()
    {
        $hash_in = array('id' => 'id',
            'fundingSubmerchantId' => '2111',
            'fundsTransferId' => '12345678',
            'amount' => '13'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addPhysicalCheckDebit($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['physicalCheckDebit'] ['count']);
        $this->assertEquals(13, $cts ['physicalCheckDebit'] ['amount']);
    }

    public function test_addEcheckCredit()
    {
        $hash_in = array('id' => 'id',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addEcheckCredit($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['echeckCredit'] ['count']);
        $this->assertEquals(123, $cts ['echeckCredit'] ['amount']);
    }

    public function test_addEcheckVerification()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addEcheckVerification($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['echeckVerification'] ['count']);
        $this->assertEquals(123, $cts ['echeckVerification'] ['amount']);
    }

    public function test_addUpdateCardValidationNumOnTokenHash()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'orderId' => '2111',
            'litleToken' => '123456789101112',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123',
            'cardValidationNum' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addUpdateCardValidationNumOnToken($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['updateCardValidationNumOnToken'] ['count']);
    }

    public function test_addUpdateSubscriptionHash()
    {
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
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addUpdateSubscription($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['updateSubscription'] ['count']);
    }

    public function test_addCancelSubscriptionHash()
    {
        $hash_in = array(
            'subscriptionId' => '1'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addCancelSubscription($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['cancelSubscription'] ['count']);
    }

    public function test_addCreatePlanHash()
    {
        $hash_in = array(
            'planCode' => '1',
            'name' => '2',
            'intervalType' => 'MONTHLY',
            'amount' => '1000'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addCreatePlan($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['createPlan'] ['count']);
    }

    public function test_addUpdatePlanHash()
    {
        $hash_in = array(
            'planCode' => '1',
            'active' => 'false'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addUpdatePlan($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['updatePlan'] ['count']);
    }

    public function test_addActivateHash()
    {
        $hash_in = array('id' => 'id',
            'orderId' => '1',
            'amount' => '2',
            'orderSource' => 'ECOMMERCE',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addActivate($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['activate'] ['count']);
        $this->assertEquals(2, $cts ['activate'] ['amount']);
    }

    public function test_addDeactivateHash()
    {
        $hash_in = array('id' => 'id',
            'orderId' => '1',
            'orderSource' => 'ECOMMERCE',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addDeactivate($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['deactivate'] ['count']);
    }

    public function test_addLoadHash()
    {
        $hash_in = array('id' => 'id',
            'orderId' => '1',
            'amount' => '2',
            'orderSource' => 'ECOMMERCE',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addLoad($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['load'] ['count']);
        $this->assertEquals(2, $cts ['load'] ['amount']);
    }

    public function test_addUnloadHash()
    {
        $hash_in = array('id' => 'id',
            'orderId' => '1',
            'amount' => '2',
            'orderSource' => 'ECOMMERCE',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addUnload($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['unload'] ['count']);
        $this->assertEquals(2, $cts ['unload'] ['amount']);
    }

    public function test_addBalanceInquiryHash()
    {
        $hash_in = array('id' => 'id',
            'orderId' => '1',
            'orderSource' => 'ECOMMERCE',
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            )
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addBalanceInquiry($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $this->assertEquals(1, $batch_request->total_txns);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['balanceInquiry'] ['count']);
    }

    public function test_mechaBatch()
    {
        $batch = new BatchRequest ($this->direct);
        $hash_in = array('id' => 'id',
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

        $hash_in = array('id' => 'id',
            'litleTxnId' => '1234567890',
            'reportGroup' => 'Planets',
            'amount' => '5000'
        );
        $batch->addAuthReversal($hash_in);

        $hash_in = array('id' => 'id',
            'litleTxnId' => '12312312',
            'amount' => '123'
        );
        $batch->addCapture($hash_in);

        $hash_in = array('id' => 'id',
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

        $hash_in = array('id' => 'id',
            'litleTxnId' => '12312312',
            'reportGroup' => 'Planets',
            'amount' => '123'
        );
        $batch->addCredit($hash_in);

        $hash_in = array('id' => 'id',
            'litleTxnId' => '123123'
        );
        $batch->addEcheckCredit($hash_in);

        $hash_in = array(
            'litleTxnId' => '123123', 'id' => 'id',
        );
        $batch->addEcheckRedeposit($hash_in);

        $hash_in = array('id' => 'id',
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

        $hash_in = array('id' => 'id',
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

        $hash_in = array('id' => 'id',
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

        $hash_in = array(
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

        $hash_in = array('id' => 'id',
            'orderId' => '1',
            'accountNumber' => '123456789101112'
        );
        $batch->addRegisterToken($hash_in);

        $hash_in = array('id' => 'id',
            'orderId' => '1',
            'litleToken' => '123456789101112',
            'cardValidationNum' => '123'
        );
        $batch->addUpdateCardValidationNumOnToken($hash_in);

        $this->assertEquals(13, $batch->total_txns);
        $cts = $batch->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['sale'] ['count']);
        $this->assertEquals(1, $cts ['auth'] ['count']);
        $this->assertEquals(1, $cts ['credit'] ['count']);
        $this->assertEquals(1, $cts ['tokenRegistration'] ['count']);
        $this->assertEquals(1, $cts ['capture'] ['count']);
        $this->assertEquals(1, $cts ['forceCapture'] ['count']);
        $this->assertEquals(1, $cts ['echeckRedeposit'] ['count']);
        $this->assertEquals(1, $cts ['echeckSale'] ['count']);
        $this->assertEquals(1, $cts ['echeckCredit'] ['count']);
        $this->assertEquals(1, $cts ['echeckVerification'] ['count']);
        $this->assertEquals(1, $cts ['updateCardValidationNumOnToken'] ['count']);

        $this->assertEquals(123, $cts ['sale'] ['amount']);
        $this->assertEquals(123, $cts ['auth'] ['amount']);
        $this->assertEquals(123, $cts ['credit'] ['amount']);
        $this->assertEquals(123, $cts ['capture'] ['amount']);
        $this->assertEquals(106, $cts ['forceCapture'] ['amount']);
        $this->assertEquals(123456, $cts ['echeckSale'] ['amount']);
        $this->assertEquals(123456, $cts ['echeckVerification'] ['amount']);
    }

    public function test_addAccountUpdate()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addAccountUpdate($hash_in);

        $this->assertTrue(file_exists($batch_request->batch_file));
        $cts = $batch_request->getCountsAndAmounts();
        $this->assertEquals(1, $cts ['accountUpdate'] ['count']);
    }

    public function test_addAccountUpdate_negative_with_transaction_before_accountUpdate()
    {
        try {
            $hash_in = array(
                'card' => array(
                    'type' => 'VI',
                    'number' => '4100000000000000',
                    'expDate' => '1213',
                    'cardValidationNum' => '1213'
                ),
                'id' => '1211',
                'orderId' => '2111',
                'reportGroup' => 'Planets',
                'orderSource' => 'ecommerce',
                'amount' => '123'
            );
            $batch_request = new BatchRequest ($this->direct);
            $batch_request->addSale($hash_in);
            $batch_request->addAccountUpdate($hash_in);
        } catch (\RuntimeException $expected) {
            $this->assertEquals($expected->getMessage(), "The transaction could not be added to the batch. The transaction type accountUpdate cannot be mixed with non-Account Updates.");

            return;
        }

        $this->fail("test_addAccountUpdate_negative_with_transaction_before_accountUpdate is expected to fail");
    }

    public function test_addAccountUpdate_negative_with_transaction_after_accountUpdate()
    {
        try {
            $hash_in = array(
                'card' => array(
                    'type' => 'VI',
                    'number' => '4100000000000000',
                    'expDate' => '1213',
                    'cardValidationNum' => '1213'
                ),
                'id' => '1211',
                'orderId' => '2111',
                'reportGroup' => 'Planets',
                'orderSource' => 'ecommerce',
                'amount' => '123'
            );
            $batch_request = new BatchRequest ($this->direct);
            $batch_request->addAccountUpdate($hash_in);
            $batch_request->addSale($hash_in);
        } catch (\RuntimeException $expected) {
            $this->assertEquals($expected->getMessage(), "The transaction could not be added to the batch. The transaction type sale cannot be mixed with AccountUpdates.");

            return;
        }

        $this->fail("test_addAccountUpdate_negative_with_transaction_after_accountUpdate is expected to fail");
    }

    public function test_isFull()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );

        $this->setExpectedException('RuntimeException', 'The transaction could not be added to the batch. It is full.');
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->total_txns = MAX_TXNS_PER_BATCH;
        $batch_request->addSale($hash_in);
    }

    public function test_addTooManyTransactions()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->total_txns = MAX_TXNS_PER_BATCH;

        $this->setExpectedException('RuntimeException', 'The transaction could not be added to the batch. It is full.');

        $batch_request->addSale($hash_in);
    }

    public function test_addToClosedBatch()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->closed = TRUE;
        $this->setExpectedException('RuntimeException', 'Could not add the transaction. This batchRequest is closed.');

        $batch_request->addSale($hash_in);
    }

    public function test_closeRequest()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addSale($hash_in);
        $batch_request->closeRequest();

        $data = file_get_contents($batch_request->batch_file);
        $this->assertTrue(!(!strpos($data, 'numSales="1"')));
        $this->assertTrue($batch_request->closed);
    }

    public function test_closeRequest_badFile()
    {
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->transaction_file = "/usr/NOPERMS";

        $this->setExpectedException('RuntimeException', 'Could not open transactions file at /usr/NOPERMS. Please check your privilege.');
        $batch_request->closeRequest();
    }

    public function test_getCountsAndAmounts()
    {
        $hash_in = array(
            'card' => array(
                'type' => 'VI',
                'number' => '4100000000000000',
                'expDate' => '1213',
                'cardValidationNum' => '1213'
            ),
            'id' => '1211',
            'orderId' => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount' => '123'
        );
        $batch_request = new BatchRequest ($this->direct);
        $batch_request->addSale($hash_in);

        $cts = $batch_request->getCountsAndAmounts();
        $this->assertNotNull($cts);
    }

    public function tearDown()
    {
        $files = glob($this->direct . '/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file))
                unlink($file); // delete file
        }
        rmdir($this->direct);
    }
}
