<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class StudentAddRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			//
		   'input_name' => 'required',
		   'input_tel' =>['required','regex:/^09\d{2}-?\d{6}$/'],
		   'input_tel_parents' => ['required','regex:/^09\d{2}-?\d{6}$/']

		];
	}

}
