<?php

class LitleOnlineResponse
{
    public $Message;
    public $CardResult;
    public $CardResultMessage;
    public $AddressResult;
    public $AddressResultMessage;
    public $CallStatus;
    public $CreditResult;
    public $TransactionID;

    public $LastResults;

    private $addressResultList = array("00" => "5-Digit zip and address match",
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

    private $cardResultList = array("M" => "Match",
                                    "N" => "No Match",
                                    "P" => "Not Processed",
                                    "S" => "Security code should be on the card, but the merchant has indicated it is not present",
                                    "U" => "Issuer is not certified for CVV2/CVC2/CID processing");

    public function __construct($litleResponseXml)
    {
        $arrayData = $this->xml2array($litleResponseXml);
        $this->CallStatus = (int)$arrayData["@attributes"]["response"];
        $this->LastResults = $arrayData;

        if ( $this->CallStatus != 0 )                                   //  Communication failure
        {
            $this->Message = $arrayData["@attributes"]["message"];
            return;
        }

        if ( isset($arrayData["voidResponse"]) )
        {
            $this->Message = $arrayData["voidResponse"]["message"];
            $this->CallStatus = $arrayData["voidResponse"]["response"];
            $this->TransactionID = $arrayData["voidResponse"]["litleTxnId"];
        }

        if ( isset($arrayData["creditResponse"]) )
        {
            $this->Message = $arrayData["creditResponse"]["message"];
            $this->CallStatus = $arrayData["creditResponse"]["response"];
            $this->TransactionID = $arrayData["creditResponse"]["litleTxnId"];
        }

        if ( isset($arrayData["captureResponse"]) )
        {
            $this->Message = $arrayData["captureResponse"]["message"];
            $this->CallStatus = $arrayData["captureResponse"]["response"];
            $this->TransactionID = $arrayData["captureResponse"]["litleTxnId"];
        }

        if ( isset($arrayData["authorizationResponse"]) )
        {
            $this->Message = $arrayData["authorizationResponse"]["message"];
            $this->CallStatus = $arrayData["authorizationResponse"]["response"];
            $this->TransactionID = $arrayData["authorizationResponse"]["litleTxnId"];

            if ( isset($arrayData["authorizationResponse"]["fraudResult"]) )
            {
                $validReq = $arrayData["authorizationResponse"]["fraudResult"];

                if ( isset($validReq["avsResult"]) )
                {
                    $this->AddressResult = $validReq["avsResult"];
                    $this->AddressResultMessage = $this->addressResultList[$validReq["avsResult"]];
                }

                if ( isset($validReq["cardValidationResult"]) )
                {
                    $this->CardResult = $validReq["cardValidationResult"];
                    $this->CardResultMessage = $this->cardResultList[$validReq["cardValidationResult"]];
                }
            }
        }
    }

    private static function xml2array($xmlObject, $out = array())
    {
        foreach ( (array)$xmlObject as $index => $node )
        {
            $out[$index] = (is_object($node) ) ? $this->xml2array($node) : $node;
        }

        return $out;
    }
}
