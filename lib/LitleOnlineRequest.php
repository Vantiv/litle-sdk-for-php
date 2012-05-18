<?php
/*
 * Copyright (c) 2011 Litle & Co.
*
* Permission is hereby granted, free of charge, to any person
* obtaining a copy of this software and associated documentation
* files (the "Software"), to deal in the Software without
* restriction, including without limitation the rights to use,
* copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the
* Software is furnished to do so, subject to the following
* conditions:
*
* The above copyright notice and this permission notice shall be
* included in all copies or substantial portions of the Software.
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND
* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
* OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
* WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
* FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
* OTHER DEALINGS IN THE SOFTWARE.
*/

class LitleOnlineRequest
{
	public function __construct()
	{
		$this->newXML = new LitleXmlMapper();
	}

	public function authorizationRequest($hash_in)
	{
		if (isset($hash_in['litleTxnId'])){
			$hash_out = array('litleTxnId'=> ($hash_in['litleTxnId']));
		}
		else {
			$hash_out = array(
			'orderId'=> Checker::requiredField($hash_in['orderId']),
			'amount'=>Checker::requiredField($hash_in['amount']),
			'orderSource'=>Checker::requiredField($hash_in['orderSource']),
			'customerInfo'=>(XmlFields::customerInfo($hash_in['customerInfo'])),
			'billToAddress'=>(XmlFields::contact($hash_in['billToAddress'])),
			'shipToAddress'=>(XmlFields::contact($hash_in['shipToAddress'])),
			'card'=> (XmlFields::cardType($hash_in['card'])),
			'paypal'=>(XmlFields::payPal($hash_in['paypal'])),
			'token'=>(XmlFields::cardTokenType($hash_in['token'])),
			'paypage'=>(XmlFields::cardPaypageType($hash_in['paypage'])),
			'billMeLaterRequest'=>(XmlFields::billMeLaterRequest($hash_in['billMeLaterRequest'])),
			'cardholderAuthentication'=>(XmlFields::fraudCheckType($hash_in['cardholderAuthentication'])),
			'processingInstructions'=>(XmlFields::processingInstructions($hash_in['processingInstructions'])),
			'pos'=>(XmlFields::pos($hash_in['pos'])),
			'customBilling'=>(XmlFields::customBilling($hash_in['customBilling'])),
			'taxBilling'=>(XmlFields::taxBilling($hash_in['taxBilling'])),
			'enhancedData'=>(XmlFields::enhancedData($hash_in['enhancedData'])),
			'amexAggregatorData'=>(XmlFields::amexAggregatorData($hash_in['amexAggregatorData'])),
			'allowPartialAuth'=>$hash_in['allowPartialAuth'],
			'healthcareIIAS'=>(XmlFields::healthcareIIAS($hash_in['healthcareIIAS'])),
			'filtering'=>(XmlFields::filteringType($hash_in['filtering'])),
			'merchantData'=>(XmlFields::merchantData($hash_in['merchantData'])),
			'recyclingRequest'=>(XmlFields::recyclingRequestType($hash_in['recyclingRequest'])),
			'fraudFilterOverride'=> $hash_in['fraudFilterOverride']);
		}

		$choice_hash = array($hash_out['card'],$hash_out['paypal'],$hash_out['token'],$hash_out['paypage']);
		$authorizationResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'authorization',$choice_hash);
		return $authorizationResponse;
	}

	public function saleRequest($hash_in)
	{
		$hash_out = array(
		'litleTxnId' => $hash_in['litleTxnId'],
		'orderId' =>Checker::requiredField($hash_in['orderId']),
		'amount' =>Checker::requiredField($hash_in['amount']),
		'orderSource'=>Checker::requiredField($hash_in['orderSource']),
		'customerInfo'=>XmlFields::customerInfo($hash_in['customerInfo']),
		'billToAddress'=>XmlFields::contact($hash_in['billToAddress']),
		'shipToAddress'=>XmlFields::contact($hash_in['shipToAddress']),
		'card'=> XmlFields::cardType($hash_in['card']),
		'paypal'=>XmlFields::payPal($hash_in['paypal']),
		'token'=>XmlFields::cardTokenType($hash_in['token']),
		'paypage'=>XmlFields::cardPaypageType($hash_in['paypage']),
		'billMeLaterRequest'=>XmlFields::billMeLaterRequest($hash_in['billMeLaterRequest']),
		'fraudCheck'=>XmlFields::fraudCheckType($hash_in['fraudCheck']),
		'cardholderAuthentication'=>XmlFields::fraudCheckType($hash_in['cardholderAuthentication']),
		'customBilling'=>XmlFields::customBilling($hash_in['customBilling']),
		'taxBilling'=>XmlFields::taxBilling($hash_in['taxBilling']),
		'enhancedData'=>XmlFields::enhancedData($hash_in['enhancedData']),
		'processingInstructions'=>XmlFields::processingInstructions($hash_in['processingInstructions']),
		'pos'=>XmlFields::pos($hash_in['pos']),
		'payPalOrderComplete'=> $hash_in['paypalOrderComplete'],
		'payPalNotes'=> $hash_in['paypalNotesType'],
		'amexAggregatorData'=>XmlFields::amexAggregatorData($hash_in['amexAggregatorData']),
		'allowPartialAuth'=>$hash_in['allowPartialAuth'],
		'healthcareIIAS'=>XmlFields::healthcareIIAS($hash_in['healthcareIIAS']),
		'filtering'=>XmlFields::filteringType($hash_in['filtering']),
		'merchantData'=>XmlFields::merchantData($hash_in['merchantData']),
		'recyclingRequest'=>XmlFields::recyclingRequestType($hash_in['recyclingRequest']),
		'fraudFilterOverride'=> $hash_in['fraudFilterOverride']);		

		$choice_hash = array($hash_out['card'],$hash_out['paypal'],$hash_out['token'],$hash_out['paypage']);
		$choice2_hash= array($hash_out['fraudCheck'],$hash_out['cardholderAuthentication']);
		$saleResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'sale',$choice_hash,$choice_hash2);
		return $saleResponse;
	}

	public function authReversalRequest($hash_in)
	{
		$hash_out = array(
			'litleTxnId' => Checker::requiredField($hash_in['litleTxnId']),
			'amount' =>$hash_in['amount'],
			'payPalNotes'=>$hash_in['payPalNotes'],
			'actionReason'=>$hash_in['actionReason']);
		$authReversalResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'authReversal');
		return $authReversalResponse;
	}

	public function creditRequest($hash_in)
	{
		$hash_out = array(
					'litleTxnId' => XmlFields::returnArrayValue($hash_in, 'litleTxnId'),
					'orderId' =>XmlFields::returnArrayValue($hash_in, 'orderId'),
					'amount' =>XmlFields::returnArrayValue($hash_in, 'amount'),
					'orderSource'=>XmlFields::returnArrayValue($hash_in, 'orderSource'),
					'billToAddress'=>XmlFields::contact(XMLFields::returnArrayValue($hash_in, 'billToAddress')),
					'card'=>XmlFields::cardType(XMLFields::returnArrayValue($hash_in, 'card')),
					'paypal'=>XmlFields::credit_payPal(XMLFields::returnArrayValue($hash_in, 'paypal')),
					'token'=>XmlFields::cardTokenType(XMLFields::returnArrayValue($hash_in, 'token')),
					'paypage'=>XmlFields::cardPaypageType(XMLFields::returnArrayValue($hash_in, 'paypage')),
					'customBilling'=>XmlFields::customBilling(XMLFields::returnArrayValue($hash_in, 'customBilling')),
					'taxBilling'=>XmlFields::taxBilling(XMLFields::returnArrayValue($hash_in, 'taxBilling')),
					'billMeLaterRequest'=>XmlFields::billMeLaterRequest(XMLFields::returnArrayValue($hash_in, 'billMeLaterRequest')),
					'enhancedData'=>XmlFields::enhancedData(XMLFields::returnArrayValue($hash_in, 'enhancedData')),
					'processingInstructions'=>XmlFields::processingInstructions(XMLFields::returnArrayValue($hash_in, 'processingInstructions')),
					'pos'=>XmlFields::pos(XMLFields::returnArrayValue($hash_in, 'pos')),
					'amexAggregatorData'=>XmlFields::amexAggregatorData(XMLFields::returnArrayValue($hash_in, 'amexAggregatorData')),
					'payPalNotes' =>XmlFields::returnArrayValue($hash_in, 'payPalNotes'),
					'actionReason'=>XmlFields::returnArrayValue($hash_in, 'actionReason')
		);

		$choice_hash = array($hash_out['card'],$hash_out['paypal'],$hash_out['token'],$hash_out['paypage']);
		$creditResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'credit',$choice_hash);
		return $creditResponse;
	}

	public function registerTokenRequest($hash_in)
	{
		$hash_out = array(
		'orderId'=>$hash_in['orderId'],
		'accountNumber'=>$hash_in['accountNumber'],
		'echeckForToken'=>XmlFields::echeckForTokenType($hash_in['echeckForToken']),
		'paypageRegistrationId'=>$hash_in['paypageRegistrationId']);

		$choice_hash = array($hash_out['accountNumber'],$hash_out['echeckForToken'],$hash_out['paypageRegistrationId']);
		$registerTokenResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'registerTokenRequest',$choice_hash);
		return $registerTokenResponse;
	}

	public function forceCaptureRequest($hash_in)
	{
		$hash_out = array(
		'orderId' =>Checker::requiredField($hash_in['orderId']),
		'amount' =>$hash_in['amount'],
		'orderSource'=>Checker::requiredField($hash_in['orderSource']),
		'billToAddress'=>XmlFields::contact($hash_in['billToAddress']),
		'card'=> XmlFields::cardType($hash_in['card']),
		'token'=>XmlFields::cardTokenType($hash_in['token']),
		'paypage'=>XmlFields::cardPaypageType($hash_in['paypage']),
		'customBilling'=>XmlFields::customBilling($hash_in['customBilling']),
		'taxBilling'=>XmlFields::taxBilling($hash_in['taxBilling']),
		'enhancedData'=>XmlFields::enhancedData($hash_in['enhancedData']),
		'processingInstructions'=>XmlFields::processingInstructions($hash_in['processingInstructions']),
		'pos'=>XmlFields::pos($hash_in['pos']),
		'amexAggregatorData'=>XmlFields::amexAggregatorData($hash_in['amexAggregatorData']));

		$choice_hash = array($hash_out['card'],$hash_out['paypal'],$hash_out['token'],$hash_out['paypage']);
		$forceCaptureResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'forceCapture',$choice_hash);
		return $forceCaptureResponse;
	}

	public function captureRequest($hash_in)
	{
		$hash_out = array(
		'partial'=>$hash_in['partial'],
	    'litleTxnId' => Checker::requiredField($hash_in['litleTxnId']),
		'amount' =>($hash_in['amount']),
		'enhancedData'=>XmlFields::enhancedData($hash_in['enhancedData']),
		'processingInstructions'=>XmlFields::processingInstructions($hash_in['processingInstructions']),
		'payPalOrderComplete'=>$hash_in['payPalOrderComplete'],
		'payPalNotes' =>$hash_in['payPalNotes']);
		$captureResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'capture');
		return $captureResponse;
	}

	public function captureGivenAuthRequest($hash_in)
	{
		$hash_out = array(
		'orderId'=>Checker::requiredField($hash_in['orderId']),
		'authInformation'=>XmlFields::authInformation($hash_in['authInformation']),
		'amount' =>Checker::requiredField($hash_in['amount']),
		'orderSource'=>Checker::requiredField($hash_in['orderSource']),
		'billToAddress'=>XmlFields::contact($hash_in['billToAddress']),
		'shipToAddress'=>XmlFields::contact($hash_in['shipToAddress']),
		'card'=> XmlFields::cardType($hash_in['card']),
		'token'=>XmlFields::cardTokenType($hash_in['token']),
		'paypage'=>XmlFields::cardPaypageType($hash_in['paypage']),
		'customBilling'=>XmlFields::customBilling($hash_in['customBilling']),
		'taxBilling'=>XmlFields::taxBilling($hash_in['taxBilling']),
		'billMeLaterRequest'=>XmlFields::billMeLaterRequest($hash_in['billMeLaterRequest']),
		'enhancedData'=>XmlFields::enhancedData($hash_in['enhancedData']),
		'processingInstructions'=>XmlFields::processingInstructions($hash_in['processingInstructions']),
		'pos'=>XmlFields::pos($hash_in['pos']),
		'amexAggregatorData'=>XmlFields::amexAggregatorData($hash_in['amexAggregatorData']));

		$choice_hash = array($hash_out['card'],$hash_out['token'],$hash_out['paypage']);
		$captureGivenAuthResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'captureGivenAuth',$choice_hash);
		return $captureGivenAuthResponse;
	}

	public function echeckRedepositRequest($hash_in)
	{
		$hash_out = array(
		'litleTxnId' => Checker::requiredField($hash_in['litleTxnId']),
		'echeck'=>XmlFields::echeckType($hash_in['echeck']),
		'echeckToken'=>XmlFields::echeckTokenType($hash_in['echeckToken']));
		
		$choice_hash = array($hash_out['echeck'],$hash_out['echeckToken']);
		$echeckRedepositResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'echeckRedeposit',$choice_hash);
		return $echeckRedepositResponse;
	}

	public function echeckSaleRequest($hash_in)
	{
		$hash_out = array(
		'litleTxnId'=>$hash_in['litleTxnId'],
		'orderId'=>$hash_in['orderId'],
		'verify'=>$hash_in['verify'],
		'amount'=>$hash_in['amount'],
		'orderSource'=>$hash_in['orderSource'],
		'billToAddress'=>XmlFields::contact($hash_in['billToAddress']),
		'shipToAddress'=>XmlFields::contact($hash_in['shipToAddress']),
		'echeck'=>XmlFields::echeckType($hash_in['echeck']),
		'echeckToken'=>XmlFields::echeckTokenType($hash_in['echeckToken']),
		'customBilling'=>XmlFields::customBilling($hash_in['customBilling']));

		$choice_hash = array($hash_out['echeck'],$hash_out['echeckToken']);

		$echeckSaleResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'echeckSale',$choice_hash);
		return $echeckSaleResponse;
	}

	public function echeckCreditRequest($hash_in)
	{
		$hash_out = array(
			'litleTxnId'=>$hash_in['litleTxnId'],
			'orderId'=>$hash_in['orderId'],
			'amount'=>$hash_in['amount'],
			'orderSource'=>$hash_in['orderSource'],
			'billToAddress'=>XmlFields::contact($hash_in['billToAddress']),
			'echeck'=>XmlFields::echeckType($hash_in['echeck']),
			'echeckToken'=>XmlFields::echeckTokenType($hash_in['echeckToken']),
			'customBilling'=>XmlFields::customBilling($hash_in['customBilling']));

		$choice_hash = array($hash_out['echeck'],$hash_out['echeckToken']);
		$echeckCreditResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'echeckCredit',$choice_hash);
		return $echeckCreditResponse;
	}

	public function echeckVerificationRequest($hash_in)
	{
		
		$hash_out = array(
			'litleTxnId'=>$hash_in['litleTxnId'],
			'orderId'=>Checker::requiredField($hash_in['orderId']),
			'amount'=>Checker::requiredField($hash_in['amount']),
			'orderSource'=>Checker::requiredField($hash_in['orderSource']),
			'billToAddress'=>XmlFields::contact($hash_in['billToAddress']),
			'echeck'=>XmlFields::echeckType($hash_in['echeck']),
			'echeckToken'=>XmlFields::echeckTokenType($hash_in['echeckToken']));
		
		$choice_hash = array($hash_out['echeck'],$hash_out['echeckToken']);
		$choice_hash = array($hash_out['echeck'],$hash_out['echeckToken']);
		$echeckVerificationResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'echeckVerification',$choice_hash);
		return $echeckVerificationResponse;
	}

	public function voidRequest($hash_in)
	{
		$hash_out = array(
		'litleTxnId' => Checker::requiredField($hash_in['litleTxnId']),
	    'processingInstructions'=>XmlFields::processingInstructions($hash_in['processingInstructions']));

		$voidResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'void');
		return $voidResponse;
	}

	public function echeckVoidRequest($hash_in)
	{
		$hash_out = array(
		'litleTxnId' => Checker::requiredField($hash_in['litleTxnId']),
		);
		$echeckVoidResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,"echeckVoid");
		return $echeckVoidResponse;
	}

	private function overideConfig($hash_in)
	{
		$hash_out = array(
		'user'=>$hash_in['user'],
		'password'=>$hash_in['password'],
		'merchantId'=>$hash_in['merchantId'],
		'reportGroup'=>$hash_in['reportGroup'],
		'version'=>$hash_in['version'],
		'url'=>$hash_in['url'],
		'timeout'=>$hash_in['timeout'],
		'proxy'=>$hash_in['proxy']);
		return $hash_out;
	}
	
	private function getOptionalAttributes($hash_in,$hash_out)
	{
		if(isset($hash_in['merchantSdk'])) {
			$hash_out['merchantSdk'] = $hash_in['merchantSdk'];
		}
		else {
			$hash_out['merchantSdk'] = 'PHP;8.13.0';
		}
		if(isset($hash_in['id'])) {
			$hash_out['id'] = $hash_in['id'];
		}
		if(isset($hash_in['customerId'])) {
			$hash_out['customerId'] = $hash_in['customerId'];
		}
		return $hash_out;
	}

	private function processRequest($hash_out, $hash_in, $type, $choice1 = null, $choice2 = null)
	{
	
		$hash_config = LitleOnlineRequest::overideconfig($hash_in);
		
		$hash = LitleOnlineRequest::getOptionalAttributes($hash_in,$hash_out);
		Checker::choice($choice1);
		Checker::choice($choice2);
		$request = Obj2xml::toXml($hash,$hash_config, $type);
	
		$litleOnlineResponse = $this->newXML->request($request,$hash_config);
		return $litleOnlineResponse;
	}

}

