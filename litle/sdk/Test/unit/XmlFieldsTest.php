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
namespace litle\sdk\Test\unit;
use litle\sdk\XmlFields;
class XmlFieldsTest extends \PHPUnit_Framework_TestCase
{
    public function test_simple_contact()
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
        $this->assertEquals($hash_out["firstName"],"Greg");
        $this->assertEquals($hash_out["addressLine2"], NULL);
        $this->assertEquals($hash_out["city"],"Lowell");
    }

    public function test_simple_customerinfo()
    {
        $hash=array(
        "ssn"=>"5215435243",
        "customerType"=>"monkey",
        "incomeAmount"=>"tomuchforamonkey",
        "incomeCurrency"=>"bannanas",
        "residenceStatus"=>"rent",
        "yearsAtResidence"=>"12");
        $hash_out = XmlFields::customerInfo($hash);
        $this->assertEquals($hash_out["ssn"],"5215435243");
        $this->assertEquals($hash_out["yearsAtEmployer"], NULL);
        $this->assertEquals($hash_out["incomeAmount"],"tomuchforamonkey");
    }

    public function test_simple_BillMeLaterRequest()
    {
        $hash=array(
            "bmlMerchantId"=>"101",
            "termsAndConditions"=>"none",
            "preapprovalNumber"=>"000",
            "merchantPromotionalCode"=>"test",
            "customerPasswordChanged"=>"NO",
            "customerEmailChanged"=>"NO");
        $hash_out = XmlFields::billMeLaterRequest($hash);
        $this->assertEquals($hash_out["bmlMerchantId"],"101");
        $this->assertEquals($hash_out["secretQuestionCode"], NULL);
        $this->assertEquals($hash_out["customerEmailChanged"],"NO");
    }

    public function test_simple_fraudCheckType()
    {
        $hash=array(
        "authenticationValue"=>"123",
        "authenticationTransactionId"=>"123",
        "authenticatedByMerchant"=> "YES");
        $hash_out = XmlFields::fraudCheckType($hash);
        $this->assertEquals($hash_out["authenticationValue"],"123");
        $this->assertEquals($hash_out["customerIpAddress"], NULL);
        $this->assertEquals($hash_out["authenticationTransactionId"],"123");
    }

    public function test_simple_authInformation()
    {
        $hash=array(
            "authDate"=>"123",
            "fraudResult"=>(array("avsResult" => "1234")),
            "authAmount"=>"123");
    $hash_out = XmlFields::authInformation($hash);
    $this->assertEquals($hash_out["authDate"],"123");
    $this->assertEquals($hash_out["authCode"], "REQUIRED");
    $this->assertEquals($hash_out["fraudResult"]["avsResult"], "1234");
    $this->assertEquals($hash_out["fraudResult"]["authenticationResult"], NULL);
    $this->assertEquals($hash_out["authAmount"],"123");
    }

    public function test_simple_fraudResult()
    {
        $hash=array(
        "avsResult"=> "123",
        "ardValidationResult"=>"456",
        "advancedAVSResult"=>"789");
        $hash_out = XmlFields::fraudResult($hash);
        $this->assertEquals($hash_out["avsResult"],"123");
        $this->assertEquals($hash_out["authenticationResult"], NULL);
        $this->assertEquals($hash_out["advancedAVSResult"],"789");
    }

    public function test_simple_healtcareAmounts()
    {
        $hash=array(
        "totalHealthcareAmount"=>"123",
        "RxAmount"=>"456",
        "visionAmount"=>"789");
        $hash_out = XmlFields::healthcareAmounts($hash);
        $this->assertEquals($hash_out["totalHealthcareAmount"],"123");
        $this->assertEquals($hash_out["dentalAmount"], NULL);
        $this->assertEquals($hash_out["RxAmount"],"456");
    }

    public function test_simple_healtcareIIAS()
    {
        $hash=array(
        "healthcareAmounts"=>(array("totalHealthcareAmount"=>"123",
        "RxAmount"=>"456",
        "visionAmount"=>"789")),
        "IIASFlag"=>"456");
        $hash_out = XmlFields::healthcareIIAS($hash);
        $this->assertEquals($hash_out["healthcareAmounts"]["totalHealthcareAmount"],"123");
        $this->assertEquals($hash_out["healthcareAmounts"]["dentalAmount"], NULL);
        $this->assertEquals($hash_out["IIASFlag"],"456");
    }

    public function test_simple_pos()
    {
        $hash=array(
        "capability"=>"123",
        "entryMode"=>"NO");
        $hash_out = XmlFields::pos($hash);
        $this->assertEquals($hash_out["capability"],"123");
        $this->assertEquals($hash_out["entryMode"], "NO");
        $this->assertEquals($hash_out["cardholderId"],"REQUIRED");
    }

    public function test_simple_detailTax()
    {
        $hash=array(
        "taxIncludedInTotal"=>"123",
        "taxAmount"=>"456",
        "taxRate"=>"high");
        $hash_out = XmlFields::detailTax($hash);
        $this->assertEquals($hash_out["taxIncludedInTotal"],"123");
        $this->assertEquals($hash_out["cardAcceptorTaxId"], NULL);
        $this->assertEquals($hash_out["taxAmount"],"456");
    }

    public function test_simple_lineItemData()
    {
        $hash=array(
        "lineItemTotal"=>"1",
        "lineItemTotalWithTax"=>"2",
        "itemDiscountAmount"=>"3",
        "commodityCode"=>"3",
        "detailTax"=> (array("taxAmount" => "high")));
        $hash_out = XmlFields::lineItemData($hash);
        $this->assertEquals($hash_out["lineItemTotal"],"1");
        $this->assertEquals($hash_out["unitCost"], NULL);
        $this->assertEquals($hash_out["lineItemTotalWithTax"],"2");
        $this->assertEquals($hash_out["detailTax"]["taxAmount"],"high");
        $this->assertEquals($hash_out["detailTax"]["taxRate"],NULL);
    }

    public function test_simple_enhancedData()
    {
        $hash=array(
        "customerReference"=>"yes",
        "salesTax"=>"5",
        "deliveryType"=>"ups",
        "taxExempt"=>"no",
        "lineItemData" => (array(
            "lineItemTotal"=>"1",
            "itemDiscountAmount"=>"3")
        ),
        "detailTax"=> (array("taxAmount" => "high")));
        $hash_out = XmlFields::enhancedData($hash);
        $this->assertEquals($hash_out["customerReference"], "yes");
        //$this->assertEquals($hash_out["lineItemData"]["lineItemTotal"],"1");
        $this->assertEquals($hash_out["discountAmount"], NULL);
        //$this->assertEquals($hash_out["lineItemData"]["lineItemTotalWithTax"],NULL);
        //$this->assertEquals($hash_out["detailTax"]["taxAmount"],"high");
        //$this->assertEquals($hash_out["detailTax"]["taxRate"],NULL);
    }
    public function test_simple_amexAggregatorData()
    {
        $hash = array(
        "sellerId"=>"1234");
        $hash_out = XmlFields::amexAggregatorData($hash);
        $this->assertEquals($hash_out["sellerId"], "1234");
        $this->assertEquals($hash_out["sellerMerchantCategoryCode"], NULL);

    }

    public function test_simple_cardType()
    {
        $hash = array(
        "type"=>"VI",
        "number"=>"4100000000000001",
        "expDate"=>"2013",
        "cardValidationNum"=>"123");
        $hash_out = XmlFields::cardType($hash);
        $this->assertEquals($hash_out["type"], "VI");
        $this->assertEquals($hash_out["track"], NULL);
        $this->assertEquals($hash_out["number"], "4100000000000001");
        $this->assertEquals($hash_out["expDate"], "2013");
        $this->assertEquals($hash_out["cardValidationNum"], "123");

    }

    public function test_simple_cardTokenType()
    {
        $hash = array(
      "expDate"=>"2013",
      "cardValidationNum"=>"123",
      "type"=>"VISA");
        $hash_out = XmlFields::cardTokenType($hash);
        $this->assertEquals($hash_out["type"], "VISA");
        $this->assertEquals($hash_out["expDate"], "2013");
        $this->assertEquals($hash_out["cardValidationNum"], "123");
        $this->assertEquals($hash_out["litleToken"], "REQUIRED");

    }

    public function test_simple_cardPaypageType()
    {
        $hash = array(
          "expDate"=>"2013",
          "cardValidationNum"=>"123",
          "type"=>"VISA");
        $hash_out = XmlFields::cardPaypageType($hash);
        $this->assertEquals($hash_out["type"], "VISA");
        $this->assertEquals($hash_out["expDate"], "2013");
        $this->assertEquals($hash_out["cardValidationNum"], "123");
        $this->assertEquals($hash_out["paypageRegistrationId"], "REQUIRED");

    }

    public function test_simple_paypal()
    {
        $hash = array(
          "token"=>"123");
        $hash_out = XmlFields::paypal($hash);
        $this->assertEquals($hash_out["token"], "123");
        $this->assertEquals($hash_out["payerId"], "REQUIRED");
        $this->assertEquals($hash_out["transactionId"], "REQUIRED");
    }

    public function test_simple_credit_paypal()
    {
        $hash = array();
        $hash_out = XmlFields::credit_paypal($hash);
        $this->assertEquals($hash_out["payerId"], "REQUIRED");
        $this->assertEquals($hash_out["payerEmail"], "REQUIRED");

    }

    public function test_customBilling()
    {
        $hash = array(
        "phone"=>"978-287",
        "city"=>"lowell",
        "descriptor"=>"123");
        $hash_out = XmlFields::customBilling($hash);
        $this->assertEquals($hash_out["phone"], "978-287");
        $this->assertEquals($hash_out["url"], NULL);
        $this->assertEquals($hash_out["descriptor"], "123");
    }

    public function test_taxBilling()
    {
        $hash = array(
       "taxAuthority"=> "123",
       "state"=>"MA");
        $hash_out = XmlFields::taxBilling($hash);
        $this->assertEquals($hash_out["taxAuthority"], "123");
        $this->assertEquals($hash_out["state"], "MA");
        $this->assertEquals($hash_out["govtTxnType"], "REQUIRED");
    }

    public function test_processingInstructions()
    {
        $hash = array("bypassVelocityCheck"=>"yes");
        $hash_out = XmlFields::processingInstructions($hash);
        $this->assertEquals($hash_out["bypassVelocityCheck"], "yes");
    }

    public function test_echeckForTokenType()
    {
        $hash = array("accNum"=>"1322143124");
        $hash_out = XmlFields::echeckForTokenType($hash);
        $this->assertEquals($hash_out["accNum"], "1322143124");
        $this->assertEquals($hash_out["routingNum"], "REQUIRED");
    }

    public function test_filteringType()
    {
        $hash = array(
        "prepaid"=>"yes",
          "international"=>"no");
        $hash_out = XmlFields::filteringType($hash);
        $this->assertEquals($hash_out["prepaid"], "yes");
        $this->assertEquals($hash_out["international"], "no");
        $this->assertEquals($hash_out["chargeback"], NUll);
    }

    public function test_echeckType()
    {
        $hash = array(
        "accType"=>"checking",
        "accNum"=>"12431431413");
        $hash_out = XmlFields::echeckType($hash);
        $this->assertEquals($hash_out["accType"], "checking");
        $this->assertEquals($hash_out["routingNum"], "REQUIRED");
        $this->assertEquals($hash_out["checkNum"], NUll);
    }

    public function test_echeckTokenType()
    {
        $hash = array(
        "litleToken" =>"1243141413421343",
        "accType"=>"checking");
        $hash_out = XmlFields::echeckTokenType($hash);
        $this->assertEquals($hash_out["accType"], "checking");
        $this->assertEquals($hash_out["routingNum"], "REQUIRED");
        $this->assertEquals($hash_out["checkNum"], NUll);
    }

    public function test_recyclingRequestType_withmissing()
    {
        $hash = array();
        $hash_out = XmlFields::recyclingRequestType($hash);
        $this->assertEquals($hash_out["recycleBy"], "REQUIRED");
    }
    public function test_recyclingRequestType()
    {
        $hash = array(
        "recycleBy" => "recylingbin");
        $hash_out = XmlFields::recyclingRequestType($hash);
        $this->assertEquals($hash_out["recycleBy"], "recylingbin");
    }

    public function test_contact_name_to_long()
    {
        $input = "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
        $hash = array("name" => $input . "1");
        $hash_out = XmlFields::contact($hash);
        $this->assertEquals($input,$hash_out["name"]);
    }

    public function test_contact_firstname_to_long()
    {
        $input = "1234567890123456789012345";
        $hash = array("firstName" => $input . "1");
        $hash_out = XmlFields::contact($hash);
        $this->assertEquals($input,$hash_out["firstName"]);
    }

    public function test_contact_middleInitial_to_long()
    {
        $input = "1";
        $hash = array("middleInitial" => $input . "1");
        $hash_out = XmlFields::contact($hash);
        $this->assertEquals($input,$hash_out["middleInitial"]);
    }

    public function test_contact_lastname_to_long()
    {
        $input = "1234567890123456789012345";
        $hash = array("lastName" => $input . "1");
        $hash_out = XmlFields::contact($hash);
        $this->assertEquals($input,$hash_out["lastName"]);
    }

    public function test_contact_companyName_to_long()
    {
        $input = "1234567890123456789012345678901234567890";
        $hash = array("companyName" => $input . "1");
        $hash_out = XmlFields::contact($hash);
        $this->assertEquals($input,$hash_out["companyName"]);
    }

    public function test_contact_addressLine1_to_long()
    {
        $input = "12345678901234567890123456789012345";
        $hash = array("addressLine1" => $input . "1");
        $hash_out = XmlFields::contact($hash);
        $this->assertEquals($input,$hash_out["addressLine1"]);
    }

    public function test_contact_addressLine2_to_long()
    {
        $input = "12345678901234567890123456789012345";
        $hash = array("addressLine2" => $input . "1");
        $hash_out = XmlFields::contact($hash);
        $this->assertEquals($input,$hash_out["addressLine2"]);
    }

    public function test_contact_addressLine3_to_long()
    {
        $input = "12345678901234567890123456789012345";
        $hash = array("addressLine3" => $input . "1");
        $hash_out = XmlFields::contact($hash);
        $this->assertEquals($input,$hash_out["addressLine3"]);
    }

    public function test_contact_city_to_long()
    {
        $input = "12345678901234567890123456789012345";
        $hash = array("city" => $input . "1");
        $hash_out = XmlFields::contact($hash);
        $this->assertEquals($input,$hash_out["city"]);
    }

    public function test_contact_state_to_long()
    {
        $input = "123456789012345678901234567890";
        $hash = array("state" => $input . "1");
        $hash_out = XmlFields::contact($hash);
        $this->assertEquals($input,$hash_out["state"]);
    }

    public function test_contact_zip_to_long()
    {
        $input = "12345678901234567890";
        $hash = array("zip" => $input . "1");
        $hash_out = XmlFields::contact($hash);
        $this->assertEquals($input,$hash_out["zip"]);
    }

    public function test_contact_country_to_long()
    {
        $input = "123";
        $hash = array("country" => $input . "1");
        $hash_out = XmlFields::contact($hash);
        $this->assertEquals($input,$hash_out["country"]);
    }

    public function test_contact_email_to_long()
    {
        $input = "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
        $hash = array("email" => $input . "1");
        $hash_out = XmlFields::contact($hash);
        $this->assertEquals($input,$hash_out["email"]);
    }

    public function test_contact_phone_to_long()
    {
        $input = "12345678901234567890";
        $hash = array("phone" => $input . "1");
        $hash_out = XmlFields::contact($hash);
        $this->assertEquals($input,$hash_out["phone"]);
    }

    public function test_recurringRequest_full()
    {
        $hash_in = array(
            'recurringRequest'=>array(
                'subscription'=>array(
                    'planCode'=>'abc123',
                    'numberOfPayments'=>'10',
                    'startDate'=>'07/25/2013',
                    'amount'=>'102',
                ),
            ),
        );
        $hash_out = XmlFields::recurringRequestType(XmlFields::returnArrayValue($hash_in,'recurringRequest'));
        $this->assertEquals($hash_out['subscription']['planCode'], "abc123");
        $this->assertEquals($hash_out['subscription']['numberOfPayments'], "10");
        $this->assertEquals($hash_out['subscription']['startDate'], "07/25/2013");
        $this->assertEquals($hash_out['subscription']['amount'], "102");
    }

    public function test_recurringRequest_onlyRequired()
    {
        $hash_in = array (
                'recurringRequest' => array (
                        'subscription' => array (
                                'planCode' => 'abc123',
                        )
                )
        );
        $hash_out = XmlFields::recurringRequestType ( XmlFields::returnArrayValue ( $hash_in, 'recurringRequest' ) );
        $this->assertEquals ( $hash_out ['subscription'] ['planCode'], "abc123" );
        $this->assertEquals ( $hash_out ['subscription'] ['numberOfPayments'], NULL );
        $this->assertEquals ( $hash_out ['subscription'] ['startDate'], NULL );
        $this->assertEquals ( $hash_out ['subscription'] ['amount'], NULL );
    }

    public function test_recurringRequest_missingRequired()
    {
        $hash_in = array (
                'recurringRequest' => array (
                        'subscription' => array (
                                'numberOfPayments' => '10',
                        )
                )
        );
        $hash_out = XmlFields::recurringRequestType ( XmlFields::returnArrayValue ( $hash_in, 'recurringRequest' ) );
        $this->assertEquals ( $hash_out ['subscription'] ['planCode'], "REQUIRED" );
        $this->assertEquals ( $hash_out ['subscription'] ['numberOfPayments'], '10' );
        $this->assertEquals ( $hash_out ['subscription'] ['startDate'], NULL );
        $this->assertEquals ( $hash_out ['subscription'] ['amount'], NULL );
    }

    public function test_pos_has_optional_catLevel()
    {
        $hash=array(
        "capability"=>"123",
        "entryMode"=>"NO",
        "catLevel"=>"self service");
        $hash_out = XmlFields::pos($hash);
        $this->assertEquals($hash_out["capability"],"123");
        $this->assertEquals($hash_out["entryMode"], "NO");
        $this->assertEquals($hash_out["cardholderId"],"REQUIRED");
        $this->assertEquals($hash_out["catLevel"],"self service");
    }

    public function test_mpos_required()
    {
        $hash_in = array('ksn' => '123', 'formatId' =>'30', 'encryptedTrack' => 'Encrypted Track', 'track1Status' =>'2', 'track2Status' => '1');
        $hash_out = XmlFields::mposType($hash_in);
        $this->assertEquals($hash_out["ksn"],"123");
        $this->assertEquals($hash_out["formatId"],"30");
        $this->assertEquals($hash_out["encryptedTrack"],"Encrypted Track");
        $this->assertEquals($hash_out["track1Status"],"2");
        $this->assertEquals($hash_out["track2Status"],"1");

    }

}
