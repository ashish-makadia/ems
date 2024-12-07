<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProjectRepository;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectAttachment;
use App\Models\Task;
use App\Models\TemplateType;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public $projectReporsitory;
    public function __construct(ProjectRepository $projectReporsitory) {
        $this->projectReporsitory = $projectReporsitory;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $breadcrumb[0]['name'] = 'projectdata';
        $breadcrumb[0]['url'] = url('project');
        $breadcrumb[1]['name'] =  __('messages.projectlisting');
        $breadcrumb[1]['datatable'] = 'ProjectListing';
        $breadcrumb[0]['editname'] =  __('messages.editproject');
        $breadcrumb[1]['url'] = '';

        if ($request->ajax()) {
             return json_encode($this->projectReporsitory->getDatatable($request));
        }

        $employees = Employee::where('status','active')->get();
        return view('project.index', compact(['breadcrumb','employees']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::where('status','active')->get();

        $projectStatus = Config::get("projectstatus.status");
        return view('project.create', compact('employees','projectStatus'));
    }

    public function getProjectTask (Request $request){
        $project_id = $request->project_id;
        $task = Task::where('project_id',$project_id)->get();
        return response()->json([
            'status' => true,
            'task' => $task
        ]);
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
            // 'project_name' => 'required',
            // 'start_date' => 'required',
            // 'end_date' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $inputData = $request->except('_token');
        if($request->start_date){
            $inputData['start_date'] = date("Y-m-d",strtotime($request->start_date));
        }else{
            $inputData['start_date'] = NULL;
        }
        if($request->end_date){
            $inputData['end_date'] = date("Y-m-d",strtotime($request->end_date));
        }else{
            $inputData['end_date'] = NULL;
        }
        if($request->team_members){
            $inputData['team_members'] = json_encode($request->team_members);
        }
        // if($request->has('attachment')){
        //     $imageName = time().'.'.$request->attachment->getClientOriginalName();
        //      // //Store in Storage Folder
        //     $request->attachment->storeAs('projects', $imageName);
        //     $inputData['attachment'] = $imageName;
        // }
        $inputData['status'] = 'Active';
        return $this->projectReporsitory->create($inputData);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::with(['task','projectattachment'])->find($id);
        $projects=Project::get();
        // dd($projects);
        return view('project.projectDetail', compact(['project','projects']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $projectStatus = Config::get("projectstatus.status");
        $employees=Employee::get();

        $team_members = [];
        if(!empty($project->team_members))
            $team_members = json_decode($project->team_members);

        return view('project.edit',compact('project','employees','projectStatus','team_members'));
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
            'project_name' => 'required',
            // 'team_members' => 'required',
       //  'start_date' => 'required',
          //  'end_date' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $inputData = $request->except('_token','_method');
        if($request->start_date){
            $inputData['start_date'] = date("Y-m-d",strtotime($request->start_date));
        }else{
            $inputData['start_date'] = NULL;
        }
        if($request->end_date){
            $inputData['end_date'] = date("Y-m-d",strtotime($request->end_date));
        }else{
            $inputData['end_date'] = NULL;
        }
        if($request->team_members){
            $inputData['team_members'] = json_encode($request->team_members);
        }
        if($request->has('attachment')){
            $imageName = time().'.'.$request->attachment->getClientOriginalName();
             // //Store in Storage Folder
            $request->attachment->storeAs('projects', $imageName);
            $inputData['attachment'] = $imageName;
        }
        $inputData['status'] = 'Active';
        return $this->projectReporsitory->update($id, $inputData);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->projectReporsitory->delete($id);
    }

    public function updatestatus($id) {
        $message["success"] =  __('messages.projectstasucs');
        $message["error"] =  __('messages.projectstafail');
        return changeStatus(Project::class,$message,$id);
        // return $this->projectReporsitory->updatestatus($id);
    }

    public function addProjectAttachment(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        $inputData['project_id'] = $request->project_id;
        if($request->has('file')){
            $imageName = time().'.'.$request->file->getClientOriginalName();
             // //Store in Storage Folder
            $request->file->storeAs('projects', $imageName);
            $inputData['files'] = $imageName;
        }
        ProjectAttachment::create($inputData);
        return response()->json([
            'status' => true
        ]);
    }
    public function assignMembers(Request $request){
        $project = Project::find($request->prj_id);
        $empIds =!empty($project->team_members)?json_decode($project->team_members):[];
        if($request->employee_id){
            $inputData['team_members'] = json_encode($request->employee_id);
        }
        $project->update($inputData);

        // $templateType = TemplateType::where("slug","project_assign")->first();
        $emailTemplate = EmailTemplate::where('template_type_id',"project_assign")->first();

        if(!empty($emailTemplate) && !empty($request->employee_id)){
            foreach ($request->employee_id as $key => $emp_id) {
                if(empty($empIds) || !in_array($emp_id,$empIds)) {
                    $employee = Employee::find($emp_id);
                    $email_preHeader = '<div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">Project Assign</div>';
                    $email_body = $email_preHeader . $emailTemplate->comment;
                    $email_body .= "<b>".ucfirst($project->project_name)." is Assigned to You";
                    $email_body .= "<p><b>".$project->start_date." To ".$project->end_date."</p>";
                    $email_body .= "<p>".$emailTemplate->sms_content."</p>";
                    $email_body .= "<p>".$emailTemplate->content."</p>";

                    Mail::send(array(), array(), function ($message) use ($employee, $email_body, $emailTemplate) {
                        $message->to($employee->email)
                            ->subject($emailTemplate->subject)
                            ->setBody($email_body, 'text/html');
                    });
                }
            }
        }

        if (auth()->user()->role == "Super Admin") {
            $email_preHeader = '<div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">Project Assign</div>';
            $email_body = $email_preHeader . ($emailTemplate->comment??'');
            $email_body .= "<b>".ucfirst($project->project_name)." is Assigned To ".$project->team_members_name;
            $email_body .= "<p><b>".$project->start_date." To ".$project->end_date."</p>";
            $email_body .= "<p>".$emailTemplate->sms_content."</p>";
            $email_body .= "<p>".$emailTemplate->content."</p>";


            Mail::send(array(), array(), function ($message) use ($email_body, $emailTemplate) {
                $message->to(auth()->user()->email)
                    ->subject($emailTemplate->subject)
                    ->setBody($email_body, 'text/html');
            });
        }

        return response()->json([
            'status' => true,
            'project' => $project->project_name
        ]);
    }
}
