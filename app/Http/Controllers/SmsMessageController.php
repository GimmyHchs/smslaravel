<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Message;
use App\Student;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class SmsMessageController extends Controller {


	public function __construct(Message $message,Student $student){

      // $this->middleware('auth');
       //$this->accountbank=$accountbank;
	   $this->student=$student;
       $this->message=$message;
       //$this->bank=$bank;
	}


	public function index(Message $messages,Student $students)
	{
		$messages = $this->message->get();
		//$students = $this->student->get();
		return view('message.index',compact('messages'));
	}


	public function create()
	{
		//
	}


	public function store()
	{
		//
	}


	public function show($id)
	{
		//
	}


	public function edit($id)
	{
		//
	}


	public function update($id)
	{
		//
	}


	public function destroy($id)
	{
		//
	}

}
