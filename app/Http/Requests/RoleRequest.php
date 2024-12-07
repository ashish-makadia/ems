<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest {
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
			'name' => ['required', 'unique:roles,name,NULL,id'],
		];
		if (request()->isMethod('put') || request()->isMethod('PATCH')) {
			$rules['name'][1] = 'unique:roles,name,' . $this->role->id . ',id';
		}
		return $rules;
	}
}
