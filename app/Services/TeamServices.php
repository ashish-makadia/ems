<?php

namespace App\Services;
use App\Models\Team;
use App\Repositories\TeamRepository;

class TeamServices {

	protected $teamRepository;

	public function __construct() {
		$this->teamRepository = new TeamRepository;
	}

	// show datatable
	public function getDatatable(object $request) {
		$json = array();

		$sql = Team::where(function ($query) use ($request) {
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
	public function createTeam($request) {
		if ($this->teamRepository->create($request)) {
			\LogActivity::addToLog("Team Insert Successfull");
			return response(['status' => '1', 'msg' => "Team Insert Successfull"]);
		} else {
			\LogActivity::addToLog("Team Insert Failed");
			return response(['status' => '0', 'msg' => "Team Insert Failed"]);
		}
	}

	// update existing data;
	public function updateTeam($team, $request) {
		$request['status'] = isset($request['status']) ? 'Active' : 'Inactive';
		if ($this->teamRepository->update($team, $request)) {
			\LogActivity::addToLog("Team Update Successfull");
			return response(['status' => '1', 'msg' => "Team Update Successfull"]);
		} else {
			\LogActivity::addToLog("Team Update Failed");
			return response(['status' => '0', 'msg' => "Team Update Failed"]);
		}
	}

	// softdelete existing data;
	public function deleteTeam($team) {
		return $this->teamRepository->delete($team);
	}

	// update status
	public function updatestatus($id) {
		return $this->teamRepository->updatestatus($id);
	}

	public function CheckTeam($request){
		$name = $request->name;
		echo $name;
	}
}