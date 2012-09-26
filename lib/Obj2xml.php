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
		$xml-> addAttribute('version',$config["version"]);
		$xml-> addAttribute('merchantSdk',$data['merchantSdk']);
		unset($data['merchantSdk']);
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
		if(isset($config['reportGroup'])) {
			($transacType-> addAttribute('reportGroup',$config["reportGroup"]));
		};
		if(isset($data['id'])) {
			($transacType-> addAttribute('id',$data["id"]));
		};
		unset($data['id']);
		Obj2xml::iterateChildren($data,$transacType);
		return $xml->asXML();
	}

	private function iterateChildren($data,$transacType){
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

	public function getConfig($data)
	{

		@$config_array =parse_ini_file('litle_SDK_config.ini');
		$names = array('user','password','merchantId','timeout','proxy','reportGroup','version','url');
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
