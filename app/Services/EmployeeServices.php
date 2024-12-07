<?php

namespace App\Services;
use App\Models\Employee;
use App\Repositories\EmployeeRepository;
use Auth;

use App\Models\LogActivity as LogActivityModel;
class EmployeeServices {
	protected $userRepository;

	public function __construct() {
		$this->employeeRepository = new EmployeeRepository;
	}

	// show datatable
	public function getDatatable(object $request) {
		$json = array();

			if (isset($request->search['value'])) {
				$sql = Employee::with('designation')->where(function ($query) use ($request) {
					$query->where('name', 'like', '%' . $request->search['value'] . '%')
						->orWhere('email', 'like', '%' . $request->search['value'] . '%')
						->orWhere('phone', 'like', '%' . $request->search['value'] . '%')
						->orWhere('status', 'like', '%' . $request->search['value'] . '%');

				})->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			} else {
				$sql = Employee::with('designation')->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			}

        // if($request->designation){
        //    $empIds =  getLeaderEmployeeIds();
        // //    if(!empty($empIds))
        //     $sql = $sql->whereIn('id', $empIds);
        // }

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
	public function createEmployee($request) {
		return $this->employeeRepository->create($request);
	}

	// update existing data;
	public function updateEmployee($employee, $request) {
		return $this->employeeRepository->update($employee, $request);
	}

	// softdelete existing data;
	public function deleteEmployee($employee) {
		return $this->employeeRepository->delete($employee);
	}

	// update status
	public function updatestatus($id) {
		return $this->employeeRepository->updatestatus($id);
	}
}
