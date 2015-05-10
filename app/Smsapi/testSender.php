<?php
require "Sender.php";

const API = "http://nov.mynet.com.tw:9090/api";
const KEY = "763ecaea1dce82286624baec4d";
const SECRET = "c4f8e535806b72b889205cec64";

$from = "0987570225";
$to = [
	"0987570225"
];
$message = "set time at 14:48";


$sender = new Send2me\Sender(API, KEY, SECRET);

$sender->from($from);
$sender->to($to);
$sender->content($message);
// $sender->at("2015-4-23 14:47:00");

$response = $sender->send();
var_dump($response);