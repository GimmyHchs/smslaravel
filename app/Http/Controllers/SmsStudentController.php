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
use App\Smsapi\Sender;
use App\Smsapi\SmsLumen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;


	const API = "http://nov.mynet.com.tw:9090/api";
	const KEY = "b67b96136e34ccd7b42656cd25";
	const SECRET = "d739d9c7015a93064aacff78c8";

date_default_timezone_set("Asia/Taipei");


class SmsStudentController extends Controller {


	public function __construct(Student $student,CourseStudent $coursestudent,Course $course){

       //$this->middleware('auth');
       //$this->accountbank=$accountbank;
       $this->student=$student;
       $this->coursestudent=$coursestudent;
       $this->course=$course;

       //subdomain check   if  get session will change the Database
       //取得Session，用來判斷是否通過subdomain連入，並且適當地切換資料庫
       if(!is_null(Session::get('subdomain')))
       {
       	 $dbname='smsdatabase_'.Session::get('subdomain');
       	 Config::set('database.connections.mysql_subdomain.database',$dbname);
    	 DB::setDefaultConnection('mysql_subdomain');
       }
       $this->middleware('auth');
	}


	public function index()
	{
		//get all student data form database
		//取得所有學生資訊
		$students = $this->student->get();

		//join [courses and courses_students table] for showing which course has already be 
		//join courses 跟 courses_students table 用此看出學生已經參與了哪些課程
		$coursestudents = $this->coursestudent->join('courses','courses.id','=','courses_students.course_id')->select('courses.name','courses_students.student_id')->get();

		//if we have Session message , compact to student/index.blade.php
		//若有session，傳遞給前端顯示
		$message = Session::get('message');
		Session::forget('message');
		 
		return view('student.index',compact('students', 'message','coursestudents'));
	}


	public function create()
	{
		//
		return view('student.create');
	}


	public function store(StudentAddRequest $request)
	{
	
		//add lastid 1 for generate barcode
		//為了barcode欄位，將最後的id值+1
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

	}


	public function show($id)
	{
		//get student null checker Because some Mysql Version will not find correct target from integer
		//某些MySQL版本在使用字串搜尋int時會出錯，因此使用int、string各搜尋一次，若兩者都是null，才是真的查無此資料
		$student=$this->student->get()->where('id',$id)->first();
		if($student==null){
			$student=$this->student->get()->where('id',intval($id))->first();
		}

		$message = Session::get('message');
		Session::forget('message');

		return view('student.show',compact('student','message'));

	}


	public function edit($id)
	{
		//get student null checker Because some Mysql Version will not find correct target from integer
		//某些MySQL版本在使用字串搜尋int時會出錯，因此使用int、string各搜尋一次，若兩者都是null，才是真的查無此資料
		$student=$this->student->get()->where('id',$id)->first();
		if($student==null){
			$student=$this->student->get()->where('id',intval($id))->first();
		}
		$student->tel='0'.substr($student->tel,3,9);
		$student->tel_parents='0'.substr($student->tel_parents,3,9);

		return view('student.edit',compact('student'));
	}


	public function update($id,StudentAddRequest $request)
	{
		//get student null checker Because some Mysql Version will not find correct target from integer
		//某些MySQL版本在使用字串搜尋int時會出錯，因此使用int、string各搜尋一次，若兩者都是null，才是真的查無此資料
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


	public function destroy($id)
	{
		//get student null checker Because some Mysql Version will not find correct target from integer
		//某些MySQL版本在使用字串搜尋int時會出錯，因此使用int、string各搜尋一次，若兩者都是null，才是真的查無此資料
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

		$student = new Student;
		$cellValues=[];
		

        foreach ($row->getCellIterator() as $cellindex => $cell) {
        	//check A1 to C1 formate
        	//確認A1~C1是不是正確格式
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
            				//省略某些已存在於MYSQL的資料
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
    	//check all row ,get checkedArrayList
    	//檢查所有row , 並取得檢查過後的List
    	$checker->checkRowList();
    	$studentlist=$checker->getCheckedList();
    	

    	//add new import students into Mysql DB
    	//新增所有匯入的學生資料
    	foreach ($studentlist as $key => $student) {
    		$newstudent = new Student;
    		$newstudent->name = $student[0];
    		$newstudent->tel = $student[1];
    		$newstudent->tel_parents = $student[2];
    		$newstudent->age=16;
            $newstudent->sex='男';

            //Tel number checker
            //檢查手機號碼格式
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
            //檢查Barcode格式
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

	public function sendsms($id){

		$student=$this->student->get()->where('id',$id)->first();
		if(is_null($student))
			$student=$this->student->get()->where('id',intval($id))->first();
		if(!is_null($student))
		{
			
		    $sender = new SmsLumen(KEY, SECRET);
			$message="SmsLaravel 測試簡訊 Date: ".date("Y-m-d")."    ".date("h:i:sa");
			$sender->setTarget([
				$student->tel_parents
			]);
			$sender->setMessage($message);
			$sender->send();
			Session::put('message', 'You send A test SMS Message to '.$student->tel_parents);
		}
		else
		{
			dd("查無此人");
		}

		return redirect('/student');
		
	}


}
