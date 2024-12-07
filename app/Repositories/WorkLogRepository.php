<?php
namespace App\Repositories;
use App\Models\WorkLog;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use App\Models\LogActivity as LogActivityModel;
class WorkLogRepository {
	// insert new entry
	public function create($request) {
		$worklog = WorkLog::create($request);

		if ($worklog) {
			\LogActivity::addToLog(__('messages.workloginssucc'));
            session()->flash('success', __('messages.workloginssucc'));
			return response(['status' => '1', 'msg' => __('messages.workloginssucc')]);
		} else {
			\LogActivity::addToLog(__('messages.worklognotinssucc'));
            session()->flash('danger', __('messages.worklognotinssucc'));
			return response(['status' => '1', 'msg' => __('messages.worklognotinssucc')]);
		}
	}

	  public function getDatatable(object $request) {

		$json = array();

			if (isset($request->search['value'])) {
				$sql = WorkLog::with(['project','task','employee','user'])->where(function ($query) use ($request) {
				})->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			} else {
				$sql = WorkLog::with(['project','task','employee','user'])->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			}

            if(Auth::user()->role == "Employee"){
                // $employee = Employee::where('user_id',Auth::user()->id)->first();
                // $sql->whereJsonContains('team_members',$employee->id);
                $sql->where('user_id',Auth::user()->id);
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
	public function update($id, $request) {

        $worklog = WorkLog::where('id',$id);
        if(!$worklog->first()){
            session()->flash('danger', __('messages.worklogstafail'));
            return response(['status' => '0', 'msg' => __('messages.worklogstafail')]);
        }

		if ($worklog->update($request)) {
			\LogActivity::addToLog(__('messages.worklogupdsucc'));
            $message = __('messages.worklogupdsucc');
            session()->flash('success', $message);
			return response()->json(['status' => '1', 'msg' => $message]);
		} else {
			\LogActivity::addToLog(__('messages.worklognotupdsucc'));
            session()->flash('danger', __('messages.worklognotupdsucc'));
			return response(['status' => '1', 'msg' => __('messages.worklognotupdsucc')]);
		}
	}


	public function delete($id) {
		$worklog = WorkLog::findOrfail($id);
		if (!$worklog) {
            session()->flash('danger', __('messages.worklogstafail'));
            return response(['status' => '0', 'msg' => __('messages.worklogstafail')]);
		} else {
			if ($worklog->delete()) {
				\LogActivity::addToLog(__('messages.worklogdelsucc'));
                $message = __('messages.worklogdelsucc');
                session()->flash('success', $message);
				return response(['status' => '1', 'msg' => __('messages.worklogdelsucc')]);
			} else {
				\LogActivity::addToLog(__('messages.worklogdelfail'));
                session()->flash('danger', __('messages.worklogdelfail'));
				return response(['status' => '0', 'msg' => __('messages.worklogdelfail')]);
			}
		}
	}

}
