<?php
namespace App\Repositories;
use App\Models\Holiday;

class HolidayRepository {
	// insert new entry
	public function create($request) {
		//$input = $request->all();
		if($request->to_date == ""){
			$to_date=date("Y-m-d",strtotime($request->from_date));
		}else{
			$to_date= date("Y-m-d",strtotime($request->to_date));
		}
		$data = array(
            'name' => $request->name,
            'from_date' => date("Y-m-d",strtotime($request->from_date)),
            'to_date' => $to_date,
            'type' => $request->type,
            'image' => $request->image,
            'description' => $request->description,
            'status' => "active",
        );
		return Holiday::create($data);
	}

	// update existing data;
	public function update($holiday, $request) {
		if($request->to_date == ""){
			$to_date=date("Y-m-d",strtotime($request->from_date));
		}else{
			$to_date= date("Y-m-d",strtotime($request->to_date));
		}
		$data = array(
            'name' => $request->name,
            'from_date' => date("Y-m-d",strtotime($request->from_date)),
            'to_date' => $to_date,
            'type' => $request->type,
            'image' => $request->image,
            'description' => $request->description,
            'status' => $request->status,
        );
		return $holiday->update($data);
	}

	// softdelete existing data;
	public function delete($holiday) {
		if ($holiday->delete()) {
			\LogActivity::addToLog("Holiday Delete");
			return response()->json(
				[
					'status' => '1',
					'Msg' => "Holiday Delete Successfully",
				]);
		} else {
			return response()->json(
				[
					'status' => '0',
					'Msg' => "Holiday Delete Failed",
				]);
		}
	}

	// update status in database
	public function updatestatus($id) {
		$holiday = Holiday::findOrfail($id);
		\LogActivity::addToLog("Holiday Status Change");

		if ($holiday->status == 'active') {
			$holiday->status = 'inactive';
		} else {
			$holiday->status = 'active';
		}
		if ($holiday->save()) {
			return response(['status' => '1', 'msg' => "Holiday Status Changed Successfully"]);
		} else {
			return response(['status' => '0', 'msg' => "Holiday Status Update Failed"]);
		}
	}
}