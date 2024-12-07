<?php
namespace App\Repositories;
use App\Models\Customersupport;
use Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\FrontActivityLog;
use App\Models\LogActivity;
use App\Models\Employee;
class CustomersupportRepository {
	//get data table




    public function getDatatable(object $request) {
		$json = array();

			if (isset($request->search['value'])) {
				$sql = Customersupport::with("user")->where(function ($query) use ($request) {
					$query->where('subject', 'like', '%' . $request->search['value'] . '%')
						->orWhere('ticket_id', 'like', '%' . $request->search['value'] . '%');

				})->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			} else {
				$sql = Customersupport::with("user")->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			}

			if(Auth::user()->role == "Employee"){
                $employee = Employee::where('user_id',Auth::user()->id)->first();
                // $sql->whereJsonContains('team_members',$employee->id);
                $sql->where('team_members','like','%"'.$employee->id.'"%');
            }
            if($request->team_member != ""){
                $sql->where('team_members','like','%"'.$request->team_member.'"%');
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

	// softdelete existing data;
	public function delete($id) {
		$customer = Customersupport::findOrfail($id);
		if (!$customer) {
            session()->flash('danger', __('messages.emailtemplatestafail'));
            return response(['status' => '0', 'msg' => __('messages.emailtemplatestafail')]);
		} else {
			if ($customer->delete()) {
				\LogActivity::addToLog(__('messages.emailtemplatedelsucc'));
                $message = __('messages.emailtemplatedelsucc');
                session()->flash('success', $message);
				return response(['status' => '1', 'msg' => __('messages.emailtemplatedelsucc')]);
			} else {
				\LogActivity::addToLog(__('messages.emailtemplatedelfail'));
                session()->flash('danger', __('messages.emailtemplatedelfail'));
				return response(['status' => '0', 'msg' => __('messages.emailtemplatedelfail')]);
			}
		}
	}

	// update status in database
	public function updatestatus($ticketId ,$status,$delivery_date) {
		// $customer = Customersupport::findOrfail($id);
        $customer = Customersupport::where("ticket_id",$ticketId)->first();
		if ($customer) {
            $isStatusChanged = 0;
            if($status != $customer->status){
                $isStatusChanged = 1;
            }
                $customer->status = $status;
                if($delivery_date && $delivery_date != "")
                    $customer->delivery_date = date('Y-m-d',strtotime($delivery_date));
			    if ($customer->save()) {
                    $customerstatus = config("projectstatus.customerstatus");
                    $log = [
                        'subject' => 'Customer Support status changed to '.$customerstatus[$status].' successfully',
                        'url' => Request::fullUrl(),
                        'request_data' => json_encode(Request::all()),
                        'method' => Request::method(),
                        'ip' => Request::ip(),
                        'agent' => Request::header('user-agent'),
                        'user_id' => auth()->check() ? auth()->user()->id : 1,
                        'data_user_id' => $customer->ticket_id,
                        'status' => $customerstatus[$status]
                    ];
                    if($isStatusChanged){
                        $IsLog = LogActivity::create($log);
                        $IsLog = FrontActivityLog::create($log);
                    }

                            // \LogActivity::addToLog('Customer Support status changed to '.$status.' successfully',$customer->id);
                            // \LogActivity::addToFrontLog('Customer Support status changed to '.$status.' successfully',$customer->id);
                        // }


                    $email_body = "<br/><h2>".$customer->subject."</h2>";
                    $email_body = "<br/><p>Customer Support ticket Status <b> ".$customerstatus[$status]." </b>!!</p>";
                    $email_body .= "<br/><b> User </b>".auth()->user()->name;
                    $email_body .= "<br/><b> Delivery Date </b>".$delivery_date;
                    $email_body .= "<br/><b> Check Ticket Status Link </b><a href=".$customer->url.">".$customer->url."</a>";
                    $emails =  $customer->mail;
                    Mail::send(array(), array(), function ($message) use ($customer, $emails,$email_body) {
                        $message->to($emails)
                            ->subject($customer->subject)
                            ->setBody($email_body, 'text/html');
                    });
                    session()->flash('success', 'Customer Support status updated');
				    return response(['status' => '1', 'Msg' => "Customer Support status updated"]);
                }
			 else {
                session()->flash('error', 'Customer Support status not updated');
				\LogActivity::addToLog(__('messages.emailtemplatedelfail'));
				return response(['status' => '0', 'Msg' => "Customer Support status not updated"]);
			}
		} else {
            session()->flash('error', 'Customer Support status not updated');
			\LogActivity::addToLog(__('messages.emailtemplatedelfail'));
			return response(['status' => '0', 'Msg' => "Customer Support status not updated"]);
		}
	}
}
