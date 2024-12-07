<?php

namespace App\Http\Controllers;

use App\Authorizable;
use App\Services\ActivityLogServices;
use Illuminate\Http\Request;

class ActivityLogController extends Controller {
	use Authorizable;
	protected $activityLogServices;

	public function __construct() {
		$this->middleware('auth');
		$this->activityLogServices = new ActivityLogServices;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		$breadcrumb[0]['name'] = 'Activity Logs';
		$breadcrumb[0]['datatable'] = 'activitylogs';
		$breadcrumb[0]['url'] = url('logActivity');
		$breadcrumb[0]['editname'] = "Edit Log Activity";
		$breadcrumb[1]['name'] =  __('messages.activitylogs');
		$breadcrumb[1]['url'] = '';

		if ($request->ajax()) {
			return $this->activityLogServices->getDatatable($request);
		}
		return view('logactivity.index', compact(['breadcrumb']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		abort(404);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		abort(404);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		abort(404);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		abort(404);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		abort(404);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		abort(404);
	}
}
