<?php namespace App\Excelchecker;

//use App\Student;

class ExcelChecker
{

	private $checkcount;
	private $rowlist;
	private $errorMessage="";
	public $checkedlist;

	function __construct() {
		$this->checkcount=0;
		$this->rowlist=[];
		$this->checkedlist=[];
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
	public function getCheckedList(){

		return $this->checkedlist;
	}
	public function getErrorMessage(){
		return $this->errorMessage;
	}

	// ===============================================================================
	// = Method
	// ===============================================================================
	public function ddrowList(){

		dd($this->rowlist);

	}
	public function addRow($row){

		$nullchecker=true;
		//dd($row);
		foreach ($row as $key => $item) {
			if(is_null($item))
			{
				$nullchecker=false;
				//$this->checkcount++;
			}
		}
		if($nullchecker)
		 array_push($this->rowlist, $row);
		else
			$this->checkcount++;

	}
	public function checkrowList(){
		$mergeList = $this->rowlist;
		$message="";
		foreach ($this->rowlist as $rowkey => $row){

			foreach ($mergeList as $mergekey => $merge) {
				
					if($row===$merge&&($rowkey<$mergekey))
					{
						$this->checkcount++;
						$mergeList[$mergekey]=null;
						$message.=" ".$rowkey.$mergekey;
					}
			}
		}

		foreach ($mergeList as $mergekey => $merge) {
			if(!$mergeList[$mergekey]==null)
				array_push($this->checkedlist, $merge);
		}
		
		//dd($this->checkedlist[3][0][]==null);
		$this->errorMessage='Excel檔內無效的資料共有'.$this->checkcount.'筆';
	}
	/*
 	public function saveAllrow(){
 		foreach ($this->rowlist as $key => $row) {
 			$row->save();
 		}

 	}
 	*/


	/*
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
	}*/

}