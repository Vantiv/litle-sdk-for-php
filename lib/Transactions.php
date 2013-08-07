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
}
