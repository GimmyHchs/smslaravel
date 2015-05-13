<?php

use Illuminate\Database\Seeder;
use App\Message;

class MessageSeeder extends Seeder {

  public function run()
  {
    DB::table('messages')->delete();

    
      Message::create([

      	 'course_id'		   	=> 		'1',
      	 'student_id'       =>    '1',
         'student_name'       =>    '測試A君',
         'from'  		        => 		'+886900000000',
         'to'               => 		'+886933333333',
         'content'          => 		'親愛的家長您好，貴子弟測試A君已抵達元祺文理補習班，請家長放心',
         'delivertype'   		=>		'deliver',

        	    
      ]);
      Message::create([
        
         'course_id'        =>    '1',
         'student_id'       =>    '2',
         'student_name'       =>    '測試B君',
         'from'             =>    '+886900000000',
         'to'               =>    '+886999876543',
         'content'          =>    '親愛的家長您好，貴子弟測試B君已抵達元祺文理補習班，請家長放心',
         'delivertype'      =>    'fail',

      ]);
      Message::create([
        
         'course_id'        =>    '2',
         'student_id'       =>    '3',
        'student_name'       =>    '測試C君',
         'from'             =>    '+886900000000',
         'to'               =>    '+886999876543',
         'content'          =>    '親愛的家長您好，貴子弟測試C君已抵達元祺文理補習班，請家長放心',
         'delivertype'      =>    'deliver',

      ]);
  }

}