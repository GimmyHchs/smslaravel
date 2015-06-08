<?php namespace App\Smsapi;


use Exception;

/**
 * Author Hchs
 * 2015/06/08
 */

class SmsLumen
{
 	
 	private $apiacc;
 	private $apipwd;
 	private $message;
 	private $url;
 	private $response;

 	function __construct($apiacc ,$apipwd) {
		$this->apiacc=$apiacc;
		$this->apipwd=$apipwd;
		$this->setApiUrl();
		$this->setApiKey();


	}

	// ===============================================================================
	// = Set
	// ===============================================================================
	private function setApiUrl() {
		$this->url = 'http://api2.send2me.cc/api/every8d?';
	}
	private function setApiKey(){

		$this->url.='UID='.$this->apiacc;
		$this->url.='&PWD='.$this->apipwd;

	}
	public function setTarget($arg){

        if(is_array($arg))
        {
        	 $this->url.='&Target=';
             foreach ($arg as $key => $value) {
             	$this->url.=$value;
             }
        }
        else
        {
        	if(strlen($arg==10||$arg==13||$arg==12))
        	{
            	$this->url.='&Target='.$arg;
        	}
            else
               throw new Exception("Error Processing Request", 1); 	
        }

	}
	public function setMessage($message){

			$this->message=$message;
			$this->url.='&MSG='.$message;

	}
    // ===============================================================================
	// = Get
	// ===============================================================================

	public function getUrl(){
		return $this->url;
	}
	public function getMessage(){
		return $this->message;
	}
	public function getResponse(){
		return $this->response;
	}

    // ===============================================================================
	// = Method
	// ===============================================================================

	public function Send(){

		$curl = curl_init();
		$this->url=str_replace(" ","%20",$this->url);
		curl_setopt($curl, CURLOPT_URL, $this->url);
		//dd('https://'.$this->url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_HEADER, FALSE);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');

		//curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
		//ssl setting
		//curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
		//curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);

		$res = curl_exec($curl);
		curl_close($curl);
		//dd($res);
		$this->response=$res;
	}

	public function test(){

		dd($this->apiacc.$this->apipwd);

	}

}
