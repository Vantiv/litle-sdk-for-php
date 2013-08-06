<?php

class LitleRequest{
	
	# file name that holds the batch requests once added
	private $request_file;
	
	private $num_batch_requests = 0;
	# note that a single litle request cannot hold more than 500,000 transactions
	private $total_transactions = 0;
	
	private $closed = false;
	/*
	 * Creates the intermediate request file and preps it to have batches added
	 */
	public function __construct($hash_config=array()){
		
	}
	
	/* 
	 * Adds a closed batch request to the Litle Request. This entails copying the completed batch file into the intermediary
	 * request file
	 */
	public function addBatchRequest($batch_request){
		
	}
	
	/*
	 * Fleshes out the XML needed for the Litle Request. Returns the file name of the completed request file
	 */
	public function closeRequest(){
		
	}	
	
	/*
	 * Alias for the preferred method of sFTP delivery
	 */
	public function sendToLitle(){
		$this->sendToLitleSFTP();
	}
	
	/*
	 * Deliver the Litle Request over sFTP using the credentials given by the config
	 */
	public function sendToLitleSFTP(){
		$this->closeRequest();
	}
	
	/*
	 * Deliver the Litle Request over a TCP stream
	 */
	public function sendToLitleStream(){
		$this->closeRequest();
	}
}





