<?php
require "Sender.php";

const API = "http://nov.mynet.com.tw:9090/api";
const KEY = "763ecaea1dce82286624baec4d";
const SECRET = "c4f8e535806b72b889205cec64";

$from = "0987654321";
$to = [
	"0912345678"
];
$message = "set time at 14:48";

$sender = new Send2me\Sender(API, KEY, SECRET);

$sender->from($from);
$sender->to($to);
$sender->content($message);

$response = $sender->send();

//dump response
var_dump($response);