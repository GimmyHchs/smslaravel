<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Course;
use App\Student;
Use App\CourseStudent;
use App\Http\Requests\CourseAddRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;


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

		//subdomain check   if  get session will change the Database
       if(!is_null(Session::get('subdomain')))
       {
       	 $dbname='smsdatabase_'.Session::get('subdomain');
       	 Config::set('database.connections.mysql_subdomain.database',$dbname);
    	 DB::setDefaultConnection('mysql_subdomain');
       }
       //$this->bank=$bank;
	}
	public function index(Course $courses)
	{
		$courses = $this->course->get();
		$message = Session::get('message');
		Session::forget('message');
		return view('course.index',compact('courses','message'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return view('course.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CourseAddRequest $request)
	{
		//
		$newcourse= new Course;
		$newcourse->name=$request->get('input_name');
		$newcourse->weekday = $request->get('input_weekday');
		$newcourse->time_start = $request->get('input_time_start');
		$newcourse->time_end = $request->get('input_time_end');
		$newcourse->date_start = $request->get('input_date_start');
		$newcourse->date_end = $request->get('input_date_end');
		$newcourse->introduction = $request->get('input_introduction');
		$newcourse->save();

		Session::put('message', "You Add Course ".$newcourse->name);
		return redirect('/course');
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
		//$myid = $id;
		$course = $this->course->get()->where('id',$myid)->first();
		if($course==null)
		{
			$myid = $id;
			$course = $this->course->get()->where('id',$myid)->first();
		}
		//$coursestudent = $this->coursestudent->get()->where('course_id',$myid);
		


		//Join table
		$students=DB::table('courses_students')->join('students', function($join) use($myid)
        {
            $join->on('students.id', '=', 'courses_students.student_id')
                 ->where('courses_students.course_id', '=', $myid);
        })->get();
		//dd($course);

		$allstudents=$this->student->get();
		
		return view('course.show',compact('students','course','allstudents'));
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
		$course=$this->course->get()->where('id',$id)->first();
		if($course==null){
			$course=$this->course->get()->where('id',intval($id))->first();
		}
		return view('course.edit',compact('course'));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,CourseAddRequest $request)
	{
		//
		$course=$this->course->get()->where('id',$id)->first();
		if($course==null){
			$course=$this->course->get()->where('id',intval($id))->first();
		}

		$course->name=$request->get('input_name');		
		$course->weekday=$request->get('input_weekday');
		$course->time_start=$request->get('input_time_start');
		$course->time_end=$request->get('input_time_end');				
		$course->date_start=$request->get('input_date_start');			
		$course->date_end=$request->get('input_date_end');
		$course->introduction=$request->get('input_introduction');	
		$course->save();
		Session::put('message', "You modified Course ".$course->name);

		return redirect('/course');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//刪除課程
   		$course = $this->course->get()->where('id',$id)->first();
   		if($course==null)
		{
			$myid = intval($id);
			$course = $this->course->get()->where('id',$myid)->first();
		}
   		

   		Session::put('message', 'You Delete Course '.$course->name);
   		$course->delete();

		return redirect('/course');
	}

	public function patchstudent($id,Request $request){
		$studentcount=count($this->student->get());
		$checkboxvalue=[];
		for($i=1;$i<=$studentcount;$i++){
			array_push($checkboxvalue,$request->get('checkbox'.$i));
//			array_push($checkboxname, 'checkbox'.$i);
		}

		foreach ($checkboxvalue as $key => $value) {
			if(!is_null($value))
			{

				$check=is_null($this->coursestudent->where('course_id',$id)->where('student_id',$value)->first());
				if($check)
				{
					$newcoursestudent = new CourseStudent;
					$newcoursestudent->course_id=$id;
					$newcoursestudent->student_id=$value;
					$newcoursestudent->save();
				}

			}
		}
		return redirect('/course/'.$id);
	}



}
