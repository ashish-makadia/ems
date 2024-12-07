<?php

namespace App\Http\Controllers;

use App\Authorizable;
use App\Http\Requests\DesignationRequest;
use App\Models\Designation;
use App\Models\Department;
use App\Services\DesignationServices;
use Illuminate\Http\Request;

class DesignationController extends Controller {

	use Authorizable;
	protected $designationsServices;

	public function __construct() {
		$this->designationsServices = new DesignationServices;
		$this->middleware('auth');
	}

	public function index(Request $request) {

		$breadcrumb[0]['name'] = 'designation';
		$breadcrumb[0]['url'] = url('designation');
		$breadcrumb[1]['name'] = "Designation Listing";
		$breadcrumb[0]['editname'] = "Edit Designation";
		$breadcrumb[1]['url'] = '';

		if ($request->ajax()) {
			return json_encode($this->designationsServices->getDatatable($request));
		}

		return view('designation.index', compact(['breadcrumb']));
	}


	public function create() {

		$department = Department::where('status','Active')->pluck('name', 'id');
		$data['view'] = view('designation.create', compact('department'))->render();
		return response()->json($data);
	}


	public function store(DesignationRequest $request) {
		return $this->designationsServices->createdesignations($request);
	}


	public function show(designations $designation) {
		return back();
	}

	public function edit(Designation $designation) {
		$department = Department::where('status','Active')->pluck('name', 'id');
		$data['view'] = view('designation.create', compact('designation', 'department'))->render();
		return response()->json($data);
	}


	public function update(DesignationRequest $request, Designation $designation) {
		return $this->designationsServices->updatedesignations($designation, $request);
	}

	public function destroy(Designation $designation) {
		return $this->designationsServices->deletedesignations($designation);
	}

	public function updatestatus($id) {
        $message["success"] = "Designation Status Changed Successfully";
        $message["error"] =  "Designation Status Update Failed";
        return changeStatus(Designation::class,$message,$id);
    }
	public function insert_new(Request $request)
    {
        $name = $request->name;
        $department_id = $request->department_id;
        $designations = Designation::where('name',$request->name)->get();
        if(count($designations) > 0){
          $get_designation = Designation::select('id','name')->where('department_id',$department_id)->get();
          return response()->json(array("designation"=>$get_designation,"name"=>$name));
        }else{
          $designations_insert = new designations([
            'department_id' => $department_id,
            'name' => $request->name,
          ]);
          $designations_insert->save();
          $get_designation = Designation::select('id','name')->where('department_id',$department_id)->get();
          return response()->json(array("designation"=>$get_designation,"name"=>$name));
        }
    }
}
