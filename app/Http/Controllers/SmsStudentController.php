<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Student;
use App\CourseStudent;
use App\Course;
use App\Http\Requests\StudentAddRequest;

class SmsStudentController extends Controller {

	/*
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct(Student $student,CourseStudent $coursestudent,Course $course){

      // $this->middleware('auth');
       //$this->accountbank=$accountbank;
       $this->student=$student;
       $this->coursestudent=$coursestudent;
       $this->course=$course;
       //$this->bank=$bank;
	}


	public function index()
	{
		//
		$students = $this->student->get();
		$coursestudents = $this->coursestudent->join('courses','courses.id','=','courses_students.course_id')->select('courses.name','courses_students.student_id')->get();
		$coursestudentarray = array();
		// for($i=0;$i<count($students);$i++)
		// {
		// 	 $mycount($coursestudent->where('student_id',$students[$i]->id))); 
	 // 	}
	 	//$mycount=count($coursestudent->where('student_id',$students[0]->id)); 

//		dd($mycount);

		$message = Session::get('message');
		Session::forget('message');
		 
		return view('student.index',compact('students', 'message','coursestudents'));
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
		$student->tel = '886'.substr($request->get('input_tel'),1,9);
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
		Session::put('message', 'You Add a Student '.$student->name);
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
		$student=$this->student->get()->where('id',$id)->first();
		if($student==null){
			$student=$this->student->get()->where('id',intval($id))->first();
		}
		$message = Session::get('message');
		Session::forget('message');
		return view('student.show',compact('student','message'));

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
		$student=$this->student->get()->where('id',$id)->first();
		if($student==null){
			$student=$this->student->get()->where('id',intval($id))->first();
		}
		$student->tel='0'.substr($student->tel,3,9);
		$student->tel_parents='0'.substr($student->tel_parents,3,9);
		return view('student.edit',compact('student'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,StudentAddRequest $request)
	{
		//
		$student=$this->student->get()->where('id',$id)->first();
		if($student==null){
			$student=$this->student->get()->where('id',intval($id))->first();
		}
		$student->name=$request->get('input_name');
		$student->tel='886'.substr($request->get('input_tel'),1,9);
		$student->tel_parents='886'.substr($request->get('input_tel_parents'),1,9);
		$student->about=$request->get('input_about');
		$student->save();
		Session::put('message',$student->name);
		return redirect('/student/'.$id);
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
		$student=$this->student->get()->where('id',$id)->first();
		if($student==null){
			$student=$this->student->get()->where('id',intval($id))->first();
		}
		//dd($student->name.'You Delete a Student '.$student->name);
		Session::put('message','You Delete a Student '.$student->name);
		$student->delete();
		return redirect('/student');
	}

}
