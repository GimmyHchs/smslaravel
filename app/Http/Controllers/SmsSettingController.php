<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Smsapi\Sender;


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

	


	public function index()
	{
		return view('setting.index'); 
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



		$sender = new Sender(API, KEY, SECRET);
		$message = $request->get('input_content')." \n set time at  ".date("Y-m-d")."\n".date("h:i:sa");
		$from = $request->get('input_from');
		$to = [
			$request->get('input_target')
		];
		$sender->from($from);
		$sender->to($to);
		$sender->content($message);

		$sender->send();
		$target = $request->get('input_target');
		//$issend = true;
		return view('setting.index',compact('target'));

	}

}
