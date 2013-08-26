<?php


#include('Net/SFTP.php');

class LitleRequest{
	
	# file name that holds the batch requests once added
	public $batches_file;
	
	public $request_file;
	
	public $response_file;
	
	private $config;
	
	
	public $num_batch_requests = 0;
	# note that a single litle request cannot hold more than 500,000 transactions
	public $total_transactions = 0;
	
	public $closed = false;
	/*
	 * Creates the intermediate request file and preps it to have batches added
	 */
	public function __construct($overrides=array()){
		$config = Obj2xml::getConfig($overrides);
		
		$this->config= $config;
		$request_dir = $config['litle_requests_path'];
		
		if(substr($request_dir, -1, 1) != DIRECTORY_SEPARATOR){
			$request_dir = $request_dir . DIRECTORY_SEPARATOR;
		}
		
		$ts = str_replace(" ", "", substr(microtime(), 2));
		$batches_filename = $request_dir . "request_" . $ts . "_batches";
		$request_filename = $request_dir . "request_" . $ts;
		$response_filename = $request_dir . "response_" . $ts;
		// if either file already exists, let's try again!
		if(file_exists($batches_filename) || file_exists($request_filename) || file_exists($response_filename)){
			$this->__construct();
		}
		
		// if we were unable to write the file
		if(file_put_contents($batches_filename, "") === FALSE){
			throw new RuntimeException("A request file could not be written at $batches_filename. Please check your privilege.");
		}
		$this->batches_file = $batches_filename;
		
		// if we were unable to write the file
		if(file_put_contents($request_filename, "") === FALSE){
			throw new RuntimeException("A request file could not be written at $request_filename. Please check your privilege.");
		}
		$this->request_file = $request_filename;
		
		if(file_put_contents($response_filename, "") === FALSE){
			throw new RuntimeException("A response file could not be written at $response_filename. Please check your privilege.");
		}
		$this->response_file = $response_filename;
	}

	public function wouldFill($addl_txns_count){
		return ($this->total_transactions + $addl_txns_count) > MAX_TXNS_PER_REQUEST;
	}
	
	/* 
	 * Adds a closed batch request to the Litle Request. This entails copying the completed batch file into the intermediary
	 * request file
	 */
	public function addBatchRequest($batch_request){
		if($this->wouldFill($batch_request->total_txns)){
			throw new RuntimeException("Couldn't add the batch to the Litle Request. The total number of transactions would exceed the maximum allowed for a request.");
		}
		
		if($this->closed){
			throw new RuntimeException("Could not add the batchRequest. This litleRequest is closed.");
		}
		
		if(!$batch_request->closed){
			$batch_request->closeRequest();
		}
		$handle = @fopen($batch_request->batch_file,"r");
		if($handle){
			while(($buffer = fgets($handle, 4096)) !== false){
				file_put_contents($this->batches_file, $buffer, FILE_APPEND);
			}
			if(!feof($handle)){
				throw new RuntimeException("Error when reading batch file at $batch_request->batch_file. Please check your privilege.");
			}
			fclose($handle);
			
			unlink($batch_request->batch_file);
			unset($batch_request->batch_file);
			$this->num_batch_requests += 1;
			$this->total_transactions += $batch_request->total_txns;
		}
		else{
			throw new RuntimeException("Could not open batch file at $batch_request->batch_file. Please check your privilege.");
		}
	}
	
	public function createRFRRequest($hash_in){
		if($this->num_batch_requests > 0){
			throw new RuntimeException("Could not add the RFR Request. A single Litle Request cannot have both an RFR request and batch requests together.");
		}
		
		if($this->closed){
			throw new RuntimeException("Could not add the RFR Request. This litleRequest is closed.");
		}
		$RFRXml = Obj2xml::rfrRequestToXml($hash_in);
		file_put_contents($this->request_file, Obj2xml::generateRequestHeader($this->config, $this->num_batch_requests), FILE_APPEND);
		file_put_contents($this->request_file, $RFRXml, FILE_APPEND);
		file_put_contents($this->request_file, "</litleRequest>", FILE_APPEND);
		unlink($this->batches_file);
		unset($this->batches_file);
		$this->closed = true;
	}
	/*
	 * Fleshes out the XML needed for the Litle Request. Returns the file name of the completed request file
	 */
	public function closeRequest(){
		$handle = @fopen($this->batches_file,"r");
		if($handle){
			file_put_contents($this->request_file, Obj2xml::generateRequestHeader($this->config, $this->num_batch_requests), FILE_APPEND);
			while(($buffer = fgets($handle, 4096)) !== false){
				file_put_contents($this->request_file, $buffer, FILE_APPEND);
			}
			if(!feof($handle)){
				throw new RuntimeException("Error when reading batches file at $this->batches_file. Please check your privilege.");
			}
			fclose($handle);
			file_put_contents($this->request_file, "</litleRequest>", FILE_APPEND);
			
			unlink($this->batches_file);
			unset($this->batches_file);
			$this->closed = true;
		}
		else{
			throw new RuntimeException("Could not open batches file at $this->batches_file. Please check your privilege.");
		}
	}	
	
