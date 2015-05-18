<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Student;
use App\CourseStudent;
use App\Course;
use App\Http\Requests\StudentAddRequest;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use App\Excelchecker\Excelchecker;


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
	public function uploadExcel(Request $request)
	{
		$message="";
		$file = $request->get('excelfile');
		if(is_null($file))
			dd('Please choose a ExcelFile...');
		$contents = "";
		$reader = Excel::load(Input::file('excelfile')->getRealPath());
		$reader->setActiveSheetIndex(0);
		//dd($reader->getActiveSheet());
		foreach ($reader->getActiveSheet()->getRowIterator() as $rowindex => $row) {
		$student = new Student;
        foreach ($row->getCellIterator() as $cellindex => $cell) {
        	if(!is_null($cell)&&$rowindex==1)
        	{
        		switch ($cellindex)
                {
                       case 'A':
            				if($cell->getValue()!='姓名')
        					dd('Excel內容格式錯誤...');
            				break;
						case 'B':
            				if($cell->getValue()!='手機')
        					dd('Excel內容格式錯誤...');
            				break;
            			case 'C':
            				if($cell->getValue()!='家長手機')
        					dd('Excel內容格式錯誤...');
            				//dd($contents);
            			default:
            				break;
            	}

        	}
            else if (!is_null($cell)&&$rowindex!=1) {
            	
            	

                switch ($cellindex)
                {
                       case 'A':
            				$student->name=$cell->getValue();
            				//dd($student->name);
            				break;
						case 'B':
            				$student->tel=$cell->getValue();
            				//dd($student->tel);
            				break;
            			case 'C':
            				$student->tel_parents=$cell->getValue();
            				//dd($contents);
            			
            			default:
            				$student->age=16;
            				$student->sex='男';
            				$lastid=$this->student->get()->last()->id;
							$lastid++;
							if($lastid<10)
								$student->barcode='cc0000'.$lastid;
							else if($lastid<100)
								$student->barcode='cc000'.$lastid;
							else if($lastid<1000)
								$student->barcode='cc00'.$lastid;

							$samestudent=$this->student->get()->where('tel',$student->tel)->where('tel_parents',$student->tel_parents)->where('name',$student->name)->first();
							if(!is_null($samestudent))
							{
								$message.='省略重複名單 : '.$samestudent->name.'\n\r -----------';
							}
							else
							{
								 $student->save();
							}
            			   
            				break;
            	}
       	 	}
        }

    	}
    	Session::put('message','You Import a Excel File-success '.$message);
		return redirect('/student');

	}
	public function downloadExcel(){
		
		Excel::create('補習班全員名單', function($excel) {

   			 // Call writer methods here
			$excel->sheet('sheet1',function($sheet){
				$data=[];
				$students=$this->student->get();
				 array_push($data, ['姓名','手機','家長手機']);
				 foreach ($students as $index => $student) {
				 	array_push($data, [$student->name,$student->tel,$student->tel_parents]);
				 }
				$sheet->fromArray($data,null,'A1',false,false);
				//$sheet->fromArray($data,null,'A2',false,false);

			});

		})->download('xlsx');
	/*
		$checker = new Excelchecker();
		$checker->check(['a','a']);
		dd($checker->getCheckCount());
		*/
	}

}
