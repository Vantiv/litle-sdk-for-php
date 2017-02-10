<?php
namespace litle\sdk;
require_once realpath(__DIR__). '/../../vendor/autoload.php';
#PHP SDK- Litle Credit Transaction
#Credit
#litleTxnId contains the Litle Transaction Id returned on 
#the capture or sale transaction being credited
#the amount is optional, if it isn't submitted the full amount will be credited
 
$credit_info = array(
		'litleTxnId'=>'100000000000000002',
                 'id'=> '456',
       		'amount'=>'1010'
		);
$initialize = new LitleOnlineRequest(); 
$creditResponse = $initialize->creditRequest($credit_info);
 
#display results
echo ("Response: " . (XmlParser::getNode($creditResponse,'response')) . "<br>");
echo ("Message: " . XmlParser::getNode($creditResponse,'message') . "<br>");
echo ("Litle Transaction ID: " . XmlParser::getNode($creditResponse,'litleTxnId'));

if(XmlParser::getNode($creditResponse,'message')!='Approved')
 throw new \Exception('LitleCreditTransaction does not get the right response');
