<?php
namespace App\Repositories;
use App\Models\Project;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\LogActivity as LogActivityModel;

class ProjectRepository {
	// insert new entry
	public function create($request) {
		$project = Project::create($request);

		if ($project) {
			\LogActivity::addToLog(__('messages.projectinssucc'));
            session()->flash('success', __('messages.projectinssucc'));
			return response()->json(['status' => '1', 'msg' => __('messages.projectinssucc')]);
		} else {
			\LogActivity::addToLog(__('messages.projectnotinssucc'));
            session()->flash('success', __('messages.projectnotinssucc'));
			return response()->json(['status' => '1', 'msg' => __('messages.projectnotinssucc')]);
		}
	}

    public function getDatatable(object $request) {
		$json = array();

			if (isset($request->search['value'])) {
				$sql = Project::where(function ($query) use ($request) {
					$query->where('project_name', 'like', '%' . $request->search['value'] . '%')
						->orWhere('start_date', 'like', '%' . $request->search['value'] . '%')
                        ->orWhere('end_date', 'like', '%' . $request->search['value'] . '%');

				})->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			} else {
				$sql = Project::orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
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

        $project = Project::where('id',$id);
        if(!$project->first()){
            session()->flash('danger', __('messages.projectstafail'));
            return response(['status' => '0', 'msg' => __('messages.projectstafail')]);
        }

		if ($project->update($request)) {
			\LogActivity::addToLog(__('messages.projectupdsucc'));
            $message = __('messages.projectupdsucc');
            session()->flash('success', $message);
			return response()->json(['status' => '1', 'msg' => $message]);
		} else {
			\LogActivity::addToLog(__('messages.projectnotupdsucc'));
            session()->flash('danger', __('messages.projectnotupdsucc'));
			return response(['status' => '1', 'msg' => __('messages.projectnotupdsucc')]);
		}
	}

	// softdelete existing data;
	public function delete($id) {
		$project = Project::findOrfail($id);
		if (!$project) {
            session()->flash('danger', __('messages.projectstafail'));
            return response(['status' => '0', 'msg' => __('messages.projectstafail')]);
		} else {
			if ($project->delete()) {
				\LogActivity::addToLog(__('messages.projectdelsucc'));
                $message = __('messages.projectdelsucc');
                session()->flash('success', $message);
				return response(['status' => '1', 'msg' => __('messages.projectdelsucc')]);
			} else {
				\LogActivity::addToLog(__('messages.projectdelfail'));
                session()->flash('danger', __('messages.projectdelfail'));
				return response(['status' => '0', 'msg' => __('messages.projectdelfail')]);
			}
		}
	}

}
