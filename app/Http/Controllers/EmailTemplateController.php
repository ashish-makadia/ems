<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Authorizable;
use App\Models\EmailTemplate;
use App\Models\TemplateType;
use App\Repositories\EmailTemplateRepository;
// use App\Models\GlobleSetting;
// use App\Traits\SendMailTraits;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;


class EmailTemplateController extends Controller
{
    use Authorizable;
	protected $emailtemplateModel;

	public function __construct() {
		$this->emailtemplateModel = new EmailTemplateRepository;
		$this->middleware('auth');
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumb[0]['name'] = 'email-template';
        $breadcrumb[0]['url'] = url('email-template');
        $breadcrumb[1]['name'] =  __('messages.email-template');
        $breadcrumb[1]['datatable'] = 'Email Template';
        $breadcrumb[0]['editname'] =  __('messages.editemailtemplate');
        $breadcrumb[1]['url'] = '';

        if ($request->ajax()) {
			return json_encode($this->emailtemplateModel->getDatatable($request));
		}

        return view('email_template.index', compact('breadcrumb'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $template_type = TemplateType::get();
        $template_type = config('projectstatus.template_type');

        return view('email_template.create', compact('template_type'));
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
            'template_type_id' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $inputData = $request->except('_token');
        // $inputData['designation_id'] = $request->designation_id;

       $inputData['status'] = 'Active';
    $res = $this->emailtemplateModel->create($inputData);

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
    public function edit($id)
    {

        $email_template = EmailTemplate::find($id);
        // $template_type = TemplateType::get();
        $template_type = config('projectstatus.template_type');

        return view('email_template.edit', compact('email_template', 'template_type'));
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
            'template_type_id' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $inputData = $request->except('_token', '_method');

        // $inputData['designation_id'] = $request->designation_id;
        $inputData['status'] = 'Active';

        return $this->emailtemplateModel->update($id, $inputData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function destroy($id)
    {
        return $this->emailtemplateModel->delete($id);
    }
    public function updatestatus($id) {
        $message["success"] =  __('messages.emailtemplatestasucs');
        $message["error"] =   __('messages.emailtemplatestafail');
        return changeStatus(EmailTemplate::class,$message,$id);
    }

    //mail send using trait comon function
    public function sendMail($id)
    {
        $data = EmailTemplate::find($id);

        // $data = $request->all();

        // $data = $request->except("_token");
        // $this-> send_mail($template_type,$subject,$sms_content,$content,$view,$to);
        //$this->send_mail('Test Template','','','Hi this is test mail message','mail','testing.test@gmail.com');
        $this->send_mail($data->template_type, $data->subject, $data->sms_content, $data->content, 'mail', 'testing.logistic@gmail.com');
        // echo "$this"; exit();
        return redirect()->back()->with('success', 'Mail Send Successfully');
    }
}
