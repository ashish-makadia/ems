<?php

namespace App\Services;
use App\Models\LogActivity;
use Auth;

class ActivityLogServices {

	// show datatable
	public function getDatatable(object $request) {
		$json = array();
		if(Auth::user()->role == 'Ship Company'){
			if (isset($request->search['value'])) {
			$sql = LogActivity::select('log_activities.*', 'users.name as user')->leftjoin('users', 'users.id', '=', 'log_activities.user_id')->
				where('data_user_id',auth()->user()->shipdetails->id)->where(function ($query) use ($request) {
				$query->where('subject', 'like', '%' . $request->search['value'] . '%')
					->orWhere('url', 'like', '%' . $request->search['value'] . '%')
					->orWhere('ip', 'like', '%' . $request->search['value'] . '%')
					->orWhere('agent', 'like', '%' . $request->search['value'] . '%')
					->orWhere('log_activities.created_at', 'like', '%' . $request->search['value'] . '%')
					->orWhere('users.name', 'like', '%' . $request->search['value'] . '%')
					->orWhere('method', 'like', '%' . $request->search['value'] . '%');

			})->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			}else {
				$sql = LogActivity::where('data_user_id',auth()->user()->shipdetails->id)->select('log_activities.*', 'users.name as user')->leftjoin('users', 'users.id', '=', 'log_activities.user_id')->
				orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			}
		}else{
			if (isset($request->search['value'])) {
				$sql = LogActivity::select('log_activities.*', 'users.name as user')->leftjoin('users', 'users.id', '=', 'log_activities.user_id')->
				where(function ($query) use ($request) {
				$query->where('subject', 'like', '%' . $request->search['value'] . '%')
					->orWhere('url', 'like', '%' . $request->search['value'] . '%')
					->orWhere('ip', 'like', '%' . $request->search['value'] . '%')
					->orWhere('agent', 'like', '%' . $request->search['value'] . '%')
					->orWhere('log_activities.created_at', 'like', '%' . $request->search['value'] . '%')
					->orWhere('users.name', 'like', '%' . $request->search['value'] . '%')
					->orWhere('method', 'like', '%' . $request->search['value'] . '%');

				})->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			} else {
				$sql = LogActivity::select('log_activities.*', 'users.name as user')->leftjoin('users', 'users.id', '=', 'log_activities.user_id')->
				orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			}
		
		}
		
		$recordsTotal = $sql->count();
		$data = $sql->limit($request->length)->skip($request->start)->get();

		$data->each(function ($item, $key) {
			$time = explode("T", $item->created_at);
			$item->date = $time;
		});
		$recordsFiltered = count($data);

		$json['data'] = $data;
		$json['draw'] = $request->draw;
		$json['recordsTotal'] = $recordsFiltered;
		$json['recordsFiltered'] = $recordsTotal;

		return json_encode($json);
	}
}