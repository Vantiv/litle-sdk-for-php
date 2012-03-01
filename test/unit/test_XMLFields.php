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

require_once("../../simpletest/autorun.php");
require_once realpath(dirname(__FILE__)) . "/../../lib/LitleOnline.php";

class Tests_XmlFields extends UnitTestCase{

	function test_simple_contact()
	{
		$hash = array(
		"firstName" =>"Greg",
		"lastName"=>"Formich",
		"companyName"=>"Litleco",
		"addressLine1"=>"900 chelmosford st",
		"city"=> "Lowell",
		"state"=>"MA",
		"zip"=>"01831",
		"country"=>"US");
		$hash_out = XmlFields::contact($hash);
		$this->assertEqual($hash_out["firstName"],"Greg");
		$this->assertEqual($hash_out["addressLine2"], NULL);
		$this->assertEqual($hash_out["city"],"Lowell");
	}

	function test_simple_customerinfo()
	{
		$hash=array(
		"ssn"=>"5215435243",
	    "customerType"=>"monkey",
		"incomeAmount"=>"tomuchforamonkey",
		"incomeCurrency"=>"bannanas",
		"residenceStatus"=>"rent",
		"yearsAtResidence"=>"12"); 
		$hash_out = XmlFields::customerInfo($hash);
		$this->assertEqual($hash_out["ssn"],"5215435243");
		$this->assertEqual($hash_out["yearsAtEmployer"], NULL);
		$this->assertEqual($hash_out["incomeAmount"],"tomuchforamonkey");
	}

	function test_simple_BillMeLaterRequest()
	{
		$hash=array(
			"bmlMerchantId"=>"101",
		    "termsAndConditions"=>"none",
		    "preapprovalNumber"=>"000",
		    "merchantPromotionalCode"=>"test",
		    "customerPasswordChanged"=>"NO",
		    "customerEmailChanged"=>"NO");
		$hash_out = XmlFields::billMeLaterRequest($hash);
		$this->assertEqual($hash_out["bmlMerchantId"],"101");
		$this->assertEqual($hash_out["secretQuestionCode"], NULL);
		$this->assertEqual($hash_out["customerEmailChanged"],"NO");
	}

	function test_simple_fraudCheckType()
	{
		$hash=array(
		"authenticationValue"=>"123",
		"authenticationTransactionId"=>"123",
		"authenticatedByMerchant"=> "YES");
		$hash_out = XmlFields::fraudCheckType($hash);
		$this->assertEqual($hash_out["authenticationValue"],"123");
		$this->assertEqual($hash_out["customerIpAddress"], NULL);
		$this->assertEqual($hash_out["authenticationTransactionId"],"123");
	}

	function test_simple_authInformation()
	{
		#$hash["detailTax"] = array("avsResult" => "1234");
		$hash=array(
			"authDate"=>"123",
			"detailTax"=>(array("avsResult" => "1234")),
			"authAmount"=>"123");
	$hash_out = XmlFields::authInformation($hash);
	$this->assertEqual($hash_out["authDate"],"123");
	$this->assertEqual($hash_out["authCode"], "REQUIRED");
	$this->assertEqual($hash_out["fraudResult"]["avsResult"], "1234");
	$this->assertEqual($hash_out["fraudResult"]["authenticationResult"], NULL);
	$this->assertEqual($hash_out["authAmount"],"123");
	}

	function test_simple_fraudResult()
	{
		$hash=array(
		"avsResult"=> "123",
		"ardValidationResult"=>"456",
		"advancedAVSResult"=>"789");
		$hash_out = XmlFields::fraudResult($hash);
		$this->assertEqual($hash_out["avsResult"],"123");
		$this->assertEqual($hash_out["authenticationResult"], NULL);
		$this->assertEqual($hash_out["advancedAVSResult"],"789");
	}

	function test_simple_healtcareAmounts()
	{
		$hash=array(
		"totalHealthcareAmount"=>"123",
		"RxAmount"=>"456",
		"visionAmount"=>"789");
		$hash_out = XmlFields::healthcareAmounts($hash);
		$this->assertEqual($hash_out["totalHealthcareAmount"],"123");
		$this->assertEqual($hash_out["dentalAmount"], NULL);
		$this->assertEqual($hash_out["RxAmount"],"456");
	}

