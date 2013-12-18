<?php

class Transactions {
	
	
	public static function createSaleHash($hash_in){
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
		);
		return $hash_out;
	}
	
	public static function createAuthHash($hash_in){
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
			);
		return $hash_out;
	}

	public static function createAuthReversalHash($hash_in){
		$hash_out = array(
			'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
			'amount' =>XmlFields::returnArrayValue($hash_in,'amount'),
			'surchargeAmount' =>XmlFields::returnArrayValue($hash_in,'surchargeAmount'),
			'payPalNotes'=>XmlFields::returnArrayValue($hash_in,'payPalNotes'),
			'actionReason'=>XmlFields::returnArrayValue($hash_in,'actionReason')
			);
		return $hash_out;			
	}

	public static function createCreditHash($hash_in){
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
		return $hash_out;	
	}

	public static function createRegisterTokenHash($hash_in){
		$hash_out = array(
			'orderId'=>XmlFields::returnArrayValue($hash_in,'orderId'),
			'accountNumber'=>XmlFields::returnArrayValue($hash_in,'accountNumber'),
			'echeckForToken'=>XmlFields::echeckForTokenType(XmlFields::returnArrayValue($hash_in,'echeckForToken')),
			'paypageRegistrationId'=>XmlFields::returnArrayValue($hash_in,'paypageRegistrationId'),
			'cardValidationNum'=>XmlFields::returnArrayValue($hash_in,'cardValidationNum'),
			);
		return $hash_out;
	}
	
	public static function createForceCaptureHash($hash_in){
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
		return $hash_out;		
	}

	public static function createCaptureHash($hash_in){
		$hash_out = array(
		'partial'=>XmlFields::returnArrayValue($hash_in,'partial'),
	    'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
		'amount' =>(XmlFields::returnArrayValue($hash_in,'amount')),
		'surchargeAmount' =>XmlFields::returnArrayValue($hash_in,'surchargeAmount'),
		'enhancedData'=>XmlFields::enhancedData(XmlFields::returnArrayValue($hash_in,'enhancedData')),
		'processingInstructions'=>XmlFields::processingInstructions(XmlFields::returnArrayValue($hash_in,'processingInstructions')),
		'payPalOrderComplete'=>XmlFields::returnArrayValue($hash_in,'payPalOrderComplete'),
		'payPalNotes' =>XmlFields::returnArrayValue($hash_in,'payPalNotes'));
		return $hash_out;		
	}

	public static function createCaptureGivenAuthHash($hash_in){
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
		return $hash_out;		
	}

	public static function createEcheckRedepositHash($hash_in){
		$hash_out = array(
			'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
			'echeck'=>XmlFields::echeckType(XmlFields::returnArrayValue($hash_in,'echeck')),
			'echeckToken'=>XmlFields::echeckTokenType(XmlFields::returnArrayValue($hash_in,'echeckToken')),
			'merchantData'=>(XmlFields::merchantData(XmlFields::returnArrayValue($hash_in,'merchantData')))
			);
		return $hash_out;		
	}

	public static function createEcheckSaleHash($hash_in){
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
		return $hash_out;		
	}
	
	public static function createEcheckCreditHash($hash_in){
		$hash_out = array(
			'litleTxnId'=>XmlFields::returnArrayValue($hash_in,'litleTxnId'),
			'orderId'=>XmlFields::returnArrayValue($hash_in,'orderId'),
			'amount'=>XmlFields::returnArrayValue($hash_in,'amount'),
			'orderSource'=>XmlFields::returnArrayValue($hash_in,'orderSource'),
			'billToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'billToAddress')),
			'echeck'=>XmlFields::echeckType(XmlFields::returnArrayValue($hash_in,'echeck')),
			'echeckToken'=>XmlFields::echeckTokenType(XmlFields::returnArrayValue($hash_in,'echeckToken')),
			'customBilling'=>XmlFields::customBilling(XmlFields::returnArrayValue($hash_in,'customBilling')));
		return $hash_out;
	}

	public static function createEcheckVerificationHash($hash_in){
		
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
		
		return $hash_out;
	}
	
	public static function createUpdateCardValidationNumOnTokenHash($hash_in){
		$hash_out = array(
				'orderId'=>XmlFields::returnArrayValue($hash_in,'orderId'),
				'litleToken' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleToken')),
				'cardValidationNum' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'cardValidationNum')),
		);		
		
		return $hash_out;
	}

    public static function createUpdateSubscriptionHash($hash_in){
        $hash_out = array(
            'subscriptionId'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'subscriptionId')),
            'planCode'=>XmlFields::returnArrayValue($hash_in,'planCode'),
            'billToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'billToAddress')),
            'card'=>XmlFields::cardType(XmlFields::returnArrayValue($hash_in,'card')),
            'token'=>XmlFields::cardTokenType(XmlFields::returnArrayValue($hash_in,'token')),
            'paypage'=>XmlFields::cardPaypageType(XmlFields::returnArrayValue($hash_in,'paypage')),
            'billingDate'=>XmlFields::returnArrayValue($hash_in,'billingDate')
        );      
        
        return $hash_out;
    }
    
    public static function createCancelSubscriptionHash($hash_in){
        $hash_out = array(
            'subscriptionId'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'subscriptionId'))
        );      
        
        return $hash_out;
    }

    public static function createCreatePlanHash($hash_in){
        $hash_out = array(
            'planCode'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'planCode')),
            'name'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'name')),
            'description'=>XmlFields::returnArrayValue($hash_in,'description'),
            'intervalType'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'intervalType')),
            'amount'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'amount')),
            'numberOfPayments'=>XmlFields::returnArrayValue($hash_in,'numberOfPayments'),
            'trialNumberOfIntervals'=>XmlFields::returnArrayValue($hash_in,'trialNumberOfIntervals'),
            'trialIntervalType'=>XmlFields::returnArrayValue($hash_in,'trialIntervalType'),
            'active'=>XmlFields::returnArrayValue($hash_in,'active')
        );      
        
        return $hash_out;
    }

    public static function createUpdatePlanHash($hash_in){
        $hash_out = array(
            'planCode'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'planCode')),
            'active'=>XmlFields::returnArrayValue($hash_in,'active')
        );      
        
        return $hash_out;
    }

    public static function createActivateHash($hash_in){
        $hash_out = array(
            'orderId'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderId')),
            'amount'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'amount')),
            'orderSource'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderSource')),
            'card'=>Checker::requiredField(XmlFields::cardType(XmlFields::returnArrayValue($hash_in,'card')))
        );      
        
        return $hash_out;
    }
    public static function createDeactivateHash($hash_in){
        $hash_out = array(
            'orderId'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderId')),
            'orderSource'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderSource')),
            'card'=>Checker::requiredField(XmlFields::cardType(XmlFields::returnArrayValue($hash_in,'card')))
        );      
        
        return $hash_out;
    }
    public static function createLoadHash($hash_in){
        $hash_out = array(
            'orderId'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderId')),
            'amount'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'amount')),
            'orderSource'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderSource')),
            'card'=>Checker::requiredField(XmlFields::cardType(XmlFields::returnArrayValue($hash_in,'card')))
        );      
        
        return $hash_out;
    }
    public static function createUnloadHash($hash_in){
        $hash_out = array(
            'orderId'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderId')),
            'amount'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'amount')),
            'orderSource'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderSource')),
            'card'=>Checker::requiredField(XmlFields::cardType(XmlFields::returnArrayValue($hash_in,'card')))
        );      
        
        return $hash_out;
    }
    public static function createBalanceInquiryHash($hash_in){
        $hash_out = array(
            'orderId'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderId')),
            'orderSource'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderSource')),
            'card'=>Checker::requiredField(XmlFields::cardType(XmlFields::returnArrayValue($hash_in,'card')))
        );      
        
        return $hash_out;
    }

	public static function createAccountUpdate($hash_in){
		$hash_out = array(
				'orderId'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderId')),
				'card'=> XmlFields::cardType(XmlFields::returnArrayValue($hash_in,'card')),
				'token'=>XmlFields::cardTokenType(XmlFields::returnArrayValue($hash_in,'token')),
		);		
		
		return $hash_out;
	}
}
