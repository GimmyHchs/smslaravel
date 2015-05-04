<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Course;
use App\Student;
Use App\CourseStudent;
Use Illuminate\Support\Facades\DB;

class SmsCourseController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct(Course $course,Student $student,CourseStudent $coursestudent){

      // $this->middleware('auth');
       //$this->accountbank=$accountbank;
       $this->course=$course;
       $this->student=$student;
       $this->coursestudent=$coursestudent;
       //$this->bank=$bank;
	}
	public function index(Course $courses)
	{
		$courses = $this->course->get();
		return view('course.index',compact('courses'));
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
	public function show($id,Course $course)
	{
		//
		$myid = intval($id);
		$course = $this->course->get()->where('id',$myid)->first();
		//$coursestudent = $this->coursestudent->get()->where('course_id',$myid);
		


		//Join table
		$students=DB::table('courses_students')->join('students', function($join) use($myid)
        {
            $join->on('students.id', '=', 'courses_students.student_id')
                 ->where('courses_students.course_id', '=', $myid);
        })->get();
		//dd($students);
		
		return view('course.show',compact('students','course'));
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
