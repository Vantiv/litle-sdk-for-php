<?php
/*class Configuration{
	function config(){
		$createFile = "config.txt";
		$fileHandle = fopen($createFile,'w') or die("can't open file");
		fclose($fileHandle);
	}
}*/
/*
$config = 'config.txt';
$handle = fopen($config, 'w') or die('cannot open file: '.$config);
//$data = implode(array('usr'=>'PHXMLTEST'));
$data = "'usr'=>'PHXMLTEST'";//,'password'=>'certpass');
fwrite($handle, $data);
//$rhandle = fopen($config, 'r');
//$rdate = fread($rhandle, filesize($config));
//echo $rdate;
fclose($rhandle);
*/

$assoc_array = array("user" => "PHXMLTEST", "password" => "certpass","version" => "8.8", "url" => "");

$new_array = array_map(create_function('$key, $value', 'return $key.":".$value." <br> ";'), array_keys($assoc_array), array_values($assoc_array));

print implode($new_array);


?>
