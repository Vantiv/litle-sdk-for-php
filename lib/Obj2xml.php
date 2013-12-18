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
require_once realpath(dirname(__FILE__)) . '/LitleOnline.php';
class Obj2xml {

	public static function toXml($data, $hash_config, $type, $rootNodeName = 'litleOnlineRequest', $xml=null)
	{
		$config= Obj2xml::getConfig($hash_config);
		$xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
		$xml-> addAttribute('merchantId',$config["merchantId"]);
		$xml-> addAttribute('version',CURRENT_XML_VERSION);
		$xml-> addAttribute('merchantSdk',$data['merchantSdk']);
		unset($data['merchantSdk']);
		if(isset($data['loggedInUser'])) {
			$xml->addAttribute('loggedInUser',$data["loggedInUser"]);
		};
		unset($data['loggedInUser']);
		$xml-> addAttribute('xmlns:xmlns','http://www.litle.com/schema');// does not show up on browser docs
		$authentication = $xml->addChild('authentication');
		$authentication->addChild('user',$config["user"]);
		$authentication->addChild('password',$config["password"]);
		$transacType = $xml->addChild($type);
		if(isset($data['partial'])) {
			($transacType-> addAttribute('partial',$data["partial"]));
		};
		unset($data['partial']);
		if(isset($data['customerId'])) {
			($transacType-> addAttribute('customerId',$data["customerId"]));
		};
		unset($data['customerId']);
		
		if(Obj2xml::transactionShouldHaveReportGroup($type, $config) && isset($config['reportGroup'])) {
			($transacType-> addAttribute('reportGroup',$config["reportGroup"]));
		};
		if(isset($data['id'])) {
			($transacType-> addAttribute('id',$data["id"]));
		};
		unset($data['id']);
		Obj2xml::iterateChildren($data,$transacType);
		return $xml->asXML();
	}
	
	public static function transactionShouldHaveReportGroup($transactionType) {
          $transactionsThatDontHaveReportGroup = array(
            'updateSubscription',
            'cancelSubscription',
            'createPlan',
            'updatePlan'
        );
        return (FALSE === array_search($transactionType, $transactionsThatDontHaveReportGroup));
	}

	public static function transactionToXml($data, $type, $report_group){
		
		$transac = simplexml_load_string("<$type />");
		if(Obj2xml::transactionShouldHaveReportGroup($type)) {
		    $transac->addAttribute('reportGroup', $report_group);
		}
		Obj2xml::iterateChildren($data,$transac);
		
		return str_replace("<?xml version=\"1.0\"?>\n", "", $transac->asXML());
	}
	
	public static function rfrRequestToXml($hash_in){
		$rfr = simplexml_load_string("<RFRRequest />");
		if(isset($hash_in['litleSessionId'])){
			$rfr->addChild('litleSessionId', $hash_in['litleSessionId']);
		}
		else if(isset($hash_in['merchantId']) && isset($hash_in['postDay'])){
			$auFileRequest = $rfr->addChild('accountUpdateFileRequestData');
			$auFileRequest->addChild('merchantId', $hash_in['merchantId']);
			$auFileRequest->addChild('postDay', $hash_in['postDay']);
		}
		else{
			throw RuntimeException('To add an RFR Request, either a litleSessionId or a merchantId and a postDay must be set.');
		}
		return str_replace("<?xml version=\"1.0\"?>\n", "", $rfr->asXML());
	}

