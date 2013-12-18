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
require_once realpath(dirname(__FILE__)) . "/LitleOnline.php";

class XmlFields
{
	public static function returnArrayValue($hash_in, $key, $maxlength = null)
	{
		$retVal = array_key_exists($key, $hash_in)? $hash_in[$key] : null;
		if ($maxlength && !is_null($retVal)) {
			$retVal = substr($retVal, 0, $maxlength);
		}
		return $retVal;
	}

	public static function contact($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"name"=>XmlFields::returnArrayValue($hash_in, "name", 100),
						"firstName" =>XmlFields::returnArrayValue($hash_in, "firstName", 25),
						"middleInitial"=>XmlFields::returnArrayValue($hash_in, "middleInitial", 1),
						"lastName"=>XmlFields::returnArrayValue($hash_in, "lastName", 25),
						"companyName"=>XmlFields::returnArrayValue($hash_in, "companyName", 40),
						"addressLine1"=>XmlFields::returnArrayValue($hash_in, "addressLine1", 35),
						"addressLine2"=>XmlFields::returnArrayValue($hash_in, "addressLine2", 35),
						"addressLine3"=>XmlFields::returnArrayValue($hash_in, "addressLine3", 35),
						"city"=>XmlFields::returnArrayValue($hash_in, "city", 35),
						"state"=>XmlFields::returnArrayValue($hash_in, "state", 30),
						"zip"=>XmlFields::returnArrayValue($hash_in, "zip", 20),
						"country"=>XmlFields::returnArrayValue($hash_in, "country", 3),
						"email"=>XmlFields::returnArrayValue($hash_in, "email", 100),
						"phone"=>XmlFields::returnArrayValue($hash_in, "phone", 20)
			);
			return $hash_out;
		}

	}

	public static function customerInfo($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out=	array(
						"ssn"=>XmlFields::returnArrayValue($hash_in, "ssn"),
						"dob"=>XmlFields::returnArrayValue($hash_in, "dob"),
						"customerRegistrationDate"=>XmlFields::returnArrayValue($hash_in, "customerRegistrationDate"),
						"customerType"=>XmlFields::returnArrayValue($hash_in, "customerType"),
						"incomeAmount"=>XmlFields::returnArrayValue($hash_in, "incomeAmount"),
						"incomeCurrency"=>XmlFields::returnArrayValue($hash_in, "incomeCurrency"),
						"customerCheckingAccount"=>XmlFields::returnArrayValue($hash_in, "customerCheckingAccount"),
						"customerSavingAccount"=>XmlFields::returnArrayValue($hash_in, "customerSavingAccount"),
						"customerWorkTelephone"=>XmlFields::returnArrayValue($hash_in, "customerWorkTelephone"),
						"residenceStatus"=>XmlFields::returnArrayValue($hash_in, "residenceStatus"),
						"yearsAtResidence"=>XmlFields::returnArrayValue($hash_in, "yearsAtResidence"),
						"yearsAtEmployer"=>XmlFields::returnArrayValue($hash_in, "yearsAtEmployer")
			);
			return $hash_out;
		}
	}

	public static function billMeLaterRequest($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"bmlMerchantId"=>XmlFields::returnArrayValue($hash_in, "bmlMerchantId"),
						"termsAndConditions"=>XmlFields::returnArrayValue($hash_in, "termsAndConditions"),
						"preapprovalNumber"=>XmlFields::returnArrayValue($hash_in, "preapprovalNumber"),
						"merchantPromotionalCode"=>XmlFields::returnArrayValue($hash_in, "merchantPromotionalCode"),
						"customerPasswordChanged"=>XmlFields::returnArrayValue($hash_in, "customerPasswordChanged"),
						"customerEmailChanged"=>XmlFields::returnArrayValue($hash_in, "customerEmailChanged"),
						"customerPhoneChanged"=>XmlFields::returnArrayValue($hash_in, "customerPhoneChanged"),
						"secretQuestionCode"=>XmlFields::returnArrayValue($hash_in, "secretQuestionCode"),
						"secretQuestionAnswer"=>XmlFields::returnArrayValue($hash_in, "secretQuestionAnswer"),
						"virtualAuthenticationKeyPresenceIndicator"=>XmlFields::returnArrayValue($hash_in, "virtualAuthenticationKeyPresenceIndicator"),
						"virtualAuthenticationKeyData"=>XmlFields::returnArrayValue($hash_in, "virtualAuthenticationKeyData"),
						"itemCategoryCode"=>XmlFields::returnArrayValue($hash_in, "itemCategoryCode"),
						"authorizationSourcePlatform"=>XmlFields::returnArrayValue($hash_in, "authorizationSourcePlatform")
			);
			return $hash_out;
		}
	}

	public static function fraudCheckType($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out =	array(
						"authenticationValue"=>XmlFields::returnArrayValue($hash_in, "authenticationValue"),
						"authenticationTransactionId"=>XmlFields::returnArrayValue($hash_in, "authenticationTransactionId"),
						"customerIpAddress"=>XmlFields::returnArrayValue($hash_in, "customerIpAddress"),
						"authenticatedByMerchant"=>XmlFields::returnArrayValue($hash_in, "authenticatedByMerchant")
			);
			return $hash_out;
		}
	}

	public static function merchantData($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out =	array(
						"campaign"=>XmlFields::returnArrayValue($hash_in, "campaign"),
						"affiliate"=>XmlFields::returnArrayValue($hash_in, "affiliate"),
						"merchantGroupingId"=>XmlFields::returnArrayValue($hash_in, "merchantGroupingId")
			);
			return $hash_out;
		}
	}


	public static function authInformation($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"authDate"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "authDate"))),
						"authCode"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "authCode"))),
						"fraudResult"=>XmlFields::fraudResult(XmlFields::returnArrayValue($hash_in,"fraudResult")),
						"authAmount"=>XmlFields::returnArrayValue($hash_in,'authAmount')
			);
			return $hash_out;
		}
	}

	public static function fraudResult($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out= 	array(
						"avsResult"=>XmlFields::returnArrayValue($hash_in, "avsResult"),
						"cardValidationResult"=>XmlFields::returnArrayValue($hash_in, "cardValidationResult"),
						"authenticationResult"=>XmlFields::returnArrayValue($hash_in, "authenticationResult"),
						"advancedAVSResult"=>XmlFields::returnArrayValue($hash_in, "advancedAVSResult")
			);
			return $hash_out;
		}
	}

	public static function healthcareAmounts($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"totalHealthcareAmount"=>XmlFields::returnArrayValue($hash_in, "totalHealthcareAmount"),
						"RxAmount"=>XmlFields::returnArrayValue($hash_in, "RxAmount"),
						"visionAmount"=>XmlFields::returnArrayValue($hash_in, "visionAmount"),
						"clinicOtherAmount"=>XmlFields::returnArrayValue($hash_in, "clinicOtherAmount"),
						"dentalAmount"=>XmlFields::returnArrayValue($hash_in, "dentalAmount")
			);
			return $hash_out;
		}
	}

	public static function healthcareIIAS($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"healthcareAmounts"=>(XmlFields::healthcareAmounts(XmlFields::returnArrayValue($hash_in, "healthcareAmounts"))),
						"IIASFlag"=>XmlFields::returnArrayValue($hash_in, "IIASFlag")
			);
			return $hash_out;
		}
	}

	public static function pos($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"capability"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "capability"))),
						"entryMode"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "entryMode"))),
						"cardholderId"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "cardholderId"))),
						"terminalId"=>XmlFields::returnArrayValue($hash_in,"terminalId"),
						"catLevel"=>XmlFields::returnArrayValue($hash_in,"catLevel"),
			);
			return $hash_out;
		}
	}

	public static function detailTax($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"taxIncludedInTotal"=>XmlFields::returnArrayValue($hash_in, "taxIncludedInTotal"),
						"taxAmount"=>XmlFields::returnArrayValue($hash_in, "taxAmount"),
						"taxRate"=>XmlFields::returnArrayValue($hash_in, "taxRate"),
						"taxTypeIdentifier"=>XmlFields::returnArrayValue($hash_in, "taxTypeIdentifier"),
						"cardAcceptorTaxId"=>XmlFields::returnArrayValue($hash_in, "cardAcceptorTaxId")
			);
			return $hash_out;
		}
	}

	public static function lineItemData($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"itemSequenceNumber"=>XmlFields::returnArrayValue($hash_in, "itemSequenceNumber"),
						"itemDescription"=>XmlFields::returnArrayValue($hash_in, "itemDescription", 26),
						"productCode"=>XmlFields::returnArrayValue($hash_in, "productCode", 12),
						"quantity"=>XmlFields::returnArrayValue($hash_in, "quantity"),
						"unitOfMeasure"=>XmlFields::returnArrayValue($hash_in, "unitOfMeasure"),
						"taxAmount"=>XmlFields::returnArrayValue($hash_in, "taxAmount"),
						"lineItemTotal"=>XmlFields::returnArrayValue($hash_in, "lineItemTotal"),
						"lineItemTotalWithTax"=>XmlFields::returnArrayValue($hash_in, "lineItemTotalWithTax"),
						"itemDiscountAmount"=>XmlFields::returnArrayValue($hash_in, "itemDiscountAmount"),
						"commodityCode"=>XmlFields::returnArrayValue($hash_in, "commodityCode"),
						"unitCost"=>XmlFields::returnArrayValue($hash_in, "unitCost"),
						"detailTax"=>(XmlFields::detailTax(XmlFields::returnArrayValue($hash_in, "detailTax")))
			);
			return $hash_out;
		}
	}

	public static function enhancedData($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"customerReference"=>XmlFields::returnArrayValue($hash_in, "customerReference"),
						"salesTax"=>XmlFields::returnArrayValue($hash_in, "salesTax"),
						"deliveryType"=>XmlFields::returnArrayValue($hash_in, "deliveryType"),
						"taxExempt"=>XmlFields::returnArrayValue($hash_in, "taxExempt"),
						"discountAmount"=>XmlFields::returnArrayValue($hash_in, "discountAmount"),
						"shippingAmount"=>XmlFields::returnArrayValue($hash_in, "shippingAmount"),
						"dutyAmount"=>XmlFields::returnArrayValue($hash_in, "dutyAmount"),
						"shipFromPostalCode"=>XmlFields::returnArrayValue($hash_in, "shipFromPostalCode"),
						"destinationPostalCode"=>XmlFields::returnArrayValue($hash_in, "destinationPostalCode"),
						"destinationCountryCode"=>XmlFields::returnArrayValue($hash_in, "destinationCountryCode"),
						"invoiceReferenceNumber"=>XmlFields::returnArrayValue($hash_in, "invoiceReferenceNumber"),
						"orderDate"=>XmlFields::returnArrayValue($hash_in, "orderDate")
			);
			foreach ($hash_in as $key => $value){
				if ($key == 'lineItemData' && $key != NULL){
					$lineItem = array();
					for($j=0; $j<count($value); $j++){
						$outIndex = ('lineItemData') . (string)$j;
						$hash_out[$outIndex] = XmlFields::lineItemData(XmlFields::returnArrayValue($value,$j));
					}
				}
				elseif ($key == 'detailTax' & $key != NULL){
					$detailtax = array();
					for($j=0; $j<count($value); $j++){
						$outIndex = ('detailTax') . (string)$j;
						$hash_out[$outIndex] = XmlFields::detailTax(XmlFields::returnArrayValue($value,$j));
					}
				}
			}
				
			return $hash_out;
		}
	}

	public static function amexAggregatorData($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"sellerId"=>XmlFields::returnArrayValue($hash_in, "sellerId"),
						"sellerMerchantCategoryCode"=>XmlFields::returnArrayValue($hash_in, "sellerMerchantCategoryCode")
			);
			return $hash_out;
		}
	}

	public static function cardType($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out= 	array(
						"type"=>XmlFields::returnArrayValue($hash_in, "type"),
						"track"=>XmlFields::returnArrayValue($hash_in, "track"),
						"number"=>XmlFields::returnArrayValue($hash_in, "number"),
						"expDate"=>XmlFields::returnArrayValue($hash_in, "expDate"),
						"cardValidationNum"=>XmlFields::returnArrayValue($hash_in, "cardValidationNum")
			);
			return $hash_out;
		}
	}

	public static function cardTokenType($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"litleToken"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "litleToken"))),
						"expDate"=>XmlFields::returnArrayValue($hash_in, "expDate"),
						"cardValidationNum"=>XmlFields::returnArrayValue($hash_in, "cardValidationNum"),
						"type"=>XmlFields::returnArrayValue($hash_in, "type")
			);
			return $hash_out;
		}
	}

	public static function cardPaypageType($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"paypageRegistrationId"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "paypageRegistrationId"))),
						"expDate"=>XmlFields::returnArrayValue($hash_in, "expDate"),
						"cardValidationNum"=>XmlFields::returnArrayValue($hash_in, "cardValidationNum"),
						"type"=>XmlFields::returnArrayValue($hash_in, "type")
			);
			return $hash_out;
		}
	}

	public static function paypal($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"payerId"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "payerId"))),
						"token"=>XmlFields::returnArrayValue($hash_in, "token"),
						"transactionId"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "transactionId")))
			);
			return $hash_out;
		}
	}

	#paypal field for credit transaction
	public static function credit_paypal($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"payerId"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "payerId"))),
						"payerEmail" =>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "payerEmail")))
			);
			return $hash_out;
		}
	}


	public static function customBilling($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"phone"=>XmlFields::returnArrayValue($hash_in, "phone", 13),
						"city" =>XmlFields::returnArrayValue($hash_in, "city", 35),
						"url" =>XmlFields::returnArrayValue($hash_in, "url", 13),
						"descriptor" =>XmlFields::returnArrayValue($hash_in, "descriptor", 25)
			);
			return $hash_out;
		}
	}

	public static function taxBilling($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"taxAuthority"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "taxAuthority"))),
						"state" =>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "state"))),
						"govtTxnType" =>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "govtTxnType")))
			);
			return $hash_out;
		}
	}

	public static function processingInstructions($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"bypassVelocityCheck"=>XmlFields::returnArrayValue($hash_in, "bypassVelocityCheck")
			);
			return $hash_out;
		}
	}

	public static function echeckForTokenType($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"accNum"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "accNum"))),
						"routingNum" =>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "routingNum")))
			);
			return $hash_out;
		}
	}

	public static function filteringType($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"prepaid"=>XmlFields::returnArrayValue($hash_in, "prepaid"),
						"international" =>XmlFields::returnArrayValue($hash_in, "international"),
						"chargeback" =>XmlFields::returnArrayValue($hash_in, "chargeback")
			);
			return $hash_out;
		}
	}

	public static function echeckType($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"accType"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "accType"))),
						"accNum" =>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "accNum"))),
						"routingNum" =>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "routingNum"))),
						"checkNum" =>XmlFields::returnArrayValue($hash_in, "checkNum")
			);
			return $hash_out;
		}
	}

	public static function echeckTokenType($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"litleToken"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "litleToken"))),
						"routingNum" =>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "routingNum"))),
						"accType" =>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "accType"))),
						"checkNum" =>XmlFields::returnArrayValue($hash_in, "checkNum")
			);
			return $hash_out;
		}
	}

	public static function recyclingRequestType($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"recycleBy"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "recycleBy")))
			);
			return $hash_out;
		}
	}
	
	
	
	public static function recurringRequestType($hash_in)
	{
		if(isset($hash_in))
		{
			$hash_out = array(
					"subscription"=>(XmlFields::recurringSubscriptionType(XmlFields::returnArrayValue($hash_in,"subscription")))
			);
			return $hash_out;		
		}
	}
	
	public static function recurringSubscriptionType($hash_in) {
		if(isset($hash_in))
		{
			$hash_out = array(
					"planCode"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "planCode"))),
					"numberOfPayments"=>(XmlFields::returnArrayValue($hash_in, "numberOfPayments")),
					"startDate"=>(XmlFields::returnArrayValue($hash_in, "startDate")),
					"amount"=>(XmlFields::returnArrayValue($hash_in, "amount")),
			);
			return $hash_out;
		}
	}
	
	public static function litleInternalRecurringRequestType($hash_in)
	{
		if(isset($hash_in))
		{
			$hash_out = array(
					"subscriptionId"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "subscriptionId"))),
					"recurringTxnId"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "recurringTxnId")))
			);
			return $hash_out;
		}
	}
	
	public static function advancedFraudChecksType($hash_in)
    {
        if (isset($hash_in))
        {
            $hash_out = array(
                "threatMetrixSessionId"=>(Checker::requiredField(XmlFields::returnArrayValue($hash_in, "threatMetrixSessionId", 128)))
            );
            return $hash_out;
        }
    }
	
}
