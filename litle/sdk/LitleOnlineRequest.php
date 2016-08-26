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
namespace litle\sdk;
require_once realpath(dirname(__FILE__)) . '/LitleOnline.php';
class LitleOnlineRequest
{
    private $useSimpleXml = false;

    public function __construct($treeResponse=false)
    {
        $this->useSimpleXml = $treeResponse;
        $this->newXML = new LitleXmlMapper();
    }

    public static function getAddressResponse($code)
    {
        $codes = array("00" => "5-Digit zip and address match",
                       "01" => "9-Digit zip and address match",
                       "02" => "Postal code and address match",
                       "10" => "5-Digit zip matches, address does not match",
                       "11" => "9-Digit zip matches, address does not match",
                       "12" => "Zip does not match, address matches",
                       "13" => "Postal code does not match, address matches",
                       "14" => "Postal code matches, address not verified",
                       "20" => "Neither zip nor address match",
                       "30" => "AVS service not supported by issuer",
                       "31" => "AVS system not available",
                       "32" => "Address unavailable",
                       "33" => "General error",
                       "34" => "AVS not performed",
                       "40" => "Address failed Litle & Co. edit checks");

        return (isset($codes[$code]) ? $codes[$code] : "Unknown Address Response");
    }

    public static function getCardResponse($code)
    {
        $codes = array("M" => "Match",
                       "N" => "No Match",
                       "P" => "Not Processed",
                       "S" => "Security code should be on the card, but the merchant has indicated it is not present",
                       "U" => "Issuer is not certified for CVV2/CVC2/CID processing",
                       ""  => "Check was not done for an unspecified reason");

        return (isset($codes[$code]) ? $codes[$code] : "Unknown Address Response");
    }

    public function authorizationRequest($hash_in)
    {
        if (isset($hash_in['litleTxnId'])) {
            $hash_out = array('litleTxnId'=> (XmlFields::returnArrayValue($hash_in,'litleTxnId')));
        } else {
            $hash_out = array(
            'orderId'=> Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderId')),
            'amount'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'amount')),
            'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
            'secondaryAmount'=>XmlFields::returnArrayValue($hash_in,'secondaryAmount'),
            'surchargeAmount' =>XmlFields::returnArrayValue($hash_in,'surchargeAmount'),
            'orderSource'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderSource')),
            'customerInfo'=>(XmlFields::customerInfo(XmlFields::returnArrayValue($hash_in,'customerInfo'))),
            'billToAddress'=>(XmlFields::contact(XmlFields::returnArrayValue($hash_in,'billToAddress'))),
            'shipToAddress'=>(XmlFields::contact(XmlFields::returnArrayValue($hash_in,'shipToAddress'))),
            'card'=> (XmlFields::cardType(XmlFields::returnArrayValue($hash_in,'card'))),
            'paypal'=>(XmlFields::payPal(XmlFields::returnArrayValue($hash_in,'paypal'))),
            'token'=>(XmlFields::cardTokenType(XmlFields::returnArrayValue($hash_in,'token'))),
            'paypage'=>(XmlFields::cardPaypageType(XmlFields::returnArrayValue($hash_in,'paypage'))),
            'applepay'=>(XmlFields::applepayType(XmlFields::returnArrayValue($hash_in,'applepay'))),
            'mpos'=>(XmlFields::mposType(XmlFields::returnArrayValue($hash_in,'mpos'))),
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
        $choice_hash = array(XmlFields::returnArrayValue($hash_out,'card'),XmlFields::returnArrayValue($hash_out,'paypal'),XmlFields::returnArrayValue($hash_out,'token'),XmlFields::returnArrayValue($hash_out,'paypage'),XmlFields::returnArrayValue($hash_out,'applepay'),XmlFields::returnArrayValue($hash_out,'mpos'));
                $authorizationResponse = $this->processRequest($hash_out,$hash_in,'authorization',$choice_hash);

        return $authorizationResponse;
    }

