<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use App\Student;

use Illuminate\Http\Request;
use App\Smsapi\Sender;
use App\Smsapi\SmsLumen;

class SendSms extends Command implements SelfHandling, ShouldBeQueued {

	use InteractsWithQueue, SerializesModels;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Student $student)
	{
		//
		$this->student=$student;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		//using API Class  check info from the project folder app/Smsapi/SmsLumen.php and testSmsLumen.php
		//使用API Class 詳細資訊請查閱本專案內的檔案 app/Smsapi/SmsLumen.php 跟 testSmsLumen.php
		$sender = new SmsLumen(KEY, SECRET);
		//$sender->test();
		
		$sender->setTarget([
			$this->student->tel_parents
			]);

		$sender->setMessage("親愛的家長您好!貴子弟".$this->student->name."已經到達學校，請家長放心!  ".$arrived_at);
		$sender->send();

	}

}
