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
require_once realpath(dirname(__FILE__)) . '/LitleOnline.php';

function writeConfig($line,$handle){
	foreach ($line as $keys => $values){
		fwrite($handle, $keys. '');
		if (is_array($values)){
			foreach ($values as $key2 => $value2){
				fwrite($handle,"['" . $key2 . "'] =" . $value2 .  PHP_EOL);
			}
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
		print "Please choose Litle url from the following list (example: 'sandbox') or directly input another URL: \nsandbox => https://www.testlitle.com/sandbox/communicator/online \npostlive => https://postlive.litle.com/vap/communicator/online \ntransact-postlive => https://transact-postlive.litle.com/vap/communicator/online \nproduction => https://payments.litle.com/vap/communicator/online \nproduction-transact => https://transact.litle.com/vap/communicator/online \nprelive => https://prelive.litle.com/vap/communicator/online \ntransact-prelive => https://transact-prelive.litle.com/vap/communicator/online" . PHP_EOL;
		$url = UrlMapper::getUrl(trim(fgets(STDIN)));
		$line['url'] = $url;
		print "Please input the proxy, if no proxy hit enter key: ";
		$line['proxy'] = trim(fgets(STDIN));
	
		print "Batch processing saves files to disk. \n";
		print "Please input a directory to save these files. If you are not using batch processing, you may hit enter. ";
		$dir = trim(fgets(STDIN));
		$line['batch_requests_path'] = $dir;
		$line['litle_requests_path'] = $dir;
		
		print "Please input your SFTP username. If you are not using SFTP, you may hit enter. ";
		$line['sftp_username'] = trim(fgets(STDIN));
		print "Please input your SFTP password. If you are not using SFTP, you may hit enter. ";
		$line['sftp_password'] = trim(fgets(STDIN));
		print "Please input the URL for batch processing. If you are not using batch processing, you may hit enter. ";
		$line['batch_url'] = trim(fgets(STDIN));
		print "Please input the port for stream batch delivery. If you are not using stream batch delivery, you may hit enter. ";
		$line['tcp_port'] = trim(fgets(STDIN));
		print "Please input the timeout (in seconds) for stream batch delivery. If you are not using stream batch delivery, you may hit enter. ";
		$line['tcp_timeout'] = trim(fgets(STDIN));
		# ssl should be usd by default
		$line['tcp_ssl'] = '1';
		$line['print_xml'] = '0';
		
		writeConfig($line,$handle);
		fwrite($handle, "timeout =  65".  PHP_EOL);
		fwrite($handle, "reportGroup = Default Report Group".  PHP_EOL);
	}
	fclose($handle);
	print "The Litle configuration file has been generated, the file is located in the lib directory". PHP_EOL;
}

initialize();

