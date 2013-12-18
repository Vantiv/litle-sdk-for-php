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
	private $useSimpleXml = false;
	
	public function __construct($treeResponse=false)
	{
		$this->useSimpleXml = $treeResponse;	
		$this->newXML = new LitleXmlMapper();
	}

	public function authorizationRequest($hash_in)
	{
		if (isset($hash_in['litleTxnId'])){
			$hash_out = array('litleTxnId'=> (XmlFields::returnArrayValue($hash_in,'litleTxnId')));
		}
		else {
			$hash_out = array(
			'orderId'=> Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderId')),
			'amount'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'amount')),
			'surchargeAmount' =>XmlFields::returnArrayValue($hash_in,'surchargeAmount'),
			'orderSource'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderSource')),
			'customerInfo'=>(XmlFields::customerInfo(XmlFields::returnArrayValue($hash_in,'customerInfo'))),
			'billToAddress'=>(XmlFields::contact(XmlFields::returnArrayValue($hash_in,'billToAddress'))),
			'shipToAddress'=>(XmlFields::contact(XmlFields::returnArrayValue($hash_in,'shipToAddress'))),
			'card'=> (XmlFields::cardType(XmlFields::returnArrayValue($hash_in,'card'))),
			'paypal'=>(XmlFields::payPal(XmlFields::returnArrayValue($hash_in,'paypal'))),
			'token'=>(XmlFields::cardTokenType(XmlFields::returnArrayValue($hash_in,'token'))),
			'paypage'=>(XmlFields::cardPaypageType(XmlFields::returnArrayValue($hash_in,'paypage'))),
			'billMeLaterRequest'=>(XmlFields::billMeLaterRequest(XmlFields::returnArrayValue($hash_in,'billMeLaterRequest'))),
			'cardholderAuthentication'=>(XmlFields::fraudCheckType(XmlFields::returnArrayValue($hash_in,'cardholderAuthentication'))),
			'processingInstructions'=>(XmlFields::processingInstructions(XmlFields::returnArrayValue($hash_in,'processingInstructions'))),
			'pos'=>(XmlFields::pos(XmlFields::returnArrayValue($hash_in,'pos'))),
			'customBilling'=>(XmlFields::customBilling(XmlFields::returnArrayValue($hash_in,'customBilling'))),
			'taxBilling'=>(XmlFields::taxBilling(XmlFields::returnArrayValue($hash_in,'taxBilling'))),
			'enhancedData'=>(XmlFields::enhancedData(XmlFields::returnArrayValue($hash_in,'enhancedData'))),
			'amexAggregatorData'=>(XmlFields::amexAggregatorData(XmlFields::returnArrayValue($hash_in,'amexAggregatorData'))),
			'allowPartialAuth'=>XmlFields::returnArrayValue($hash_in,'allowPartialAuth'),
			'healthcareIIAS'=>(XmlFields::healthcareIIAS(XmlFields::returnArrayValue($hash_in,'healthcareIIAS'))),
			'filtering'=>(XmlFields::filteringType(XmlFields::returnArrayValue($hash_in,'filtering'))),
			'merchantData'=>(XmlFields::merchantData(XmlFields::returnArrayValue($hash_in,'merchantData'))),
			'recyclingRequest'=>(XmlFields::recyclingRequestType(XmlFields::returnArrayValue($hash_in,'recyclingRequest'))),
			'fraudFilterOverride'=> XmlFields::returnArrayValue($hash_in,'fraudFilterOverride'),
			'recurringRequest'=>XmlFields::recurringRequestType(XmlFields::returnArrayValue($hash_in,'recurringRequest')),
			'debtRepayment'=>XmlFields::returnArrayValue($hash_in,'debtRepayment'),
			'advancedFraudChecks'=>XmlFields::advancedFraudChecksType(XmlFields::returnArrayValue($hash_in,'advancedFraudChecks')),
			);
		}

		$choice_hash = array(XmlFields::returnArrayValue($hash_out,'card'),XmlFields::returnArrayValue($hash_out,'paypal'),XmlFields::returnArrayValue($hash_out,'token'),XmlFields::returnArrayValue($hash_out,'paypage'));
		$authorizationResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'authorization',$choice_hash);
		return $authorizationResponse;
	}

	public function saleRequest($hash_in)
	{
		$hash_out = array(
			'litleTxnId' => XmlFields::returnArrayValue($hash_in,'litleTxnId'),
			'orderId' =>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderId')),
			'amount' =>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'amount')),
			'surchargeAmount' =>XmlFields::returnArrayValue($hash_in,'surchargeAmount'),
			'orderSource'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderSource')),
			'customerInfo'=>XmlFields::customerInfo(XmlFields::returnArrayValue($hash_in,'customerInfo')),
			'billToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'billToAddress')),
			'shipToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'shipToAddress')),
			'card'=> XmlFields::cardType(XmlFields::returnArrayValue($hash_in,'card')),
			'paypal'=>XmlFields::payPal(XmlFields::returnArrayValue($hash_in,'paypal')),
			'token'=>XmlFields::cardTokenType(XmlFields::returnArrayValue($hash_in,'token')),
			'paypage'=>XmlFields::cardPaypageType(XmlFields::returnArrayValue($hash_in,'paypage')),
			'billMeLaterRequest'=>XmlFields::billMeLaterRequest(XmlFields::returnArrayValue($hash_in,'billMeLaterRequest')),
			'fraudCheck'=>XmlFields::fraudCheckType(XmlFields::returnArrayValue($hash_in,'fraudCheck')),
			'cardholderAuthentication'=>XmlFields::fraudCheckType(XmlFields::returnArrayValue($hash_in,'cardholderAuthentication')),
			'customBilling'=>XmlFields::customBilling(XmlFields::returnArrayValue($hash_in,'customBilling')),
			'taxBilling'=>XmlFields::taxBilling(XmlFields::returnArrayValue($hash_in,'taxBilling')),
			'enhancedData'=>XmlFields::enhancedData(XmlFields::returnArrayValue($hash_in,'enhancedData')),
			'processingInstructions'=>XmlFields::processingInstructions(XmlFields::returnArrayValue($hash_in,'processingInstructions')),
			'pos'=>XmlFields::pos(XmlFields::returnArrayValue($hash_in,'pos')),
			'payPalOrderComplete'=> XmlFields::returnArrayValue($hash_in,'paypalOrderComplete'),
			'payPalNotes'=> XmlFields::returnArrayValue($hash_in,'paypalNotesType'),
			'amexAggregatorData'=>XmlFields::amexAggregatorData(XmlFields::returnArrayValue($hash_in,'amexAggregatorData')),
			'allowPartialAuth'=>XmlFields::returnArrayValue($hash_in,'allowPartialAuth'),
			'healthcareIIAS'=>XmlFields::healthcareIIAS(XmlFields::returnArrayValue($hash_in,'healthcareIIAS')),
			'filtering'=>XmlFields::filteringType(XmlFields::returnArrayValue($hash_in,'filtering')),
			'merchantData'=>XmlFields::merchantData(XmlFields::returnArrayValue($hash_in,'merchantData')),
			'recyclingRequest'=>XmlFields::recyclingRequestType(XmlFields::returnArrayValue($hash_in,'recyclingRequest')),
			'fraudFilterOverride'=> XmlFields::returnArrayValue($hash_in,'fraudFilterOverride'),
			'recurringRequest'=>XmlFields::recurringRequestType(XmlFields::returnArrayValue($hash_in,'recurringRequest')),
			'litleInternalRecurringRequest'=>XmlFields::litleInternalRecurringRequestType(XmlFields::returnArrayValue($hash_in,'litleInternalRecurringRequest')),
			'debtRepayment'=>XmlFields::returnArrayValue($hash_in,'debtRepayment'),
			'advancedFraudChecks'=>XmlFields::advancedFraudChecksType(XmlFields::returnArrayValue($hash_in,'advancedFraudChecks')),
		);

		$choice_hash = array($hash_out['card'],$hash_out['paypal'],$hash_out['token'],$hash_out['paypage']);
		$choice2_hash= array($hash_out['fraudCheck'],$hash_out['cardholderAuthentication']);
		$saleResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'sale',$choice_hash,$choice2_hash);
		return $saleResponse;
	}

	public function authReversalRequest($hash_in)
	{
		$hash_out = array(
			'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
			'amount' =>XmlFields::returnArrayValue($hash_in,'amount'),
			'surchargeAmount' =>XmlFields::returnArrayValue($hash_in,'surchargeAmount'),
			'payPalNotes'=>XmlFields::returnArrayValue($hash_in,'payPalNotes'),
			'actionReason'=>XmlFields::returnArrayValue($hash_in,'actionReason'));
		$authReversalResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'authReversal');
		return $authReversalResponse;
	}

	public function creditRequest($hash_in)
	{
		$hash_out = array(
					'litleTxnId' => XmlFields::returnArrayValue($hash_in, 'litleTxnId'),
					'orderId' =>XmlFields::returnArrayValue($hash_in, 'orderId'),
					'amount' =>XmlFields::returnArrayValue($hash_in, 'amount'),
					'surchargeAmount' =>XmlFields::returnArrayValue($hash_in,'surchargeAmount'),
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
			'orderId'=>XmlFields::returnArrayValue($hash_in,'orderId'),
			'accountNumber'=>XmlFields::returnArrayValue($hash_in,'accountNumber'),
			'echeckForToken'=>XmlFields::echeckForTokenType(XmlFields::returnArrayValue($hash_in,'echeckForToken')),
			'paypageRegistrationId'=>XmlFields::returnArrayValue($hash_in,'paypageRegistrationId'),
			'cardValidationNum'=>XmlFields::returnArrayValue($hash_in,'cardValidationNum'),
		);

		$choice_hash = array($hash_out['accountNumber'],$hash_out['echeckForToken'],$hash_out['paypageRegistrationId']);
		$registerTokenResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'registerTokenRequest',$choice_hash);
		return $registerTokenResponse;
	}

	public function forceCaptureRequest($hash_in)
	{
		$hash_out = array(
			'orderId' =>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderId')),
			'amount' =>XmlFields::returnArrayValue($hash_in,'amount'),
			'surchargeAmount' =>XmlFields::returnArrayValue($hash_in,'surchargeAmount'),
			'orderSource'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderSource')),
			'billToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'billToAddress')),
			'card'=> XmlFields::cardType(XmlFields::returnArrayValue($hash_in,'card')),
			'token'=>XmlFields::cardTokenType(XmlFields::returnArrayValue($hash_in,'token')),
			'paypage'=>XmlFields::cardPaypageType(XmlFields::returnArrayValue($hash_in,'paypage')),
			'customBilling'=>XmlFields::customBilling(XmlFields::returnArrayValue($hash_in,'customBilling')),
			'taxBilling'=>XmlFields::taxBilling(XmlFields::returnArrayValue($hash_in,'taxBilling')),
			'enhancedData'=>XmlFields::enhancedData(XmlFields::returnArrayValue($hash_in,'enhancedData')),
			'processingInstructions'=>XmlFields::processingInstructions(XmlFields::returnArrayValue($hash_in,'processingInstructions')),
			'pos'=>XmlFields::pos(XmlFields::returnArrayValue($hash_in,'pos')),
			'amexAggregatorData'=>XmlFields::amexAggregatorData(XmlFields::returnArrayValue($hash_in,'amexAggregatorData')),
			'merchantData'=>(XmlFields::merchantData(XmlFields::returnArrayValue($hash_in,'merchantData'))),
			'debtRepayment'=>XmlFields::returnArrayValue($hash_in,'debtRepayment'),				
		);

		$choice_hash = array(XmlFields::returnArrayValue($hash_out,'card'),XmlFields::returnArrayValue($hash_out,'paypal'),XmlFields::returnArrayValue($hash_out,'token'),XmlFields::returnArrayValue($hash_out,'paypage'));
		$forceCaptureResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'forceCapture',$choice_hash);
		return $forceCaptureResponse;
	}

	public function captureRequest($hash_in)
	{
		$hash_out = array(
		'partial'=>XmlFields::returnArrayValue($hash_in,'partial'),
	    'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
		'amount' =>(XmlFields::returnArrayValue($hash_in,'amount')),
		'surchargeAmount' =>XmlFields::returnArrayValue($hash_in,'surchargeAmount'),
		'enhancedData'=>XmlFields::enhancedData(XmlFields::returnArrayValue($hash_in,'enhancedData')),
		'processingInstructions'=>XmlFields::processingInstructions(XmlFields::returnArrayValue($hash_in,'processingInstructions')),
		'payPalOrderComplete'=>XmlFields::returnArrayValue($hash_in,'payPalOrderComplete'),
		'payPalNotes' =>XmlFields::returnArrayValue($hash_in,'payPalNotes'));
		$captureResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'capture');
		return $captureResponse;
	}

	public function captureGivenAuthRequest($hash_in)
	{
		$hash_out = array(
			'orderId'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderId')),
			'authInformation'=>XmlFields::authInformation(XmlFields::returnArrayValue($hash_in,'authInformation')),
			'amount' =>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'amount')),
			'surchargeAmount' =>XmlFields::returnArrayValue($hash_in,'surchargeAmount'),
			'orderSource'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderSource')),
			'billToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'billToAddress')),
			'shipToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'shipToAddress')),
			'card'=> XmlFields::cardType(XmlFields::returnArrayValue($hash_in,'card')),
			'token'=>XmlFields::cardTokenType(XmlFields::returnArrayValue($hash_in,'token')),
			'paypage'=>XmlFields::cardPaypageType(XmlFields::returnArrayValue($hash_in,'paypage')),
			'customBilling'=>XmlFields::customBilling(XmlFields::returnArrayValue($hash_in,'customBilling')),
			'taxBilling'=>XmlFields::taxBilling(XmlFields::returnArrayValue($hash_in,'taxBilling')),
			'billMeLaterRequest'=>XmlFields::billMeLaterRequest(XmlFields::returnArrayValue($hash_in,'billMeLaterRequest')),
			'enhancedData'=>XmlFields::enhancedData(XmlFields::returnArrayValue($hash_in,'enhancedData')),
			'processingInstructions'=>XmlFields::processingInstructions(XmlFields::returnArrayValue($hash_in,'processingInstructions')),
			'pos'=>XmlFields::pos(XmlFields::returnArrayValue($hash_in,'pos')),
			'amexAggregatorData'=>XmlFields::amexAggregatorData(XmlFields::returnArrayValue($hash_in,'amexAggregatorData')),
			'merchantData'=>(XmlFields::merchantData(XmlFields::returnArrayValue($hash_in,'merchantData'))),
			'debtRepayment'=>XmlFields::returnArrayValue($hash_in,'debtRepayment')
		);

		$choice_hash = array($hash_out['card'],$hash_out['token'],$hash_out['paypage']);
		$captureGivenAuthResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'captureGivenAuth',$choice_hash);
		return $captureGivenAuthResponse;
	}

	public function echeckRedepositRequest($hash_in)
	{
		$hash_out = array(
			'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
			'echeck'=>XmlFields::echeckType(XmlFields::returnArrayValue($hash_in,'echeck')),
			'echeckToken'=>XmlFields::echeckTokenType(XmlFields::returnArrayValue($hash_in,'echeckToken')),
			'merchantData'=>(XmlFields::merchantData(XmlFields::returnArrayValue($hash_in,'merchantData')))
		);
		
		$choice_hash = array($hash_out['echeck'],$hash_out['echeckToken']);
		$echeckRedepositResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'echeckRedeposit',$choice_hash);
		return $echeckRedepositResponse;
	}

	public function echeckSaleRequest($hash_in)
	{
		$hash_out = array(
		'litleTxnId'=>XmlFields::returnArrayValue($hash_in,'litleTxnId'),
		'orderId'=>XmlFields::returnArrayValue($hash_in,'orderId'),
		'verify'=>XmlFields::returnArrayValue($hash_in,'verify'),
		'amount'=>XmlFields::returnArrayValue($hash_in,'amount'),
		'orderSource'=>XmlFields::returnArrayValue($hash_in,'orderSource'),
		'billToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'billToAddress')),
		'shipToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'shipToAddress')),
		'echeck'=>XmlFields::echeckType(XmlFields::returnArrayValue($hash_in,'echeck')),
		'echeckToken'=>XmlFields::echeckTokenType(XmlFields::returnArrayValue($hash_in,'echeckToken')),
		'customBilling'=>XmlFields::customBilling(XmlFields::returnArrayValue($hash_in,'customBilling')));

		$choice_hash = array($hash_out['echeck'],$hash_out['echeckToken']);

		$echeckSaleResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'echeckSale',$choice_hash);
		return $echeckSaleResponse;
	}
	
	//public function echeckSaleRequestObject(EcheckSale $echeckSale) {
		//TODO Can I overload?  What are php's rules?
	//}

	public function echeckCreditRequest($hash_in)
	{
		$hash_out = array(
			'litleTxnId'=>XmlFields::returnArrayValue($hash_in,'litleTxnId'),
			'orderId'=>XmlFields::returnArrayValue($hash_in,'orderId'),
			'amount'=>XmlFields::returnArrayValue($hash_in,'amount'),
			'orderSource'=>XmlFields::returnArrayValue($hash_in,'orderSource'),
			'billToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'billToAddress')),
			'echeck'=>XmlFields::echeckType(XmlFields::returnArrayValue($hash_in,'echeck')),
			'echeckToken'=>XmlFields::echeckTokenType(XmlFields::returnArrayValue($hash_in,'echeckToken')),
			'customBilling'=>XmlFields::customBilling(XmlFields::returnArrayValue($hash_in,'customBilling')));

		$choice_hash = array($hash_out['echeck'],$hash_out['echeckToken']);
		$echeckCreditResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'echeckCredit',$choice_hash);
		return $echeckCreditResponse;
	}

	public function echeckVerificationRequest($hash_in)
	{
		
		$hash_out = array(
			'litleTxnId'=>XmlFields::returnArrayValue($hash_in,'litleTxnId'),
			'orderId'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderId')),
			'amount'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'amount')),
			'orderSource'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderSource')),
			'billToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'billToAddress')),
			'echeck'=>XmlFields::echeckType(XmlFields::returnArrayValue($hash_in,'echeck')),
			'echeckToken'=>XmlFields::echeckTokenType(XmlFields::returnArrayValue($hash_in,'echeckToken')),
			'merchantData'=>(XmlFields::merchantData(XmlFields::returnArrayValue($hash_in,'merchantData'))),
		);
		
		$choice_hash = array($hash_out['echeck'],$hash_out['echeckToken']);
		$choice_hash = array($hash_out['echeck'],$hash_out['echeckToken']);
		$echeckVerificationResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'echeckVerification',$choice_hash);
		return $echeckVerificationResponse;
	}

	public function voidRequest($hash_in)
	{
		$hash_out = array(
		'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
	    'processingInstructions'=>XmlFields::processingInstructions(XmlFields::returnArrayValue($hash_in,'processingInstructions')));

		$voidResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,'void');
		return $voidResponse;
	}

	public function echeckVoidRequest($hash_in)
	{
		$hash_out = array(
		'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
		);
		$echeckVoidResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,"echeckVoid");
		return $echeckVoidResponse;
	}

    public function depositReversalRequest($hash_in)
    {
        $hash_out = array(
        'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
        );
        $response = LitleOnlineRequest::processRequest($hash_out,$hash_in,"depositReversal");
        return $response;
    }
    public function refundReversalRequest($hash_in)
    {
        $hash_out = array(
        'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
        );
        $response = LitleOnlineRequest::processRequest($hash_out,$hash_in,"refundReversal");
        return $response;
    }
	public function activateReversalRequest($hash_in)
    {
        $hash_out = array(
        'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
        );
        $response = LitleOnlineRequest::processRequest($hash_out,$hash_in,"activateReversal");
        return $response;
    }
	public function deactivateReversalRequest($hash_in)
    {
        $hash_out = array(
        'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
        );
        $response = LitleOnlineRequest::processRequest($hash_out,$hash_in,"deactivateReversal");
        return $response;
    }
	public function loadReversalRequest($hash_in)
    {
        $hash_out = array(
        'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
        );
        $response = LitleOnlineRequest::processRequest($hash_out,$hash_in,"loadReversal");
        return $response;
    }
	public function unloadReversalRequest($hash_in)
    {
        $hash_out = array(
        'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
        );
        $response = LitleOnlineRequest::processRequest($hash_out,$hash_in,"unloadReversal");
        return $response;
    }
	
	public function updateCardValidationNumOnToken($hash_in)
	{
		$hash_out = array(
				'orderId'=>XmlFields::returnArrayValue($hash_in,'orderId'),
				'litleToken' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleToken')),
				'cardValidationNum' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'cardValidationNum')),
		);
		$updateCardValidationNumOnTokenResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,"updateCardValidationNumOnToken");
		return $updateCardValidationNumOnTokenResponse;
	}

    public function updateSubscription($hash_in)
    {
        $hash_out = Transactions::createUpdateSubscriptionHash($hash_in);
        $choice_hash = array(XmlFields::returnArrayValue($hash_out,'card'),XmlFields::returnArrayValue($hash_out,'token'),XmlFields::returnArrayValue($hash_out,'paypage'));
        $updateSubscriptionResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,"updateSubscription");
        return $updateSubscriptionResponse;
    }

    public function cancelSubscription($hash_in)
    {
        $hash_out = Transactions::createCancelSubscriptionHash($hash_in);
        $cancelSubscriptionResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,"cancelSubscription");
        return $cancelSubscriptionResponse;
    }
    
    public function updatePlan($hash_in)
    {
        $hash_out = Transactions::createUpdatePlanHash($hash_in);
        $updatePlanResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,"updatePlan");
        return $updatePlanResponse;
    }

    public function createPlan($hash_in)
    {
        $hash_out = Transactions::createCreatePlanHash($hash_in);
        $createPlanResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,"createPlan");
        return $createPlanResponse;
    }
    
    public function activate($hash_in)
    {
        $hash_out = Transactions::createActivateHash($hash_in);
        $txnResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,"activate");
        return $txnResponse;
    }
    public function deactivate($hash_in)
    {
        $hash_out = Transactions::createDeactivateHash($hash_in);
        $txnResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,"deactivate");
        return $txnResponse;
    }
    public function load($hash_in)
    {
        $hash_out = Transactions::createLoadHash($hash_in);
        $txnResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,"load");
        return $txnResponse;
    }
    public function unload($hash_in)
    {
        $hash_out = Transactions::createUnloadHash($hash_in);
        $txnResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,"unload");
        return $txnResponse;
    }
    public function balanceInquiry($hash_in)
    {
        $hash_out = Transactions::createBalanceInquiryHash($hash_in);
        $txnResponse = LitleOnlineRequest::processRequest($hash_out,$hash_in,"balanceInquiry");
        return $txnResponse;
    }
	
	private function overideConfig($hash_in)
	{
		$hash_out = array(
		'user'=>XmlFields::returnArrayValue($hash_in,'user'),
		'password'=>XmlFields::returnArrayValue($hash_in,'password'),
		'merchantId'=>XmlFields::returnArrayValue($hash_in,'merchantId'),
		'reportGroup'=>XmlFields::returnArrayValue($hash_in,'reportGroup'),
		'version'=>XmlFields::returnArrayValue($hash_in,'version'),
		'url'=>XmlFields::returnArrayValue($hash_in,'url'),
		'timeout'=>XmlFields::returnArrayValue($hash_in,'timeout'),
		'proxy'=>XmlFields::returnArrayValue($hash_in,'proxy'),
		'print_xml'=>XmlFields::returnArrayValue($hash_in,'print_xml'));
		return $hash_out;
	}
	
	private function getOptionalAttributes($hash_in,$hash_out)
	{
		if(isset($hash_in['merchantSdk'])) {
			$hash_out['merchantSdk'] = XmlFields::returnArrayValue($hash_in,'merchantSdk');
		}
		else {
			$hash_out['merchantSdk'] = CURRENT_SDK_VERSION;
		}
		if(isset($hash_in['id'])) {
			$hash_out['id'] = XmlFields::returnArrayValue($hash_in,'id');
		}
		if(isset($hash_in['customerId'])) {
			$hash_out['customerId'] = XmlFields::returnArrayValue($hash_in,'customerId');
		}
		if(isset($hash_in['loggedInUser'])) {
			$hash_out['loggedInUser'] = XmlFields::returnArrayValue($hash_in,'loggedInUser');
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
		$litleOnlineResponse = $this->newXML->request($request,$hash_config,$this->useSimpleXml);
		return $litleOnlineResponse;
	}

}

