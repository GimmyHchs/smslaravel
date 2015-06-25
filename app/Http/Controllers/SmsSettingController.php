<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Smsapi\Sender;
use App\Smsapi\SmsLumen;

use App\Student;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;

	const API = "http://nov.mynet.com.tw:9090/api";
	const KEY = "b67b96136e34ccd7b42656cd25";
	const SECRET = "d739d9c7015a93064aacff78c8";


date_default_timezone_set("Asia/Taipei");

class SmsSettingController extends Controller {


	public function __construct(Student $student){

		$this->student=$student;

	   //subdomain check   if  get session will change the Database
	   //取得Session，用來判斷是否通過subdomain連入，並且適當地切換資料庫
	   if(!is_null(Session::get('subdomain')))
       {
       	 $dbname='smsdatabase_'.Session::get('subdomain');
       	 Config::set('database.connections.mysql_subdomain.database',$dbname);
    	 DB::setDefaultConnection('mysql_subdomain');
       }
	   $this->middleware('auth');
	}
	


	public function index()
	{

		$message = Session::get('message');
		Session::forget('message');

		return view('setting.index',compact('message')); 
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
	public function sendsms(Request $request){

		//using API Class  check info  from https://bitbucket.org/Shisha/send2me_api
		//使用API Class 詳細資訊請查閱 https://bitbucket.org/Shisha/send2me_api
		date_default_timezone_set("Asia/Taipei");
		$sender = new Sender(API, KEY, SECRET);
		$message = $request->get('input_content')." \n set time at  ".date("Y-m-d")."\n".date("h:i:sa");
		$from = $request->get('input_from');

		if(substr($request->get('input_target'), 0,1)=="0")
		{
			$to = [
				'886'.substr($request->get('input_target'), 1,9)
			];
		}
		else{
			$to = [
				$request->get('input_target')
			];
		}
		$sender->from($from);
		$sender->to($to);
		$sender->content($message);

		$sender->send();
		$target = $request->get('input_target');
		//$issend = true;
		//dd($to);
		Session::put('message', 'You Send SMS to '.$target);
		return redirect('/setting');

	}
	public function sendlumensms(Request $request){
		date_default_timezone_set("Asia/Taipei");
		//using API Class  check info from the project folder app/Smsapi/SmsLumen.php and testSmsLumen.php
		//使用API Class 詳細資訊請查閱本專案內的檔案 app/Smsapi/SmsLumen.php 跟 testSmsLumen.php
		$sender = new SmsLumen(KEY, SECRET);
		//$sender->test();
		$sender->setTarget([
			$request->get('input_target')
			]);
		$sender->setMessage($request->get('input_content'));
		
		//dd($sender->getUrl());
		$sender->send();
		//dd($sender->getUrl());
		//dd($request);
		Session::put('message', 'You Send SMS to '.$request->get('input_target'));
		return redirect('/setting');
	}
	public function sendemail(Request $request){


		  // passing value to the view
		  // 傳送給郵件view的變數資料
		  $template_data = array(
		      'name'=> 'Hchs',
		      'content' => $request->get('input_content')
		  );
		  
		  // receive data
		  // 收件者資料
		  $userinfo = array(
		    'email'=>$request->get('input_target'),
		    'subject'=>'使用 GMail!'
		  );
		  Mail::send('emails.index', $template_data, function($message) use ($userinfo)
		  {
		      $message->to($userinfo['email'])->subject($userinfo['subject']);
		  });


		Session::put('message', 'You Send Email to '.$userinfo['email']);
		return redirect('/setting');


	}

	public function mobileSendSms(Request $request){

		date_default_timezone_set("Asia/Taipei");
		$barcode = $request->get('barcode');
		$student=$this->student->get()->where('barcode',$barcode)->first();
		$arrived_at=date("Y-m-d")." ".date("h:i:sa");

		//using API Class  check info from the project folder app/Smsapi/SmsLumen.php and testSmsLumen.php
		//使用API Class 詳細資訊請查閱本專案內的檔案 app/Smsapi/SmsLumen.php 跟 testSmsLumen.php
		$sender = new SmsLumen(KEY, SECRET);
		//$sender->test();
		
		$sender->setTarget([
			$student->tel_parents
			]);

		$sender->setMessage("親愛的家長您好!貴子弟".$student->name."已經到達學校，請家長放心!  ".$arrived_at);
		$sender->send();
		//Session::put('message', 'You Send SMS to '.$request->get('input_target'));
		return Response::json(array('name' => $student->name, 'arrived_at' => $arrived_at,'barcode' => $request->get('barcode')));

	}
}
