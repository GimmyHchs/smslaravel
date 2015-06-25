<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;


class SmsHomeController extends Controller {


	private $subdomain;
	public function __construct(){
	   //subdomain check   if  get session will change the Database
	   //取得Session，用來判斷是否通過subdomain連入，並且適當地切換資料庫
	   if(!is_null(Session::get('subdomain')))
       {
       	 $this->subdomain=Session::get('subdomain');
       	 $dbname='smsdatabase_'.Session::get('subdomain');
       	 Config::set('database.connections.mysql_subdomain.database',$dbname);
    	 DB::setDefaultConnection('mysql_subdomain');
       }
       $this->middleware('guest');
	}


	public function index()
	{
		//
		$subdomain=$this->subdomain;
		return view('smspages.smshome',compact('subdomain'));
	}

	
}
