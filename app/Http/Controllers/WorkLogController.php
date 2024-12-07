<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Models\Employee;
use App\Models\WorkLog;
use Illuminate\Support\Facades\Validator;
use App\Repositories\WorkLogRepository;
use Illuminate\Support\Facades\Auth;

class WorkLogController extends Controller
{
    public $workLogRepository;
    public function __construct(WorkLogRepository $workLogRepository)
    {
        $this->workLogRepository = $workLogRepository;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $breadcrumb[0]['name'] = 'worklog';
        $breadcrumb[0]['url'] = url('work_log');
        $breadcrumb[1]['name'] =  __('messages.workloglisting');
        $breadcrumb[1]['datatable'] = 'WorkLogListing';
        $breadcrumb[0]['editname'] =  __('messages.editworklog');
        $breadcrumb[1]['url'] = '';

        if ($request->ajax()) {
            return json_encode($this->workLogRepository->getDatatable($request));
        }
        return view('work_log.index', compact(['breadcrumb']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['view'] = view('work_log.create')->render();
		return response()->json($data);

        // $employees = Employee::where('status', 'active')->get();
        // return view('work_log.create', compact('employees'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'project_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        $inputData = $request->except('_token','set_to_time','reduced_by_time');

        $time_spent = WorkLog::where('task_id',$request->task_id)->sum('time_spent');

        $task = Task::find($request->task_id);
        $remaining_estimate = (float)$task->estimate_hour - ((float)$time_spent+(float)$request->time_spent);

        $task->update(['remaining_estimate_time' => $remaining_estimate]);

        $inputData['project_id']  = $task->project_id;
        $employee = Employee::where('user_id',Auth::user()->id)->first();
        $inputData['employee_id']  = $employee->id??0;
        $inputData['user_id']  = Auth::user()->id;

        $inputData['log_date'] = $request->log_date != ""?date("Y-m-d", strtotime($request->log_date)):null;
        $workLog = WorkLog::where(['task_id' => $request->task_id,'log_date'=>$inputData['log_date']])->first();
        $inputData['time_spent']  = (@$workLog->time_spent+(float)$request->time_spent);

        $inputData['status'] = 'Active';
        // dd($inputData);
        return $this->workLogRepository->create($inputData);
    }
     public function edit(WorkLog $work_log)
    {
        // $project = Project::where('team_members','like','%"'.$work_log->employee_id.'"%')->where(['status'=> 'active'])->get();

        // $a = 0;
        // $tasks = [];
        // foreach($project as $key => $prj){
        //     $task =  Task::where('status', 'active')->where('project_id',$prj->id)->get();
        //     foreach($task as $tsk){
        //         $tasks[$a]['id'] = $tsk->id;
        //         $tasks[$a]['task_title'] = $tsk->task_title;
        //         $a++;
        //     }
        // }

        // $employees = Employee::where('status', 'active')->get();

        // return view('work_log.edit', compact('project', 'tasks','employees','work_log'));

        $data['view'] = view('work_log.create',compact('work_log'))->render();
		return response()->json($data);
    }

     public function update(Request $request, $id)
    {
             $validator = Validator::make($request->all(), [
            // 'project_id' => 'required'
            ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $inputData = $request->except('_token','_method','set_to_time','reduced_by_time');
        $time_spent = WorkLog::where('task_id',$request->task_id)->where('id','!=',$id)->sum('time_spent');
        $task = Task::find($request->task_id);
        $remaining_estimate = (float)$task->estimate_hour - ($time_spent+(float)$request->time_spent);
        $remaining_estimate = $remaining_estimate>0?$remaining_estimate:0;
        $task->update(['remaining_estimate_time' => $remaining_estimate]);

        $inputData['project_id']  = $task->project_id;
        $employee = Employee::where('user_id',Auth::user()->id)->first();
        $inputData['employee_id']  = $employee->id??0;
        $inputData['log_date'] = $request->log_date != ""?date("Y-m-d", strtotime($request->log_date)):null;
        $inputData['status'] = 'Active';

        return $this->workLogRepository->update($id, $inputData);
    }

     public function destroy($id)
    {
        $worklog = Worklog::find($id);
        $task = Task::find($worklog->task_id);
        $totalEstimateTime = $task->remaining_estimate_time +  $worklog->time_spent;
        $task->update([
            'remaining_estimate_time' => $totalEstimateTime
        ]);
        return $this->workLogRepository->delete($id);
    }
    public function checkTimeSpent(Request $request){
        $task = Task::find($request->task_id);
        $status = true;
        if((float)$task->estimate_hour < (float)$request->time_spent){
            $status = false;
        }
        return response()->json($status);
    }
    public function updatestatus($id) {
        $message["success"] =  __('messages.worklogstasucs');
        $message["error"] =  __('messages.worklogtafail');
        return changeStatus(WorkLog::class,$message,$id);
    }


}
