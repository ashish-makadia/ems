<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest {
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
			'name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'unique:department,name,NULL,id,deleted_at,NULL'],
		];
		if (request()->isMethod('put') || request()->isMethod('PATCH')) {
			$rules['name'][2] = 'unique:department,name,' . $this->department->id . ',id,deleted_at,NULL';
		}
		return $rules;
	}
}
