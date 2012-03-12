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
function writeConfig($line,$handle){
	foreach ($line as $keys => $values){
		fwrite($handle, $keys. '');
		if (is_array($values)){
			foreach ($values as $key2 => $value2){
				fwrite($handle,"['" . $key2 . "'] =" . $value2 .  PHP_EOL);
			}
			//writeConfig($values,$handle);
		}
		else{
			fwrite($handle,' =' . $values);
			fwrite($handle, PHP_EOL);
		}
	}
}
function initialize(){

	$line = array();
	$merchantArray = array();
	$handle = @fopen('./litle_SDK_config.ini', "w");
	if ($handle) {
		print "Welcome to Litle PHP_SDK" . PHP_EOL;
		print "Please input your user name: ";
		$line['user'] = trim(fgets(STDIN));
		print "Please input your password: ";
		$line['password'] = trim(fgets(STDIN));
		print "Please input your merchantId: ";
		$line['currency_merchant_map ']['DEFAULT'] = trim(fgets(STDIN));
		print "Please choose Litle url from the following list (example: 'cert') or directly input another URL: \nsandbox => https://www.testlitle.com/sandbox/communicator/online \ncert => https://cert.litle.com/vap/communicator/online \nprecert => https://precert.litle.com/vap/communicator/online \nproduction1 => https://payments.litle.com/vap/communicator/online \nproduction2 => https://payments2.litle.com/vap/communicator/online" . PHP_EOL;
		$url = urlMapper(trim(fgets(STDIN)));
		$line['url'] = $url;
		print "Please input the proxy, if no proxy hit enter key: ";
		$line['proxy'] = trim(fgets(STDIN));
		writeConfig($line,$handle);
		fwrite($handle, "version = 8.10" .  PHP_EOL);
		fwrite($handle, "timeout =  65".  PHP_EOL);
		fwrite($handle, "reportGroup = planets".  PHP_EOL);
	}
	fclose($handle);
	print "The Litle configuration file has been generated, the file is located in the lib directory". PHP_EOL;
}



function urlMapper($litleEnv){
	$litleOnlineCtx = 'vap/communicator/online';
	if ($litleEnv == "sandbox")
	return 'https://www.testlitle.com/sandbox/communicator/online';
	elseif ($litle_env == "cert")
	return 'https://cert.litle.com/' . $litleOnlineCtx;
	elseif ($litleEnv == "precert")
	return 'https://precert.litle.com/' . $litleOnlineCtx;
	elseif ($litleEnv == "production1")
	return 'https://payments.litle.com/' . $litleOnlineCtx;
	elseif ($litleEnv == "production2")
	return 'https://payments2.litle.com/' . $litleOnlineCtx;
	else
	return 'https://www.testlitle.com/sandbox/communicator/online';
}

initialize();

