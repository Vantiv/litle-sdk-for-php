<?php

	// Create Specific XML object using the general XML object class 
	// set values here for fields
class createObj{
		
	function createAuth($config){
	
	include 'genXmlObj.php';
	$ob = array_filter($array_with_nulls);# no null values in the array
		$ob->$authenticationField[0]->$authenticationField[0]=@$config["litleTxnId"];
    $ob->$authenticationField[0]->$authenticationField[1]=@$config["usr"];
    $ob->$authenticationField[0]->$authenticationField[2]=@$config["password"];
	$ob->$authorizationField[0]->$authorizationField[1]=@$config["orderId"];
	$ob->$authorizationField[0]->$authorizationField[2]=@$config["amount"]; 
		$ob->$authorizationField[0]->$authorizationField[3]=@$config["orderSource"];
		
	#DO FIELD LIKE BILL TO ADDRESS HERE NOT EMBEDDED VALUES LIKE NAME & ADDRESS 	
		$ob->$authorizationField[0]->$billToAddressField[0]->$billToAddressField[1]=@$config["name"];
		$ob->$authorizationField[0]->$billToAddressField[0]->$billToAddressField[6]=@$config["addressLine1"];
		$ob->$authorizationField[0]->$billToAddressField[0]->$billToAddressField[7]= (isset($config["addressLine2"]) ?$config["addressLine2"]:NULL);
		$ob->$authorizationField[0]->$billToAddressField[0]->$billToAddressField[9]=@$config["city"];
			$ob->$authorizationField[0]->$billToAddressField[0]->$billToAddressField[10]=@$config["state"];
		$ob->$authorizationField[0]->$billToAddressField[0]->$billToAddressField[11]=@$config["zip"];
  	  	$ob->$authorizationField[0]->$billToAddressField[0]->$billToAddressField[12]=@$config["country"];
		#$ob->$authorizationField[0]->$billToAddressField[0]->$billToAddressField[13]=@$config["email"];
		#$ob->$authorizationField[0]->$billToAddressField[0]->$billToAddressField[14]=@$config["phone"];	
		
		#$ob->$authorizationField[0]->$cardField[0]->$cardField[1]=@$config["type"];
		#$ob->$authorizationField[0]->$cardField[0]->$cardField[2]=@$config["number"];
		#$ob->$authorizationField[0]->$cardField[0]->$cardField[3]=@$config["expDate"];
		#$ob->$authorizationField[0]->$cardField[0]->$cardField[4]=@$config["cardValidationNum"];
	
	return $ob;
	}
	
	Class Checker
	{
		function purgeNull($outArray)
		{
			for($i=0;$i<count($outArray);$i++){
       		     	if($outArray[$i]== '' || nil ){
        	        			$outArray[$i].
        	    	}
        	}
		}
		function requiredMissing($outArray)
		{
			for($i=0;$i<count($outArray);$i++){
            	if($outArray[$i]== 'REQUIRED'){
                	throw new Exception("Error, missing required field $outArray[$i]");
            	}
        	}
		}
		function choice($outArray)
		{
			if ($outArray.length > 1){
				throw new Exception("Error,only one choice is valid for the following field");
			#check if more than one choice is set and raise flag 
			$output = array_filter($outArray,"REQUIRED")
			}
		}
		
	}
	
	

	
	function createAuthReversal($config){
	
	include 'genXmlObj.php';
    	$ob->$authenticationField[0]->$authenticationField[1]=@$config["usr"];
    	$ob->$authenticationField[0]->$authenticationField[2]=@$config["password"];
	$ob->$authReversalField[0]->$authReversalField[1]=@$config["litleTxnId"];
	$ob->$authReversalField[0]->$authReversalField[2]=@$config["amount"];
	return $ob;
	}

	function createCapture($config){
	
	include 'genXmlObj.php';
    	$ob->$authenticationField[0]->$authenticationField[1]=@$config["usr"];
    	$ob->$authenticationField[0]->$authenticationField[2]=@$config["password"];
	$ob->$captureField[0]->$captureField[1]=@$config["litleTxnId"];
	$ob->$captureField[0]->$captureField[2]=@$config["amount"];
	return $ob;
	}

