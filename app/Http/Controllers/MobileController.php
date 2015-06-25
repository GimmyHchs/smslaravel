<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Smsapi\Sender;
use App\Smsapi\SmsLumen;

use App\Student;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;

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