    public function saleRequest($hash_in)
    {
        $hash_out = array(
            'litleTxnId' => XmlFields::returnArrayValue($hash_in,'litleTxnId'),
            'orderId' =>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderId')),
            'amount' =>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'amount')),
        	'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
            'secondaryAmount'=>XmlFields::returnArrayValue($hash_in,'secondaryAmount'),
            'surchargeAmount' =>XmlFields::returnArrayValue($hash_in,'surchargeAmount'),
            'orderSource'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderSource')),
            'customerInfo'=>XmlFields::customerInfo(XmlFields::returnArrayValue($hash_in,'customerInfo')),
            'billToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'billToAddress')),
            'shipToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'shipToAddress')),
            'card'=> XmlFields::cardType(XmlFields::returnArrayValue($hash_in,'card')),
            'paypal'=>XmlFields::payPal(XmlFields::returnArrayValue($hash_in,'paypal')),
            'token'=>XmlFields::cardTokenType(XmlFields::returnArrayValue($hash_in,'token')),
            'paypage'=>XmlFields::cardPaypageType(XmlFields::returnArrayValue($hash_in,'paypage')),
        	'applepay'=>(XmlFields::applepayType(XmlFields::returnArrayValue($hash_in,'applepay'))),
            'mpos'=>(XmlFields::mposType(XmlFields::returnArrayValue($hash_in,'mpos'))),
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

        $choice_hash = array($hash_out['card'],$hash_out['paypal'],$hash_out['token'],$hash_out['paypage'],$hash_out['applepay'],$hash_out['mpos']);
        $choice2_hash= array($hash_out['fraudCheck'],$hash_out['cardholderAuthentication']);
        $saleResponse = $this->processRequest($hash_out,$hash_in,'sale',$choice_hash,$choice2_hash);

