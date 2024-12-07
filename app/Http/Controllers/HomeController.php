<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Task;
use App\Models\HourManagement;
use App\Models\WorkLog;
use Illuminate\Support\Facades\Auth;
use Session;
use Stevebauman\Location\Facades\Location;
use DB;
use App\Models\Holiday;
use App\Models\Leave_management;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $today = date('Y-m-d');
        $breadcrumb[0]['name'] = 'Dashboard';
        $breadcrumb[0]['url'] = url('Dashboard');
        $breadcrumb[0]['editname'] = 'Dashboard';
        $breadcrumb[1]['name'] = 'Dashboard';
        $breadcrumb[1]['url'] = '';

        if (auth()->user()->role == "Super Admin") {
            $data = "Welcome Super Admin";
            $attendance = Attendance::where('emp_id', $user->id)->whereDate('DateTimePunchedIn', '=', $today)->first();
            $attend = Attendance::all();
        } else {
            $data = "Welcome User";
            $attendance = Attendance::where('emp_id', $user->id)->whereDate('DateTimePunchedIn', '=', $today)->first();
            $attend = Attendance::where('emp_id', $user->id)->get();
        }
        $employee = Employee::where('user_id', $user->id)->first();
        $currentMonth = date('m');
        $present_days = DB::table("attendance")->whereRaw('MONTH(DateTimePunchedIn) = ?',[$currentMonth])->where('emp_id',$user->id)->get();
        $presentCount = $present_days->count();
        $leave_days = DB::table("leave_management")->whereRaw('MONTH(from_date) = ?',[$currentMonth])->where('employee_id',$user->id)->where('type',3)->get();
        $leaveCount = $leave_days->count();
        $working_hours = HourManagement::where('id', 1)->first();
        if (isset($employee->employee_type) == 1) {
            $working_hour = $working_hours?$working_hours->fulltime_hours:0;
        } elseif (isset($employee->employee_type) == 2) {
            $working_hour = $working_hours?$working_hours->parttime_hours:0;
        } elseif (isset($employee->employee_type) == 3) {
            $working_hour = $working_hours?$working_hours->halftime_hours:0;
        } else {
            $working_hour = "";
        }

        $expiryProject = [];
        $endDate = date('Y-m-d', strtotime(' + 5 days'));

        if (auth()->user()->role == "Super Admin") {
            $expiryProject = Project::where('end_date','>=',date('Y-m-d'))->where('end_date','<=',$endDate)->get();
        } else {
            $userId = Auth::user()->id;
            $expiryProject = Project::where('team_members','like','%"'.$userId.'"%')->where('end_date','>=',date('Y-m-d'))->where('end_date','<=',$endDate)->get();
        }

        $expiryTask = [];
        if (auth()->user()->role == "Super Admin") {
            $expiryTask = Task::where('end_date','>=',date('Y-m-d'))->where('end_date','<=',$endDate)->get();
        } else {
            $userId = Auth::user()->id;
            $expiryTask = Task::where('team_members','like','%"'.$userId.'"%')->where('end_date','>=',date('Y-m-d'))->where('end_date','<=',$endDate)->get();
        }

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

        return view('home', compact(['breadcrumb', 'data', 'attendance','working_hour','attend','expiryProject','expiryTask','presentCount','leaveCount','c_holiday','o_holiday','applied_leave','leave']));
    }
    public function getWorkLogData(){
        $projects = Project::where('status','active')->get();
        $workLog = [];
        foreach($projects as $key => $prj){
            $workLog['label'][$key] = ucfirst($prj->project_name);
            $workLog['value'][$key] = WorkLog::where('project_id',$prj->id)->count();
        }
        return response()->json([
            'worklog' => $workLog
        ]);
    }
    public function attendance_insert(Request $request)
    {
        //$ip = '162.159.24.227';
        $ip = $request->ip();
        $browser = $_SERVER['HTTP_USER_AGENT'];
        $currentUserInfo = Location::get($ip);
        if ($currentUserInfo) {
            date_default_timezone_set($currentUserInfo->timezone);
            $date = date('Y-m-d H:i:s');
            $location = $currentUserInfo->cityName . ', ' . $currentUserInfo->regionName . ', ' . $currentUserInfo->countryName . '.';
        } else {
            date_default_timezone_set('Asia/Kolkata');
            $date = date('Y-m-d H:i:s');
            $location = '';
        }
        $user = Auth::user();
        $data = array(
            'emp_id' => $user->id,
            'DateTimePunchedIn' => $date,
            'ip_address' => $ip,
            'browser' => $browser,
            'location' => $location,
            'emoji_id' => $request->emoji_id,
        );

        $store = Attendance::create($data);
        if ($store) {
            Session::flash('success', 'Punch in successfully!');
            $succsess = "success";
        } else {
            Session::flash('danger', 'Something went worng! Please contact to administrator');
            $succsess = "fail";
        }
        return redirect()->back()->with('msg', $succsess);
        //return redirect()->route('admin.dashboard');
    }
    public function attendance_out_insert(Request $request,$id)
    {
        $ip = $request->ip();
        $currentUserInfo = Location::get($ip);
        if ($currentUserInfo) {
            date_default_timezone_set($currentUserInfo->timezone);
            $date = date('Y-m-d H:i:s');
        } else {
            date_default_timezone_set('Asia/Kolkata');
            $date = date('Y-m-d H:i:s');
        }
        $data = array(
            'DateTimePunchedOut' => $date,
        );
        $store = Attendance::where('id', $id)->update($data);
        if ($store) {
            Session::flash('success', 'Punch Out successfully!');
            $succsess = "success";
        } else {
            Session::flash('danger', 'Something went worng! Please contact to administrator');
            $succsess = "fail";
        }
        return redirect()->back()->with('msg', $succsess);
        //return redirect()->route('admin.dashboard');
    }
}
