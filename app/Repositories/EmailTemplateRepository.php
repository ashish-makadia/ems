<?php
namespace App\Repositories;
use App\Models\EmailTemplate;
use App\Models\Project;
use App\Models\Employee;
use App\Models\Customersupport;

use Illuminate\Support\Facades\Auth;
use App\Models\TemplateType;


use App\Models\LogActivity as LogActivityModel;
class EmailTemplateRepository {
	// insert new entry


	public function create($request) {
		$emailtemplate = EmailTemplate::create($request);

		if ($emailtemplate) {
			\LogActivity::addToLog(__('messages.emailtemplateinssucc'));
            session()->flash('success', __('messages.emailtemplateinssucc'));
			return response()->json(['status' => '1', 'msg' => __('messages.emailtemplateinssucc')]);
		} else {
			\LogActivity::addToLog(__('messages.emailtemplatenotinssucc'));
            session()->flash('success', __('messages.emailtemplatenotinssucc'));
			return response()->json(['status' => '1', 'msg' => __('messages.emailtemplatenotinssucc')]);
		}
	}

    public function getDatatable(object $request) {
		$json = array();

			if (isset($request->search['value'])) {
				$sql = EmailTemplate::where(function ($query) use ($request) {
					$query->where('subject', 'like', '%' . $request->search['value'] . '%')
						->orWhere('sms_content', 'like', '%' . $request->search['value'] . '%');

				})->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			} else {
				$sql = EmailTemplate::orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
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

	// update existing data;
	public function update($id, $request) {

        $emailtemplate = EmailTemplate::where('id',$id);
        if(!$emailtemplate->first()){
            session()->flash('danger', __('messages.emailtemplatestafail'));
            return response(['status' => '0', 'msg' => __('messages.emailtemplatestafail')]);
        }

		if ($emailtemplate->update($request)) {
			\LogActivity::addToLog(__('messages.emailtemplateupdsucc'));
            $message = __('messages.emailtemplateupdsucc');
            session()->flash('success', $message);
			return response()->json(['status' => '1', 'msg' => $message]);
		} else {
			\LogActivity::addToLog(__('messages.emailtemplatenotupdsucc'));
            session()->flash('danger', __('messages.emailtemplatenotupdsucc'));
			return response(['status' => '1', 'msg' => __('messages.emailtemplatenotupdsucc')]);
		}
	}

	// softdelete existing data;
	public function delete($id) {
		$emailtemplate = EmailTemplate::findOrfail($id);
		if (!$emailtemplate) {
            session()->flash('danger', __('messages.emailtemplatestafail'));
            return response(['status' => '0', 'msg' => __('messages.emailtemplatestafail')]);
		} else {
			if ($emailtemplate->delete()) {
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
	public function updatestatus($id) {
		$emailtemplate = EmailTemplate::findOrfail($id);
		if ($emailtemplate) {
			if ($emailtemplate->status == 'Active') {
				$emailtemplate->status = 'Inactive';
			} else {
				$emailtemplate->status = 'Active';
			}

			if ($emailtemplate->save()) {
                \LogActivity::addToLog(__('messages.emailtemplatestasucs'));
				return response(['status' => '1', 'msg' => __('messages.emailtemplatestasucs')]);
			} else {
				\LogActivity::addToLog(__('messages.emailtemplatedelfail'));
				return response(['status' => '0', 'msg' => __('messages.emailtemplatestafail')]);
			}
		} else {
			\LogActivity::addToLog(__('messages.emailtemplatedelfail'));
			return response(['status' => '0', 'msg' => __('messages.emailtemplatestafail')]);
		}
	}
}
