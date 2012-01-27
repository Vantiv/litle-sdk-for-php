<?php
	// class and methods to parse a XML document into an object 
class tagValue{

	function getXmlValueByTag($xml,$tag){
        	$parser    =    xml_parser_create();//Create an XML parser
        	xml_parse_into_struct($parser, $xml, $outArray);// Parse XML data into an array structure
        	xml_parser_free($parser);//Free an XML parser
       
        	for($i=0;$i<count($outArray);$i++){
            	if($outArray[$i]['tag']==strtoupper($tag)){
                	$tagValue    =    $outArray[$i]['value'];
            	}
        	}
        	return $tagValue;
    	}
}
?>
