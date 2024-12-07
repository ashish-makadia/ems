<?php

namespace App\Services;
use App\Models\Holiday;
use App\Repositories\HolidayRepository;

class HolidayServices {

	protected $holidayRepository;

	public function __construct() {
		$this->holidayRepository = new HolidayRepository;
	}

	// show datatable
	public function getDatatable(object $request) {
		$json = array();

		$sql = Holiday::where(function ($query) use ($request) {
			$query->where('name', 'like', '%' . $request->search['value'] . '%')
				->orWhere('status', 'like', '%' . $request->search['value'] . '%');

		})->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
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
	public function createHoliday($request) {
		if ($this->holidayRepository->create($request)) {
			\LogActivity::addToLog("Holiday Insert Successfull");
			return response(['status' => '1', 'msg' => "Holiday Insert Successfull"]);
		} else {
			\LogActivity::addToLog("Holiday Insert Failed");
			return response(['status' => '0', 'msg' => "Holiday Insert Failed"]);
		}
	}

	// update existing data;
	public function updateHoliday($holiday, $request) {
		$request['status'] = isset($request['status']) ? 'Active' : 'Inactive';
		if ($this->holidayRepository->update($holiday, $request)) {
			\LogActivity::addToLog("Holiday Update Successfull");
			return response(['status' => '1', 'msg' => "Holiday Update Successfull"]);
		} else {
			\LogActivity::addToLog("Holiday Update Failed");
			return response(['status' => '0', 'msg' => "Holiday Update Failed"]);
		}
	}

	// softdelete existing data;
	public function deleteHoliday($holiday) {
		return $this->holidayRepository->delete($holiday);
	}

	// update status
	public function updatestatus($id) {
		return $this->holidayRepository->updatestatus($id);
	}

	public function CheckHoliday($request){
		$name = $request->name;
		echo $name;
	}
}