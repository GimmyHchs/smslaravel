<?php
require "SmsLumen.php";


//Please get the key from http://api2.send2me.cc/
const KEY = "763ecaea1dce82286624baec4d";
const SECRET = "c4f8e535806b72b889205cec64";

$sender = new SmsLumen(KEY, SECRET);
$message="SmsLaravel 測試簡訊 Date: ".date("Y-m-d")."    ".date("h:i:sa");
$sender->setTarget([
	'0916023011'
]);
$sender->setMessage($message);
$sender->send();

//the Response is not null AFTER $sender->send()
$response=getResponse();
//dump response
var_dump($response);