<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Project;
use App\Models\WorkLog;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Repositories\WorkLogRepository;
use Illuminate\Support\Facades\Validator;
use App\Models\Task;
use App\Exports\WorkLogReportExport;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public $workLogRepository;
    public function __construct(WorkLogRepository $workLogRepository)
    {
        $this->workLogRepository = $workLogRepository;
        $this->middleware('auth');
    }

    public function workLogReport(Request $request){
        $breadcrumb[0]['name'] = 'worklogreports';
        $breadcrumb[0]['url'] = url('reports/worklog_report');
        $breadcrumb[1]['name'] =  __('messages.worklogreport');

        $breadcrumb[1]['datatable'] = 'Worklog Report';
        $breadcrumb[0]['editname'] =  __('messages.worklogreport');
        $breadcrumb[1]['url'] = '';
        // $employeeArr = Employee::where('status','active')->get()->toArray();
        $employees = User::where("role","Super Admin")->orWhere("role","Employee")->get()->toArray();
        // $employees = array_merge($employeeArr,employees$users);
        if (auth()->user()->role == "Super Admin") {
            $projectList = Project::where('status', 'active')->get();
        } else {
            $employee = Employee::where('user_id',auth()->user()->id)->first();
            @$projectList = Project::where('team_members','like','%"'.$employee->id.'"%')->where('status', 'active')->get();
        }

        if ($request->ajax()) {
             return json_encode($this->projectReporsitory->getDatatable($request));
        }

        return view('reports.worklog_form', compact(['breadcrumb','employees','projectList']));
    }
    public function getWorkLogReport (Request $request){
        if (auth()->user()->role == "Super Admin") {
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required'
            ]);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
        }

        $breadcrumb[0]['name'] = 'worklogreports';
        $breadcrumb[0]['url'] = url('reports/worklog_report');
        $breadcrumb[1]['name'] =  __('messages.worklogreport');
        $breadcrumb[1]['datatable'] = 'Worklog Report';
        $breadcrumb[0]['editname'] =  __('messages.worklogreport');
        $breadcrumb[1]['url'] = '';

        $employees = User::where("role","Super Admin")->orWhere("role","Employee")->get()->toArray();
        // $employees = array_merge($employeeArr,employees$users);
        if (auth()->user()->role == "Super Admin") {
            $projectList = Project::where('status', 'active')->get();
        } else {
            $employee = Employee::where('user_id',auth()->user()->id)->first();
            @$projectList = Project::where('team_members','like','%"'.$employee->id.'"%')->where('status', 'active')->get();
        }

        $employee = "";
        $dayArr = [];
        $employeeReports = [];

        $start_date = date('Y-m-d',strtotime($request->start_date));
        $end_date = date('Y-m-d',strtotime($request->end_date));

        $datetime1 = new DateTime($start_date);
        $datetime2 = new DateTime($end_date);
        $interval = $datetime1->diff($datetime2);

        $month = date('M',strtotime($start_date));
        $monthYear = date('Y-m',strtotime($start_date));
        $days = $interval->format('%a');

        if(auth()->user()->role == "Employee"){
            $userId = auth()->user()->id;
            $users =  User::where("id",$userId)->get();
            $employee = Employee::where('user_id',$userId)->first();
        } else {
            $users =  User::whereIn("id",$request->employee_id)->get();
        }

        foreach ($users as $eKey => $value) {
            $employeeReports[$eKey]['employee_name'] = $value->name;
            $employee = Employee::where('user_id',$value->id)->first();
            $projects = Project::select("*");
                if($request->project_id){
                    $projects = $projects->where('id',$request->project_id);
                }
                // if($value->role == "Employee")
                //     $projects = $projects->where('team_members','like','%"'.$employee->id.'"%')->get();
                // else
                    $projects = $projects->get();

                $reportData = [];
                foreach($projects as $key => $prj) {
                    $start_date = date('Y-m-d',strtotime($request->start_date));
                    $end_date = date('Y-m-d',strtotime($request->end_date));
                    $worklog = WorkLog::select('*');
                    $worklog = $worklog->where(['user_id' => $value->id,'project_id'=> $prj->id])->whereBetween('log_date', [$start_date, $end_date]);
                    if($request->task_id)
                         $worklog->where('task_id', $request->task_id);
                    if($worklog->count()>0){
                        $reportData[ $key ]['project_name'] = $prj->project_name;
                        $reportData[ $key ]['project_id'] = $prj->id;
                        while (strtotime($start_date) <= strtotime($end_date)) {
                            $worklog = WorkLog::select('log_date','id','time_spent');
                            $worklog = $worklog->where(['user_id' => $value->id,'project_id'=> $prj->id,'log_date' => $start_date])->get();

                                $data = [];
                                if(count($worklog) > 0){
                                    $dayArr[$start_date] = $start_date;
                                    $workLogData = $worklog->toArray();
                                    $hours = 0;
                                    foreach ($workLogData as $k => $data) {
                                        $hours += $data['time_spent'];
                                        $data['log_date'] = date('d-m-Y',strtotime($data['log_date']));
                                    }
                                    $data['hour'] = $hours;
                                } else{
                                    $dayArr[$start_date] = $start_date;
                                    $data['log_date'] = date('d-m-Y',strtotime($start_date));
                                    $data['hour'] = '0';
                                }
                                // \Log::info(json_encode($data). " ".$key);
                                $reportData[ $key ]['data'][] = $data;
                                $start_date = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
                        }

                        $tasks = Task::where("project_id",$prj->id);

                        if($request->task_id)
                            $tasks->where('id', $request->task_id);

                            $tasks = $tasks->get();

                        foreach ($tasks as $tKey => $tsk) {
                            $start_date = date('Y-m-d',strtotime($request->start_date));
                            $end_date = date('Y-m-d',strtotime($request->end_date));
                            $worklog = WorkLog::select('*')->where(['user_id' => $value->id,'project_id' => $prj->id,'task_id' => $tsk->id])->whereBetween('log_date', [$start_date, $end_date]);

                            if($worklog->count() > 0){
                                $reportData[ $key ]['task'][$tKey]['task_name'] = $tsk->summry.'-'.$tsk->id;
                                $reportData[ $key ]['task'][$tKey]['comment'] = $tsk->description;

                                $task = [];
                                while (strtotime($start_date) <= strtotime($end_date)) {
                                        $data = [];
                                        $worklog = WorkLog::select('log_date','id','time_spent')->where(['user_id' => $value->id,'project_id' => $prj->id,'task_id' => $tsk->id,'log_date' => $start_date])->get();
                                        $hours = 0;
                                        if(count($worklog) >0){
                                            $dayArr[$start_date] = $start_date;
                                            $workLogData = $worklog->toArray();
                                            foreach ($workLogData as $k => $data) {
                                                $hours += $data['time_spent'];
                                                $data['log_date'] = date('d-m-Y',strtotime($data['log_date']));
                                            }
                                            $data['hour'] = $hours;
                                        } else{
                                            $dayArr[$start_date] = $start_date;
                                            $data['log_date'] = date('d-m-Y',strtotime($start_date));
                                            $data['hour'] = '0';
                                        }

                                        $reportData[ $key ]['task'][$tKey]['days'][] = $data;

                                    $start_date = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
                                }
                            }
                        }
                    }
                    $employeeReports[$eKey]['reportData'] = $reportData;
                }
        }

        $inputData = $request->except('_token');
       return view("reports.worklog_form", compact(['breadcrumb','employeeReports','days','dayArr','month','monthYear','inputData','employees','projectList']));
        // return view('reports.worklog_form', compact(['reportHtml','inputData','employees','projectList','breadcrumb','employees','projectList',]));
    }

    public function getWorkLogExcel(Request $request){
        if (auth()->user()->role == "Super Admin") {
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required'
            ]);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
        }

        $breadcrumb[0]['name'] = 'worklogreports';
        $breadcrumb[0]['url'] = url('reports/worklog_report');
        $breadcrumb[1]['name'] =  __('messages.worklogreport');
        $breadcrumb[1]['datatable'] = 'Worklog Report';
        $breadcrumb[0]['editname'] =  __('messages.worklogreport');
        $breadcrumb[1]['url'] = '';

        $employee = "";
        $dayArr = [];
        $employeeReports = [];

        $start_date = date('Y-m-d',strtotime($request->start_date));
        $end_date = date('Y-m-d',strtotime($request->end_date));

        $datetime1 = new DateTime($start_date);
        $datetime2 = new DateTime($end_date);
        $interval = $datetime1->diff($datetime2);

        $month = date('M',strtotime($start_date));
        $monthYear = date('Y-m',strtotime($start_date));
        $days = $interval->format('%a');

        if(auth()->user()->role == "Employee"){
            $userId = auth()->user()->id;
            $users =  User::where("id",$userId)->get();
            $employee = Employee::where('user_id',$userId)->first();
        } else {
            $users =  User::whereIn("id",$request->employee_id)->get();
        }

        foreach ($users as $eKey => $value) {
            $employeeReports[$eKey]['employee_name'] = $value->name;

            $employee = Employee::where('user_id',$value->id)->first();
            $projects = Project::select("*");
                if($request->project_id){
                    $projects = $projects->where('id',$request->project_id);
                }
                if($value->role == "Employee")
                    $projects = $projects->where('team_members','like','%"'.$employee->id.'"%')->get();
                else
                    $projects = $projects->get();

                $reportData = [];
                foreach($projects as $key => $prj) {
                    $start_date = date('Y-m-d',strtotime($request->start_date));
                    $end_date = date('Y-m-d',strtotime($request->end_date));
                    $worklog = WorkLog::select('*');
                    $worklog = $worklog->where(['user_id' => $value->id,'project_id'=> $prj->id])->whereBetween('log_date', [$start_date, $end_date]);
                    if($request->task_id)
                         $worklog->where('task_id', $request->task_id);
                    if($worklog->count()>0){
                        $reportData[ $key ]['project_name'] = $prj->project_name;
                        $reportData[ $key ]['project_id'] = $prj->id;
                        while (strtotime($start_date) <= strtotime($end_date)) {
                            $worklog = WorkLog::select('log_date','id','time_spent');
                            $worklog = $worklog->where(['user_id' => $value->id,'project_id'=> $prj->id,'log_date' => $start_date])->get();

                                $data = [];
                                if(count($worklog) > 0){
                                    $dayArr[$start_date] = $start_date;
                                    $workLogData = $worklog->toArray();
                                    $hours = 0;
                                    foreach ($workLogData as $k => $data) {
                                        $hours += $data['time_spent'];
                                        $data['log_date'] = date('d-m-Y',strtotime($data['log_date']));
                                    }
                                    $data['hour'] = $hours;
                                } else{
                                    $dayArr[$start_date] = $start_date;
                                    $data['log_date'] = date('d-m-Y',strtotime($start_date));
                                    $data['hour'] = '0';
                                }
                                // \Log::info(json_encode($data). " ".$key);
                                $reportData[ $key ]['data'][] = $data;
                                $start_date = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
                        }

                        $tasks = Task::where("project_id",$prj->id)->get();
                        foreach ($tasks as $tKey => $tsk) {
                            $start_date = date('Y-m-d',strtotime($request->start_date));
                            $end_date = date('Y-m-d',strtotime($request->end_date));
                            $worklog = WorkLog::select('*')->where(['user_id' => $value->id,'project_id' => $prj->id,'task_id' => $tsk->id])->whereBetween('log_date', [$start_date, $end_date])
                            ;

                            if($worklog->count() > 0){
                                $reportData[ $key ]['task'][$tKey]['task_name'] = $tsk->summry.'-'.$tsk->id;
                                $reportData[ $key ]['task'][$tKey]['comment'] = $tsk->description;

                                $task = [];
                                while (strtotime($start_date) <= strtotime($end_date)) {
                                        $data = [];
                                        $worklog = WorkLog::select('log_date','id','time_spent')->where(['user_id' => $value->id,'project_id' => $prj->id,'task_id' => $tsk->id,'log_date' => $start_date])->get();
                                        $hours = 0;
                                        if(count($worklog) >0){
                                            $dayArr[$start_date] = $start_date;
                                            $workLogData = $worklog->toArray();
                                            foreach ($workLogData as $k => $data) {
                                                $hours += $data['time_spent'];
                                                $data['log_date'] = date('d-m-Y',strtotime($data['log_date']));
                                            }
                                            $data['hour'] = $hours;
                                        } else{
                                            $dayArr[$start_date] = $start_date;
                                            $data['log_date'] = date('d-m-Y',strtotime($start_date));
                                            $data['hour'] = '0';
                                        }

                                        $reportData[ $key ]['task'][$tKey]['days'][] = $data;

                                    $start_date = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
                                }
                            }
                        }
                    }
                    $employeeReports[$eKey]['reportData'] = $reportData;
                }
        }

        $employees = User::where("role","Super Admin")->orWhere("role","Employee")->get()->toArray();
        // $employees = array_merge($employeeArr,employees$users);
        if (auth()->user()->role == "Super Admin") {
            $projectList = Project::where('status', 'active')->get();
        } else {
            $employee = Employee::where('user_id',auth()->user()->id)->first();
            @$projectList = Project::where('team_members','like','%"'.$employee->id.'"%')->where('status', 'active')->get();
        }

        $reportHtml = view("reports.reportsHtml", compact(['breadcrumb','employeeReports','days','dayArr','month','monthYear']))->render();
        return view('reports.worklog_form', compact(['reportHtml','employees','projectList','breadcrumb','employees','projectList',]));
    }

    public function checkworklogTime(Request $request){
        $worklog = WorkLog::where('log_date',date('Y-m-d',strtotime($request->log_date)))->whereTime('start_time', '>=', $request->start_time)->orWhereTime('end_time', '<=', $request->end_time)->get();
        return response()->json([
            'worklog' => count($worklog),
            'data' => $worklog
        ]);
    }


}
