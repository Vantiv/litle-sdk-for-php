<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

class communication{
  function httpRequest($req){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_PROXY, "");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_URL, "https://cert.litle.com/vap/communicator/online");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
	curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
	//curl_setopt($ch, CURLOPT_SSLVERIFYPEER, true);
	//curl_setopt($ch, CURLOPT_SSLVERIFYHOST,1);
	//curl_setopt($ch, CURLOPT_CAINFO,realpath(dirname(__FILE__))."/../cert/cert.litle.pem");//check the pem file
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	$response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	return $output;
  }
}
?>
