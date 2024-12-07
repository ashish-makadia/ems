<?php
namespace App\Repositories;
use App\Models\Department;

class TeamLeadRepository {
	// insert new entry
	public function create($request) {
		$employee = Employee::create($request);

		if ($employee) {
			\LogActivity::addToLog(__('messages.employeeinssucc'));
			return response(['status' => '1', 'msg' => __('messages.employeeinssucc')]);
		} else {
			\LogActivity::addToLog(__('messages.employeenotinssucc'));
			return response(['status' => '1', 'msg' => __('messages.employeenotinssucc')]);
		}
	}

	// update existing data;

}
