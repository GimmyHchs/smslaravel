<?php

use Illuminate\Database\Seeder;
use App\Course;

class CourseSeeder extends Seeder {

  public function run()
  {
    DB::table('courses')->delete();

    
      Course::create([

      	 'name'		   	=> 		'Apple English (測試課程)',
         'weekday'  	=> 		'四',
         'time_start'   => 		'15:30:00',
         'time_end'     => 		'17:30:00',
         'date_start'   => 		'2015-04-04',
         'date_end'	    => 		'2015-06-04',
         'introduction' =>	    'Apple English 讓你多益怒考990',
        	
      ]);
      Course::create([
        
      	 'name'		   	=> 		'社會 (測試課程)',
         'weekday'  	=> 		'五',
         'time_start'   => 		'15:30:00',
         'time_end'     => 		'17:30:00',
         'date_start'   => 		'2015-04-01',
         'date_end'	    => 		'2015-07-01',
         'introduction' =>	    '歷史地理公民通通有',


      ]);
    	Course::create([
        
      	 'name'		   	=> 		'Android Develop (測試課程)',
         'weekday'  	=> 		'一',
         'time_start'   => 		'13:30:00',
         'time_end'     => 		'17:30:00',
         'date_start'   => 		'2015-04-01',
         'date_end'	    => 		'2015-05-01',
         'introduction' =>	    '一個月的短期課程就能讓你成為手機軟體工程師!!!!!',


      ]);
  }

}