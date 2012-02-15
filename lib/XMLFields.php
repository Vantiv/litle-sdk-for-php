<?php
// =begin
// Copyright (c) 2011 Litle & Co.

// Permission is hereby granted, free of charge, to any person
// obtaining a copy of this software and associated documentation
// files (the "Software"), to deal in the Software without
// restriction, including without limitation the rights to use,
// copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the
// Software is furnished to do so, subject to the following
// conditions:

// The above copyright notice and this permission notice shall be
// included in all copies or substantial portions of the Software.

// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
// EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
// OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
// NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
// HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
// WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
// FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
// OTHER DEALINGS IN THE SOFTWARE.
// =end

#
# Contains all of the underlying XML fields and specifications needed to create the transaction set
#
class XMLFields
{
	public static function contact($hash_in)
	{
		$hash_out = array(
		'name' => $hash_in['name'],
		'firstName' =>$hash_in['firstName'],
		'middleInitial'=>$hash_in['middleInitial'],
		'lastName'=>$hash_in['lastName'],
		'companyName'=>$hash_in['companyName'],
		'addressLine1'=>$hash_in['addressLine1'],
		'addressLine2'=>$hash_in['addressLine2'],
		'addressLine3'=>$hash_in['addressLine3'],
		'city'=>$hash_in['city'],
		'state'=>$hash_in['state'],
		'zip'=>$hash_in['zip'],
		'country'=>$hash_in['country'],
		'email'=>$hash_in['email'],
		'phone'=>$hash_in['phone']
		);
		#Checker.purge_null($hash_out)
		#Checker.required_missing($hash_out)
		return $hash_out;
	}

	public static function customerInfo($hash_in)
	{
		$hash_out=array(
		'ssn'=>$hash_in['ssn'],
		'dob'=>$hash_in['dob'],
		'customerRegistrationDate'=>$hash_in['customerRegistrationDate'],
		'customerType'=>$hash_in['customerType'],
		'incomeAmount'=>$hash_in['incomeAmount'],
		'incomeCurrency'=>$hash_in['incomeCurrency'],
		'customerCheckingAccount'=>$hash_in['customerCheckingAccount'],
		'customerSavingAccount'=>$hash_in['customerSavingAccount'],
		'customerWorkTelephone'=>$hash_in['customerWorkTelephone'],
		'residenceStatus'=>$hash_in['residenceStatus'],
		'yearsAtResidence'=>$hash_in['yearsAtResidence'],
		'yearsAtEmployer'=>$hash_in['yearsAtEmployer']
		);
		#Checker.purge_null($hash_out)
		#Checker.required_missing($hash_out)
		return $hash_out;
	}

	public static function billMeLaterRequest($hash_in)
	{
		$hash_out = array(
		'bmlMerchantId'=>$hash_in['bmlMerchantId'],
		'termsAndConditions'=>$hash_in['termsAndConditions'],
		'preapprovalNumber'=>$hash_in['preapprovalNumber'],
		'merchantPromotionalCode'=>$hash_in['merchantPromotionalCode'],
		'customerPasswordChanged'=>$hash_in['customerPasswordChanged'],
		'customerEmailChanged'=>$hash_in['customerEmailChanged'],
		'customerPhoneChanged'=>$hash_in['customerPhoneChanged'],
		'secretQuestionCode'=>$hash_in['secretQuestionCode'],
		'secretQuestionAnswer'=>$hash_in['secretQuestionAnswer'] ,
		'virtualAuthenticationKeyPresenceIndicator'=>$hash_in['virtualAuthenticationKeyPresenceIndicator'] ,
		'virtualAuthenticationKeyData'=>$hash_in['virtualAuthenticationKeyData'],
		'itemCategoryCode'=>$hash_in['itemCategoryCode'],
		'authorizationSourcePlatform'=>$hash_in['authorizationSourcePlatform']
		);
		#Checker.purge_null($hash_out)
		#Checker.requirtagValueed_missing($hash_out)
		return $hash_out;
	}

