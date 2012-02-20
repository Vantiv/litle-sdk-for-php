<?php
error_reporting(E_ALL ^ E_NOTICE);
#ini_set('display_errors', '1');

// this class contains the method to create an xml document from an object

class Obj2xml {

	// 	var $xmlResult;
	// 	// construct function creates the basic XML doc with attributes added
	// 	function __construct($rootNode,$config){
	// 		$xml = new SimpleXMLElement("<$rootNode></$rootNode>");

	// 		# take in array of attributes and clycle through them or pull values from config file/
	// 		$xml-> addAttribute('version',$config["version"]);
	// 		$xml->addAttribute('merchantId',$config["merchantId"]);
	// 		$xml-> addAttribute('xmlns:xmlns','http://www.litle.com/schema');// does not show up on browser docs
	// 	}
	// 	//iterates through child classes and adds into xml document
	// 	private function iteratechildren($array,$xml){
	// 		foreach ($array as $name=>$value) {
	// 			if (is_string($value) || is_numeric($value)) {
	// 				$xml->$name=$value;
	// 			}else {
	// 				$xml->$name=null;
	// 				Obj2xml::iteratechildren($value,$xml);
	// 			}
	// 		}
	// 	}
	// 	//changes the object to xml doc, calls previous two functions
	// 	function toXml($array,$type,$config) {
	// 		Obj2xml::iteratechildren($array,$xml);
	// 		#$xml->$type-> addAttribute('reportGroup',$config["reportGroup"]);
	// 		#$xml->$type-> addAttribute('id',$config["id"]);
	// 		return $this->xmlResult->asXML();
	// 	}
	// }

	// 	/**
	// 	 * The main function for converting to an XML document.
	// 	 * Pass in a multi dimensional array and this recrusively loops through and builds up an XML document.
	// 	 *
	// 	 * @param array $data
	// 	 * @param string $rootNodeName - what you want the root node to be - defaultsto data.
	// 	 * @param SimpleXMLElement $xml - should only be used recursively
	// 	 * @return string XML
	// 	 */
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
		if ((is_string($value) && $value != 'REQUIRED') || is_numeric($value)) {
			$transacType->addChild($key,$value);
		}
		elseif(is_array($value))
		{
			#$transacType->$name=$key;
			#if (is_array($value))
			#{
			#echo $key;
			#var_dump($value);
		#echo '            ';
		$node = $transacType->addChild($key);

		Obj2xml::iterateChildren($value,$node);

		#}
		}
	}
}
}

?>
