<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', '1');


require_once realpath(dirname(__FILE__)) . '/Checker.php';
require_once realpath(dirname(__FILE__)) . '/XMLFields.php';
require_once realpath(dirname(__FILE__)) . '/Obj2xml.php';
require_once realpath(dirname(__FILE__)) . '/communication.php';

class LitleOnlineRequest
{
	public static function initilaize()
	{
		#load configuration file
	
		}

	public static function authorizationRequest($hash_in)
	{
		$config = array('user'=>'PHXMLTEST',
				'password' => 'certpass', 
				'merchantId' => '101',
				'version' => '8.10', 
				'reportGroup' => 'planets',
				'id' => '10');
		$hash_out = array(
			#'litleTxnId'=> Checker::required_field($hash_in['litleTxnId']),
			'orderId'=> Checker::required_field($hash_in['orderId']),
			'amount'=>Checker::required_field($hash_in['amount']),
			'orderSource'=>Checker::required_field($hash_in['orderSource']),
			'customerInfo'=>Checker::optional_field(XMLFields::customerInfo($hash_in['customerInfo'])),
			'billToAddress'=>Checker::optional_field(XMLFields::contact($hash_in['billToAddress'])),
			'shipToAddress'=>Checker::optional_field(XMLFields::contact($hash_in['shipToAddress'])),
			'card'=> Checker::optional_field(XMLFields::cardType($hash_in['card'])),
			'paypal'=>Checker::optional_field(XMLFields::payPal($hash_in['paypal'])),
			'token'=>Checker::optional_field(XMLFields::cardTokenType($hash_in['token'])),
			'paypage'=>Checker::optional_field(XMLFields::cardPaypageType($hash_in['paypage'])),
			'billMeLaterRequest'=>Checker::optional_field(XMLFields::billMeLaterRequest($hash_in['billMeLaterRequest'])),
			'cardholderAuthentication'=>Checker::optional_field(XMLFields::fraudCheckType($hash_in['cardholderAuthentication'])),
			'processingInstructions'=>Checker::optional_field(XMLFields::processingInstructions($hash_in['processingInstructions'])),
			'pos'=>Checker::optional_field(XMLFields::pos($hash_in['pos'])),
			'customBilling'=>Checker::optional_field(XMLFields::customBilling($hash_in['customBilling'])),
			'taxBilling'=>Checker::optional_field(XMLFields::taxBilling($hash_in['taxBilling'])),
			'enhancedData'=>Checker::optional_field(XMLFields::enhancedData($hash_in['enhancedData'])),
			'amexAggregatorData'=>Checker::optional_field(XMLFields::amexAggregatorData($hash_in['amexAggregatorData'])),
			'allowPartialAuth'=>$hash_in['allowPartialAuth'],
			'healthcareIIAS'=>Checker::optional_field(XMLFields::healthcareIIAS($hash_in['healthcareIIAS'])),
			'filtering'=>Checker::optional_field(XMLFields::filteringType($hash_in['filtering'])),
			'merchantData'=>Checker::optional_field(XMLFields::filteringType($hash_in['merchantData'])),
			'recyclingRequest'=>Checker::optional_field(XMLFields::recyclingRequestType($hash_in['recyclingRequest'])));
		
		//	litleOnline_hash = build_full_hash($hash_in, {
		//		:authorization => hash_out})
		
				  LitleXmlMapper::request($hash_out,'authorization',$config);
	}

	#private function($config)
	#{
	#	$hash_out = array(
	#	'user' =>(Checker::requiredValue($config['user'])),
	#	'password' =>(Checker::requiredValue($config['password'])));
	#	return $hash_out;
	#}
	
}
?>
