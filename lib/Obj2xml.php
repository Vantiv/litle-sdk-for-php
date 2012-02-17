<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

	// this class contains the method to create an xml document from an object
	
class Obj2xml {

	  var $xmlResult;  
	  // construct function creates the basic XML doc with attributes added
  	  function __construct($rootNode,$config){
 	       $this->xmlResult = new SimpleXMLElement("<$rootNode></$rootNode>");
 	       
 	       # take in array of attributes and clycle through them or pull values from config file/
	       $this->xmlResult-> addAttribute('version',$config["version"]);
	       $this->xmlResult-> addAttribute('merchantId',$config["merchantId"]);
  	       $this->xmlResult-> addAttribute('xmlns:xmlns','http://www.litle.com/schema');// does not show up on browser docs
 	   }
	 //iterates through child classes and adds into xml document
 	  private function iteratechildren($object,$xml){
 	       foreach ($object as $name=>$value) {
  	          if (is_string($value) || is_numeric($value)) {
  	              $xml->$name=$value;       
   	         }else {
     	           $xml->$name=null;
     	          $this->iteratechildren($value,$xml->$name);
      	      }
      	  }
   	 }
 	//changes the object to xml doc, calls previous two functions 
  	 function toXml($object,$type,$config) { 
  	      $this->iteratechildren($object,$this->xmlResult);   
  	      $this->xmlResult->$type-> addAttribute('reportGroup',$config["reportGroup"]);
	      $this->xmlResult->$type-> addAttribute('id',$config["id"]);
   	      return $this->xmlResult->asXML();
  	 }
}

?>
