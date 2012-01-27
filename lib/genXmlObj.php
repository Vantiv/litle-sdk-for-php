<?php
	//this file defines all of the fields for differernt types of trasactions
    	//the fields are stored as strings and grouped by parent/child field classes
    	// the group of strings is then stored into an array which will later be used to define the xml
  	$authenticationField =array('authentication','user','password');
	$authorizationField =array( 'authorization','orderId','amount','orderSource');
	$authReversalField = array('authReversal','litleTxnId','amount');
	$captureField = array('capture','litleTxnId','amount');
	$forceCaptureField = array('forceCapture','orderId','amount','orderSource');
	$captureGivenAuthField = array('captureGivenAuth','orderId','amount','orderSource');
	$saleField = array('sale','orderId','amount','orderSource');
    	$creditField = array('credit','litleTxnId','amount'); 
	$voidField = array('void','litleTxnId');
	//token
	$registerTokenRequestField = array('registerTokenRequest','orderId','accountNumber');
	//echeck
	$echeckSaleField =  array('echeckSale','orderId','amount','orderSource');
	$echeckCreditField = array('echeckCredit','orderId','amount','orderSource');
	$echeckVerificationField = array('echeckVerification','orderId','amount','orderSource');
	$echeckRedepositField = array('echeckRedeposit','litleTxnId');
	//support data
	$contactField = array('name','firstName','middleInitial','lastName','companyName','addressLine1','addressLine2','addressLine3','city', 'state', 'zip','country','email','phone');
	$customerInfoField = array('customerInfoField','ssn','dob','customerRegistrationDate','customerType','incomeAmount','incomeCurrency','customerCheckingAccount','customerSavingAccount','customerWorkTelephone','residenceStatus','yearsAtResidence','yearsAtEmployer');
	$billMeLaterRequestField = array('billMeLaterRequest','bmlMerchantId');
	$fraudCheckTypeField = array('fraudCheckType','authenticationValue','authenticationTransactionId','customerIpAddress','authenticatedByMerchant');
	$authInformationField = array('authInformation','authDate','authCode','fraudResult','authAmount');
	$fraudResultField = array('fraudResult','avsResult','cardValidationResult','authenticationResult','advancedAVSResult');
	$posField = array('pos','capability','entryMode','cardholderId');
	$enhancedDataField = array('enhancedData','customerReference','salesTax','deliveryType','taxExempt','discountAmount','shippingAmount','dutyAmount','shipFromPostalCode','destinationPostalCode','destinationCountryCode','invoiceReferenceNumber','orderDate','detailTax','lineItemData');
	$detailTaxField = array('detailTax','taxIncludedInTotal','taxAmount','taxRate','taxTypeIdentifier','cardAcceptorTaxId');
	$lineItemDataField = array('lineItemData','itemSequenceNumber','itemDescription','productCode','quantity','unitOfMeasure','taxAmount','lineItemTotal','lineItemTotalWithTax','itemDiscountAmount','commodityCode','unitCost','detailTax');
	$amexAggregatorDataField = array('amexAggregator','sellerId','sellerMerchantCategoryCode');
	$billToAddressField = array('billToAddress', 'name', 'firstName','middleInitial','lastName','companyName','addressLine1','addressLine2','addressLine3','city', 'state', 'zip','country','email','phone');
	$shipToAddressField = array('shipToAddress', 'name', 'addressLine1','addressLine2','addressLine3','city', 'state', 'zip','country','email','phone');
    	$cardField = array('card','type','number','expDate','cardValidationNum');
	$cardTokenField = array('cardTokenType','litleToken','expDate','cardValidationNum');
	$cardPaypageTypeField = array('cardPaypageType','paypageRegistrationId','expDate','cardValidationNum','type');
	$payPalField = array('payPal','payerId','token','transactionId');
	$creditpayPalField = array('credit_payPal','payerId','payerEmail');
	$customBillingField = array('customBilling','phone','city','url');
	$taxBillingField = array('taxBilling','taxAuthority','state','govtTxnType');
	$processingInstructionsField = array('processingInstructions','bypassVelocityCheck');
	$echeckForTokenTypeField = array('echeckForTokenType','accNum','routingnNum');
	$filteringTypeField = array('filteringType','prepaid','international','chargeback');
	$echeckField = array('echeck','accType','accNum','routingNum','checkNum');
	$echeckTokenField = array('echeckTokne','litleToken','routingNum','accType','checkNum');
	$recyclingRequestTypeField = array('recyclingRequestType','recyleBy');
?>