	public static function fraudCheckType($hash_in)
	{
		$hash_out =array(
		'authenticationValue'=>$hash_in['authenticationValue'],
		'authenticationTransactionId'=>$hash_in['authenticationTransactionId'],
		'customerIpAddress'=>$hash_in['customerIpAddress'],
		'authenticatedByMerchant'=>$hash_in['authenticatedByMerchant']);
		#Checker.purge_null(hash_out)
		#Checker.required_missing(hash_out)
		return $hash_out;
	}

	public static function authInformation($hash_in)
	{
		$hash_out = array(
		'authDate'=>(($hash_in['authDate'] == NULL) ? 'REQUIRED':$hash_in['authDate']),
		'authCode'=>(($hash_in['authCode'] == NULL) ? 'REQUIRED':$hash_in['authCode']),
		'fraudResult'=>XMLFields::fraudResult($hash_in['detailTax']),
		'authAmount'=>$hash_in['authAmount']);
		#Checker.purge_null($hash_out)
		#Checker.required_missing($hash_out)
		return $hash_out;
	}

	public static function fraudResult($hash_in)
	{
		$hash_out= array(
		'avsResult'=> $hash_in['avsResult'],
		'ardValidationResult'=>$hash_in['cardValidationResult'],
		'authenticationResult'=>$hash_in['authenticationResult'],
		'advancedAVSResult'=>$hash_in['advancedAVSResult']);

		// 	Checker.purge_null($hash_out)
		// 	Checker.required_missing($hash_out)
		return $hash_out;
	}

	public static function healthcareAmounts($hash_in)
	{
		$hash_out = array(
		'totalHealthcareAmount'=>$hash_in['totalHealthcareAmount'],
		'RxAmount'=>$hash_in['RxAmount'],
		'visionAmount'=>$hash_in['visionAmount'],
		'clinicOtherAmount'=>$hash_in['clinicOtherAmount'],
		'dentalAmount'=>$hash_in['dentalAmount']);
		//Checker.purge_null(hash_out)
		//Checker.required_missing(hash_out)
		return $hash_out;
	}

	public static function healthcareIIAS($hash_in)
	{
		$hash_out = array(
		'healthcareAmounts'=>XMLFields::healthcareAmounts($hash_in['healthcareAmounts']),
		'IIASFlag'=>$hash_in['IIASFlag']);
		//Checker.purge_null(hash_out)
		//Checker.required_missing(hash_out)
		return $hash_out;
	}

	public static function pos($hash_in)
	{
		$hash_out = array(
		'capability'=>(($hash_in['capability'] == NULL) ? 'REQUIRED':$hash_in['capability']),
		'entryMode'=>(($hash_in['entryMode'] == NULL) ? 'REQUIRED':$hash_in['entryMode']),
		'cardholderId'=>(($hash_in['cardholderId'] == NULL) ? 'REQUIRED':$hash_in['cardholderId']));
		//Checker.purge_null(hash_out)
		//Checker.required_missing(hash_out)
		return $hash_out;
	}

	public static function detailTax($hash_in)
	{
		$hash_out = array(
		'taxIncludedInTotal'=>$hash_in['taxIncludedInTotal'],
		'taxAmount'=>$hash_in['taxAmount'],
		'taxRate'=>$hash_in['taxRate'],
		'taxTypeIdentifier'=>$hash_in['taxTypeIdentifier'],
		'cardAcceptorTaxId'=>$hash_in['cardAcceptorTaxId']);
		//Checker.purge_null(hash_out)
		//Checker.required_missing($hash_out)
		return $hash_out;
	}

	public static function lineItemData($hash_in)
	{
		$hash_out = array(
		'itemSequenceNumber'=>$hash_in['itemSequenceNumber'],
		'itemDescription'=>$hash_in['itemDescription'],
		'productCode'=>$hash_in['productCode'],
		'quantity'=>$hash_in['quantity'],
		'unitOfMeasure'=>$hash_in['unitOfMeasure'],
		'taxAmount'=>$hash_in['taxAmount'],
		'lineItemTotal'=>$hash_in['lineItemTotal'],
		'lineItemTotalWithTax'=>$hash_in['lineItemTotalWithTax'],
		'itemDiscountAmount'=>$hash_in['itemDiscountAmount'],
		'commodityCode'=>$hash_in['commodityCode'],
		'unitCost'=>$hash_in['unitCost'],
		'detailTax'=> XMLFields::detailTax($hash_in['detailTax']));

		//Checker.purge_null(hash_out)
		//Checker.required_missing(hash_out)
		return $hash_out;
	}

