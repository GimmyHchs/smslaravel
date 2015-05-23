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
use App\Excelchecker\ExcelChecker;


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
		//get all student data form database
		$students = $this->student->get();

		//join [courses and courses_students table] for showing which course has already be 
		$coursestudents = $this->coursestudent->join('courses','courses.id','=','courses_students.course_id')->select('courses.name','courses_students.student_id')->get();

		//if we have Session message , compact to student/index.blade.php
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
	
		//add lastid 1 for generate barcode
		$lastid=$this->student->get()->last()->id;
		$lastid++;

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

		$student->save();
		

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
		//get student null checker Because some Mysql Version will not find correct target from integer
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
		//get student null checker Because some Mysql Version will not find correct target from integer
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
		//get student null checker Because some Mysql Version will not find correct target from integer
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
		//get student null checker Because some Mysql Version will not find correct target from integer
		$student=$this->student->get()->where('id',$id)->first();
		if($student==null){
			$student=$this->student->get()->where('id',intval($id))->first();
		}

		Session::put('message','You Delete a Student '.$student->name);
		$student->delete();
		return redirect('/student');
	}
	public function uploadExcel(Request $request)
	{
		$message="";

		//get Excel file RealPath from client
		$contents = "";
		$reader = Excel::load(Input::file('excelfile')->getRealPath());
		$reader->setActiveSheetIndex(0);
	
		//this checker class will check ALL "row" if error,same,null or not
		//檢查是否有完全重複的欄位、空值，並將排除所有錯誤之後的ROW資料，以陣列方式存在$checker->$checkedlist
		$checker =new ExcelChecker();
		
		//double foreach  for i=row  j=cell ,   
		foreach ($reader->getActiveSheet()->getRowIterator() as $rowindex => $row) {
			//
		$student = new Student;
		$cellValues=[];
		

        foreach ($row->getCellIterator() as $cellindex => $cell) {
        	//check A1 to C1 formate
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
            				array_push($cellValues, $cell->getValue());
            				break;
						case 'B':
            				$student->tel=$cell->getValue();
            				array_push($cellValues,$cell->getValue());
            				break;
            			case 'C':
            				$student->tel_parents=$cell->getValue();
            				array_push($cellValues, $cell->getValue());

            			default:
            				//ignore the same student between Mysql DB and Excel file
							$samestudent=$this->student->get()->where('tel',$student->tel)->where('tel_parents',$student->tel_parents)->where('name',$student->name)->first();
							if(!is_null($samestudent))
							{
								$message.='省略已重複名單 : '.$samestudent->name.'\n\r ---------';
							}
							else
							{
								//此欄(row)存入ExcelChecker
								$checker->addRow($cellValues);
							}
            			   
            				break;
            	}
       	 	}
        }

    	}
    	//check all row ,get checkedArrayList;
    	$checker->checkRowList();
    	$studentlist=$checker->getCheckedList();
    	

    	//add new import students into Mysql DB
    	foreach ($studentlist as $key => $student) {
    		$newstudent = new Student;
    		$newstudent->name = $student[0];
    		$newstudent->tel = $student[1];
    		$newstudent->tel_parents = $student[2];
    		$newstudent->age=16;
            $newstudent->sex='男';

            //Tel number checker
            if(strlen($student[1])==12||strlen($student[1])==10||strlen($student[1])==9)
            {
				if(strlen($student[1])==9)
					$newstudent->tel='886'.$student[1];
				else if (strlen($student[1])==10) 
					$newstudent->tel='886'.substr($student[1], 1);
			}
            else
            	$newstudent->tel='錯誤的電話格式';

            if(strlen($student[2])==12||strlen($student[2])==10||strlen($student[2])==9)
            {
				if(strlen($student[2])==9)
					$newstudent->tel_parents='886'.$student[2];
				else if (strlen($student[2])==10) 
					$newstudent->tel_parents='886'.substr($student[2], 1);
			}
            else
            	$newstudent->tel_parents='錯誤的電話格式';


            //Barcode Checker
    		$lastid=$this->student->get()->last()->id;
			$lastid++;
			if($lastid<10)
					$newstudent->barcode='cc0000'.$lastid;
			else if($lastid<100)
					$newstudent->barcode='cc000'.$lastid;
			else if($lastid<1000)
					$newstudent->barcode='cc00'.$lastid;

			$samestudent=$this->student->get()->where('tel',$newstudent->tel)->where('tel_parents',$newstudent->tel_parents)->where('name',$newstudent->name)->first();
			if(is_null($samestudent))
    		$newstudent->save();
    	}

    	Session::put('message','You Import a Excel File-success '.$message.$checker->getErrorMessage());
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
			});

		})->download('xlsx');

	}

}
