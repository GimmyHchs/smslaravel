<?php namespace App\Smsapi;

/**
 * Author Shisha
 * 2015/4/11
 */

class Sender
{

	private $url;
	private $key;
	private $secret;

	private $sender;
	private $recipient;
	private $message;
	private $scheduled;

	function __construct($url, $key, $secret) {
		$this->setApiUrl($url);
		$this->setApiToken($key, $secret);
	}


	// ===============================================================================
	// = set Api
	// ===============================================================================

	public function setApiUrl($url) {
		$this->url = $url;
	}

	public function setApiToken($key, $secret) {
		$this->key = $key;
		$this->secret = $secret;
	}


	// ===============================================================================
	// = Sender
	// ===============================================================================

	public function from($arg) {
		$this->setSender($arg);
	}

	public function setSender($sender) {
		$this->sender = $sender;
	}


	// ===============================================================================
	// = Recipient
	// ===============================================================================

	public function to($arg) {
		$this->setRecipient($arg);
	}

	public function setRecipient($arg) {
		if (is_array($arg)) {
			$this->setRecipientList($arg);
		} else if (is_string($arg)) {
			$this->setRecipientSingel($arg);
		} else {
			throw new Exception("Argument 1 must be String or Array.");
		}
	}

	private function setRecipientSingel($recipient) {
		$this->recipient = $this->checkRecipient($recipient);
	}

	private function setRecipientList($recipientList) {
		$arr = array_map(function($recipient) {
			return $this->checkRecipient($recipient);
		}, $recipientList);

		$this->recipient = implode(",", $arr);
	}

	private function checkRecipient($recipient) {
		return $recipient;
	}


	// ===============================================================================
	// = Message
	// ===============================================================================

	public function content($arg) {
		$this->setMessage($arg);
	}
	
	public function setMessage($message) {
		$this->message = $this->checkMessage($message);
	}

	private function checkMessage($message) {
		return $message;
	}


	// ===============================================================================
	// = Recipient
	// ===============================================================================

	public function at($date) {
		$this->setDate($date);
	}

	public function setDate($date) {
		$time = strtotime($date);
		$timeString = date("Y-m-d G:i:s", $time);

		$this->scheduled = $timeString;
	}

	// ===============================================================================
	// = Method
	// ===============================================================================

	public function send() {
		$datas = array(
			"from" => $this->sender,
			"to" => $this->recipient,
			"content" => $this->message
		);

		if ( ! empty($this->scheduled)) {
			$datas = array_merge($datas, array(
				"scheduled_at" => $this->scheduled,
				"schedule_mode" => TRUE
			));
		}

		return $this->postMessages($datas);
	}


	// ===============================================================================
	// = Api Interface
	// ===============================================================================

	public function getUser() {
		return $this->requestGet("/user");
	}

	public function getMessages($id = null) {
		$after = (is_string($id))? "/$id" : "";
		return $this->requestGet("/messages" . $after);
	}

	public function postMessages($data) {
		return $this->requestPost("/messages", $data);
	}

	public function getRecipients($sn) {
		$after = (is_string($sn))? "/$sn" : "";
		return $this->requestGet("/recipients" . $after);
	}


	// ===============================================================================
	// = Request
	// ===============================================================================

	private function requestGet($after) {
		$url = $this->getUrl($after);
		$token = $this->getToken();

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_HEADER, FALSE);

		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			"Accept: application/vnd.send2me.v1",
			"Authorization: Token token=$token"
		));

		$response = curl_exec($curl);
		curl_close($curl);

		return $response;

	}

	private function requestPost($after, $data) {
		$url = $this->getUrl($after);
		$token = $this->getToken();
		$data = array("message" => $data);
		$query = $this->dataArrayToQuery($data);


		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_HEADER, FALSE);

		curl_setopt($curl, CURLOPT_POST, TRUE);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $query);

		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			"Content-Type: application/x-www-form-urlencoded",
			"Accept: application/vnd.send2me.v1",
			"Authorization: Token token=$token"
		));

		$response = curl_exec($curl);
		curl_close($curl);

		return $response;
	}


	// ===============================================================================
	// = Function
	// ===============================================================================

	private function getUrl($after = "") {
		return $this->url . $after;
	}

	private function getToken() {
		return $this->key . ":" . $this->secret;
	}

	private function dataArrayToQuery($array) {
		return http_build_query($array);
	}
}