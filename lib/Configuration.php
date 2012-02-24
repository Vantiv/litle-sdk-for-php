<?php 
#echo 'My home is' .$_ENV["HOME"] . '!';
#public function getConfig()
#{
	$config_array =parse_ini_file('./litle_SDK_config.ini');
	echo $config_array['user'];
#}
?>