<html>
<header>
</header>
<body>
<?php
	require_once realpath(dirname(__FILE__)) . '/configuration.php';

//$config = realpath(dirname(__FILE__)).'/config.txt';
//$data = implode($new_array);
//create config file

$config_array = array("user" => $_POST["user"], "password" => $_POST["password"],"version" => $_POST["version"], "url" => $_POST["url"],"proxy_address" => $_POST["proxy_address"],"proxy_port" => $_POST["proxy_port"]);

$new_array = array_map(create_function('$key, $value', 'return $key."=>".$value." <br> ";'), array_keys($config_array), array_values($config_array));

print implode($new_array);

Configuration::create_config(realpath(dirname(__FILE__)).'/config.txt', implode($new_array));

echo realpath(dirname(__FILE__)).'/config.txt';

?>
</body>
</html>
