<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Smsapi\Sender;
use App\Smsapi\SmsLumen;

use App\Student;
use App\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;

	const API = "http://nov.mynet.com.tw:9090/api";
	const KEY = "b67b96136e34ccd7b42656cd25";
	const SECRET = "d739d9c7015a93064aacff78c8";


class MobileController extends Controller {

	public function __construct(Student $student){

		$this->student=$student;
		Session::set('subdomain','s1');
	   //subdomain check   if  get session will change the Database
	   //取得Session，用來判斷是否通過subdomain連入，並且適當地切換資料庫
	   if(!is_null(Session::get('subdomain')))
       {
       	 $dbname='smsdatabase_'.Session::get('subdomain');
       	 Config::set('database.connections.mysql_subdomain.database',$dbname);
    	 DB::setDefaultConnection('mysql_subdomain');
       }
	}

	public function mobileSendSms(Request $request){

		date_default_timezone_set("Asia/Taipei");
		$barcode = $request->get('barcode');
		$student=$this->student->get()->where('barcode',$barcode)->first();
		$arrived_at=date("Y-m-d")." ".date("h:i:sa");

		//new queue for send Sms  check info to project folder app/commands/SendSms.php
		//建立新的Queue，用來傳送SMS訊息，詳細內容查閱本專案檔案 app/commands/SendSms.php
		Queue::push(new SendSms($student));

		return Response::json(array('name' => $student->name, 'arrived_at' => $arrived_at,'barcode' => $request->get('barcode')));



	}

}
