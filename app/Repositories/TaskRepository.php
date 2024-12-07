<?php
namespace App\Repositories;
use App\Models\Task;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use App\Models\LogActivity as LogActivityModel;
class TaskRepository {
	// insert new entry
	public function create($request) {
		$task = Task::create($request);

		if ($task) {
			\LogActivity::addToLog(__('messages.taskinssucc'));
            session()->flash('success', __('messages.taskinssucc'));
			return response(['status' => '1', 'msg' => __('messages.taskinssucc')]);
		} else {
			\LogActivity::addToLog(__('messages.tasknotinssucc'));
            session()->flash('danger', __('messages.tasknotinssucc'));
			return response(['status' => '1', 'msg' => __('messages.tasknotinssucc')]);
		}
	}

	  public function getDatatable(object $request) {
		    $json = array();

			if (isset($request->search['value'])) {
				$sql = Task::with('project')->where(function ($query) use ($request) {
					$query->where('summry', 'like', '%' . $request->search['value'] . '%');

				})->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			} else {
				$sql = Task::with('project')->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			}
            if(Auth::user()->role == "Employee"){
                $employee = Employee::where('user_id',Auth::user()->id)->first();
                // $sql->whereJsonContains('team_members',$employee->id);

                    $sql->where('team_members','like','%"'.$employee->id.'"%');

            }
            if($request->start_date != "" && $request->end_date){
                $sql->where('start_date','>=',date('Y-m-d',strtotime($request->start_date)));
                $sql->where('start_date','<=',date('Y-m-d',strtotime($request->end_date)));
            }
            if($request->team_member != ""){
                $sql->where('team_members','like','%"'.$request->team_member.'"%');
            }
            if($request->project_id != ""){
                $sql->where('project_id',$request->project_id);
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

        $task = Task::where('id',$id);
        if(!$task->first()){
            session()->flash('danger', __('messages.taskstafail'));
            return response(['status' => '0', 'msg' => __('messages.taskstafail')]);
        }

		if ($task->update($request)) {
			\LogActivity::addToLog(__('messages.taskupdsucc'));
            $message = __('messages.taskupdsucc');
            session()->flash('success', $message);
			return response()->json(['status' => '1', 'msg' => $message]);
		} else {
			\LogActivity::addToLog(__('messages.tasknotupdsucc'));
            session()->flash('danger', __('messages.tasknotupdsucc'));
			return response(['status' => '1', 'msg' => __('messages.tasknotupdsucc')]);
		}
	}


	public function delete($id) {
		$task = Task::findOrfail($id);
		if (!$task) {
            session()->flash('danger', __('messages.taskstafail'));
            return response(['status' => '0', 'msg' => __('messages.taskstafail')]);
		} else {
			if ($task->delete()) {
				\LogActivity::addToLog(__('messages.taskdelsucc'));
                $message = __('messages.taskdelsucc');
                session()->flash('success', $message);
				return response(['status' => '1', 'msg' => __('messages.taskdelsucc')]);
			} else {
				\LogActivity::addToLog(__('messages.taskdelfail'));
                session()->flash('danger', __('messages.taskdelfail'));
				return response(['status' => '0', 'msg' => __('messages.taskdelfail')]);
			}
		}
	}

}
