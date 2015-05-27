<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;


class SmsHomeController extends Controller {



	public function __construct(){
	   //subdomain check   if  get session will change the Database
	   if(!is_null(Session::get('subdomain')))
       {
       	 $subdomain=Session::get('subdomain');
       	 $dbname='smsdatabase_'.Session::get('subdomain');
       	 Config::set('database.connections.mysql_subdomain.database',$dbname);
    	 DB::setDefaultConnection('mysql_subdomain');
       }

	}


	public function index()
	{
		//

		return view('smspages.smshome',compact('subdomain'));
	}

	
}
