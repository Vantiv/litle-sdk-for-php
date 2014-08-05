<?php
namespace litle\sdk;
require_once realpath(__DIR__). '/../../vendor/autoload.php'; 
$request = new LitleRequest();
$request->createRFRRequest(array('litleSessionId' => '8675309'));
 