	function createSale($config){
	
	include 'genXmlObj.php';
    	$ob->$authenticationField[0]->$authenticationField[1]=@$config["usr"];
    	$ob->$authenticationField[0]->$authenticationField[2]=@$config["password"];
	$ob->$saleField[0]->$saleField[1]=@$config["orderId"];
	$ob->$saleField[0]->$saleField[2]=@$config["amount"];
	$ob->$saleField[0]->$saleField[3]=@$config["orderSource"];
	$ob->$saleField[0]->$billToAddressField[0]->$billToAddressField[1]=@$config["name"];
	$ob->$saleField[0]->$billToAddressField[0]->$billToAddressField[6]=@$config["addressLine1"];
	$ob->$saleField[0]->$billToAddressField[0]->$billToAddressField[7]=@$config["addressLine2"];
	$ob->$saleField[0]->$billToAddressField[0]->$billToAddressField[8]=@$config["addressLine3"];
	$ob->$saleField[0]->$billToAddressField[0]->$billToAddressField[9]=@$config["city"];
	$ob->$saleField[0]->$billToAddressField[0]->$billToAddressField[10]=@$config["state"];
	$ob->$saleField[0]->$billToAddressField[0]->$billToAddressField[11]=@$config["zip"];
        $ob->$saleField[0]->$billToAddressField[0]->$billToAddressField[12]=@$config["country"];
	$ob->$saleField[0]->$billToAddressField[0]->$billToAddressField[13]=@$config["email"];
	$ob->$saleField[0]->$billToAddressField[0]->$billToAddressField[14]=@$config["phone"];
	$ob->$saleField[0]->$cardField[0]->$cardField[1]=@$config["type"];
	$ob->$saleField[0]->$cardField[0]->$cardField[2]=@$config["number"];
	$ob->$saleField[0]->$cardField[0]->$cardField[3]=@$config["expDate"];
	$ob->$saleField[0]->$cardField[0]->$cardField[4]=@$config["cardValidationNum"];
        return $ob;
	}

	function createCredit($config){

	include 'genXmlObj.php';
    	$ob->$authenticationField[0]->$authenticationField[1]=@$config["usr"];
    	$ob->$authenticationField[0]->$authenticationField[2]=@$config["password"];
	$ob->$creditField[0]->$creditField[1]=@$config["litleTxnId"];
	$ob->$creditField[0]->$creditField[2]=@$config["amount"];
        return $ob;
 	}

	function createVoid($config){
	
	include 'genXmlObj.php';
    	$ob->$authenticationField[0]->$authenticationField[1]=@$config["usr"];
    	$ob->$authenticationField[0]->$authenticationField[2]=@$config["password"];
	$ob->$voidField[0]->$voidField[1]=@$config["litleTxnId"];
	return $ob;
	}
	
	function echeckSale($config){

	include 'genXmlObj.php';
    	$ob->$authenticationField[0]->$authenticationField[1]=@$config["usr"];
    	$ob->$authenticationField[0]->$authenticationField[2]=@$config["password"];
	$ob->$echeckSaleField[0]->$echeckSaleField[1]=@$config["orderId"];
	$ob->$echeckSaleField[0]->$echeckSaleField[2]=@$config["amount"];
	$ob->$echeckSaleField[0]->$echeckSaleField[3]=@$config["orderSource"];
	$ob->$echeckSaleField[0]->$billToAddressField[0]->$billToAddressField[1]=@$config["name"];
	$ob->$echeckSaleField[0]->$billToAddressField[0]->$billToAddressField[5]=@$config["companyName"];
	$ob->$echeckSaleField[0]->$billToAddressField[0]->$billToAddressField[6]=@$config["addressLine1"];
	$ob->$echeckSaleField[0]->$billToAddressField[0]->$billToAddressField[9]=@$config["city"];
	$ob->$echeckSaleField[0]->$billToAddressField[0]->$billToAddressField[10]=@$config["state"];
	$ob->$echeckSaleField[0]->$billToAddressField[0]->$billToAddressField[11]=@$config["zip"];
        $ob->$echeckSaleField[0]->$billToAddressField[0]->$billToAddressField[12]=@$config["country"];
	$ob->$echeckSaleField[0]->$echeckField[0]->$echeckField[1]=@$config["accType"];
	$ob->$echeckSaleField[0]->$echeckField[0]->$echeckField[2]=@$config["accNum"];
	$ob->$echeckSaleField[0]->$echeckField[0]->$echeckField[3]=@$config["routingNum"];
	return $ob;
	}
	
