<?php

use Illuminate\Database\Seeder;
use App\Student;

class StudentSeeder extends Seeder {

  public function run()
  {
    DB::table('students')->delete();

    
      Student::create([

      	 'name'		   	=> 		'測試A',
      	 'sex'          =>      '男',
         'tel'  		=> 		'886922222222',
         'tel_parents'  => 		'886933333333',
         'barcode'  =>     'cc00001',
         'about'        => 		'我是測試A君，大家好..............................................',
         'age'   		=>		'17',

        	
      ]);
      Student::create([
        
      	 'name'		   	=> 		'測試B',
      	 'sex'          =>      '女',
         'tel'  		=> 		'886999999543',
         'barcode'  =>     'cc00002',
         'tel_parents'  => 		'886999876543',
         'about'        => 		'我是測試B君，@@',
         'age'   		=>		'19',



      ]);
    	Student::create([
        
      	 'name'		   	=> 		'測試C',
      	 'sex'          =>      '男',
         'tel'  		=> 		'886922412752',
         'tel_parents'  => 		'886933727553',
         'barcode'  =>     'cc00003',
         'about'        => 		'我是測試C君,SSSSSSSSSSSSSSSSSSSSSSSS',
         'age'   		=>		'14',



      ]);
      Student::create([
        
         'name'       =>    '測試D',
         'sex'          =>      '男',
         'tel'      =>    '886922412755',
         'tel_parents'  =>    '886933727558',
         'barcode'  =>     'cc00004',
         'about'        =>    '我是測試D君,我沒有參與任何課程',
         'age'      =>    '15',



      ]);
      Student::create([
        
         'name'       =>    '黃清秀',
         'sex'          =>      '男',
         'tel'      =>    '886916023011',
         'tel_parents'  =>    '886916023011',
         'barcode'  =>     'cc00027',
         'about'        =>    '我是黃清秀，手機號碼與資料皆是正確的，我沒有參與任何課程',
         'age'      =>    '22',



      ]);
  }

}