	public static function generateBatchHeader($counts_and_amounts){
		$config= Obj2xml::getConfig(array());
		
		$xml = simplexml_load_string("<batchRequest />");
		$xml->addAttribute('merchantId', $config['merchantId']);
		$xml->addAttribute('merchantSdk', CURRENT_SDK_VERSION);
		
		$xml->addAttribute('authAmount', $counts_and_amounts['auth']['amount']);
		$xml->addAttribute('numAuths', $counts_and_amounts['auth']['count']);
		
		$xml->addAttribute('saleAmount', $counts_and_amounts['sale']['amount']);
		$xml->addAttribute('numSales', $counts_and_amounts['sale']['count']);
		
		$xml->addAttribute('creditAmount', $counts_and_amounts['credit']['amount']);
		$xml->addAttribute('numCredits', $counts_and_amounts['credit']['count']);
		
		$xml->addAttribute('numTokenRegistrations', $counts_and_amounts['tokenRegistration']['count']);
		
		$xml->addAttribute('captureGivenAuthAmount', $counts_and_amounts['captureGivenAuth']['amount']);
		$xml->addAttribute('numCaptureGivenAuths', $counts_and_amounts['captureGivenAuth']['count']);
	
		$xml->addAttribute('forceCaptureAmount', $counts_and_amounts['forceCapture']['amount']);
		$xml->addAttribute('numForceCaptures', $counts_and_amounts['forceCapture']['count']);
		
		$xml->addAttribute('authReversalAmount', $counts_and_amounts['authReversal']['amount']);
		$xml->addAttribute('numAuthReversals', $counts_and_amounts['authReversal']['count']);
		
		$xml->addAttribute('captureAmount', $counts_and_amounts['capture']['amount']);
		$xml->addAttribute('numCaptures', $counts_and_amounts['capture']['count']);
		
		$xml->addAttribute('echeckVerificationAmount', $counts_and_amounts['echeckVerification']['amount']);
		$xml->addAttribute('numEcheckVerification', $counts_and_amounts['echeckVerification']['count']);
		
		$xml->addAttribute('echeckCreditAmount', $counts_and_amounts['echeckCredit']['amount']);
		$xml->addAttribute('numEcheckCredit', $counts_and_amounts['echeckCredit']['count']);
		
		$xml->addAttribute('numEcheckRedeposit', $counts_and_amounts['echeckRedeposit']['count']);
		
		$xml->addAttribute('echeckSalesAmount', $counts_and_amounts['echeckSale']['amount']);
		$xml->addAttribute('numEcheckSales', $counts_and_amounts['echeckSale']['count']);
		
		$xml->addAttribute('numUpdateCardValidationNumOnTokens', $counts_and_amounts['updateCardValidationNumOnToken']['count']);
		
		$xml->addAttribute('numUpdateSubscriptions', $counts_and_amounts['updateSubscription']['count']);
		
		$xml->addAttribute('numCancelSubscriptions', $counts_and_amounts['cancelSubscription']['count']);
		
		$xml->addAttribute('numCreatePlans', $counts_and_amounts['createPlan']['count']);
		$xml->addAttribute('numUpdatePlans', $counts_and_amounts['updatePlan']['count']);
		
        $xml->addAttribute('numActivates', $counts_and_amounts['activate']['count']);
		$xml->addAttribute('activateAmount', $counts_and_amounts['activate']['amount']);
        $xml->addAttribute('numDeactivates', $counts_and_amounts['deactivate']['count']);
        $xml->addAttribute('numLoads', $counts_and_amounts['load']['count']);
		$xml->addAttribute('loadAmount', $counts_and_amounts['load']['amount']);
        $xml->addAttribute('numUnloads', $counts_and_amounts['unload']['count']);
		$xml->addAttribute('unloadAmount', $counts_and_amounts['unload']['amount']);
        $xml->addAttribute('numBalanceInquirys', $counts_and_amounts['balanceInquiry']['count']);
		
		$xml->addAttribute('numAccountUpdates', $counts_and_amounts['accountUpdate']['count']);
		
		return str_replace("/>", ">", str_replace("<?xml version=\"1.0\"?>\n", "", $xml->asXML()));
	}

	public static function generateRequestHeader($config, $num_batch_requests){
		$xml = simplexml_load_string("<litleRequest />");
		
		$xml->addAttribute('numBatchRequests', $num_batch_requests);
		$xml->addAttribute('version', CURRENT_XML_VERSION);
		$xml->addAttribute('xmlns:xmlns','http://www.litle.com/schema');
		$authentication = $xml->addChild('authentication');
		$authentication->addChild('user',$config["user"]);
		$authentication->addChild('password',$config["password"]);
		
		return str_replace("<?xml version=\"1.0\"?>\n", "", str_replace("</litleRequest>", "", $xml->asXML()));
	}

	private static function iterateChildren($data,$transacType){
		foreach($data as $key => $value)
		{
			if ($value === "REQUIRED"){
				throw new InvalidArgumentException("Missing Required Field: /$key/");
			}elseif (substr($key, 0, 12) === 'lineItemData'){
				$temp_node = $transacType->addChild('lineItemData');
				Obj2xml::iterateChildren($value,$temp_node);
			}elseif (substr($key,0,-1) == 'detailTax'){
				$temp_node = $transacType->addChild('detailTax');
				Obj2xml::iterateChildren($value,$temp_node);
			}elseif (((is_string($value)) || is_numeric($value))) {
				$transacType->addChild($key,str_replace('&','&amp;',$value));
			}elseif(is_array($value))
			{
				$node = $transacType->addChild($key);
				Obj2xml::iterateChildren($value,$node);
			}
		}
	}

	public static function getConfig($data)
	{
		@$config_array =parse_ini_file('litle_SDK_config.ini'); //TODO Use an empty config_array if the file doesn't exist
		$names = array('user','password','merchantId','timeout','proxy','reportGroup','version','url', 
		'litle_requests_path', 'batch_requests_path', 'sftp_username', 'sftp_password', 'batch_url', 'tcp_port', 'tcp_ssl', 'tcp_timeout', 'print_xml');
		foreach($names as $name)
		{
			if (isset($data[$name]))
			{
				$config[$name] = $data[$name];

			}else{
				if ($name == 'merchantId'){
					$config['merchantId'] = $config_array['currency_merchant_map']['DEFAULT'];
				}else if ($name == 'version'){
					$config['version'] = isset($config_array['version'])? $config_array['version']:CURRENT_XML_VERSION;
				}else if ($name == 'timeout'){
						$config['timeout'] = isset($config_array['timeout'])? $config_array['timeout']:'65';
				}else {
					if ((!isset($config_array[$name])) and ($name != 'proxy')){
						throw new InvalidArgumentException("Missing Field /$name/");
					}
					$config[$name] = $config_array[$name];
				}
			}
		}
		return $config;
	}
}

?>
