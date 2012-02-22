<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', '1');

require_once realpath(dirname(__FILE__)) . '/LitleXmlMapper.php';
require_once realpath(dirname(__FILE__)) . '/Checker.php';
require_once realpath(dirname(__FILE__)) . '/XMLFields.php';
require_once realpath(dirname(__FILE__)) . '/communication.php';
require_once realpath(dirname(__FILE__)) . '/Obj2xml.php';
require_once realpath(dirname(__FILE__)) . '/Xml_parser.php';

class LitleOnlineRequest
{
	public function __construct()
	{
		#load configuration file
		$this->newXML = new LitleXmlMapper();
	}

	public function authorizationRequest($hash_in)
	{
		$config = array('user'=>'PHXMLTEST',
				'password' => 'certpass', 
				'merchantId' => '101',
				'version' => '8.10', 
				'reportGroup' => 'planets',
				'id' => '10');
		$hash_out = array(
			'litleTxnId'=> ($hash_in['litleTxnId']),
			'orderId'=> Checker::required_field($hash_in['orderId']),
			'amount'=>Checker::required_field($hash_in['amount']),
			'orderSource'=>Checker::required_field($hash_in['orderSource']),
			'customerInfo'=>(XMLFields::customerInfo($hash_in['customerInfo'])),
			'billToAddress'=>(XMLFields::contact($hash_in['billToAddress'])),
			'shipToAddress'=>(XMLFields::contact($hash_in['shipToAddress'])),
			'card'=> (XMLFields::cardType($hash_in['card'])),
			'paypal'=>(XMLFields::payPal($hash_in['paypal'])),
			'token'=>(XMLFields::cardTokenType($hash_in['token'])),
			'paypage'=>(XMLFields::cardPaypageType($hash_in['paypage'])),
			'billMeLaterRequest'=>(XMLFields::billMeLaterRequest($hash_in['billMeLaterRequest'])),
			'cardholderAuthentication'=>(XMLFields::fraudCheckType($hash_in['cardholderAuthentication'])),
			'processingInstructions'=>(XMLFields::processingInstructions($hash_in['processingInstructions'])),
			'pos'=>(XMLFields::pos($hash_in['pos'])),
			'customBilling'=>(XMLFields::customBilling($hash_in['customBilling'])),
			'taxBilling'=>(XMLFields::taxBilling($hash_in['taxBilling'])),
			'enhancedData'=>(XMLFields::enhancedData($hash_in['enhancedData'])),
			'amexAggregatorData'=>(XMLFields::amexAggregatorData($hash_in['amexAggregatorData'])),
			'allowPartialAuth'=>$hash_in['allowPartialAuth'],
			'healthcareIIAS'=>(XMLFields::healthcareIIAS($hash_in['healthcareIIAS'])),
			'filtering'=>(XMLFields::filteringType($hash_in['filtering'])),
			'merchantData'=>(XMLFields::filteringType($hash_in['merchantData'])),
			'recyclingRequest'=>(XMLFields::recyclingRequestType($hash_in['recyclingRequest'])));

		$request = Obj2xml::toXml($hash_out,'authorization',$config);
		$choice_hash = array($hash_out['card'],$hash_out['paypal'],$hash_out['token'],$hash_out['paypage']);
		Checker::choice($choice_hash);
		$respOb = $this->newXML->request($request);
		return $respOb;
	}
	public function saleRequest($hash_in)
	{
		$config = array('user'=>'PHXMLTEST',
						'password' => 'certpass', 
						'merchantId' => '101',
						'version' => '8.10', 
						'reportGroup' => 'planets',
						'id' => '10');
		$hash_out = array(
		'litleTxnId' => $hash_in['litleTxnId'],
		'orderId' =>Checker::required_field($hash_in['orderId']),
		'amount' =>Checker::required_field($hash_in['amount']),
		'orderSource'=>Checker::required_field($hash_in['orderSource']),
		'customerInfo'=>XMLFields::customerInfo($hash_in['customerInfo']),
		'billToAddress'=>XMLFields::contact($hash_in['billToAddress']),
		'shipToAddress'=>XMLFields::contact($hash_in['shipToAddress']),
		'card'=> XMLFields::cardType($hash_in['card']),
		'paypal'=>XMLFields::payPal($hash_in['paypal']),
		'token'=>XMLFields::cardTokenType($hash_in['token']),
		'paypage'=>XMLFields::cardPaypageType($hash_in['paypage']),
		'billMeLaterRequest'=>XMLFields::billMeLaterRequest($hash_in['billMeLaterRequest']),
		'fraudCheck'=>XMLFields::fraudCheckType($hash_in['fraudCheck']),
		'cardholderAuthentication'=>XMLFields::fraudCheckType($hash_in['cardholderAuthentication']),
		'customBilling'=>XMLFields::customBilling($hash_in['customBilling']),
		'taxBilling'=>XMLFields::taxBilling($hash_in['taxBilling']),
		'enhancedData'=>XMLFields::enhancedData($hash_in['enhancedData']),
		'processingInstructions'=>XMLFields::processingInstructions($hash_in['processingInstructions']),
		'pos'=>XMLFields::pos($hash_in['pos']),
		'payPalOrderComplete'=> $hash_in['paypalOrderComplete'],
		'payPalNotes'=> $hash_in['paypalNotesType'],
		'amexAggregatorData'=>XMLFields::amexAggregatorData($hash_in['amexAggregatorData']),
		'allowPartialAuth'=>$hash_in['allowPartialAuth'],
		'healthcareIIAS'=>XMLFields::healthcareIIAS($hash_in['healthcareIIAS']),
		'filtering'=>XMLFields::filteringType($hash_in['filtering']),
		'merchantData'=>XMLFields::filteringType($hash_in['merchantData']),
		'recyclingRequest'=>XMLFields::recyclingRequestType($hash_in['recyclingRequest']));

		$request = Obj2xml::toXml($hash_out,'sale',$config);

		$choice_hash = array($hash_out['card'],$hash_out['paypal'],$hash_out['token'],$hash_out['paypage']);
		Checker::choice($choice_hash);
		$choice2_hash= array($hash_out['fraudCheck'],$hash_out['cardholderAuthentication']);
		Checker::choice($choice2_hash);

		$respOb = $this->newXML->request($request);
		return $respOb;
	}

