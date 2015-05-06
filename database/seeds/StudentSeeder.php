<?php

use Illuminate\Database\Seeder;
use App\Student;

class StudentSeeder extends Seeder {

  public function run()
  {
    DB::table('students')->delete();

    
      Student::create([

      	 'name'		   	=> 		'測試A君',
      	 'sex'          =>      '男',
         'tel'  		=> 		'+886922222222',
         'tel_parents'  => 		'+886933333333',
         'barcode'  =>     'CC00001',
         'about'        => 		'我是測試A君，大家好..............................................',
         'age'   		=>		'17',

        	
      ]);
      Student::create([
        
      	 'name'		   	=> 		'測試B君',
      	 'sex'          =>      '女',
         'tel'  		=> 		'+886999999543',
         'barcode'  =>     'CC00002',
         'tel_parents'  => 		'+886999876543',
         'about'        => 		'我是測試B君，@@',
         'age'   		=>		'19',



      ]);
    	Student::create([
        
      	 'name'		   	=> 		'測試C君',
      	 'sex'          =>      '男',
         'tel'  		=> 		'+886922412752',
         'tel_parents'  => 		'+886933727553',
         'barcode'  =>     'CC00003',
         'about'        => 		'我是測試C君,SSSSSSSSSSSSSSSSSSSSSSSS',
         'age'   		=>		'14',



      ]);
  }

}