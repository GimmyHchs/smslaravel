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



	public function __construct(Course $course,Student $student,CourseStudent $coursestudent){

       $this->course=$course;
       $this->student=$student;
       $this->coursestudent=$coursestudent;

		//subdomain check   if  get session will change the Database
        //取得Session，用來判斷是否通過subdomain連入，並且適當地切換資料庫
       if(!is_null(Session::get('subdomain')))
       {
       	 $dbname='smsdatabase_'.Session::get('subdomain');
       	 Config::set('database.connections.mysql_subdomain.database',$dbname);
    	 DB::setDefaultConnection('mysql_subdomain');
       }

	}
	
	public function index(Course $courses)
	{
		$courses = $this->course->get();
		$message = Session::get('message');
		Session::forget('message');
		return view('course.index',compact('courses','message'));
	}


	public function create()
	{
		return view('course.create');
	}


	public function store(CourseAddRequest $request)
	{
		//store a new record into courses table
		//於courses table儲存一筆新的資料
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


	public function show($id,Course $course)
	{
		//student null checker Because some Mysql Version will not find correct target from integer
		//某些MySQL版本在使用字串搜尋int時會出錯，因此使用int、string各搜尋一次，若兩者都是null，才是真的查無此資料
		$myid = intval($id);
		$course = $this->course->get()->where('id',$myid)->first();
		if($course==null)
		{
			$myid = $id;
			$course = $this->course->get()->where('id',$myid)->first();
		}


		//Join table
		$students=DB::table('courses_students')->join('students', function($join) use($myid)
        {
            $join->on('students.id', '=', 'courses_students.student_id')
                 ->where('courses_students.course_id', '=', $myid);
        })->get();

		$allstudents=$this->student->get();
		
		return view('course.show',compact('students','course','allstudents'));
	}


	public function edit($id)
	{
		//
		$course=$this->course->get()->where('id',$id)->first();
		if($course==null){
			$course=$this->course->get()->where('id',intval($id))->first();
		}
		return view('course.edit',compact('course'));

	}


	public function update($id,CourseAddRequest $request)
	{
		//update course information
		//更新某筆course的資料
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


	public function destroy($id)
	{

		//delete course from courses table
		//刪掉某筆course資料
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

		//add some students into the course
		//將學生加入至某個課程當中
		$studentcount=count($this->student->get());
		$checkboxvalue=[];
		for($i=1;$i<=$studentcount;$i++){
			array_push($checkboxvalue,$request->get('checkbox'.$i));

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
