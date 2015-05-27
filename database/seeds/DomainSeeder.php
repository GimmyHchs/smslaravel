<?php

use Illuminate\Database\Seeder;
use App\DomainUser;

class DomainSeeder extends Seeder {

  public function run()
  {
    DB::table('domain_users')->delete();
      DomainUser::create([

      	 'domain'		   	=> 		'hchs',

      ]);
  
  }

}