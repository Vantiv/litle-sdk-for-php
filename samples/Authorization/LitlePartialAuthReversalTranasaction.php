<?php
namespace litle\sdk;
require_once realpath(__DIR__). '/../../vendor/autoload.php';
 
#Partial Auth Reversal
#litleTxnId contains the Litle Transaction Id returned on the authorization
 
$authRev_info = array(
  'litleTxnId'=>'350000000000000001',
  'amount'=>'20020'
);
 
$initialize = new LitleOnlineRequest();
$reversalResponse = $initialize->authReversalRequest($authRev_info);
#display results
echo ("Response: " . (XmlParser::getNode($reversalResponse,'response')) . "<br>");
echo ("Message: " . XmlParser::getNode($reversalResponse,'message') . "<br>");
echo ("Litle Transaction ID: " . XmlParser::getNode($reversalResponse,'litleTxnId'));

if(XmlParser::getNode($reversalResponse,'message')!='Approved')
 throw new \Exception('LitlePartialAuthReversalTranasaction does not get the right response');