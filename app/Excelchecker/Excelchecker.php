<?php namespace App\Excelchecker;

class Excelchecker
{

	private $checkcount;


	function __construct() {
		$this->checkcount=0;
	}


	// ===============================================================================
	// = set
	// ===============================================================================

	public function setCheckCount($checkcount) {
		$this->checkcount = $checkcount;
	}


	// ===============================================================================
	// = get
	// ===============================================================================

	public function getCheckCount() {
		return $this->checkcount;
		
	}


	// ===============================================================================
	// = Method
	// ===============================================================================

	public function check($array){

		$var=null;
		foreach ($array as $key => $item) {
			if(!is_null($var)){

				if($var==$item)
				{
					$this->checkcount++;
				}

			}
		    $var = $item;
		}
		


	}

}