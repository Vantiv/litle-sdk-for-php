<link rel="stylesheet" type="text/css" media="screen" href="stylesheet.php">
<html>
<header>
</header>
<body>
<table>
<tr>
<td colspan="2"><div align="center">
<h4>Thank you for using Litle Payment!!!<h4></div>
<?php
	require_once realpath(dirname(__FILE__)) . '/../lib/communication.php';
	require_once realpath(dirname(__FILE__)) . '/../lib/createObj.php';
	require_once realpath(dirname(__FILE__)) . '/../lib/Obj2xml.php';
	require_once realpath(dirname(__FILE__)) . '/../lib/tagValue.php';

	$config = array('usr'=>'IMPTEST',
			'password'=>'cert3d6Z',
			'merchantId'=>$_POST[merchantId],
			'version'=>'8.8',
			'reportGroup'=>$_POST[reportGroup],
			'id'=>$_POST[id],
			'orderId'=>$_POST[orderId],
			'amount'=>$_POST[amount],
			'litleTxnId'=>$_POST[litleTxnId],
			'orderSource'=>$_POST[orderSource],
			'name'=>$_POST[name],
			'addressLine1'=>$_POST[addressLine1],
			'city'=>$_POST[city],
			'state'=>$_POST[state],	
			'zip'=>$_POST[zip],
			'country'=>$_POST[country],
			'number'=>$_POST[number],
			'type'=>$_POST[type],
			'expDate'=>$_POST[expmonth].substr($_POST[expyear],-2),
			'cardValidationNum'=>$_POST[cardValidationNum]);
	if ($_POST[method] == "authorization")
	{
	    $ob=createObj::createAuth($config);
	}
	elseif ($_POST[method] == "authReversal")
	{
	    $ob=createObj::createAuthReversal($config);
	}
	elseif ($_POST[method] == "credit")
	{
	    $ob=createObj::createCredit($config);
	}
	elseif ($_POST[method] == "capture")
	{
	    $ob=createObj::createCapture($config);
	}
	elseif ($_POST[method] == "sale")
	{
	    $ob=createObj::createSale($config);
	}
	elseif ($_POST[method] == "void")
	{
	    $ob=createObj::createVoid($config);
	}
	$type = $_POST[method];
	$converter=new Obj2xml("litleOnlineRequest",$config);
	$req = $converter->toXml($ob,$type,$config);
	if (!$req){
		echo "error with Litle Online Request";
	}
	
	$response = communication::httpRequest($req);

	if (!$response){
		echo "error with Litle Online Response ";
	}

	$txnID= tagValue::getXmlValueByTag($response,'litleTxnId');   
	$txnOrderID = tagValue::getXmlValueByTag($response,'orderId');
	$txnTime = tagValue::getXmlValueByTag($response,'responseTime');
	$txnMessage = tagValue::getXmlValueByTag($response,'message');
	
	echo "LitleTransaction: ".$type."<br>";
	echo "Litle Order ID: ".$txnOrderID."<br>";
	echo "Litle Transaction ID: ".$txnID."<br>";
	echo "Litle Transaction Time: ".$txnTime."<br>";
	echo "Litle Response Message: ".$txnMessage."<br>"."<br>";
?>
</td>
</tr>
</table>
</body>
</html>
