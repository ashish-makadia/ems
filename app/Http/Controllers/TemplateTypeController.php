<?php

namespace App\Http\Controllers;

use App\Authorizable;
use App\Models\TemplateType;
use App\Models\Designation;
use App\Repositories\TemplateTypeRepository;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Http\Request;

class TemplateTypeController extends Controller {
	use Authorizable;
	protected $templateTypeRepository;
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function __construct() {
		$this->templateTypeRepository = new TemplateTypeRepository;
		$this->middleware('auth');
	}

	public function index(Request $request) {
		$breadcrumb[0]['name'] = 'templatetype';
		$breadcrumb[0]['url'] = url('templatetype');
		$breadcrumb[1]['name'] =  "TemplateType Listing";
		$breadcrumb[0]['editname'] =  "Edit TemplateType";
		$breadcrumb[1]['url'] = '';

		if ($request->ajax()) {
			return json_encode($this->templateTypeRepository->getDatatable($request));
		}

		return view('template_type.index', compact(['breadcrumb']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$data['view'] = view('template_type.create')->render();
		return response()->json($data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
        $inputData = $request->except('_token');
		return $this->templateTypeRepository->create($inputData);
	}

	public function show(TemplateType $templatetype) {
		return back();
	}

	public function edit(TemplateType $templatetype) {
		$data['view'] = view('template_type.create', compact('templatetype'))->render();
		return response()->json($data);
	}

	public function update(Request $request, TemplateType $templatetype) {
		return $this->templateTypeRepository->update($templatetype, $request);
	}
	public function destroy(TemplateType $templatetype) {
		return $this->templateTypeRepository->delete($templatetype);
	}

	public function updatestatus($id) {
		return $this->templateTypeRepository->updatestatus($id);
	}

	public function insert_new(Request $request){
		return $this->templateTypeRepository->CheckDepartment($request);
	}
}

