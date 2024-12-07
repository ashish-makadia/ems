<?php

namespace App\Http\Controllers;

use App\Authorizable;
use App\Models\Department;
use App\Models\Designation;
use App\Services\DepartmentServices;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Http\Request;

class DepartmentController extends Controller {
	use Authorizable;
	protected $departmentServices;
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function __construct() {
		$this->departmentServices = new DepartmentServices;
		$this->middleware('auth');
	}

	public function index(Request $request) {
		$breadcrumb[0]['name'] = 'department';
		$breadcrumb[0]['url'] = url('department');
		$breadcrumb[1]['name'] =  "Department Listing";
		$breadcrumb[0]['editname'] =  "Edit Department";
		$breadcrumb[1]['url'] = '';

		if ($request->ajax()) {
			return json_encode($this->departmentServices->getDatatable($request));
		}

		return view('department.index', compact(['breadcrumb']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$data['view'] = view('department.create')->render();
		return response()->json($data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(DepartmentRequest $request) {
		return $this->departmentServices->createDepartments($request);
	}

	public function show(Department $department) {
		return back();
	}

	public function edit(Department $department) {
		$data['view'] = view('department.create', compact('department'))->render();
		return response()->json($data);
	}

	public function update(DepartmentRequest $request, Department $department) {
		return $this->departmentServices->updateDepartment($department, $request);
	}
	public function destroy(Department $department) {
		return $this->departmentServices->deleteDepartment($department);
	}
    public function updatestatus($id) {
        $message["success"] = "Department Status Changed Successfully";
        $message["error"] =  "Department Status Update Failed";
        return changeStatus(Department::class,$message,$id);
    }
	public function get_designation_list(Request $request){
		$designations = Designation::select('id','name')->where('department_id',$request->department_id)->get();
        return response()->json($designations);
	}

	public function insert_new(Request $request){
		return $this->departmentServices->CheckDepartment($request);
	}
}
