<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Categories;
use App\Models\Customersupport;
use App\Models\SubCategories;
use App\Models\LogActivity;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Validator;
use App\Models\Country;
use App\Models\Region;
use App\Models\Province;
use App\Models\User;
use App\Models\Municipality;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Redirect;
use Illuminate\Support\Facades\Mail;
use URL;
use App\Models\FrontActivityLog;
use Carbon\Carbon;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('frontend.home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function customercreate()
    {
        $categories = Categories::get();
        $subcategories = SubCategories::get();
        $regions = Region::get();
        $country = Country::get();
        $province = Province::get();
        $municipality = Municipality::get();
        $siteinfo=Config::get('constants.siteinfo');
        //return $siteinfo;
        return view('frontend.customer',compact('categories','subcategories','regions','country','province','municipality'));
    }

    public function customersupport()
    {
        return view('frontend.support');
    }


    public function customerfeedback($ticketId=null)
    {
        $customerSup = [];
        // if($ticketId)
        //     $customerSup = Customersupport::where("ticket_id",$ticketId)->first();
        // else
            $customerSup = Customersupport::get();
        return view('frontend.feedback',compact('customerSup'));
    }

    public function customerfeedbackView($ticketId)
    {
        // $ticId = explode('-',$ticketId);
        // $ticId = $ticId[1]??1;
        $customerSup = Customersupport::where("ticket_id",$ticketId)->first();
        $logActivities  = FrontActivityLog::where(["front_log_activities.data_user_id" => $ticketId])->where("status","!=","")->get();
// dd($logActivities);
        return view('frontend.feedbackView',compact('customerSup','logActivities'));
    }


    public function customersupportstore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'description' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'mail' => 'required',
            'mobile' => 'required',
            'priority' => 'required',
        ]);

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }else{
            $support_file ="";
            if($request->has('file_upload'))
            {

                $imageName = time().'.'.$request->file_upload->getClientOriginalName();
                $request->file_upload->storeAs('support', $imageName);
                $support_file= $imageName;
            }

            $lastCust = Customersupport::orderBy("id",'desc')->first();
            $ticId = !empty($lastCust)?$lastCust->serial_no:0;
            $ticId +=1;
            if($ticId >= 1 && $ticId < 10){
                $ticketNo = "000".$ticId;
            } elseif($ticId >= 10 && $ticId < 100){
                $ticketNo = "00".$ticId;
            }
            elseif($ticId >= 100 && $ticId < 1000){
                $ticketNo = "0".$ticId;
            } else {
                $ticketNo = $ticId;
            }
            $custPrefix = config("projectstatus.customersup_prefix");
            $ticket_id = $custPrefix.$ticketNo;
            // $ticket_id=random_int(100000, 999999);
            $url=" ".URL::to("/customer-support/$ticket_id");
            // dd($url);
            //return $url;
            $support= new Customersupport;
            $support->subject = $request->subject;
            $support->Description = $request->description;
            $support->website = $request->website;
            $support->first_name = $request->firstname;
            $support->last_name = $request->lastname;
            $support->company = $request->company;
            $support->mail = $request->mail;
            $support->mobile = $request->mobile;
            $support->file = $support_file;
            $support->priority = $request->priority;
            // $support->delivery_date = date('Y-m-d');
            $support->status = 1;
            $support->ticket_id = $ticket_id;
            $support->serial_no = $ticId;
            $support->url =$url;

            $support->save();

        if( $support->save()){
            \LogActivity::addToFrontLog('Customer Support Request added Successfully',$support->ticket_id,"Created","front");
            $email_body = $request->description."<br/>";
            $email_body .= "<b>".$request->website." is requested From</b> ".$request->first_name." ".$request->last_name;
            $email_body .= "<p>".$request->priority."</p>";
            $email_body .= "<p>".$request->subject."</p>";
            $email_body .= "<p>". $request->company."</p>";
            $email_body .= "<p><a href=". $url.">". $url."</a></p>";

            $emails = User::where("role","Super Admin")->get()->pluck("email")->toArray();
            $emails[] =  $request->mail;
            Mail::send(array(), array(), function ($message) use ($request, $emails,$email_body) {
                $message->to($emails)
                    ->subject($request->subject)
                    ->setBody($email_body, 'text/html');
            });
        }

        return Redirect::back()->with('message', "Ticket  Created  successfully Visit:  $url ");
        }

    }

}
