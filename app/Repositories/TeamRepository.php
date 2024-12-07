<?php
namespace App\Repositories;
use App\Models\Team;

class TeamRepository {
	// insert new entry
	public function create($request) {
	
		$data = array(
            'name' => $request->name,
            'status' => "active",
        );
		return Team::create($data);
	}

	// update existing data;
	public function update($holiday, $request) {
	
		$data = array(
            'name' => $request->name,
            'status' => $request->status,
        );
		return $holiday->update($data);
	}

	// softdelete existing data;
	public function delete($holiday) {
		if ($holiday->delete()) {
			\LogActivity::addToLog("Team Delete");
			return response()->json(
				[
					'status' => '1',
					'Msg' => "Team Delete Successfully",
				]);
		} else {
			return response()->json(
				[
					'status' => '0',
					'Msg' => "Team Delete Failed",
				]);
		}
	}

	// update status in database
	public function updatestatus($id) {
		$holiday = Team::findOrfail($id);
		\LogActivity::addToLog("Team Status Change");

		if ($holiday->status == 'active') {
			$holiday->status = 'inactive';
		} else {
			$holiday->status = 'active';
		}
		if ($holiday->save()) {
			return response(['status' => '1', 'msg' => "Team Status Changed Successfully"]);
		} else {
			return response(['status' => '0', 'msg' => "Team Status Update Failed"]);
		}
	}
}