	public static function enhancedData($hash_in)
	{
		$hash_out = array(
		'customerReference'=>$hash_in['customerReference'],
		'salesTax'=>$hash_in['salesTax'],
		'deliveryType'=>$hash_in['deliveryType'],
		'taxExempt'=>$hash_in['taxExempt'],
		'discountAmount'=>$hash_in['discountAmount'],
		'shippingAmount'=>$hash_in['shippingAmount'],
		'dutyAmount'=>$hash_in['dutyAmount'],
		'shipFromPostalCode'=>$hash_in['shipFromPostalCode'],
		'destinationPostalCode'=>$hash_in['destinationPostalCode'],
		'destinationCountryCode'=>$hash_in['destinationCountryCode'],
		'invoiceReferenceNumber'=>$hash_in['invoiceReferenceNumber'],
		'orderDate'=>$hash_in['orderDate'],
		'detailTax'=> XMLFields::detailTax($hash_in['detailTax']),
		'lineItemData'=> XMLFields::lineItemData($hash_in['lineItemData']));

		// Checker.purge_null(hash_out)
		// Checker.required_missing(hash_out)
		return $hash_out;
	}

	public static function amexAggregatorData($hash_in)
	{
		$hash_out = array(
		'sellerId'=>$hash_in['sellerId'],
		'sellerMerchantCategoryCode'=>$hash_in['sellerMerchantCategoryCode']);
		//Checker.purge_null(hash_out)
		//Checker.required_missing(hash_out)
		return $hash_out;
	}

	public static function cardType($hash_in)
	{
		$hash_out= array(
			'type'=>$hash_in['type'] ,
			'track'=>$hash_in['track'],
			'number'=>$hash_in['number'],
			'expDate'=>$hash_in['expDate'],
			'cardValidationNum'=>$hash_in['cardValidationNum']);
		#Checker.purge_null(hash_out)
		#Checker.choice(choice_hash)
		return $hash_out;
	}

	public static function cardTokenType($hash_in)
	{
		$hash_out = array(
		'litleToken'=> (($hash_in['litleToken'] == NULL) ? 'REQUIRED':$hash_in['litleToken']),
		'expDate'=>$hash_in['expDate'],
		'cardValidationNum'=>$hash_in['cardValidationNumber'],
		'type'=>$hash_in['type']);
		#Checker.purge_null(hash_out)
		# Checker.required_missing(hash_out)
		return $hash_out;
	}

	public static function cardPaypageType($hash_in)
	{
		$hash_out = array(
		'paypageRegistrationId'=> (($hash_in['paypageRegistrationId'] == NULL) ? 'REQUIRED':$hash_in['paypageRegistrationId']),
		'expDate'=>$hash_in['expDate'] ,
		'cardValidationNum'=>$hash_in['cardValidationNumber'],
		'type'=>$hash_in['type']);
		#Checker.purge_null(hash_out)
		#Checker.required_missing(hash_out)
		return $hash_out;
	}

	public static function payPal($hash_in)
	{
		$hash_out = array(
		'payerId'=>(($hash_in['payerId'] == NULL) ? 'REQUIRED':$hash_in['payerId']),
		'token'=>$hash_in['token'],
		'transactionId'=>(($hash_in['transactionId'] == NULL) ? 'REQUIRED':$hash_in['transactionId']));
		#Checker.purge_null(hash_out)
		#Checker.required_missing(hash_out)
		return $hash_out;
	}

	#paypal field for credit transaction
	public static function credit_payPal($hash_in)
	{
		$hash_out = array(
		'payerId'=>(($hash_in['payerId'] == NULL) ? 'REQUIRED':$hash_in['payerId']),
		'payerEmail' =>(($hash_in['payerEmail'] == NULL) ? 'REQUIRED':$hash_in['payerEmail']));
		#Checker.purge_null(hash_out)
		#choice_hash={
		#'1'=>hash_out[:payerId],'2'=>hash_out[:payerEmail]}
		#Checker.choice(choice_hash)
		#Checker.required_missing(hash_out)
		return $hash_out;
		}

	
}
	




























?>