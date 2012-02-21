<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', '1');

// this class contains the method to create an xml document from an object

class Obj2xml {

	public static function toXml($data, $type, $config, $rootNodeName = 'litleOnlineRequest', $xml=null)
	{
		$xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
		$xml-> addAttribute('version',$config["version"]);
		$xml-> addAttribute('merchantId',$config["merchantId"]);
		$xml-> addAttribute('xmlns:xmlns','http://www.litle.com/schema');// does not show up on browser docs
		$authentication = $xml->addChild('authentication');
		$authentication->addChild('user',$config["user"]);
		$authentication->addChild('password',$config["password"]);
		$transacType = $xml->addChild($type);
		$transacType-> addAttribute('reportGroup',$config["reportGroup"]);
		$transacType-> addAttribute('id',$config["id"]);
		Obj2xml::iterateChildren($data,$transacType);
		return $xml->asXML();
	}
	// loop through the data passed in.
	private function iterateChildren($data,$transacType){
		foreach($data as $key => $value)
		{
			if ($value == "REQUIRED"){
				throw new Exception("Missing Required Field: /$key/");
			}
			elseif ((is_string($value)) || is_numeric($value)) {
				$transacType->addChild($key,$value);
			}
			elseif(is_array($value))
			{
				$node = $transacType->addChild($key);
				Obj2xml::iterateChildren($value,$node);

			}
		}
	}
}

?>
