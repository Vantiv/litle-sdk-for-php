<?php
namespace litle\sdk;
require_once realpath(__DIR__). '/../vendor/autoload.php';

exec("../vendor/phpunit/phpunit/composer/bin/phpunit --configuration ../phpunit.xml ",$output);
print_r($output);

require_once ("Authorization/AuthWithPaypageReID.php");
require_once ("Authorization/LitleAuthorizationTransaction.php");
require_once ("Authorization/LitlePaymentFullLifeCycleExample.php");
require_once ("Authorization/LitleAuthReversalTransaction.php");
require_once ("Authorization/LitleReAuthorizationTransaction.php");
require_once ("Authorization/LitlePartialAuthReversalTranasaction.php");
require_once ("Credit/LitleCreditTransaction.php");
require_once ("Credit/LitleRefundTransaction.php");
require_once ("Capture/LitlePartialCapture.php");
require_once ("Capture/LitleCaptureTransaction.php");
require_once ("Capture/LitleCaptureGivenAuthTransaction.php");
require_once ("Capture/LitleForceCaptureTransaction.php");
require_once ("Sale/LitleSaleTransaction.php");
require_once ("Other/LitleAvsOnlyTransaction.php");
require_once ("Other/LitleVoidTransaction.php");
require_once ("Other/RawProcessing.php");
require_once ("Other/RfrRequest.php");
require_once ("Token/LitleRegisterTokenTransaction.php");
require_once ("Token/LitleSaleWithTokenTransaction.php");
require_once ("Batch/SampleBatchDriver.php");
require_once ("Batch/MechaBatch.php");
require_once ("Batch/ConfiguredLitleBatchRequestsMaually.php");






