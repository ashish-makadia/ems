<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest {
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
			'name' => ['required', '', 'unique:categories,name,NULL,id'],
		];
		if (request()->isMethod('put') || request()->isMethod('PATCH')) {
			//$rules['name'] = 'unique:categories,name,' . $this->categories->id . ',id';
			$rules['name'][2] = 'unique:department,name,' . $this->category->id . ',id,deleted_at,NULL';
		}
		return $rules;
	}
}
