<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave_management;
use Illuminate\Support\Facades\Auth;
use App\Models\EmailTemplate;
use App\Models\Employee;
use App\Models\TemplateType;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use SebastianBergmann\Template\Template;
use Session;

class LeaveManagementController extends Controller
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
        $breadcrumb[0]['name'] = 'leave-management';
        $breadcrumb[0]['url'] = url('leave-management');
        $breadcrumb[0]['editname'] = 'Leave Management';
        $breadcrumb[1]['name'] = 'Leave Management';
        $breadcrumb[1]['url'] = '';
        $json = array();
        if (auth()->user()->role == "Super Admin") {
            $leaveData = Leave_management::select('leave_management.*', 'users.name as username')->leftjoin('users', 'users.id', '=', 'leave_management.employee_id')->where('leave_management.status', "pending")->get();
            $approveData = Leave_management::select('leave_management.*', 'users.name as username')->leftjoin('users', 'users.id', '=', 'leave_management.employee_id')->where('leave_management.status', "approved")->get();
            $rejectData = Leave_management::select('leave_management.*', 'users.name as username')->leftjoin('users', 'users.id', '=', 'leave_management.employee_id')->where('leave_management.status', "rejected")->get();
            return view('leave_management.index', compact(['breadcrumb','leaveData','approveData','rejectData']));
        } else {
            $leaveData = Leave_management::select('leave_management.*', 'users.name as username')->leftjoin('users', 'users.id', '=', 'leave_management.employee_id')->where('employee_id', $user->id)->get();
            return view('leave_management.emp_index', compact(['breadcrumb','leaveData']));
        }

    }
    public function show(Request $request)
    {
        if (isset($request->search['value'])) {
            $sql = Leave_management::select('leave_management.*', 'users.name as username')->leftjoin('users', 'users.id', '=', 'leave_management.employee_id')->where(function ($query) use ($request) {
                $query->where('description', 'like', '%' . $request->search['value'] . '%')
                    ->orWhere('users.name', 'like', '%' . $request->search['value'] . '%');

            })->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
        } else {
            $sql = Leave_management::select('leave_management.*', 'users.name as username')->leftjoin('users', 'users.id', '=', 'leave_management.employee_id')->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
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
    public function insert_leave(Request $request)
    {
       $user = Auth::user();
       $data = array(
        'employee_id' => $user->id,
        'holiday_id' => 1,
        'from_date' => $request->from_date,
        'to_date' => $request->to_date,
        'type' => $request->type,
        'description' => $request->comment,
        'status' => "pending",
    );

    $res = Leave_management::create($data);
    if($request->type == 1 )
        $templateType = "apply_opt";
    if($request->type == 2 )
        $templateType = "present_leave";
    if($request->type == 3)
        $templateType = "apply_leave";
    if($request->type == 4 )
        $templateType = "apply_comp_off";

    // $template_Type = TemplateType::where("slug",$templateType)->first();
    $emailTemplate = EmailTemplate::where('template_type_id',$templateType)->first();

    if(!empty($emailTemplate)){
        // s$projectType = TemplateType::find($request->type)->toArray();
        $projectType = config('projectstatus.template_type')[$templateType]??'';
        $email_preHeader = '<div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">' . $projectType. '</div>';
        $email_body = $email_preHeader . $emailTemplate->comment;
        $email_body .= "<b>".$projectType." is requested From</b>".$request->from_date." To ".$request->to_date;
        $email_body .= "<p>".$emailTemplate->sms_content."</p>";
        $email_body .= "<p>".$emailTemplate->content."</p>";
        $email_body .= "<p>".$request->comment."</p>";

        if (auth()->user()->role == "Super Admin") {
            $emails = array(auth()->user()->email);
        }
        if (auth()->user()->role == "Employee") {
            $user =  User::where('role',"Super Admin")->first();
            $emails = array( auth()->user()->email,$user->email);
        }
        Mail::send(array(), array(), function ($message) use ($request, $emails,$email_body, $emailTemplate) {
            $message->to($emails)
                ->subject($emailTemplate->subject)
                ->setBody($email_body, 'text/html');
        });
    }

    $message = "Leave Request Submitted Successfully !!";
    session()->flash('success', $message);
    return response()->json([
        'status' => true,
        'message' => $message
    ]);
    }
    public function change_status($id,$status)
    {
       $leaveManagement = Leave_management::find($id);
       $leaveManagement->update([
            'status' => $status
        ]);

        if($status == "approved"){
            // $template_Type = TemplateType::where("slug","approved_leave")->first();
    $emailTemplate = EmailTemplate::where('template_type_id',"approved_leave")->first();

            if(!empty($emailTemplate)){
                $projectType = config('projectstatus.template_type')["approved_leave"]??'';
                $email_preHeader = '<div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">' . $projectType . '</div>';
                $email_body = $email_preHeader . $emailTemplate->comment;
                $email_body .= "<b>Your ". $projectType." is approved For </b>".$leaveManagement->from_date." To ".$leaveManagement->to_date;
                $email_body .= "<p>".$emailTemplate->sms_content."</p>";
                $email_body .= "<p>".$emailTemplate->content."</p>";
                $user = User::find($leaveManagement->employee_id);

                if (auth()->user()->role == "Super Admin") {
                    $emails = array(auth()->user()->email);
                }
                if ($user && $user->role == "Employee") {
                    $emails = array( auth()->user()->email,$user->email);
                }
                Mail::send(array(), array(), function ($message) use ($emails,$email_body, $emailTemplate) {
                    $message->to($emails)
                        ->subject($emailTemplate->subject)
                        ->setBody($email_body, 'text/html');
                });
            }
        }
        if($status == "rejected"){
            // $template_Type = TemplateType::where("slug","reject_leave")->first();
            $emailTemplate = EmailTemplate::where('template_type_id',"reject_leave")->first();
            if(!empty($emailTemplate)){
                $projectType = TemplateType::find($leaveManagement->type)->toArray();
                $projectType = config('projectstatus.template_type')["reject_leave"]??'';
                $email_preHeader = '<div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">' . $projectType. '</div>';
                $email_body = $email_preHeader . $emailTemplate->comment;
                $email_body .= "<b>Your ". $projectType." is rejected For </b>".$leaveManagement->from_date." To ".$leaveManagement->to_date;
                $email_body .= "<p>".$emailTemplate->sms_content."</p>";
                $email_body .= "<p>".$emailTemplate->content."</p>";

                if (auth()->user()->role == "Super Admin") {
                    $emails = array(auth()->user()->email);
                }
                if (auth()->user()->role == "Employee") {
                    $user =  User::where('role',"Super Admin")->first();
                    $emails = array( auth()->user()->email,$user->email);
                }
                Mail::send(array(), array(), function ($message) use ($emails,$email_body, $emailTemplate) {
                    $message->to($emails)
                        ->subject($emailTemplate->subject)
                        ->setBody($email_body, 'text/html');
                });
            }
        }
        Session::flash('success', 'Status successfully Changed!');
        return redirect()->route('leave-management.index');
    }
}
