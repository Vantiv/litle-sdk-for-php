<?php
error_reporting(E_ALL);
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
		$hash_out = array(
			'litleTxnId'=> Checker::$hash_in['litleTxnId'],
			'orderId'=> Checker::required_field($hash_in['orderId']),
			'amount'=>Checker::required_field($hash_in['amount']),
			'orderSource'=>Checker::required_field($hash_in['orderSource']),
			'customerInfo'=>XMLFields::customerInfo($hash_in['customerInfo']),
			'billToAddress'=>XMLFields::contact($hash_in['billToAddress']),
			'shipToAddress'=>XMLFields::contact($hash_in['shipToAddress']),
			'card'=> XMLFields::cardType($hash_in['card']),
			'paypal'=>XMLFields::payPal($hash_in['paypal']),
			'token'=>XMLFields::cardTokenType($hash_in['token']),
			'paypage'=>XMLFields::cardPaypageType($hash_in['paypage']),
			'billMeLaterRequest'=>XMLFields::billMeLaterRequest($hash_in['billMeLaterRequest']),
			'cardholderAuthentication'=>XMLFields::fraudCheckType($hash_in['cardholderAuthentication']),
			'processingInstructions'=>XMLFields::processingInstructions($hash_in['processingInstructions']),
			'pos'=>XMLFields::pos($hash_in['pos']),
			'customBilling'=>XMLFields::customBilling($hash_in['customBilling']),
			'taxBilling'=>XMLFields::taxBilling($hash_in['taxBilling']),
			'enhancedData'=>XMLFields::enhancedData($hash_in['enhancedData']),
			'amexAggregatorData'=>XMLFields::amexAggregatorData($hash_in['amexAggregatorData']),
			'allowPartialAuth'=>$hash_in['allowPartialAuth'],
			'healthcareIIAS'=>XMLFields.healthcareIIAS($hash_in['healthcareIIAS']),
			'filtering'=>XMLFields::filteringType($hash_in['filtering']),
			'merchantData'=>XMLFields::filteringType($hash_in['merchantData']),
			'recyclingRequest'=>XMLFields::recyclingRequestType($hash_in['recyclingRequest']));
		
			#litleOnline_hash = build_full_hash($hash_in, {
				#:authorization => hash_out})
				#LitleXmlMapper::request('authorizationRequest',litleOnline_hash,@config_hash)
	}

	#private function($config)
	#{
	#	$hash_out = array(
	#	'user' =>(Checker::requiredValue($config['user'])),
	#	'password' =>(Checker::requiredValue($config['password'])));
	#	return $hash_out;
	#}
	
}
// echo "Start";
// $hash=array(
// 		'customerReference'=>'yes',
// 		'salesTax'=>'5',
// 		'deliveryType'=>'ups',
// 		'taxExempt'=>'no',
// 		'lineItemData' => (array('lineItemTotal'=>'1',
// 		'itemDiscountAmount'=>'3')));
// $config = array('usr'=>'IMPTEST',
// 			'password'=>'cert3d6Z',
// 			'merchantId'=>'087900',
// 			'version'=>'8.8',
// 			'reportGroup'=>'Planets',
// 			'litleTxnId'=>'1234567890');
// $type = 'authentication';
// $hash_out = XMLFields::enhancedData($hash);
// $converter=new Obj2xml("litleOnlineRequest",$config);
// #header("Content-Type:text/xml");
// $req = $converter->toXml($hash,$type,$config);
// $response = communication::httpRequest($req);
// echo $response;
// echo $req;
?>
