<?php
use App\Smsapi\Sender;

const API = "http://nov.mynet.com.tw:9090/api";
const KEY = "b67b96136e34ccd7b42656cd25";
const SECRET = "d739d9c7015a93064aacff78c8";

$from = "+886916023011";
$to = [
	"+886916023011"
];
date_default_timezone_set("Asia/Taipei");
//$currenttime=time();

$message = "set time at  ".date("Y-m-d")."  ".date("h:i:sa");


$sender = new Sender(API, KEY, SECRET);

$sender->from($from);
$sender->to($to);
$sender->content($message);
// $sender->at("2015-4-23 14:47:00");

$response = $sender->send();

var_dump($response);