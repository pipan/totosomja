<?php
class Paypal{
	
	public $data = array();
	
	public function __construct(){
		
	}
	
	public function encrypt_user($id, $salt){
		return substr($salt, 0, 4).$id.substr($salt, 4, 4);
	}
	
	public function decrypt_user($code){
		if (strlen($code) > 8){
			$ret = array();
			$ret['id'] = substr($code, 4, strlen($code) - 8);
			$ret['salt'] = substr($code, 0, 4).substr($code, strlen($code) - 4, 4);
			return $ret;
		}
		return false;
	}
	
	public function compare_user($user, $user_db){
		if ($user['id'] == $user_db['id'] && $user['salt'] == substr($user_db['salt'], 0, 8)){
			return true;
		}
		return false;
	}
	
	public function _ipn(){
		// STEP 1: read POST data
		
		// Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
		// Instead, read raw POST data from the input stream.
		$raw_post_data = file_get_contents('php://input');
		$raw_post_array = explode('&', $raw_post_data);
		$myPost = array();
		foreach ($raw_post_array as $keyval) {
			$keyval = explode ('=', $keyval);
			if (count($keyval) == 2)
				$myPost[$keyval[0]] = urldecode($keyval[1]);
		}
		// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
		$req = 'cmd=_notify-validate';
		if(function_exists('get_magic_quotes_gpc')) {
			$get_magic_quotes_exists = true;
		}
		foreach ($myPost as $key => $value) {
			if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
				$value = urlencode(stripslashes($value));
			} else {
				$value = urlencode($value);
			}
			$req .= "&$key=$value";
		}
		
		
		// STEP 2: POST IPN data back to PayPal to validate
		
		$ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
		
		// In wamp-like environments that do not come bundled with root authority certificates,
		// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set
		// the directory path of the certificate as shown below:
		// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
		if( !($res = curl_exec($ch)) ) {
			// error_log("Got " . curl_error($ch) . " when processing IPN data");
			curl_close($ch);
			$this->parse_ipn();
			exit;
		}
		curl_close($ch);
		$this->parse_ipn($res);
	}
	
	public function parse_ipn($text = ""){
		if ($text != ""){
			$this->data[0] = $text;
			foreach($_POST as $key => $value) {
				$this->data[$key] = $value;
			}
		}
		else{
			$this->data[0] = "FAIL";
		}
	}
	
	public function parse_pdt($text){
		$line = explode("\n", $text);
		$i = 0;
		foreach ($line as $l){
			$tmp = explode("=", $l);
			if (sizeof($tmp) > 1){
				$this->data[$tmp[0]] = str_replace("+", " ", $tmp[1]);
			}
			else{
				$this->data[$i] = $tmp[0];
				$i++;
			}
		}
	}
	
	public function _pdt(){
		// Change to www.sandbox.paypal.com to test against sandbox
		$pp_hostname = "www.sandbox.paypal.com";
		
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-synch';
		
		$tx_token = "";
		if (isset($_GET['tx'])){
			$tx_token = $_GET['tx'];
		}
		$auth_token = "IFGVi9E-s_NDPYO4HcifpACcMJuFPOvHoup8QhPe73VlrDLd8zCiFRz15-q";
		$req .= "&tx=$tx_token&at=$auth_token";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://$pp_hostname/cgi-bin/webscr");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		//set cacert.pem verisign certificate path in curl using 'CURLOPT_CAINFO' field here,
		//if your server does not bundled with default verisign certificates.
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: $pp_hostname"));
		$result = curl_exec($ch);
		curl_close($ch);
		$this->parse_pdt($result);
	}
	
	public function is_valid_pdt(){
		if (sizeof($this->data) > 0 &&  substr($this->data[0], 0, 4) != "FAIL"){
			return true;
		}
		return false;
	}
	
	public function is_valid_ipn(){
		if (sizeof($this->data) > 0 && strcmp ($this->data[0], "VERIFIED") == 0 && isset($this->data['txn_id'])){
			return true;
		}
		return false;
	}
	
	public function to_string(){
		$ret = "";
		foreach ($this->data as $key => $value){
			$ret .= $key."=".$value."\n";
		}
		return $ret;
	}
}