	public function authReversalRequest($hash_in)
	{
		$hash_out = array(
			'litleTxnId' => XMLFields::required_field($hash_in['litleTxnId']),
			'amount' =>$hash_in['amount'],
			'payPalNotes'=>$hash_in['payPalNotes'],
			'actionReason'=>$hash_in['actionReason']);

		$request = Obj2xml::toXml($hash_out,'authReversal',$config);
		$respOb = $this->newXML->request($request);
		return $respOb;
	}

	public function creditRequest($hash_in)
	{
		$hash_out = array(
			'litleTxnId' => $hash_in['litleTxnId'],
			'orderId' =>$hash_in['orderId'],
			'amount' =>$hash_in['amount'],
			'orderSource'=>$hash_in['orderSource'],
			'billToAddress'=>XMLFields::contact($hash_in['billToAddress']),
			'card'=> XMLFields::cardType($hash_in['card']),
			'paypal'=>XMLFields::payPal($hash_in['paypal']),
			'token'=>XMLFields::cardTokenType($hash_in['token']),
			'paypage'=>XMLFields::cardPaypageType($hash_in['paypage']),
			'customBilling'=>XMLFields::customBilling($hash_in['customBilling']),
			'taxBilling'=>XMLFields::taxBilling($hash_in['taxBilling']),
			'billMeLaterRequest'=>XMLFields::billMeLaterRequest($hash_in['billMeLaterRequest']),
			'enhancedData'=>XMLFields::enhancedData($hash_in['enhancedData']),
			'processingInstructions'=>XMLFields::processingInstructions($hash_in['processingInstructions']),
			'pos'=>XMLFields::pos($hash_in['pos']),
			'amexAggregatorData'=>XMLFields::amexAggregatorData($hash_in['amexAggregatorData']),
			'payPalNotes' =>$hash_in['payPalNotes']);

		$request = Obj2xml::toXml($hash_out,'capture',$config);
		$choice_hash = array($hash_out['card'],$hash_out['paypal'],$hash_out['token'],$hash_out['paypage']);
		Checker::choice($choice_hash);
		$creditResponse = $this->newXML->request($request);
		return $creditResponse;

	}
	
	public function captureRequest($hash_in)
	{
		$config = array('user'=>'PHXMLTEST',
								'password' => 'certpass', 
								'merchantId' => '101',
								'version' => '8.10', 
								'reportGroup' => 'planets',
								'id' => '10');
		$hash_out = array(
				'partial'=>$hash_in['partial'],
			'litleTxnId' => Checker::required_field($hash_in['litleTxnId']),
		'amount' =>($hash_in['amount']),
		'enhancedData'=>XMLFields::enhancedData($hash_in['enhancedData']),
		'processingInstructions'=>XMLFields::processingInstructions($hash_in['processingInstructions']),
		'payPalOrderComplete'=>$hash_in['payPalOrderComplete'],
		'payPalNotes' =>$hash_in['payPalNotes']);
	
		$request = Obj2xml::toXml($hash_out,'capture',$config);
		echo $request;
		$respOb = $this->newXML->request($request);
		return $respOb;
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
