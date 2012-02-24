<?php


function initialize(){

	$line = array();
	$handle = @fopen('litle_SDK_config.ini', "w");
	if ($handle) {
		print "Welcome to Litle PHP_SDK" . PHP_EOL;
		print "Please input your user name:";
		$line['user'] = trim(fgets(STDIN));
		print "Please input your password:";
		$line['password'] = trim(fgets(STDIN));
		print "Please input your merchantId:";
		$line['merchantId'] = trim(fgets(STDIN));
		print "Please input your XML version:";
		$line['version'] = trim(fgets(STDIN));
		print "Please input your id:";
		$line['id'] = trim(fgets(STDIN));
		print "Please input your reportGroup:";
		$line['reportGroup'] = trim(fgets(STDIN));
		print "Please choose Litle url from the following list (example: 'cert') or directly input another URL: \nsandbox => https://www.testlitle.com/sandbox/communicator/online \ncert => https://cert.litle.com/vap/communicator/online \nprecert => https://precert.litle.com/vap/communicator/online \nproduction1 => https://payments.litle.com/vap/communicator/online \nproduction2 => https://payments2.litle.com/vap/communicator/online" . PHP_EOL;
		$url = url_mapper(trim(fgets(STDIN)));
		$line['url'] = $url;
		print "Please input the proxy, if no proxy hit enter key: ";
		$line['proxy'] = trim(fgets(STDIN));

		foreach ($line as $keys => $values){
			fwrite($handle, $keys .' = '. $values);
			fwrite($handle, PHP_EOL);
		}
	}
	
	print "The Litle configuration file has been generated, the file is located in the lib diretory"; 
	fclose($handle);

}
initialize();



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



?>

 def Setup.choice(litle_env)
    litle_online_ctx = 'vap/communicator/online'
    if litle_env == "sandbox\n"
      return 'https://www.testlitle.com/sandbox/communicator/online'
    elsif litle_env == "cert\n"
      return 'https://cert.litle.com/' + litle_online_ctx
    elsif litle_env == "precert\n"
      return 'https://precert.litle.com/' + litle_online_ctx
    elsif litle_env == "production1\n"
      return 'https://payments.litle.com/' + litle_online_ctx
    elsif litle_env == "production2\n"
      return 'https://payments2.litle.com/' + litle_online_ctx
    else
      return 'https://www.testlitle.com/sandbox/communicator/online'
    end
  end

<!-- def initialize(filename) @handle = File.new(filename, -->
<!-- File::CREAT|File::TRUNC|File::RDWR, 0600) File.open(filename, "w") do -->
<!-- |f| puts "Welcome to Litle Ruby_SDK" puts "Please input your user name:" -->
<!-- f.puts "user: "+ gets puts "Please input your password:" f.puts -->
<!-- "password: " + gets puts "Please input your merchantId:" f.puts -->
<!-- "currency_merchant_map:" f.puts " DEFAULT: " + gets f.puts -->
<!-- "default_report_group: 'Default Report Group'" f.puts "version: '8.10'" -->
<!-- puts "Please choose Litle url from the following list (example: 'cert') -->
<!-- or directly input another URL: \nsandbox => -->
<!-- https://www.testlitle.com/sandbox/communicator/online \ncert => -->
<!-- https://cert.litle.com/vap/communicator/online \nprecert => -->
<!-- https://precert.litle.com/vap/communicator/online \nproduction1 => -->
<!-- https://payments.litle.com/vap/communicator/online \nproduction2 => -->
<!-- https://payments2.litle.com/vap/communicator/online" f.puts "url: " + -->
<!-- Setup.choice(gets) puts "Please input the proxy address, if no proxy hit -->
<!-- enter key: " f.puts "proxy_addr: " + gets puts "Please input the proxy -->
<!-- port, if no proxy hit enter key: " f.puts "proxy_port: " + gets f.puts -->
<!-- "printxml: false" f.puts "timeout: 65" end -->
