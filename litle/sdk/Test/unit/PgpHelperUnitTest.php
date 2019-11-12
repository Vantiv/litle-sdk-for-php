<?php

namespace litle\sdk\Test\unit;

use litle\sdk\Obj2xml;
use litle\sdk\PgpHelper;

class PgpHelperUnitTest extends \PHPUnit_Framework_TestCase
{
    private $direct;
    private $requestFilename;
    private $encryptedRequestFilename;
    private $publicKey;
    private $responseFilename;
    private $decryptedResponseFilename;
    private $passphrase;

    public function setUp()
    {
        $this->direct = sys_get_temp_dir() . '/test' . CURRENT_SDK_VERSION;
        if (!file_exists($this->direct)) {
            mkdir($this->direct);
        }

        $config = Obj2xml::getConfig(array());

        $this->requestFilename = $this->direct."/test.txt";
        $input = "This is the text to be encrypted. PHP SDK V11";
        file_put_contents($this->requestFilename, $input);
        $this->encryptedRequestFilename = $this->direct."/test.asc";
        $this->publicKey = $_SERVER['testPublicKeyID'];
        $this->responseFilename = $this->direct."/test.asc";
        $this->decryptedResponseFilename = $this->direct."/test2.txt";
        $this->passphrase = $config['gpgPassphrase'];
    }

    public function test_encryptDecrypt(){
        PgpHelper::encrypt($this->requestFilename, $this->encryptedRequestFilename, $this->publicKey);
        $this->assertTrue(file_exists($this->encryptedRequestFilename));
        PgpHelper::decrypt($this->responseFilename, $this->decryptedResponseFilename, $this->passphrase);
        $this->assertTrue(file_exists($this->decryptedResponseFilename));
        $input = file_get_contents($this->requestFilename);
        $output = file_get_contents($this->decryptedResponseFilename);
        $this->assertEquals($input, $output);
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