<?php

namespace litle\sdk\Test\functional;

use litle\sdk\BatchRequest;
use litle\sdk\LitleRequest;
use litle\sdk\LitleResponseProcessor;

class BatchRequestEncryptionFunctionalTest extends \PHPUnit_Framework_TestCase
{
    private $direct;
    private $username;
    private $password;
    private $sftpUsername;
    private $sftpPassword;
    private $merchantId;

    public function setUp()
    {
        $this->direct = sys_get_temp_dir() . '/test';
        if (!file_exists($this->direct)) {
            mkdir($this->direct);
        }

        $this->username = $_SERVER['encUsername'];
        $this->password = $_SERVER['encPassword'];
        $this->sftpUsername = $_SERVER['encSftpUsername'];
        $this->sftpPassword = $_SERVER['encSftpPassword'];
        $this->merchantId = $_SERVER['encMerchantId'];
    }

    public function test_configuredLitleBatchRequestsManually()
    {
        $sale_info = array(
            'id' => '1',
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
                'number' =>'5112010000000003',
                'expDate' => '0112',
                'cardValidationNum' => '349',
                'type' => 'MC')
        );


        $config_hash = array(
            'user' => $this->username,
            'password' => $this->password,
            'merchantId' => $this->merchantId,
            'sftp_username' => $this->sftpUsername,
            'sftp_password' => $this->sftpPassword,
            'useEncryption' => 'true',
            'batch_url' => 'payments.vantivprelive.com',
        );

        $litle_request = new LitleRequest($config_hash);
        $batch_request = new BatchRequest();

        # add a sale to the batch
        $batch_request->addSale($sale_info);
        # close the batch, indicating that we intend to add no more sales
        $batch_request->closeRequest();
        # add the batch to the litle request
        $litle_request->addBatchRequest($batch_request);
        # close the litle request, indicating that we intend to add no more batches
        $litle_request->closeRequest();
        # send the batch to litle via SFTP
        $response_file = $litle_request->sendToLitle();
        # process the response file
        $resp = new LitleResponseProcessor($response_file);

        $message = $resp->getXmlReader()->getAttribute("message");
        $response = $resp->getXmlReader()->getAttribute("response");
        $this->assertEquals("Valid Format", $message);
        $this->assertEquals(0, $response);
    }

    public function test_mechaBatch()
    {
        $config_hash = array(
            'user' => $this->username,
            'password' => $this->password,
            'merchantId' => $this->merchantId,
            'sftp_username' => $this->sftpUsername,
            'sftp_password' => $this->sftpPassword,
            'useEncryption' => 'true',
        );
        $request = new LitleRequest($config_hash);

        $batch = new BatchRequest();
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
        $request->addBatchRequest($batch);

        $resp = new LitleResponseProcessor($request->sendToLitle());

        $message = $resp->getXmlReader()->getAttribute("message");
        $response = $resp->getXmlReader()->getAttribute("response");
        $this->assertEquals("Valid Format", $message);
        $this->assertEquals(0, $response);
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
