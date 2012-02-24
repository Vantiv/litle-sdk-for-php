<?php
class Configuration{
    function create_config($config, $data){
	$handle = fopen($config, 'w+');
	fwrite($handle, $data);
	fclose($handle);
    }

    function get_config($config){
	$handle = fopen($config, 'r');
	$data = fread($handle, filesize($config));
	fclose($handle);
	return $data;
    }
    function doubleExplode ($del1, $del2, $array){
    	$array1 = explode("$del1", $array);
	foreach($array1 as $key=>$value){
		$array2 = explode("$del2", $value);
		foreach($array2 as $key2=>$value2){
			$array3[] = $value2; 
			}
	}
    	$afinal = array();
	for ( $i = 0; $i <= count($array3); $i += 2) {
   		if($array3[$i]!=""){
   		$afinal[trim($array3[$i])] = trim($array3[$i+1]);
    		}
	}
	return $afinal;
}
}
?>
