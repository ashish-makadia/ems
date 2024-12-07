<?php

namespace App\Http\Controllers;
use App\Repositories\CustomersupportRepository;
use Illuminate\Http\Request;
use App\Authorizable;
use App\Models\LogActivity;
use App\Models\Employee;
use App\Models\Customersupport;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Auth;


class CustomersupportController extends Controller
{
    // use Authorizable;
    protected $customersupportModel;

    public function __construct() {
        $this->customersupportModel = new CustomersupportRepository;
        // $this->middleware('auth');
    }

   public function index(Request $request)
   {
    $breadcrumb[0]['name'] = 'customersupport';
    $breadcrumb[0]['url'] = url('customer-support');
    $breadcrumb[1]['name'] = 'customersupport';
    $breadcrumb[1]['datatable'] = 'Customersupport';
    $breadcrumb[0]['editname'] = 'Edit Customersupport';
    $breadcrumb[1]['url'] = '';

    if ($request->ajax()) {
        return json_encode($this->customersupportModel->getDatatable($request));
    }

        $employees = Employee::where('status','active')->get();
        $statuses = config("projectstatus.customerstatus"); $customerstatus = config("projectstatus.customerstatus");
    return view('customer_support.index', compact('breadcrumb','employees','statuses'));
   }


   public function destroy($id)
    {
        return $this->customersupportModel->delete($id);
    }

   public function updatestatus(Request $request)
    {
        return $this->customersupportModel->updatestatus($request->ticket_id,$request->status,$request->delivery_date);
    }

    public function show($ticketId)
    {
        $customerSup = Customersupport::where("ticket_id",$ticketId)->first();
        $IsLog = LogActivity::where(["data_user_id" => $customerSup->id])->count();
        if($customerSup->is_view == 0){
            $customerSup->is_view = 1;
            $customerSup->save();
            \LogActivity::addToLog('Customer Support ticket seen successfully',$customerSup->id);
            \LogActivity::addToFrontLog('Customer Support ticket seen successfully',$ticketId,"Seen");
        }

        $customerstatus = config("projectstatus.customerstatus");
        return view('customer_support.show',compact('customerSup','customerstatus'));
    }

   public function assignMembers(Request $request){

         $customer = Customersupport::find($request->cus_id);
        $empIds =!empty($customer->team_members)?json_decode($customer->team_members):[];
        if($request->employee_id){
            $inputData['team_members'] = json_encode($request->employee_id);
        }
        $inputData['assined_by'] = Auth::user()->id;
        if($customer->update($inputData)){
            \LogActivity::addToFrontLog("Assign Members to Customer Support by ". Auth::user()->name,$customer->ticket_id,"Assigned");
            \LogActivity::addToLog("Assign Members to Customer Support by ". Auth::user()->name,$customer->ticket_id);
        }



        $emailTemplate = EmailTemplate::where('template_type_id',"project_assign")->first();

        if(!empty($emailTemplate) && !empty($request->employee_id)){
            foreach ($request->employee_id as $key => $emp_id) {
                if(empty($empIds) || !in_array($emp_id,$empIds)) {
                    $employee = Employee::find($emp_id);
                    $email_preHeader = '<div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">Customer Support Tickit  Assign</div>';
                    $email_body = $email_preHeader . $emailTemplate->comment;
                    $email_body .= "<b>".ucfirst($customer->subject)." is Assigned to You";

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
            $email_body .= "<b>".ucfirst($customer->subject)." is Assigned To ".$customer->team_members_name;
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
            'CustomerTicket' => $customer->subject
        ]);
    }

    public function getCustomer(Request $request){

        $customer = Customersupport::find($request->id);
        $empIds = !empty($customer->team_members)?json_decode($customer->team_members):[];

        $employees = Employee::get();

        $html = "";
        $html = "<option value=''>...............</option>";
        foreach($employees as $emp){
            $selected = "";
            if(in_array($emp->id,$empIds)){
                $selected = "selected";
            }
            $html .= "<option value=".$emp->id." ".$selected.">".$emp->name."</option>";
        }

        // $customer = Project::whereIn('team_members',$emp_id)->get();
        return response()->json([
            'status' => true,
            'employee' => $html,
            'CustomerTicketEmp' => $empIds
        ]);
    }
}
