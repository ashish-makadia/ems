<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskServices;
use App\Models\Task;
use App\Models\Project;
use App\Models\Employee;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use App\Repositories\TaskRepository;
use App\Models\WorkLog;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $taskReporsitory;
    public function __construct(TaskRepository $taskReporsitory)
    {
        $this->taskReporsitory = $taskReporsitory;
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $breadcrumb[0]['name'] = 'worklog';
        $breadcrumb[0]['url'] = url('task');
        $breadcrumb[0]['worklog_name'] = 'worklog';
        $breadcrumb[0]['worklog_url'] = url('worklog');
        $breadcrumb[1]['name'] =  __('messages.tasklisting');
        $breadcrumb[1]['datatable'] = 'TaskListing';
        $breadcrumb[0]['editname'] =  __('messages.edittask');
        $breadcrumb[1]['url'] = '';

        if ($request->ajax()) {
            return json_encode($this->taskReporsitory->getDatatable($request));
        }
        $employees = Employee::where('status','active')->get();
        $projects = Project::where('status', 'active')->get();
        return view('task.index', compact(['breadcrumb','projects','employees']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee = Employee::where('user_id',Auth::user()->id)->first();
        $projects = Project::where('status', 'active');
        if(Auth::user()->role == "Employee"){
            $projects = $projects->where('team_members','like','%"'.$employee->id.'"%');
        }
        $projects = $projects->get();
        $tasktype = Config::get("tasktype.type");
        // dd($tasktype); exit;
        $employees = Employee::where('status', 'active')->get();
        return view('task.create', compact('projects', 'tasktype', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required',
            // 'team_members' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $inputData = $request->except('_token');
        $inputData['remaining_estimate_time'] = $request->estimate_hour;
        if ($request->team_members) {
            $inputData['team_members'] = json_encode($request->team_members);
        } else {
            $employee =   Employee::where('user_id',Auth::user()->id)->first();
            $inputData['team_members'] = '["'.$employee->id.'"]';

            // $inputData['team_members'] = json_encode($team_members);
        }

        $inputData['status'] = 'Active';
        $res = $this->taskReporsitory->create($inputData);

        return $res;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $employee = Employee::where('user_id',Auth::user()->id)->first();
        $projects = Project::where('status', 'active');
        if(Auth::user()->role == "Employee"){
            $projects = $projects->where('team_members','like','%"'.$employee->id.'"%');
        }
        $projects = $projects->get();

        $project = Project::find($task->project_id);
        $empIds = json_decode($project->team_members);

        $employees = Employee::whereIn('id',$empIds)->get();

        $tasktype = Config::get("tasktype.type");

        $team_members = [];

        if (!empty($task->team_members))
            $team_members = json_decode($task->team_members);

        return view('task.edit', compact('projects', 'task', 'tasktype', 'employees', 'team_members'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required',
            // 'team_members' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $inputData = $request->except('_token', '_method');
        $inputData['start_date'] = date("Y-m-d", strtotime($request->start_date));
        $inputData['end_date'] = date("Y-m-d", strtotime($request->end_date));

        if ($request->team_members) {
            $inputData['team_members'] = json_encode($request->team_members);
        }
        $time_spent = WorkLog::where('task_id',$id)->sum('time_spent');

        $inputData['remaining_estimate_time'] = $request->estimate_hour - $time_spent;
        $inputData['status'] = 'Active';
        return $this->taskReporsitory->update($id, $inputData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->taskReporsitory->delete($id);
    }

    public function updatestatus($id) {
        $message["success"] =  __('messages.taskstasucs');
        $message["error"] =  __('messages.tasktafail');
        return changeStatus(Task::class,$message,$id);
    }

    public function addTaskWorkLog($id){
        $task = Task::find($id);
        $project = Project::where(['status' => 'active','id'=>$task->project_id])->get();
        $employees = Employee::where('user_id',Auth::user()->id)->get();
        $tasks = Task::where('id',$id)->get();
        $team_members = json_decode($task->team_members);
        return view('work_log.create', compact('project', 'tasks','employees','task','team_members'));
    }

}
