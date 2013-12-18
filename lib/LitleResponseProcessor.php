<?php
class LitleResponseProcessor {

	private $xml_reader;
	
	/*
	 * $response_file is a string corresponding to the path of the response file to be processed.
	 */ 
	public function __construct($response_file){
		$this->xml_reader = new XMLReader();
		$this->xml_reader->open("file://" . $response_file);
		$this->xml_reader->setParserProperty(XMLReader::SUBST_ENTITIES, true);
		# read onto the root node
		$this->xml_reader->read();
		# if the response from litle is non-zero
		if($this->xml_reader->getAttribute("response") == "1"){
			$msg = $this->xml_reader->getAttribute('message');
			throw new RuntimeException("Response file $response_file indicates error: $msg");
		}
	}
	
	/*
	 * If called with either false or no argument, return a SimpleXMLElement corresponding to the next transaction response in the response file.
	 * If called with true, return the raw XML for the next transaction response in the response file.
	 * 
	 * In either case, if another transaction cannot be read from the file, return FALSE.
	 */
	public function nextTransaction($raw = FALSE){
		$tracked_elements_names = array(
			"accountUpdateResponse",
			"authorizationResponse",
			"authReversalResponse",
			"captureResponse",
			"captureGivenAuthResponse",
			"creditResponse",
			"echeckCreditResponse",
			"echeckRedepositResponse",
			"echeckSalesResponse",
			"echeckVerificationResponse",
			"forceCaptureResponse",
			"registerTokenResponse",
			"saleResponse",
			"updateCardValidationNumOnTokenResponse",
			"updateSubscriptionResponse",
			"cancelSubscriptionResponse",
			"createPlanResponse",
			"updatePlanResponse",
			"activateResponse",
			"deactivateResponse",
			"loadResponse",
			"unloadResponse",
			"balanceInquiryResponse"
		);
		
		if(in_array($this->xml_reader->localName, $tracked_elements_names) && $this->xml_reader->nodeType != XMLReader::END_ELEMENT){
			$txn_response = $this->xml_reader->readOuterXml();
			if(!$raw){
				$txn_response = simplexml_load_string($txn_response);
			}
			$this->xml_reader->read();
			return $txn_response;
		}
		else{
			if($this->xml_reader->read()){
				return $this->nextTransaction($raw);
			}
			return false;	
		}
	}
}



