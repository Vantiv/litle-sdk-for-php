<?php

require_once realpath(dirname(__FILE__)) . '/../../lib/LitleOnline.php';

class transactions_UnitTest extends PHPUnit_Framework_TestCase {
	
	function test_auth_with_card()
	{
		$hash_in = array(
			'card'=>array('type'=>'VI',
					'number'=>'4100000000000001',
					'expDate'=>'1213',
					'cardValidationNum' => '1213'),
			'orderId'=> '2111',
			'orderSource'=>'ecommerce',
			'amount'=>'123');

		$hash_out = Transactions::createAuthHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
	}
	
	
	function test_auth_muliple_lineItemData()
	{
		$lineItemData = array(
		array('itemSequenceNumber' => '1','itemDescription'=>'desc'),
		array('itemSequenceNumber' => '2','itemDescription'=>'desc2'));

		$hash_in = array(
					'card'=>array('type'=>'VI',
							'number'=>'4100000000000001',
							'expDate'=>'1213',
							'cardValidationNum' => '1213'),
					'orderId'=> '2111',
					'orderSource'=>'ecommerce',
					'enhancedData'=>array('salesTax'=> '123',
					'shippingAmount'=>'123',	
					'lineItemData'=>$lineItemData),
					'amount'=>'123');

		$hash_out = Transactions::createAuthHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
	}
	
	function test_auth_muliple_detailTax()
	{
		$detailTax = array(
		array('taxAmount' => '0', 'cardAcceptorTaxId' => '0'),
		array('taxAmount' => '1', 'cardAcceptorTaxId' => '1'));

		$hash_in = array(
						'card'=>array('type'=>'VI',
								'number'=>'4100000000000001',
								'expDate'=>'1213',
								'cardValidationNum' => '1213'),
						'orderId'=> '2111',
						'orderSource'=>'ecommerce',
						'enhancedData'=>array('salesTax'=> '123',
						'shippingAmount'=>'123',	
						'detailTax'=>$detailTax),
						'amount'=>'123');

		$hash_out = Transactions::createAuthHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
	}

	function test_auth_merchant_data()
	{
		$hash_in = array(
				'orderId'=> '2111',
				'orderSource'=>'ecommerce',
				'amount'=>'123',
				'merchantData'=>array(
					'campaign'=>'foo'
		)
		);
		$hash_out = Transactions::createAuthHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
	}
	
