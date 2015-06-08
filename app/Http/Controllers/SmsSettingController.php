<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Smsapi\Sender;
use App\Smsapi\SmsLumen;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

	const API = "http://nov.mynet.com.tw:9090/api";
	const KEY = "b67b96136e34ccd7b42656cd25";
	const SECRET = "d739d9c7015a93064aacff78c8";

date_default_timezone_set("Asia/Taipei");

class SmsSettingController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct(){


	   //subdomain check   if  get session will change the Database
	   if(!is_null(Session::get('subdomain')))
       {
       	 $dbname='smsdatabase_'.Session::get('subdomain');
       	 Config::set('database.connections.mysql_subdomain.database',$dbname);
    	 DB::setDefaultConnection('mysql_subdomain');
       }

	}
	


	public function index()
	{

		$message = Session::get('message');
		Session::forget('message');

		return view('setting.index',compact('message')); 
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	public function sendsms(Request $request){

		//using API Class    check info  from https://bitbucket.org/Shisha/send2me_api

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
		Session::put('message', $target);
		return redirect('/setting');

	}
	public function sendlumensms(Request $request){

		$sender = new SmsLumen(KEY, SECRET);
		//$sender->test();
		$sender->setTarget([
			$request->get('input_target')
			]);
		$sender->setMessage('中文簡訊測試');
		
		//dd($sender->getUrl());
		$sender->send();
		//dd($sender->getUrl());
		//dd($request);
		Session::put('message', $target);
		return redirect('/setting');
	}

}