	function test_simple_healtcareIIAS()
	{
		$hash=array(
		"healthcareAmounts"=>(array("totalHealthcareAmount"=>"123",
		"RxAmount"=>"456",
		"visionAmount"=>"789")),
		"IIASFlag"=>"456");
		$hash_out = XmlFields::healthcareIIAS($hash);
		$this->assertEqual($hash_out["healthcareAmounts"]["totalHealthcareAmount"],"123");
		$this->assertEqual($hash_out["healthcareAmounts"]["dentalAmount"], NULL);
		$this->assertEqual($hash_out["IIASFlag"],"456");
	}

	function test_simple_pos()
	{
		$hash=array(
		"capability"=>"123",
		"entryMode"=>"NO");
		$hash_out = XmlFields::pos($hash);
		$this->assertEqual($hash_out["capability"],"123");
		$this->assertEqual($hash_out["entryMode"], "NO");
		$this->assertEqual($hash_out["cardholderId"],"REQUIRED");
	}

	function test_simple_detailTax()
	{
		$hash=array(
		"taxIncludedInTotal"=>"123",
		"taxAmount"=>"456",
		"taxRate"=>"high");
		$hash_out = XmlFields::detailTax($hash);
		$this->assertEqual($hash_out["taxIncludedInTotal"],"123");
		$this->assertEqual($hash_out["cardAcceptorTaxId"], NULL);
		$this->assertEqual($hash_out["taxAmount"],"456");
	}

	function test_simple_lineItemData()
	{
		$hash=array(
		"lineItemTotal"=>"1",
		"lineItemTotalWithTax"=>"2",
		"itemDiscountAmount"=>"3",
		"commodityCode"=>"3",
		"detailTax"=> (array("taxAmount" => "high")));
		$hash_out = XmlFields::lineItemData($hash);
		$this->assertEqual($hash_out["lineItemTotal"],"1");
		$this->assertEqual($hash_out["unitCost"], NULL);
		$this->assertEqual($hash_out["lineItemTotalWithTax"],"2");
		$this->assertEqual($hash_out["detailTax"]["taxAmount"],"high");
		$this->assertEqual($hash_out["detailTax"]["taxRate"],NULL);
	}

	function test_simple_enhancedData()
	{
		$hash=array(
		"customerReference"=>"yes",
		"salesTax"=>"5",
		"deliveryType"=>"ups",
		"taxExempt"=>"no",
		"lineItemData" => (array("lineItemTotal"=>"1",
		"itemDiscountAmount"=>"3")),
		"detailTax"=> (array("taxAmount" => "high")));
		$hash_out = XmlFields::enhancedData($hash);
		$this->assertEqual($hash_out["customerReference"], "yes");
		$this->assertEqual($hash_out["lineItemData"]["lineItemTotal"],"1");
		$this->assertEqual($hash_out["discountAmount"], NULL);
		$this->assertEqual($hash_out["lineItemData"]["lineItemTotalWithTax"],NULL);
		$this->assertEqual($hash_out["detailTax"]["taxAmount"],"high");
		$this->assertEqual($hash_out["detailTax"]["taxRate"],NULL);
	}
	function test_simple_amexAggregatorData()
	{
		$hash = array(
		"sellerId"=>"1234");
		$hash_out = XmlFields::amexAggregatorData($hash);
		$this->assertEqual($hash_out["sellerId"], "1234");
		$this->assertEqual($hash_out["sellerMerchantCategoryCode"], NULL);

	}

	function test_simple_cardType()
	{
		$hash = array(
		"type"=>"VI",
		"number"=>"4100000000000001",
		"expDate"=>"2013",
		"cardValidationNum"=>"123");
		$hash_out = XmlFields::cardType($hash);
		$this->assertEqual($hash_out["type"], "VI");
		$this->assertEqual($hash_out["track"], NULL);
		$this->assertEqual($hash_out["number"], "4100000000000001");
		$this->assertEqual($hash_out["expDate"], "2013");
		$this->assertEqual($hash_out["cardValidationNum"], "123");

	}

	function test_simple_cardTokenType()
	{
		$hash = array(
      "expDate"=>"2013",
      "cardValidationNumber"=>"123",
      "type"=>"VISA");
		$hash_out = XmlFields::cardTokenType($hash);
		$this->assertEqual($hash_out["type"], "VISA");
		$this->assertEqual($hash_out["expDate"], "2013");
		$this->assertEqual($hash_out["cardValidationNum"], "123");
		$this->assertEqual($hash_out["litleToken"], "REQUIRED");

	}

