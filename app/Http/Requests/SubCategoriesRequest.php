<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoriesRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		$rules = [
			//'name' => ['required', 'string', 'unique:id,designation_name,NULL,id,deleted_at,NULL'],
		//	'department_id' => ['required', 'exists:department,id'],
		];
	//	if (request()->isMethod('put') || request()->isMethod('PATCH')) {
		//	$rules['name'][2] = 'unique:id,designation_name,' . $this->designation->id . ',id,deleted_at,NULL';
	//	}
		return $rules;
	}
}