	/*
	 * Alias for the preferred method of sFTP delivery
	 */
	public function sendToLitle(){
		$this->sendToLitleSFTP();
		return $this->response_file;
	}
	
	/*
	 * Deliver the Litle Request over sFTP using the credentials given by the config. Returns the name of the file retrieved from the server
	 */
	public function sendToLitleSFTP(){
		if(!$this->closed){
			$this->closeRequest();
		}
		
		$session = $this->createSFTPSession();
		# with extension .prg
		$session->put('/inbound/' . basename($this->request_file) . '.prg', $this->request_file, NET_SFTP_LOCAL_FILE);
		# rename when the file upload is complete
		$session->rename('/inbound/' . basename($this->request_file) . '.prg', '/inbound/' . basename($this->request_file) . '.asc');
		
		$this->retrieveFromLitleSFTP($session);
	}
	
	/*
	 * Given a timeout (defaults to 7200 seconds - two hours), periodically poll the SFTP directory, looking for the response file for this request.
	 */ 
	public function retrieveFromLitleSFTP($session, $sftp_timeout=7200){
		$time_spent = 0;
		$this->resetSFTPSession($session);
		while($time_spent < $sftp_timeout){
			# we'll get booted off periodically; make this a non-issue by periodically reconnecting
			if($time_spent % 180 == 0){
				$this->resetSFTPSession($session);
			}
			
			$files = $session->nlist('/outbound');
			
			if(in_array(basename($this->request_file) . '.asc', $files)){
				$this->downloadFromLitleSFTP($session,$time_spent, $sftp_timeout);
				return;
			}
		
			$time_spent += 20;
			sleep(20);
		}
		
		throw new Exception("Response file can not be retrieved because of timeout (Duration : 2 hours)");
		
	}
	
	/*
	 * Creates SFTP Session with given login credentials
	 */
	public function createSFTPSession(){
		$sftp_url = $this->config['batch_url'];
		$sftp_username = $this->config['sftp_username'];
		$sftp_password = $this->config['sftp_password'];
		$session = new Net_SFTP($sftp_url);
		if(!$session->login($sftp_username, $sftp_password)){
			throw new RuntimeException("Failed to SFTP with the username $sftp_username and the password $sftp_password to the host $sftp_url. Check your credentials!");
		}		
		
		return $session;
	}
	
	/*
	 * Resets SFTP Session if Session is unseeted or timed out
	 */ 
	 public function resetSFTPSession($session){
	 	if(!isset($session)){
	 		$session = $this->createSFTPSession();
	 	}
	 }
	
	/*
	 * Downloads the response file from the SFTP server to local system iteratively
	 */ 
	public function downloadFromLitleSFTP($session, $time_spent, $sftp_timeout){
		$sftp_remote_file = '/outbound/' . basename($this->request_file) . '.asc';
		$this->resetSFTPSession($session);
		while($time_spent < $sftp_timeout){
			try{
				if($time_spent % 180 == 0){
					$this->resetSFTPSession($session);
				}
				$session->get($sftp_remote_file, $this->response_file);
				$session->delete($sftp_remote_file);
				$this->response_file = str_replace("request", "response", $this->response_file);
				unset ($session);
				return;
			}
			catch(Exception $exception){
				$message = $exception->getMessage();
				if(stristr($message, "errno=32 broken pipe")){
					$time_spent += 20;
					sleep(20);
				}
				else{
					throw new Exception($message);
				}
			}
		}
	}
	
	/*
	 * Deliver the Litle Request over a TCP stream. Returns the name of the file retrieved from the server
	 */
	public function sendToLitleStream(){
		if(!$this->closed){
			$this->closeRequest();
		}
		
		$tcp_url = $this->config['batch_url'];
		$tcp_port = $this->config['tcp_port'];
		$tcp_ssl = (int)$this->config['tcp_ssl'];
		$tcp_timeout = $this->config['tcp_timeout'];;
		
		if($tcp_ssl){
			$tcp_url = 'ssl://' . $tcp_url;
		}
		
		$sock = fsockopen($tcp_url, $tcp_port, $err_no, $err_str, $tcp_timeout);
		
		if(!$sock){
			throw new RuntimeException("Error when opening socket at $tcp_url : $tcp_port. Error number: $err_no Error message: $err_str");
		}
		else{
			$handle = @fopen($this->request_file,"r");
			if($handle){
				while(($buffer = fgets($handle, 4096)) !== false){
					fwrite($sock, $buffer);
				}
				if(!feof($handle)){
					throw new RuntimeException("Error when reading request file at $this->request_file. Please check your privilege.");
				}
				fclose($handle);
			}
			else{
				throw new RuntimeException("Could not open request file at $this->request_file. Please check your privilege.");
			}
			# read from the response socket while there's data
			while (!feof($sock)) {
				file_put_contents($this->response_file, fgets($sock, 128), FILE_APPEND);
    		}
			fclose($sock);
			return $this->response_file;
		}
	}
}





