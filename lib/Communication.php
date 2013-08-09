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
class Communication{
	static function httpRequest($req,$hash_config=NULL){
		
		$config = Obj2xml::getConfig($hash_config);
		
		if((int)$config['print_xml']){
			echo $req;
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_PROXY, $config['proxy']);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: text/xml'));
		curl_setopt($ch, CURLOPT_URL, $config['url']);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
		curl_setopt($ch,CURLOPT_TIMEOUT, $config['timeout']);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSLVERSION, 3);
		$output = curl_exec($ch);
		$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if (! $output){
			throw new Exception (curl_error($ch));
		}
		else
		{
			curl_close($ch);
			if((int)$config['print_xml']){
				echo $output;
			}
			return $output;
		}

	}
}