	function test_simple_cardPaypageType()
	{
		$hash = array(
	      "expDate"=>"2013",
	      "cardValidationNumber"=>"123",
	      "type"=>"VISA");
		$hash_out = XmlFields::cardPaypageType($hash);
		$this->assertEqual($hash_out["type"], "VISA");
		$this->assertEqual($hash_out["expDate"], "2013");
		$this->assertEqual($hash_out["cardValidationNum"], "123");
		$this->assertEqual($hash_out["paypageRegistrationId"], "REQUIRED");

	}

	function test_simple_paypal()
	{
		$hash = array(
	      "token"=>"123");
		$hash_out = XmlFields::paypal($hash);
		$this->assertEqual($hash_out["token"], "123");
		$this->assertEqual($hash_out["payerId"], "REQUIRED");
		$this->assertEqual($hash_out["transactionId"], "REQUIRED");
	}

	function test_simple_credit_paypal()
	{
		$hash = array();
		$hash_out = XmlFields::credit_paypal($hash);
		$this->assertEqual($hash_out["payerId"], "REQUIRED");
		$this->assertEqual($hash_out["payerEmail"], "REQUIRED");

	}

	function test_customBilling()
	{
		$hash = array(
		"phone"=>"978-287",
		"city"=>"lowell",
		"descriptor"=>"123");
		$hash_out = XmlFields::customBilling($hash);
		$this->assertEqual($hash_out["phone"], "978-287");
		$this->assertEqual($hash_out["url"], NULL);
		$this->assertEqual($hash_out["descriptor"], "123");
	}

	function test_taxBilling()
	{
		$hash = array(
	   "taxAuthority"=> "123",
       "state"=>"MA");
		$hash_out = XmlFields::taxBilling($hash);
		$this->assertEqual($hash_out["taxAuthority"], "123");
		$this->assertEqual($hash_out["state"], "MA");
		$this->assertEqual($hash_out["govtTxnType"], "REQUIRED");
	}

	function test_processingInstructions()
	{
		$hash = array("bypassVelocityCheck"=>"yes");
		$hash_out = XmlFields::processingInstructions($hash);
		$this->assertEqual($hash_out["bypassVelocityCheck"], "yes");
	}

	function test_echeckForTokenType()
	{
		$hash = array("accNum"=>"1322143124");
		$hash_out = XmlFields::echeckForTokenType($hash);
		$this->assertEqual($hash_out["accNum"], "1322143124");
		$this->assertEqual($hash_out["routingNum"], "REQUIRED");
	}

	function test_filteringType()
	{
		$hash = array(
		"prepaid"=>"yes",
      	"international"=>"no");
		$hash_out = XmlFields::filteringType($hash);
		$this->assertEqual($hash_out["prepaid"], "yes");
		$this->assertEqual($hash_out["international"], "no");
		$this->assertEqual($hash_out["chargeback"], NUll);
	}

	function test_echeckType()
	{
		$hash = array(
		"accType"=>"checking",
		"accNum"=>"12431431413");
		$hash_out = XmlFields::echeckType($hash);
		$this->assertEqual($hash_out["accType"], "checking");
		$this->assertEqual($hash_out["routingNum"], "REQUIRED");
		$this->assertEqual($hash_out["checkNum"], NUll);
	}

	function test_echeckTokenType()
	{
		$hash = array(
		"litleToken" =>"1243141413421343",
		"accType"=>"checking");
		$hash_out = XmlFields::echeckTokenType($hash);
		$this->assertEqual($hash_out["accType"], "checking");
		$this->assertEqual($hash_out["routingNum"], "REQUIRED");
		$this->assertEqual($hash_out["checkNum"], NUll);
	}

	function test_recyclingRequestType_withmissing()
	{
		$hash = array();
		$hash_out = XmlFields::recyclingRequestType($hash);
		$this->assertEqual($hash_out["recyleBy"], "REQUIRED");
	}
	function test_recyclingRequestType()
	{
		$hash = array(
		"recyleBy" => "recylingbin");
		$hash_out = XmlFields::recyclingRequestType($hash);
		$this->assertEqual($hash_out["recyleBy"], "recylingbin");
	}
}



