<?php
namespace App\Repositories;
use App\Models\Department;

class DepartmentRepository {
	// insert new entry
	public function create($request) {
		$input = $request->all();
		$input['created_by'] = auth()->user()->id;
        \LogActivity::addToLog("Department Created Successfully");
		return Department::create($input);
	}

	// update existing data;
	public function update($department, $request) {
		return $department->update($request->all());
	}

	// softdelete existing data;
	public function delete($department) {
		if ($department->delete()) {
			\LogActivity::addToLog("Department Delete");
			return response()->json(
				[
					'status' => '1',
					'Msg' => "Department Delete Successfully",
				]);
		} else {
			return response()->json(
				[
					'status' => '0',
					'Msg' => "Department Delete Failed",
				]);
		}
	}
}
