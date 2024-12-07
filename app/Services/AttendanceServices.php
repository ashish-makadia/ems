<?php

namespace App\Services;

use App\Models\Attendance;
use App\Repositories\AttendanceRepository;
use Auth;

use App\Models\LogActivity as LogActivityModel;

class AttendanceServices
{
	protected $userRepository;

	public function __construct()
	{
		$this->attendanceRepository = new AttendanceRepository;
	}

	// show datatable
	public function getDatatable(object $request)
	{
		$json = array();
		$user = Auth::user();
		if (auth()->user()->role == "Super Admin") {
			if (isset($request->search['value'])) {
				$sql = Attendance::select('attendance.*', 'users.name as username')->leftjoin('users', 'users.id', '=', 'attendance.emp_id')->where(function ($query) use ($request) {
					$query->where('location', 'like', '%' . $request->search['value'] . '%')
						->orWhere('ip_address', 'like', '%' . $request->search['value'] . '%')
						->orWhere('users.name', 'like', '%' . $request->search['value'] . '%')
						->orWhere('browser', 'like', '%' . $request->search['value'] . '%');
				})->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			} else {
				$sql = Attendance::select('attendance.*', 'users.name as username')->leftjoin('users', 'users.id', '=', 'attendance.emp_id')->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			}
		} else {
			if (isset($request->search['value'])) {
				$sql = Attendance::select('attendance.*', 'users.name as username')->leftjoin('users', 'users.id', '=', 'attendance.emp_id')->where('emp_id', $user->id)->where(function ($query) use ($request) {
					$query->where('location', 'like', '%' . $request->search['value'] . '%')
						->orWhere('ip_address', 'like', '%' . $request->search['value'] . '%')
						->orWhere('users.name', 'like', '%' . $request->search['value'] . '%')
						->orWhere('browser', 'like', '%' . $request->search['value'] . '%');
				})->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			} else {
				$sql = Attendance::select('attendance.*', 'users.name as username')->leftjoin('users', 'users.id', '=', 'attendance.emp_id')->where('emp_id', $user->id)->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
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
}
