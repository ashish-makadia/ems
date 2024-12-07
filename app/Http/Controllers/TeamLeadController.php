<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
class TeamLeadController extends Controller
{

    public function index(Request $request) {
		$breadcrumb[0]['name'] = 'TeamLead';
		$breadcrumb[0]['url'] = url('team-lead');
		$breadcrumb[1]['name'] =  "Team Leader Listing";
		$breadcrumb[0]['editname'] =  "Edit Team Lead";
		$breadcrumb[1]['url'] = '';

        if($request->ajax()) {
            return json_encode($this->employeeServices->getDatatable($request));
        }
		return view('team_lead.index', compact(['breadcrumb']));
	}
    public function create() {
        $designations = config('projectstatus.designation');

        $employees = Employee::where('status',1)->get();
		$data['view'] = view('team_lead.create', compact('designations','employees'))->render();
		return response()->json($data);
	}
    public function store(Request $request) {
        $employee_id = $request->employee_id;
        $employee = Employee::find($employee_id);
        $desigArr =  json_decode($employee->designation_id);

        if(is_array($desigArr) && !in_array($request->designation_id,$desigArr)){
            $desigArr[] = $request->designation_id;

            $employee->update(['designation_id' => $desigArr]);
        }
        $message = "Assign Member Successfully !!";
        session()->flash('success', $message);
        return response()->json([
            'status' => true,
            'msg' => $message
        ]);

    }
    public function edit(Employee $employee) {
        $designations = config('projectstatus.designation');

        $employees = Employee::where('status',1)->get();
        $empDesig = json_decode($employee->designation_id);

		$data['view'] = view('team_lead.create', compact('designations','employees','empDesig','employee'))->render();
		return response()->json($data);
	}
}