 	function test_auth_fraud_filter_override() {
 		$hash_in = array(
 			'card'=>array(	'type'=>'VI',
 							'number'=>'4100000000000001',
 							'expDate'=>'1213',
 							'cardValidationNum' => '1213'),
 			'orderSource'=>'ecommerce',
 			'amount'=>'123',
 			'fraudFilterOverride'=>'true'
 		);
		$hash_out = Transactions::createAuthHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));		
		
 	}

 	function test_auth_surchargeAmount() {
 		$hash_in = array(
 			'card'=>array(
 				'type'=>'VI',
 				'number'=>'4100000000000001',
 				'expDate'=>'1213'
 			),
 			'amount'=>'2',
 			'surchargeAmount'=>'1',
 			'orderSource'=>'ecommerce',
 		);
		$hash_out = Transactions::createAuthHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));			
 	}

	function test_auth_surchargeAmount_Optional() {
 		$hash_in = array(
 				'card'=>array(
 						'type'=>'VI',
 						'number'=>'4100000000000001',
 						'expDate'=>'1213'
 				),
 				'orderId'=>'12344',
 				'amount'=>'2',
 				'orderSource'=>'ecommerce',
 		);
		$hash_out = Transactions::createAuthHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));		
 	}

 	function test_auth_recurringRequest() {
 		$hash_in = array(
 			'card'=>array(
 				'type'=>'VI',
 				'number'=>'4100000000000001',
 				'expDate'=>'1213'
 			),
 			'orderId'=>'12344',
 			'amount'=>'2',
 			'orderSource'=>'ecommerce',
 			'fraudFilterOverride'=>'true',
 			'recurringRequest'=>array(
 				'subscription'=>array(
 					'planCode'=>'abc123',
 					'numberOfPayments'=>12
 				)
 			)
 		);
		$hash_out = Transactions::createAuthHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));	
  	}
	
  	function test_auth_debtRepayment() {
  		$hash_in = array(
  				'card'=>array(
  						'type'=>'VI',
  						'number'=>'4100000000000001',
  						'expDate'=>'1213'
  				),
  				'orderId'=>'12344',
  				'amount'=>'2',
  				'orderSource'=>'ecommerce',
  				'fraudFilterOverride'=>'true',
  				'debtRepayment'=>'true'
  		);
		$hash_out = Transactions::createAuthHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
  	}	
	
	function test_capture_simple_capture()
	{
		$hash_in = array('litleTxnId'=> '12312312', 'amount'=>'123');
		$hash_out = Transactions::createCaptureHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));		
	}
	
	function test_capture_surchargeAmount() {
 		$hash_in = array(
 			'litleTxnId'=>'3',
 			'amount'=>'2',
 			'surchargeAmount'=>'1',
 			'payPalNotes'=>'notes',
 		);
		$hash_out = Transactions::createCaptureHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));		
 	}	
 	function test_capture_surchargeAmount_optional() {
 		$hash_in = array(
 				'litleTxnId'=>'3',
 				'amount'=>'2',
 				'payPalNotes'=>'notes',
 		);
		$hash_out = Transactions::createCaptureHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));	
 	}	
	function test_captureGivenAuth_simple_captureGivenAuth()
	{
		$hash_in = array(
       'amount'=>'123',
       'orderId'=>'12344',
       'authInformation' => array(
       'authDate'=>'2002-10-09','authCode'=>'543216',
       'authAmount'=>'12345'),
       'orderSource'=>'ecommerce',
       'card'=>array(
       'type'=>'VI',
       'number' =>'4100000000000001',
       'expDate' =>'1210'));
		$hash_out = Transactions::createCaptureGivenAuthHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));		
	}	

	function test_captureGivenAuth_surchargeAmount() {
 		$hash_in = array(
 			'amount'=>'2',
 			'surchargeAmount'=>'1',
 			'orderSource'=>'ecommerce',
 			'orderId'=>'3'
 		);
		$hash_out = Transactions::createCaptureGivenAuthHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
 	}
 		
 	function test_captureGivenAuth_surchargeAmount_optional() {
 		$hash_in = array(
 				'amount'=>'2',
 				'orderSource'=>'ecommerce',
 				'orderId'=>'3'
 		);
		$hash_out = Transactions::createCaptureGivenAuthHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
 	}
	
 	function test_captureGivenAuth_debtRepayment_true() {
 		$hash_in = array(
 				'amount'=>'2',
 				'orderSource'=>'ecommerce',
 				'orderId'=>'3',
 				'merchantData'=>array(
 					'campaign'=>'foo',
 				),
 				'debtRepayment'=>'true'
 		);
		$hash_out = Transactions::createCaptureGivenAuthHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));		
 	}
	
 	function test_captureGivenAuth_debtRepayment_false() {
 		$hash_in = array(
 				'amount'=>'2',
 				'orderSource'=>'ecommerce',
 				'orderId'=>'3',
 				'merchantData'=>array(
 					'campaign'=>'foo',
 				),
 				'debtRepayment'=>'false'
 		);
		$hash_out = Transactions::createCaptureGivenAuthHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
 	}	
	
 	function test_captureGivenAuth_debtRepayment_optional() {
 		$hash_in = array(
 				'amount'=>'2',
 				'orderSource'=>'ecommerce',
 				'orderId'=>'3',
 				'merchantData'=>array(
 						'campaign'=>'foo',
 				),
 		);
		$hash_out = Transactions::createCaptureGivenAuthHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));		
 	}
	
	function test_credit()
	{
		$hash_in = array('litleTxnId'=> '12312312',
						 'orderId'=> '2111',
						 'orderSource'=>'ecommerce',
						 'amount'=>'123');
		$hash_out = Transactions::createCreditHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));		
	}
	
	function test_credit_action_reason_on_orphaned_refund()
	{
		$hash_in = array(
					'orderId'=> '2111',
					'orderSource'=>'ecommerce',
					'amount'=>'123',
					'actionReason'=>'SUSPECT_FRAUD'
		);
		$hash_out = Transactions::createCreditHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));		
	}
	
	function test_credit_surchargeAmount_tied() {
		$hash_in = array(
				'amount'=>'2',
				'surchargeAmount'=>'1',
				'litleTxnId'=>'3',
				'processingInstructions'=>array(),
		);
		$hash_out = Transactions::createCreditHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));			
	}	
	
	function test_credit_surchargeAmount_tied_optional() {
		$hash_in = array(
				'amount'=>'2',
				'litleTxnId'=>'3',
				'processingInstructions'=>array(),
		);
		$hash_out = Transactions::createCreditHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
	}	
	
	function test_credit_surchargeAmount_orphan() {
		$hash_in = array(
				'amount'=>'2',
				'surchargeAmount'=>'1',
				'orderId'=>'3',
				'orderSource'=>'ecommerce',
		);
		$hash_out = Transactions::createCreditHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));		
	}
	
	function test_credit_surchargeAmount_orphan_optional() {
		$hash_in = array(
				'amount'=>'2',
				'orderId'=>'3',
				'orderSource'=>'ecommerce',
		);
		$hash_out = Transactions::createCreditHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));			
	}	
	
	function test_credit_pos_tied() {
		$hash_in = array(
				'amount'=>'2',
				'pos'=>array(
					'terminalId'=>'abc123',
					'capability'=>'a',
					'entryMode'=>'b',
					'cardholderId'=>'c'
				),
				'litleTxnId'=>'3',
				'payPalNotes'=>'notes',
		);
		$hash_out = Transactions::createCreditHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
	}
	
	function test_credit_pos_tied_optional() {
		$hash_in = array(
				'amount'=>'2',
				'litleTxnId'=>'3',
				'payPalNotes'=>'notes',
		);
		$hash_out = Transactions::createCreditHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
	}
	
	function test_echeckCredit()
	{
		$hash_in = array('litleTxnId' =>'123123');
		$hash_out = Transactions::createEcheckCreditHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
	}	
	
	function test_echeckRedeposit()
	{
		$hash_in = array('litleTxnId' =>'123123');
		$hash_out = Transactions::createEcheckRedepositHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));		
	}	

	function test_echeckRedeposit_merchantData()
	{
		$hash_in = array(
				'litleTxnId' =>'123123', 
				'merchantData'=>array('campaign'=>'camping'));
		$hash_out = Transactions::createEcheckRedepositHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));				
	}	
	
	function test_echeckSale()
	{
		$hash_in = array('litleTxnId' =>'123123');
		$hash_out = Transactions::createEcheckSaleHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));			
	}	
	
	function test_simple_echeckVerification()
	{
	     $hash_in = array('amount'=>'123','orderId'=>'123','orderSource'=>'ecommerce',
		'echeckToken' => array('accType'=>'Checking','routingNum'=>'123123','litleToken'=>'1234565789012','checkNum'=>'123455'));
		$hash_out = Transactions::createEcheckVerificationHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
	}
	
	function test_echeckVerification_merchantData()
	{
		$hash_in = array('amount'=>'123','orderId'=>'123','orderSource'=>'ecommerce','merchantData'=>array('campaign'=>'camping'),
				'echeckToken' => array('accType'=>'Checking','routingNum'=>'123123','litleToken'=>'1234565789012','checkNum'=>'123455'));
		$hash_out = Transactions::createEcheckVerificationHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
	}

	function test_simple_forceCapture()
	{
		$hash_in = array(
	      'amount'=>'106',
	      'orderSource'=>'ecommerce',
	      'token'=> array(
	      'litleToken'=>'123456789101112',
	      'expDate'=>'1210',
	      'cardValidationNum'=>'555',
	      'type'=>'VI'));
		$hash_out = Transactions::createForceCaptureHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));	
	}			
	
	function test_forceCapture_surchargeAmount() {
 		$hash_in = array(
 			'orderId'=>'3',
 			'amount'=>'2',
 			'surchargeAmount'=>'1',
 			'orderSource'=>'ecommerce',
 		);
		$hash_out = Transactions::createForceCaptureHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));		
 	}

 	function test_forceCapture_surchargeAmount_optional() {
 		$hash_in = array(
 			'orderId'=>'3',
 			'amount'=>'2',
 			'orderSource'=>'ecommerce',
 		);
		$hash_out = Transactions::createForceCaptureHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));			
 	}
	
 	function test_forceCapture_debtRepayment_true() {
 		$hash_in = array(
 				'amount'=>'2',
 				'orderSource'=>'ecommerce',
 				'orderId'=>'3',
 				'merchantData'=>array(
 						'campaign'=>'foo',
 				),
 				'debtRepayment'=>'true'
 		);
		$hash_out = Transactions::createForceCaptureHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out)); 	
	}

 	function test_forceCapture_debtRepayment_false() {
 		$hash_in = array(
 				'amount'=>'2',
 				'orderSource'=>'ecommerce',
 				'orderId'=>'3',
 				'merchantData'=>array(
 						'campaign'=>'foo',
 				),
 				'debtRepayment'=>'false'
 		);
		$hash_out = Transactions::createForceCaptureHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out)); 
 	}
	
 	function test_forceCapture_debtRepayment_optional() {
 		$hash_in = array(
 				'amount'=>'2',
 				'orderSource'=>'ecommerce',
 				'orderId'=>'3',
 				'merchantData'=>array(
 						'campaign'=>'foo',
 				),
 		);
		$hash_out = Transactions::createForceCaptureHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out)); 
 	}	
	
	function test_sale_with_card()
	{
		$hash_in = array(
			'card'=>array('type'=>'VI',
					'number'=>'4100000000000001',
					'expDate'=>'1213',
					'cardValidationNum' => '1213'),
			'orderId'=> '2111',
			'orderSource'=>'ecommerce',
			'amount'=>'123');
		
		$hash_out = Transactions::createSaleHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
	}
	
	function test_token()
	{
		$hash_in = array(
			'orderId'=>'1',
			'accountNumber'=>'123456789101112');
		
		$hash_out = Transactions::createRegisterTokenHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
	}
	
	function test_simple_updateCardValidationNumOnToken()
	{
		$hash_in = array(
			'orderId'=>'1',
			'litleToken'=>'123456789101112',
			'cardValidationNum'=>'123');
		$hash_out = Transactions::createUpdateCardValidationNumOnTokenHash($hash_in);
		$this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
	}
									
}


?>