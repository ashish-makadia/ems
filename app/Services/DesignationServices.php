<?php

namespace App\Services;

use App\Models\Designation;
use App\Repositories\DesignationRepository;

class DesignationServices
{
	protected $designationsRepository;

	public function __construct()
	{
		$this->designationsRepository = new DesignationRepository;
	}

	// show datatable
	public function getDatatable(object $request)
	{
		$json = array();


		$sql = Designation::select('department.name as department_name', 'designation.*')->leftjoin('department', 'department.id', '=', 'designation.department_id')->where(function ($query) use ($request) {
			$query->where('department.name', 'like', '%' . $request->search['value'] . '%')
				->orWhere('designation.name', 'like', '%' . $request->search['value'] . '%')
				->orWhere('designation.status', 'like', '%' . $request->search['value'] . '%');
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
	public function createdesignations($request)
	{
		if ($this->designationsRepository->create($request)) {
			\LogActivity::addToLog("Designation Inserted Successfully");
			return response(['status' => '1', 'msg' => "Designation Inserted Successfully"]);
		} else {
			\LogActivity::addToLog("Designation Insert Failed");
			return response(['status' => '0', 'msg' => "Designation Insert Failed"]);
		}
	}

	// update existing data;
	public function updatedesignations($designation, $request)
	{
		$request['updated_by'] = auth()->user()->id;
		$request['status'] = isset($request['status']) ? 'Active' : 'Inactive';

		if ($this->designationsRepository->update($designation, $request)) {
			\LogActivity::addToLog("Designation Updated Successfully");
			return response(['status' => '1', 'msg' => "Designation Updated Successfully"]);
		} else {
			\LogActivity::addToLog("Designation Update Failed");
			return response(['status' => '0', 'msg' => "Designation Update Failed"]);
		}
	}

	// softdelete existing data;
	public function deletedesignations($designation)
	{
		return $this->designationsRepository->delete($designation);
	}

	// update status
	public function updatestatus($id)
	{
		return $this->designationsRepository->updatestatus($id);
	}

	public function insert($request)
	{
		return $this->designationsRepository->insert($request);
	}
}
