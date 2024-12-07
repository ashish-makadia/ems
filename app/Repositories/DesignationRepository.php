<?php
namespace App\Repositories;
use App\Models\Designation;
use App\Models\Department;

class DesignationRepository {
	// insert new entry
	public function create($request) {
		$input = $request->all();
		$input['created_by'] = auth()->user()->id;
        \LogActivity::addToLog("Designation Created Successfully");
		return Designation::create($input);

	}

	// update existing data;
	public function update($designation, $request) {
		return $designation->update($request->all());
	}

	// softdelete existing data;
	public function delete($designation) {
		if ($designation->delete()) {
			\LogActivity::addToLog("Designation Deleted Successfully");
			return response()->json(
				[
					'status' => '1',
					'Msg' => "Designation Deleted Successfully",
				]);
		} else {
			\LogActivity::addToLog("Designation Delete Failed");
			return response()->json(
				[
					'status' => '0',
					'Msg' => "Designation Delete Failed",
				]);
		}
	}

	public function insert($request) {
		$name = $request->name;
        $department_id = $request->department_id;
        $designations = Designation::where('name',$request->name)->get();
        if(count($designations) > 0){
          $get_designation = Designation::select('id','name')->where('department_id',$department_id)->get();
          return response()->json(array("designation"=>$get_designation,"name"=>$name));
        }else{
          $designations_insert = new Designation([
            'department_id' => $department_id,
            'name' => $request->name
          ]);
          $designations_insert->save();
          $get_designation = Designation::select('id','name')->where('department_id',$department_id)->get();
          return response()->json(array("designation"=>$get_designation,"name"=>$name));
        }
	}
}
