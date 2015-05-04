<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;

class SmsController extends Controller {

	
	public function index()
	{
		//
		return view('smspages.smshome');
	}

	
	public function viewcourselist(){

		return view('smspages.smscourselist');

	}
	public function viewmessagestate(){

		return view('smspages.smsmessagestate');

	}
	public function viewsystemsetting(){

		return view('smspages.smssystemsetting');

	}

}
