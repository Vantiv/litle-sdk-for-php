<?php

class BatchRequest {
	
	private $counts_and_amounts;
	
	private $closed = false;
	
	# file name which holds the transaction markups during the batch process
	private $transaction_file;
	
	
	public function __construct($request_dir=NULL){
		// if a dir to place the request file is not explicitly provided, grab it from the config file
		if(!$request_dir){
			$conf = Obj2xml::getConfig(array());
			$request_dir = $conf['batchRequestsPath'];
		}
		
		$ts = date('Hisu');
		
		$filename = $request_dir . "batch_" . $ts . "_txns";
		
		// if the file already exists, let's try again!
		if(file_exists($filename)){
			$this->__construct();
		}
		
		// if we were unable to write the file
		if(file_put_contents($filename, "") === FALSE){
			throw new RuntimeException("A batch file could not be written at $filename. Please check your privilege.");
		}
		
		$this->transaction_file = $filename;
	}
	
	/* 
	 * Extracts the appropriate values from the hash in and passes them along to the addTransaction function
	 */
	public function addSale($hash_in){
		$hash_out = Transactions::createSaleHash($hash_in);
		
		$choice_hash = array($hash_out['card'],$hash_out['paypal'],$hash_out['token'],$hash_out['paypage']);
		$choice2_hash= array($hash_out['fraudCheck'],$hash_out['cardholderAuthentication']);
		
		$this->addTransaction($hash_out, $hash_in, 'sale');
	}
	
	
	
	
	

	/*
	 * Adds the XML for the transaction given the appropriate data to the transactions file
	 */ 
	private function addTransaction($hash_out, $hash_in, $type, $choice1 = null, $choice2 = null){
		if(isset($hash_in['reportGroup'])){
			$report_group = $hash_in['reportGroup'];
		}
		else{
			$conf = Obj2xml::getConfig(array());
			$report_group = $conf['reportGroup'];
		}
		
		Checker::choice($choice1);
		Checker::choice($choice2);
		
		$request = Obj2xml::transactionToXml($hash_out, $type, $report_group);
		echo $request;
	}
	
	/*
	 * When no more transactions are to be added, the transactions file can be amended with the XML tags for the counts 
	 *  and amounts of the batch request. Returns the filename of the complete batchrequest file
	 */
	public function closeRequest(){
		$closed = true;
	}
}
