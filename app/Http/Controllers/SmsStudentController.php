<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Student;
use App\Http\Requests\StudentAddRequest;
class SmsStudentController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct(Student $student){

      // $this->middleware('auth');
       //$this->accountbank=$accountbank;
       $this->student=$student;
       //$this->bank=$bank;
	}


	public function index()
	{
		//
		$students = $this->student->get();
		$message = Session::get('message');
		Session::forget('message');
		return view('student.index',compact('students', 'message'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return view('student.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(StudentAddRequest $request)
	{
		//Check The Input
	

		$lastid=$this->student->get()->last()->id;
		$lastid++;
		//$lastid=10;
		$student = new Student;
		$student->name = $request->get('input_name');
		$student->age = $request->get('input_age');
		$student->sex = $request->get('input_sex');
		$student->tel = $request->get('input_tel');
		$student->tel_parents = '886'.substr($request->get('input_tel_parents'),1,9);
		$student->about = $request->get('input_about');
		if($lastid<10)
			$student->barcode='cc0000'.$lastid;
		else if($lastid<100)
			$student->barcode='cc000'.$lastid;
		else if($lastid<1000)
			$student->barcode='cc00'.$lastid;
		//$lastid=$laststudent->id;
		$isaddstudent=true;

		$student->save();
		//dd($student->tel_parents);
		Session::put('message', $student->name);
		return redirect('/student');
		
		//return view('student.index',compact('isaddstudent','students'));
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

}
