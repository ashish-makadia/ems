<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Holiday;
use App\Models\Leave_management;
use App\Services\AttendanceServices;
use App\Services\UserServices;
use App\Models\Role;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

use App\Models\LogActivity as LogActivityModel;

class AttendanceController extends Controller
{
    protected $attendanceServices,$userServices,$userRepository;
    public function __construct() {
        $this->attendanceServices = new AttendanceServices;
        $this->userServices = new UserServices;
        $this->userRepository = new UserRepository;
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $breadcrumb[0]['name'] = 'attendancedata';
        $breadcrumb[0]['url'] = url('attendance');
        $breadcrumb[1]['name'] =  "Attendance Listing";
        $breadcrumb[1]['datatable'] = 'AttendanceListing';
        $breadcrumb[0]['editname'] =  "Edit Attendance";
        $breadcrumb[1]['url'] = '';

        if ($request->ajax()) {
            return json_encode($this->attendanceServices->getDatatable($request));
        }

        return view('attendance.index', compact(['breadcrumb']));
    }
    public function attendance_report(Request $request)
	{
        $breadcrumb[0]['name'] = 'attendancedata';
        $breadcrumb[0]['url'] = url('attendance');
        $breadcrumb[1]['name'] =  "Attendance Report";
        $breadcrumb[1]['datatable'] = 'AttendanceReport';
        $breadcrumb[0]['editname'] =  "Edit AttendanceReport";
        $breadcrumb[1]['url'] = '';
        $users = User::get();
		return view('attendance.attendance_report', compact('users','breadcrumb'));
	}
    public function report(Request $request) {
		$json = array();

			if (isset($request->search['value'])) {
				$sql = Attendance::select('attendance.*', 'users.name as username')->leftjoin('users', 'users.id', '=', 'attendance.emp_id')->where(function ($query) use ($request) {
					$query->where('location', 'like', '%' . $request->search['value'] . '%')
						->orWhere('ip_address', 'like', '%' . $request->search['value'] . '%')
						->orWhere('users.name', 'like', '%' . $request->search['value'] . '%')
						->orWhere('browser', 'like', '%' . $request->search['value'] . '%');

				})->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			} else {
				$sql = Attendance::select('attendance.*', 'users.name as username')->leftjoin('users', 'users.id', '=', 'attendance.emp_id')->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			}
            if (isset($request->user_id)) {
                $sql->where('emp_id', $request->user_id);
            }
      
            if ($request->fromdate && $request->todate) {
                $date1 = date_create($request->fromdate);
                $from = date_format($date1, "Y-m-d");

                $date2 = date_create($request->todate);
                $to = date_format($date2, "Y-m-d");
                $sql->whereBetween('DateTimePunchedIn', array($from, $to));
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
    public function get_calender(Request $request)
    {
  
        // if($request->ajax()) {
       
        //      $data = Attendance::whereDate('DateTimePunchedIn', '>=', $request->start)
        //                ->get(['id', 'emp_id', 'DateTimePunchedIn', 'DateTimePunchedOut']);
  
        //      return response()->json($data);
        // }
        $breadcrumb[0]['name'] = 'attendancedata';
        $breadcrumb[0]['url'] = url('attendance');
        $breadcrumb[1]['name'] =  "Attendance Calender";
        $breadcrumb[1]['datatable'] = 'AttendanceCalender';
        $breadcrumb[0]['editname'] =  "Edit Calender";
        $breadcrumb[1]['url'] = '';
        $user = Auth::user();
        if (auth()->user()->role == "Super Admin") {
            $attend = Attendance::select('attendance.*', 'users.name as username')->leftjoin('users', 'users.id', '=', 'attendance.emp_id')->get();
            $c_holiday = Holiday::where('type','Compulsory')->get();
            $o_holiday = Holiday::where('type','Optional')->get();
            $applied_leave = Leave_management::select('leave_management.*', 'users.name as username')->leftjoin('users', 'users.id', '=', 'leave_management.employee_id')->where('leave_management.status',"pending")->get();
            $leave = Leave_management::select('leave_management.*', 'users.name as username')->leftjoin('users', 'users.id', '=', 'leave_management.employee_id')->where('leave_management.status', "approved")->get();
        } else {
            $attend = Attendance::where('emp_id', $user->id)->get();
            $c_holiday = Holiday::where('type','Compulsory')->get();
            $o_holiday = Holiday::where('type','Optional')->get();
            $applied_leave = Leave_management::select('leave_management.*', 'users.name as username')->leftjoin('users', 'users.id', '=', 'leave_management.employee_id')->where('leave_management.employee_id',$user->id)->where('leave_management.status',"pending")->get();
            $leave = Leave_management::select('leave_management.*', 'users.name as username')->leftjoin('users', 'users.id', '=', 'leave_management.employee_id')->where('leave_management.employee_id',$user->id)->where('leave_management.status', "approved")->get();
        }
        return view('attendance.fullcalender', compact(['breadcrumb','attend','c_holiday','o_holiday','applied_leave','leave']));
    }
    
}
