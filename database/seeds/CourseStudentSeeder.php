<?php

use Illuminate\Database\Seeder;
use App\CourseStudent;

class CourseStudentSeeder extends Seeder {

  public function run()
  {
    DB::table('courses_students')->delete();

    //第一堂課擁有三個學生
      CourseStudent::create([

      	 'course_id'		   	 =>		'1',
         'student_id'        =>   '1',
     	 
      ]);
      CourseStudent::create([

         'course_id'        =>    '1',
         'student_id'        =>   '2',
       
      ]);
      CourseStudent::create([

         'course_id'        =>    '1',
         'student_id'        =>   '3',
       
      ]);
      //以上三名

      //第二堂課有兩名學生
      CourseStudent::create([

         'course_id'        =>    '2',
         'student_id'        =>    '1',
       
      ]);
      CourseStudent::create([

         'course_id'        =>    '2',
         'student_id'        =>    '3',
       
      ]);
      //以上 1 .3 兩名學生

      //第三堂課有一名學生
      CourseStudent::create([

         'course_id'        =>    '3',
         'student_id'        =>    '2',
       
      ]);

  }

}