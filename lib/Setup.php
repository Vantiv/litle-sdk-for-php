<?php

function initialize(){

	$line = array();
	$handle = @fopen('./litle_SDK_config.ini', "w");
	if ($handle) {
		print "Welcome to Litle PHP_SDK" . PHP_EOL;
		print "Please input your user name: ";
		$line['user'] = trim(fgets(STDIN));
		print "Please input your password: ";
		$line['password'] = trim(fgets(STDIN));
		print "Please input your merchantId: ";
		$line['merchantId'] = trim(fgets(STDIN));
		print "Please choose Litle url from the following list (example: 'cert') or directly input another URL: \nsandbox => https://www.testlitle.com/sandbox/communicator/online \ncert => https://cert.litle.com/vap/communicator/online \nprecert => https://precert.litle.com/vap/communicator/online \nproduction1 => https://payments.litle.com/vap/communicator/online \nproduction2 => https://payments2.litle.com/vap/communicator/online" . PHP_EOL;
		$url = url_mapper(trim(fgets(STDIN)));
		$line['url'] = $url;
		print "Please input the proxy, if no proxy hit enter key: ";
		$line['proxy'] = trim(fgets(STDIN));

		foreach ($line as $keys => $values){
			fwrite($handle, $keys .' = '. $values);
			fwrite($handle, PHP_EOL);
		}
		fwrite($handle, "version = '8.10'" .  PHP_EOL);
		fwrite($handle, "printxml =  false".  PHP_EOL);
		fwrite($handle, "timeout =  65".  PHP_EOL);
		fwrite($handle, "id =  10".  PHP_EOL);
		fwrite($handle, "reportGroup = planets".  PHP_EOL);
		fwrite($handle, "sslverify = false".  PHP_EOL);
		
	}
	fclose($handle);
	print "The Litle configuration file has been generated, the file is located in the lib directory". PHP_EOL;

}

function url_mapper($litle_env){
	$litle_online_ctx = 'vap/communicator/online';
	if ($litle_env == "sandbox")
		return 'https://www.testlitle.com/sandbox/communicator/online';
	elseif ($litle_env == "cert")
		return 'https://cert.litle.com/' . $litle_online_ctx;
	elseif ($litle_env == "precert")
		return 'https://precert.litle.com/' . $litle_online_ctx;
	elseif ($litle_env == "production1")
		return 'https://payments.litle.com/' . $litle_online_ctx;
	elseif ($litle_env == "production2")
		return 'https://payments2.litle.com/' . $litle_online_ctx;
	else
		return 'https://www.testlitle.com/sandbox/communicator/online';
}

initialize();

?>
