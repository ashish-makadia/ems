<?php

namespace App\Services;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Auth;

class TaskServices {
	protected $taskRepository;

	public function __construct() {
		$this->taskRepository = new TaskRepository;
	}

	// show datatable
	public function getDatatable(object $request) {
		$json = array();

			if (isset($request->search['value'])) {
				$sql = Task::where(function ($query) use ($request) {
					$query->where('project', 'like', '%' . $request->search['value'] . '%')
						->orWhere('tasktype', 'like', '%' . $request->search['value'] . '%');

				})->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			} else {
				$sql = Employee::orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			}

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
	public function createTask($request) {
		return $this->taskRepository->create($request);
	}

	// update existing data;
	public function updateEmployee($employee, $request) {
		return $this->taskRepository->update($employee, $request);
	}

	// softdelete existing data;
	public function deleteEmployee($employee) {
		return $this->taskRepository->delete($employee);
	}

	// update status
	public function updatestatus($id) {
		return $this->taskRepository->updatestatus($id);
	}
}
