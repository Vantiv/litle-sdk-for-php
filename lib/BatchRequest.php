<?php

class BatchRequest {
	
	private $counts_and_amounts;
	
	public $total_txns = 0;
	
	public $closed = false;
	
	# file name which holds the transaction markups during the batch process
	private $transaction_file;
	
	public $batch_file;
	
	
	public function isFull(){
		return $this->total_txns >= MAX_TXNS_PER_BATCH;
	}
	
	public function __construct($request_dir=NULL){
		// initialize the counts and amounts
		
		$this->counts_and_amounts = array(
			'auth' => array(
				'count' => 0,
				'amount' => 0,
			),
			'sale' => array(
				'count' => 0,
				'amount' => 0,
			),
			'credit' => array(
				'count' => 0,
				'amount' => 0,
			),
			'tokenRegistration' => array(
				'count' => 0,
			),
			'captureGivenAuth' => array(
				'count' => 0,
				'amount' => 0,
			),
			'forceCapture' => array(
				'count' => 0,
				'amount' => 0,
			),
			'authReversal' => array(
				'count' => 0,
				'amount' => 0,
			),
			'capture' => array(
				'count' => 0,
				'amount' => 0,
			),
			'echeckVerification' => array(
				'count' => 0,
				'amount' => 0,
			),
			'echeckCredit' => array(
				'count' => 0,
				'amount' => 0,
			),
			'echeckRedeposit' => array(
				'count' => 0,
			),
			'echeckSale' => array(
				'count' => 0,
				'amount' => 0,
			),
			'updateCardValidationNumOnToken' => array(
				'count' => 0,
			),
			'accountUpdate' => array(
				'count' => 0,
			));
		
		// if a dir to place the request file is not explicitly provided, grab it from the config file
		if(!$request_dir){
			$conf = Obj2xml::getConfig(array());
			$request_dir = $conf['batch_requests_path'];
		}
		
		if(substr($request_dir, -1, 1) != DIRECTORY_SEPARATOR){
			$request_dir = $request_dir . DIRECTORY_SEPARATOR;
		}
		
		$ts = str_replace(" ", "", substr(microtime(), 2));
		$filename = $request_dir . "batch_" . $ts . "_txns";
		$batch_filename = $request_dir . "batch_" . $ts;
		
		// if either file already exists, let's try again!
		if(file_exists($filename) || file_exists($batch_filename)){
			$this->__construct();
		}
		
		// if we were unable to write the file
		if(file_put_contents($filename, "") === FALSE){
			throw new RuntimeException("A batch file could not be written at $filename. Please check your privilege.");
		}
		$this->transaction_file = $filename;
		
		// if we were unable to write the file
		if(file_put_contents($batch_filename, "") === FALSE){
			throw new RuntimeException("A batch file could not be written at $batch_filename. Please check your privilege.");
		}
		$this->batch_file = $batch_filename;
		
	}
	
	/* 
	 * Extracts the appropriate values from the hash in and passes them along to the addTransaction function
	 */
	public function addSale($hash_in){
		$hash_out = Transactions::createSaleHash($hash_in);
		
		$choice_hash = array($hash_out['card'],$hash_out['paypal'],$hash_out['token'],$hash_out['paypage']);
		$choice2_hash= array($hash_out['fraudCheck'],$hash_out['cardholderAuthentication']);
		
		$this->addTransaction($hash_out, $hash_in, 'sale');
		$this->counts_and_amounts['sale']['count'] += 1;
		$this->counts_and_amounts['sale']['amount'] += $hash_out['amount'];
	}
	
	
	
	
	

	/*
	 * Adds the XML for the transaction given the appropriate data to the transactions file
	 */ 
	private function addTransaction($hash_out, $hash_in, $type, $choice1 = null, $choice2 = null){
		if($this->isFull()){
			throw new RuntimeException('The transaction could not be added to the batch. It is full.');
		}
		
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
		
		if(file_put_contents($this->transaction_file, $request, FILE_APPEND) === FALSE){
			throw new RuntimeException("A transaction could not be written to the batch file at $transaction_file. Please check your privilege.");
		}
		
		$this->total_txns += 1;
	}
	
	/*
	 * When no more transactions are to be added, the transactions file can be amended with the XML tags for the counts 
	 *  and amounts of the batch request. Returns the filename of the complete batchrequest file
	 */
	public function closeRequest(){
		$handle = @fopen($this->transaction_file,"r");
		if($handle){
			file_put_contents($this->batch_file, Obj2xml::generateBatchHeader($this->counts_and_amounts), FILE_APPEND);
			while(($buffer = fgets($handle, 4096)) !== false){
				file_put_contents($this->batch_file, $buffer, FILE_APPEND);
			}
			if(!feof($handle)){
				throw new RuntimeException("Error when reading transactions file at $this->transaction_file. Please check your privilege.");
			}
			fclose($handle);
			file_put_contents($this->batch_file, "</batchRequest>", FILE_APPEND);
			
			unlink($this->transaction_file);
			unset($this->transaction_file);
			$this->closed = true;
		}
		else{
			throw new RuntimeException("Could not open transactions file at $this->transaction_file. Please check your privilege.");
		}
	}
}
