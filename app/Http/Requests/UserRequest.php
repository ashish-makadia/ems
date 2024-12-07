<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UserRequest extends FormRequest {
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
		if (request()->isMethod('put') || request()->isMethod('PATCH')) {
			return [ 			
				'name' => 'required',
				'email' => 'required|email|unique:users,email,'.$this->user->id,
				'mobile_no' => 'required|numeric|digits_between:5,10||unique:users,mobile_no,'.$this->user->id,
				'role' => 'required|numeric|exists:roles,id'
			];
		}
		if(Auth::user()->role == 'Super Admin'){
			$rules = [
			'name' => ['required'],
			'email' => ['required', 'email', 'unique:users,email'],
			'mobile_no' => ['required', 'numeric', 'digits_between:5,10', 'unique:users,mobile_no'],
			'role' => ['required', 'numeric', 'exists:roles,id'],
			'password' => ['required', 'min:8'],
		];
		}else{
			$rules = [
				'name' => ['required'],
				'email' => ['required', 'email', 'unique:users,email'],
				'mobile_no' => ['required', 'numeric', 'digits_between:5,10', 'unique:users,mobile_no'],
			];
		}
		return $rules;
	}
}
