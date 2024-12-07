<?php

namespace App\Services;
use App\Models\Department;
use App\Repositories\DepartmentRepository;

class DepartmentServices {

	protected $departmentRepository;

	public function __construct() {
		$this->departmentRepository = new DepartmentRepository;
	}

	// show datatable
	public function getDatatable(object $request) {
		$json = array();

		$sql = Department::where(function ($query) use ($request) {
			$query->where('name', 'like', '%' . $request->search['value'] . '%')
				->orWhere('status', 'like', '%' . $request->search['value'] . '%');

		})->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
		$recordsTotal = $sql->count();
		$data = $sql->limit($request->length)->skip($request->start)->get();
		$recordsFiltered = count($data);

		$json['data'] = $data;
		$json['draw'] = $request->draw;
		$json['recordsTotal'] = $recordsFiltered;
		$json['recordsFiltered'] = $recordsTotal;

		return $json;
	}

	// insert new entry
	public function createDepartments($request) {

		if ($this->departmentRepository->create($request)) {
			\LogActivity::addToLog("Department Insert Successfull");
			return response(['status' => '1', 'msg' => "Department Insert Successfull"]);
		} else {
			\LogActivity::addToLog("Department Insert Failed");
			return response(['status' => '0', 'msg' => "Department Insert Failed"]);
		}
	}

	// update existing data;
	public function updateDepartment($department, $request) {
		$request['status'] = isset($request['status']) ? 'Active' : 'Inactive';
		if ($this->departmentRepository->update($department, $request)) {
			\LogActivity::addToLog("Department Update Successfull");
			return response(['status' => '1', 'msg' => "Department Update Successfull"]);
		} else {
			\LogActivity::addToLog("Department Update Failed");
			return response(['status' => '0', 'msg' => "Department Update Failed"]);
		}
	}

	// softdelete existing data;
	public function deleteDepartment($department) {
		return $this->departmentRepository->delete($department);
	}

	// update status
	public function updatestatus($id) {
		return $this->departmentRepository->updatestatus($id);
	}

	public function CheckDepartment($request){
		$name = $request->department_name;
		echo $name;
	}
}
