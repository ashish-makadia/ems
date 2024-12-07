<?php

namespace App\Http\Controllers;

use App\Authorizable;
use App\Models\Team;
use App\Services\TeamServices;
use App\Http\Requests\TeamRequest;
use Illuminate\Http\Request;

class TeamController extends Controller {
	use Authorizable;
	protected $teamServices;
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function __construct() {
		$this->teamServices = new TeamServices;
		$this->middleware('auth');
	}

	public function index(Request $request) {
		$breadcrumb[0]['name'] = 'team';
		$breadcrumb[0]['url'] = url('team');
		$breadcrumb[1]['name'] =  "Team Listing";
		$breadcrumb[0]['editname'] =  "Edit Team";
		$breadcrumb[1]['url'] = '';

		if ($request->ajax()) {
			return json_encode($this->teamServices->getDatatable($request));
		}

		return view('team.index', compact(['breadcrumb']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$data['view'] = view('team.create')->render();
		return response()->json($data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(TeamRequest $request) {
		return $this->teamServices->createTeam($request);
	}

	public function show(Team $team) {
		return back();
	}

	public function edit(Team $team) {
		$data['view'] = view('team.create', compact('team'))->render();
		return response()->json($data);
	}

	public function update(TeamRequest $request, Team $team) {
		return $this->teamServices->updateTeam($team, $request);
	}
	public function destroy(Team $team) {
		return $this->teamServices->deleteTeam($team);
	}

	public function updatestatus($id) {
		return $this->teamServices->updatestatus($id);
	}

	public function insert_new(Request $request){
		return $this->teamServices->CheckTeam($request);
	}
}