        return $saleResponse;
    }

    public function authReversalRequest($hash_in)
    {
        $hash_out = array(
            'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
        	'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
            'amount' =>XmlFields::returnArrayValue($hash_in,'amount'),
            'surchargeAmount' =>XmlFields::returnArrayValue($hash_in,'surchargeAmount'),
            'payPalNotes'=>XmlFields::returnArrayValue($hash_in,'payPalNotes'),
            'actionReason'=>XmlFields::returnArrayValue($hash_in,'actionReason'));
        $authReversalResponse = $this->processRequest($hash_out,$hash_in,'authReversal');

        return $authReversalResponse;
    }

    public function creditRequest($hash_in)
    {
        $hash_out = array(
                    'litleTxnId' => XmlFields::returnArrayValue($hash_in, 'litleTxnId'),
        		    'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
                    'orderId' =>XmlFields::returnArrayValue($hash_in, 'orderId'),
                    'amount' =>XmlFields::returnArrayValue($hash_in, 'amount'),
        		    'secondaryAmount'=>XmlFields::returnArrayValue($hash_in,'secondaryAmount'),
                    'surchargeAmount' =>XmlFields::returnArrayValue($hash_in,'surchargeAmount'),
                    'orderSource'=>XmlFields::returnArrayValue($hash_in, 'orderSource'),
                    'billToAddress'=>XmlFields::contact(XMLFields::returnArrayValue($hash_in, 'billToAddress')),
                    'card'=>XmlFields::cardType(XMLFields::returnArrayValue($hash_in, 'card')),
                    'paypal'=>XmlFields::credit_payPal(XMLFields::returnArrayValue($hash_in, 'paypal')),
                    'token'=>XmlFields::cardTokenType(XMLFields::returnArrayValue($hash_in, 'token')),
                    'paypage'=>XmlFields::cardPaypageType(XMLFields::returnArrayValue($hash_in, 'paypage')),
                    'mpos'=>(XmlFields::mposType(XmlFields::returnArrayValue($hash_in,'mpos'))),
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

        $choice_hash = array($hash_out['card'],$hash_out['paypal'],$hash_out['token'],$hash_out['paypage'],$hash_out['mpos']);
        $creditResponse = $this->processRequest($hash_out,$hash_in,'credit',$choice_hash);

        return $creditResponse;
    }

    public function registerTokenRequest($hash_in)
    {
        $hash_out = array(
            'orderId'=>XmlFields::returnArrayValue($hash_in,'orderId'),
        	'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
            'accountNumber'=>XmlFields::returnArrayValue($hash_in,'accountNumber'),
            'echeckForToken'=>XmlFields::echeckForTokenType(XmlFields::returnArrayValue($hash_in,'echeckForToken')),
            'paypageRegistrationId'=>XmlFields::returnArrayValue($hash_in,'paypageRegistrationId'),
            'applepay'=>(XmlFields::applepayType(XmlFields::returnArrayValue($hash_in,'applepay'))),
            'cardValidationNum'=>XmlFields::returnArrayValue($hash_in,'cardValidationNum'),
        );

        $choice_hash = array($hash_out['accountNumber'],$hash_out['echeckForToken'],$hash_out['paypageRegistrationId'],$hash_out['applepay']);
        $registerTokenResponse = $this->processRequest($hash_out,$hash_in,'registerTokenRequest',$choice_hash);

        return $registerTokenResponse;
    }

    public function forceCaptureRequest($hash_in)
    {
        $hash_out = array(
            'orderId' =>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderId')),
        	'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
            'amount' =>XmlFields::returnArrayValue($hash_in,'amount'),
        	'secondaryAmount'=>XmlFields::returnArrayValue($hash_in,'secondaryAmount'),
            'surchargeAmount' =>XmlFields::returnArrayValue($hash_in,'surchargeAmount'),
            'orderSource'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderSource')),
            'billToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'billToAddress')),
            'card'=> XmlFields::cardType(XmlFields::returnArrayValue($hash_in,'card')),
            'token'=>XmlFields::cardTokenType(XmlFields::returnArrayValue($hash_in,'token')),
            'paypage'=>XmlFields::cardPaypageType(XmlFields::returnArrayValue($hash_in,'paypage')),
            'mpos'=>(XmlFields::mposType(XmlFields::returnArrayValue($hash_in,'mpos'))),
            'customBilling'=>XmlFields::customBilling(XmlFields::returnArrayValue($hash_in,'customBilling')),
            'taxBilling'=>XmlFields::taxBilling(XmlFields::returnArrayValue($hash_in,'taxBilling')),
            'enhancedData'=>XmlFields::enhancedData(XmlFields::returnArrayValue($hash_in,'enhancedData')),
            'processingInstructions'=>XmlFields::processingInstructions(XmlFields::returnArrayValue($hash_in,'processingInstructions')),
            'pos'=>XmlFields::pos(XmlFields::returnArrayValue($hash_in,'pos')),
            'amexAggregatorData'=>XmlFields::amexAggregatorData(XmlFields::returnArrayValue($hash_in,'amexAggregatorData')),
            'merchantData'=>(XmlFields::merchantData(XmlFields::returnArrayValue($hash_in,'merchantData'))),
            'debtRepayment'=>XmlFields::returnArrayValue($hash_in,'debtRepayment'),
        );

        $choice_hash = array(XmlFields::returnArrayValue($hash_out,'card'),XmlFields::returnArrayValue($hash_out,'paypal'),XmlFields::returnArrayValue($hash_out,'token'),XmlFields::returnArrayValue($hash_out,'paypage'),XmlFields::returnArrayValue($hash_out,'mpos'));
        $forceCaptureResponse = $this->processRequest($hash_out,$hash_in,'forceCapture',$choice_hash);

        return $forceCaptureResponse;
    }

    public function captureRequest($hash_in)
    {
        $hash_out = array(
        'partial'=>XmlFields::returnArrayValue($hash_in,'partial'),
        'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
        'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
        'amount' =>(XmlFields::returnArrayValue($hash_in,'amount')),
        'surchargeAmount' =>XmlFields::returnArrayValue($hash_in,'surchargeAmount'),
        'enhancedData'=>XmlFields::enhancedData(XmlFields::returnArrayValue($hash_in,'enhancedData')),
        'processingInstructions'=>XmlFields::processingInstructions(XmlFields::returnArrayValue($hash_in,'processingInstructions')),
        'payPalOrderComplete'=>XmlFields::returnArrayValue($hash_in,'payPalOrderComplete'),
        'payPalNotes' =>XmlFields::returnArrayValue($hash_in,'payPalNotes'));
        $captureResponse = $this->processRequest($hash_out,$hash_in,'capture');

        return $captureResponse;
    }

    public function captureGivenAuthRequest($hash_in)
    {
        $hash_out = array(
            'orderId'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderId')),
        	'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
            'authInformation'=>XmlFields::authInformation(XmlFields::returnArrayValue($hash_in,'authInformation')),
            'amount' =>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'amount')),
        	'secondaryAmount'=>XmlFields::returnArrayValue($hash_in,'secondaryAmount'),
            'surchargeAmount' =>XmlFields::returnArrayValue($hash_in,'surchargeAmount'),
            'orderSource'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderSource')),
            'billToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'billToAddress')),
            'shipToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'shipToAddress')),
            'card'=> XmlFields::cardType(XmlFields::returnArrayValue($hash_in,'card')),
            'token'=>XmlFields::cardTokenType(XmlFields::returnArrayValue($hash_in,'token')),
            'paypage'=>XmlFields::cardPaypageType(XmlFields::returnArrayValue($hash_in,'paypage')),
            'mpos'=>(XmlFields::mposType(XmlFields::returnArrayValue($hash_in,'mpos'))),
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

        $choice_hash = array($hash_out['card'],$hash_out['token'],$hash_out['paypage'],$hash_out['mpos']);
        $captureGivenAuthResponse = $this->processRequest($hash_out,$hash_in,'captureGivenAuth',$choice_hash);

        return $captureGivenAuthResponse;
    }

    public function echeckRedepositRequest($hash_in)
    {
        $hash_out = array(
            'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
        	'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
            'echeck'=>XmlFields::echeckType(XmlFields::returnArrayValue($hash_in,'echeck')),
            'echeckToken'=>XmlFields::echeckTokenType(XmlFields::returnArrayValue($hash_in,'echeckToken')),
            'merchantData'=>(XmlFields::merchantData(XmlFields::returnArrayValue($hash_in,'merchantData')))
        );

        $choice_hash = array($hash_out['echeck'],$hash_out['echeckToken']);
        $echeckRedepositResponse = $this->processRequest($hash_out,$hash_in,'echeckRedeposit',$choice_hash);

        return $echeckRedepositResponse;
    }

    public function echeckSaleRequest($hash_in)
    {
        $hash_out = array(
        'litleTxnId'=>XmlFields::returnArrayValue($hash_in,'litleTxnId'),
        'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
        'orderId'=>XmlFields::returnArrayValue($hash_in,'orderId'),
        'verify'=>XmlFields::returnArrayValue($hash_in,'verify'),
        'amount'=>XmlFields::returnArrayValue($hash_in,'amount'),
        'secondaryAmount'=>XmlFields::returnArrayValue($hash_in,'secondaryAmount'),
        'orderSource'=>XmlFields::returnArrayValue($hash_in,'orderSource'),
        'billToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'billToAddress')),
        'shipToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'shipToAddress')),
        'echeck'=>XmlFields::echeckType(XmlFields::returnArrayValue($hash_in,'echeck')),
        'echeckToken'=>XmlFields::echeckTokenType(XmlFields::returnArrayValue($hash_in,'echeckToken')),
        'customBilling'=>XmlFields::customBilling(XmlFields::returnArrayValue($hash_in,'customBilling')));

        $choice_hash = array($hash_out['echeck'],$hash_out['echeckToken']);

        $echeckSaleResponse = $this->processRequest($hash_out,$hash_in,'echeckSale',$choice_hash);

        return $echeckSaleResponse;
    }

    //public function echeckSaleRequestObject(EcheckSale $echeckSale) {
        //TODO Can I overload?  What are php's rules?
    //}

    public function echeckCreditRequest($hash_in)
    {
        $hash_out = array(
            'litleTxnId'=>XmlFields::returnArrayValue($hash_in,'litleTxnId'),
        	'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
            'orderId'=>XmlFields::returnArrayValue($hash_in,'orderId'),
            'amount'=>XmlFields::returnArrayValue($hash_in,'amount'),
        	'secondaryAmount'=>XmlFields::returnArrayValue($hash_in,'secondaryAmount'),
            'orderSource'=>XmlFields::returnArrayValue($hash_in,'orderSource'),
            'billToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'billToAddress')),
            'echeck'=>XmlFields::echeckType(XmlFields::returnArrayValue($hash_in,'echeck')),
            'echeckToken'=>XmlFields::echeckTokenType(XmlFields::returnArrayValue($hash_in,'echeckToken')),
            'customBilling'=>XmlFields::customBilling(XmlFields::returnArrayValue($hash_in,'customBilling')));

        $choice_hash = array($hash_out['echeck'],$hash_out['echeckToken']);
        $echeckCreditResponse = $this->processRequest($hash_out,$hash_in,'echeckCredit',$choice_hash);

        return $echeckCreditResponse;
    }

    public function echeckVerificationRequest($hash_in)
    {

        $hash_out = array(
            'litleTxnId'=>XmlFields::returnArrayValue($hash_in,'litleTxnId'),
        	'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
            'orderId'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderId')),
            'amount'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'amount')),
            'orderSource'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'orderSource')),
            'billToAddress'=>XmlFields::contact(XmlFields::returnArrayValue($hash_in,'billToAddress')),
            'echeck'=>XmlFields::echeckType(XmlFields::returnArrayValue($hash_in,'echeck')),
            'echeckToken'=>XmlFields::echeckTokenType(XmlFields::returnArrayValue($hash_in,'echeckToken')),
            'merchantData'=>(XmlFields::merchantData(XmlFields::returnArrayValue($hash_in,'merchantData'))),
        );

        $choice_hash = array($hash_out['echeck'],$hash_out['echeckToken']);
        $echeckVerificationResponse = $this->processRequest($hash_out,$hash_in,'echeckVerification',$choice_hash);

        return $echeckVerificationResponse;
    }

    public function voidRequest($hash_in)
    {
        $hash_out = array(
        'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
        'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
        'processingInstructions'=>XmlFields::processingInstructions(XmlFields::returnArrayValue($hash_in,'processingInstructions')));
        $voidResponse = $this->processRequest($hash_out,$hash_in,'void');

        return $voidResponse;
    }

    public function echeckVoidRequest($hash_in)
    {
        $hash_out = array(
        'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
        'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
        );
        $echeckVoidResponse = $this->processRequest($hash_out,$hash_in,"echeckVoid");

        return $echeckVoidResponse;
    }

    public function depositReversalRequest($hash_in)
    {
        $hash_out = array(
        'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
        'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
        );
        $response = $this->processRequest($hash_out,$hash_in,"depositReversal");

        return $response;
    }
    public function refundReversalRequest($hash_in)
    {
        $hash_out = array(
        'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
        'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
        );
        $response = $this->processRequest($hash_out,$hash_in,"refundReversal");

        return $response;
    }
    public function activateReversalRequest($hash_in)
    {
        $hash_out = array(
        'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
        'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
        );
        $response = $this->processRequest($hash_out,$hash_in,"activateReversal");

        return $response;
    }
    public function deactivateReversalRequest($hash_in)
    {
        $hash_out = array(
        'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
        'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
        );
        $response = $this->processRequest($hash_out,$hash_in,"deactivateReversal");

        return $response;
    }
    public function loadReversalRequest($hash_in)
    {
        $hash_out = array(
        'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
        'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
        );
        $response = $this->processRequest($hash_out,$hash_in,"loadReversal");

        return $response;
    }
    public function unloadReversalRequest($hash_in)
    {
        $hash_out = array(
        'litleTxnId' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleTxnId')),
        'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
        );
        $response = $this->processRequest($hash_out,$hash_in,"unloadReversal");

        return $response;
    }

    public function updateCardValidationNumOnToken($hash_in)
    {
        $hash_out = array(
                'orderId'=>XmlFields::returnArrayValue($hash_in,'orderId'),
        		'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
                'litleToken' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'litleToken')),
                'cardValidationNum' => Checker::requiredField(XmlFields::returnArrayValue($hash_in,'cardValidationNum')),
        );
        $updateCardValidationNumOnTokenResponse = $this->processRequest($hash_out,$hash_in,"updateCardValidationNumOnToken");

        return $updateCardValidationNumOnTokenResponse;
    }

    public function updateSubscription($hash_in)
    {
        $hash_out = Transactions::createUpdateSubscriptionHash($hash_in);
        $choice_hash = array(XmlFields::returnArrayValue($hash_out,'card'),XmlFields::returnArrayValue($hash_out,'token'),XmlFields::returnArrayValue($hash_out,'paypage'));
        $updateSubscriptionResponse = $this->processRequest($hash_out,$hash_in,"updateSubscription");

        return $updateSubscriptionResponse;
    }

    public function cancelSubscription($hash_in)
    {
        $hash_out = Transactions::createCancelSubscriptionHash($hash_in);
        $cancelSubscriptionResponse = $this->processRequest($hash_out,$hash_in,"cancelSubscription");

        return $cancelSubscriptionResponse;
    }

    public function updatePlan($hash_in)
    {
        $hash_out = Transactions::createUpdatePlanHash($hash_in);
        $updatePlanResponse = $this->processRequest($hash_out,$hash_in,"updatePlan");

        return $updatePlanResponse;
    }

    public function createPlan($hash_in)
    {
        $hash_out = Transactions::createCreatePlanHash($hash_in);
        $createPlanResponse = $this->processRequest($hash_out,$hash_in,"createPlan");

        return $createPlanResponse;
    }

    public function activate($hash_in)
    {
        $hash_out = Transactions::createActivateHash($hash_in);
        $txnResponse = $this->processRequest($hash_out,$hash_in,"activate");

        return $txnResponse;
    }
    public function deactivate($hash_in)
    {
        $hash_out = Transactions::createDeactivateHash($hash_in);
        $txnResponse = $this->processRequest($hash_out,$hash_in,"deactivate");

        return $txnResponse;
    }
    public function load($hash_in)
    {
        $hash_out = Transactions::createLoadHash($hash_in);
        $txnResponse = $this->processRequest($hash_out,$hash_in,"load");

        return $txnResponse;
    }
    public function unload($hash_in)
    {
        $hash_out = Transactions::createUnloadHash($hash_in);
        $txnResponse = $this->processRequest($hash_out,$hash_in,"unload");

        return $txnResponse;
    }
    public function balanceInquiry($hash_in)
    {
        $hash_out = Transactions::createBalanceInquiryHash($hash_in);
        $txnResponse = $this->processRequest($hash_out,$hash_in,"balanceInquiry");

        return $txnResponse;
    }
    
    public function queryTransaction($hash_in)
    {
    	$hash_out = array(
    			'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
    			'origId'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'origId')),
    			'origActionType'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'origActionType')),
    			'origLitleTxnId'=>XmlFields::returnArrayValue($hash_in,'origLitleTxnId'),
    			'origOrderId'=>XmlFields::returnArrayValue($hash_in,'origOrderId'),
    			'origAccountNumber'=>XmlFields::returnArrayValue($hash_in,'origAccountNumber'),
    	);
    	$queryTransactionResponse = $this->processRequest($hash_out,$hash_in,"queryTransaction");
    
    	return $queryTransactionResponse;
    }
    
    public function fraudCheck($hash_in)
    {
    	$hash_out = array(
    			'id'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'id')),
    			'advancedFraudChecks'=>Checker::requiredField(XmlFields::returnArrayValue($hash_in,'advancedFraudChecks')),
    			'billToAddress' => XmlFields::contact ( XmlFields::returnArrayValue ( $hash_in, 'billToAddress' ) ),
    			'shipToAddress' => XmlFields::contact ( XmlFields::returnArrayValue ( $hash_in, 'shipToAddress' ) ),
    			'amount' => ( XmlFields::returnArrayValue ( $hash_in, 'amount' ) )
    	);
    	$fraudCheckResponse = $this->processRequest($hash_out,$hash_in,"fraudCheck");
    	
    	return $fraudCheckResponse;
    }

    private static function overrideConfig($hash_in)
    {
        $hash_config = array();
        $names = explode(',', LITLE_CONFIG_LIST);

        foreach ($names as $name) {
            if (array_key_exists($name, $hash_in)) {
                $hash_config[$name] = XmlFields::returnArrayValue($hash_in, $name);
            }
        }

        return $hash_config;
    }

    private static function getOptionalAttributes($hash_in,$hash_out)
    {
        if (isset($hash_in['merchantSdk'])) {
            $hash_out['merchantSdk'] = XmlFields::returnArrayValue($hash_in,'merchantSdk');
        } else {
            $hash_out['merchantSdk'] = CURRENT_SDK_VERSION;
        }
        if (isset($hash_in['id'])) {
            $hash_out['id'] = XmlFields::returnArrayValue($hash_in,'id');
        }
        if (isset($hash_in['customerId'])) {
            $hash_out['customerId'] = XmlFields::returnArrayValue($hash_in,'customerId');
        }
        if (isset($hash_in['loggedInUser'])) {
            $hash_out['loggedInUser'] = XmlFields::returnArrayValue($hash_in,'loggedInUser');
        }

        return $hash_out;
    }

    private function processRequest($hash_out, $hash_in, $type, $choice1 = null, $choice2 = null)
    {
        $hash_config = LitleOnlineRequest::overrideConfig($hash_in);
        $hash = LitleOnlineRequest::getOptionalAttributes($hash_in,$hash_out);
        Checker::choice($choice1);
        Checker::choice($choice2);
        $request = Obj2xml::toXml($hash,$hash_config, $type);
        $litleOnlineResponse = $this->newXML->request($request,$hash_config,$this->useSimpleXml);
		
        return $litleOnlineResponse;
    }

}
