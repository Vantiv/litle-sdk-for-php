<html>
<head>
</head>
<body>
<?php
	// include the the four other files needed to test
	require_once realpath(dirname(__FILE__)) . '/../lib/communication.php';
	require_once realpath(dirname(__FILE__)) . '/../lib/createObj.php';
	require_once realpath(dirname(__FILE__)) . '/../lib/Obj2xml.php';
	require_once realpath(dirname(__FILE__)) . '/../lib/tagValue.php';

	$config = array('usr'=>'IMPTEST',
			'password'=>'cert3d6Z',
			'merchantId'=>'087900',
			'version'=>'8.8',
			'reportGroup'=>'Planets',
			'litleTxnId'=>'1234567890',
			'amount'=>'5000');
	$ob=createObj::createAuthReversal($config);
	$type = 'authReversal';
    	$converter=new Obj2xml("litleOnlineRequest",$config);
    	header("Content-Type:text/xml");
	$req = $converter->toXml($ob,$type,$config);
	if (!$req){
		echo "error with Litle Online Request";
	}
   	//echo $req; //display request
	
	$response = communication::httpRequest($req);
	echo $response;//dispaly litle response XML 
	if (!$response){
		echo "error with Litle Online Response ";
	}

       $txnID= tagValue::getXmlValueByTag($response,'litleTxnId');   //convert Resonse xml to an object and get tag value

 	//echo "Transaction ID: ".$txnID;// display transaction id
?>
</body>
</html>
