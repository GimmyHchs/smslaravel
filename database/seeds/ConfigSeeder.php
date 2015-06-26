<?php

use Illuminate\Database\Seeder;
use App\Config;

class ConfigSeeder extends Seeder {

  public function run()
  {
    DB::table('configs')->delete();
    
      Config::create([

         'name'          => 		'messageformat',
         'value'   		=>		'親愛的家長您好，貴子弟%NAME已抵達S1補習班，請家長放心%TIME',

      ]);
  }

}