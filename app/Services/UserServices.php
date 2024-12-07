<?php

namespace App\Services;
use App\Models\User;
use App\Repositories\UserRepository;
use Auth;

class UserServices {
	protected $userRepository;

	public function __construct() {
		$this->userRepository = new UserRepository;
	}

	// show datatable
	public function getDatatable(object $request) {
		$json = array();
		$user_data = Auth::user(); 
		//echo "<pre>"; print_r($test); exit;
		if ($user_data->role == 'Ship Company') {
			# code...
			if (isset($request->search['value'])) {
				$sql = User::where('id',$user_data->id)->where(function ($query) use ($request) {
					$query->where('name', 'like', '%' . $request->search['value'] . '%')
						->orWhere('email', 'like', '%' . $request->search['value'] . '%')
						->orWhere('mobile_no', 'like', '%' . $request->search['value'] . '%')
						->orWhere('status', 'like', '%' . $request->search['value'] . '%');

				})->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			} else {
				$sql = User::where('id',$user_data->id)->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			}
		}else{
			if (isset($request->search['value'])) {
				$sql = User::where(function ($query) use ($request) {
					$query->where('name', 'like', '%' . $request->search['value'] . '%')
						->orWhere('email', 'like', '%' . $request->search['value'] . '%')
						->orWhere('mobile_no', 'like', '%' . $request->search['value'] . '%')
						->orWhere('status', 'like', '%' . $request->search['value'] . '%');

				})->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			} else {
				$sql = User::orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			}
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

	// insert new entry
	public function createUser($request) {
		return $this->userRepository->create($request);
	}

	// update existing data;
	public function updateUser($user, $request) {
		return $this->userRepository->update($user, $request);
	}

	// softdelete existing data;
	public function deleteUser($user) {
		return $this->userRepository->delete($user);
	}

	// update status
	public function updatestatus($id) {
		return $this->userRepository->updatestatus($id);
	}
}