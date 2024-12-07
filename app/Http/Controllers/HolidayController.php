<?php

namespace App\Http\Controllers;

use App\Authorizable;
use App\Models\Holiday;
use App\Services\HolidayServices;
use App\Http\Requests\HolidayRequest;
use Illuminate\Http\Request;

class HolidayController extends Controller {
	use Authorizable;
	protected $holidayServices;
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function __construct() {
		$this->holidayServices = new HolidayServices;
		$this->middleware('auth');
	}

	public function index(Request $request) {
		$breadcrumb[0]['name'] = 'holiday';
		$breadcrumb[0]['url'] = url('holiday');
		$breadcrumb[1]['name'] =  "Holiday Listing";
		$breadcrumb[0]['editname'] =  "Edit Holiday";
		$breadcrumb[1]['url'] = '';

		if ($request->ajax()) {
			return json_encode($this->holidayServices->getDatatable($request));
		}

		return view('holiday.index', compact(['breadcrumb']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$data['view'] = view('holiday.create')->render();
		return response()->json($data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(HolidayRequest $request) {
		return $this->holidayServices->createHoliday($request);
	}

	public function show(Holiday $holiday) {
		return back();
	}

	public function edit(Holiday $holiday) {
		$data['view'] = view('holiday.create', compact('holiday'))->render();
		return response()->json($data);
	}

	public function update(HolidayRequest $request, Holiday $holiday) {
		return $this->holidayServices->updateHoliday($holiday, $request);
	}
	public function destroy(Holiday $holiday) {
		return $this->holidayServices->deleteHoliday($holiday);
	}
    public function updatestatus($id) {
        // ALTER TABLE `holiday_management` CHANGE `status` `status` ENUM('Active','Inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
        $message["success"] = "Holiday Status Changed Successfully";
        $message["error"] = "Holiday Status Update Failed";
        return changeStatus(Holiday::class,$message,$id);
    }

	public function insert_new(Request $request){
		return $this->holidayServices->CheckHoliday($request);
	}
}