	function echeckCredit($config){
	
	include 'genXmlObj.php';
    	$ob->$authenticationField[0]->$authenticationField[1]=@$config["usr"];
    	$ob->$authenticationField[0]->$authenticationField[2]=@$config["password"];
	$ob->$echeckCreditField[0]->$echeckSaleField[1]=@$config["orderId"];
	$ob->$echeckCreditField[0]->$echeckSaleField[2]=@$config["amount"];
	$ob->$echeckCreditField[0]->$echeckSaleField[3]=@$config["orderSource"];
	$ob->$echeckCreditField[0]->$billToAddressField[0]->$billToAddressField[1]=@$config["name"];
	$ob->$echeckCreditField[0]->$billToAddressField[0]->$billToAddressField[5]=@$config["companyName"];
	$ob->$echeckCreditField[0]->$billToAddressField[0]->$billToAddressField[6]=@$config["addressLine1"];
	$ob->$echeckCreditField[0]->$billToAddressField[0]->$billToAddressField[9]=@$config["city"];
	$ob->$echeckCreditField[0]->$billToAddressField[0]->$billToAddressField[10]=@$config["state"];
	$ob->$echeckCreditField[0]->$billToAddressField[0]->$billToAddressField[11]=@$config["zip"];
        $ob->$echeckCreditField[0]->$billToAddressField[0]->$billToAddressField[12]=@$config["country"];
	$ob->$echeckCreditField[0]->$echeckField[0]->$echeckField[1]=@$config["accType"];
	$ob->$echeckCreditField[0]->$echeckField[0]->$echeckField[2]=@$config["accNum"];
	$ob->$echeckCreditField[0]->$echeckField[0]->$echeckField[3]=@$config["routingNum"];
	return $ob;
	}
	
	function echeckVerification($config){

	include 'genXmlObj.php';
    	$ob->$authenticationField[0]->$authenticationField[1]=@$config["usr"];
    	$ob->$authenticationField[0]->$authenticationField[2]=@$config["password"];
	$ob->$echeckVerificationField[0]->$echeckSaleField[1]=@$config["orderId"];
	$ob->$echeckVerificationField[0]->$echeckSaleField[2]=@$config["amount"];
	$ob->$echeckVerificationField[0]->$echeckSaleField[3]=@$config["orderSource"];
	$ob->$echeckVerificationField[0]->$billToAddressField[0]->$billToAddressField[2]=@$config["firstName"];
	$ob->$echeckVerificationField[0]->$billToAddressField[0]->$billToAddressField[4]=@$config["lastName"];
	$ob->$echeckVerificationField[0]->$billToAddressField[0]->$billToAddressField[5]=@$config["companyName"];
	$ob->$echeckVerificationField[0]->$billToAddressField[0]->$billToAddressField[6]=@$config["addressLine1"];
	$ob->$echeckVerificationField[0]->$billToAddressField[0]->$billToAddressField[9]=@$config["city"];
	$ob->$echeckVerificationField[0]->$billToAddressField[0]->$billToAddressField[10]=@$config["state"];
	$ob->$echeckVerificationField[0]->$billToAddressField[0]->$billToAddressField[11]=@$config["zip"];
        $ob->$echeckVerificationField[0]->$billToAddressField[0]->$billToAddressField[12]=@$config["country"];
	$ob->$echeckVerificationField[0]->$billToAddressField[0]->$billToAddressField[14]=@$config["phone"];
	$ob->$echeckVerificationField[0]->$echeckField[0]->$echeckField[1]=@$config["accType"];
	$ob->$echeckVerificationField[0]->$echeckField[0]->$echeckField[2]=@$config["accNum"];
	$ob->$echeckVerificationField[0]->$echeckField[0]->$echeckField[3]=@$config["routingNum"];
	return $ob;
	}

	function echeckRedeposit($config){
	include 'genXmlObj.php';
    	$ob->$authenticationField[0]->$authenticationField[1]=@$config["usr"];
    	$ob->$authenticationField[0]->$authenticationField[2]=@$config["password"];
	return $ob;
	}

	function createToken($config){

	include 'genXmlObj.php';
    	$ob->$authenticationField[0]->$authenticationField[1]=@$config["usr"];
    	$ob->$authenticationField[0]->$authenticationField[2]=@$config["password"];
	$ob->$registerTokenRequestField[0]->$registerTokenRequestField[1]=@$config["orderId"];
	$ob->$registerTokenRequestField[0]->$registerTokenRequestField[2]=@$config["accountNumber"];		
        return $ob;
 	}
}
?>
