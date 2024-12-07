<?php

namespace App\Http\Controllers;

use App\Authorizable;
use App\Models\Categories;
use App\Models\SubCategories;
use App\Services\CategoriesServices;
use App\Http\Requests\CategoriesRequest;
use Illuminate\Http\Request;
use Response;

class CategoriesController extends Controller {
	use Authorizable;
	protected $categoryServices;
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function __construct() {
		$this->categoryServices = new CategoriesServices;
		$this->middleware('auth');
	}

	public function index(Request $request) {
		$breadcrumb[0]['name'] = 'categories';
		$breadcrumb[0]['url'] = url('categories');
		$breadcrumb[1]['name'] =  "Category Listing";
		$breadcrumb[0]['editname'] =  "Edit Category";
		$breadcrumb[1]['url'] = '';

		if ($request->ajax()) {
			return json_encode($this->categoryServices->getDatatable($request));
		}

		return view('category.index', compact(['breadcrumb']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$data['view'] = view('category.create')->render();
		return response()->json($data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CategoriesRequest $request) {
		return $this->categoryServices->createCategories($request);
	}

	public function show(Categories $categories) {
		return back();
	}

	public function edit(Categories $category) {
		$data['view'] = view('category.create', compact('category'))->render();
		return response()->json($data);
	}

	public function update(Request $request, Categories $categories) {
	
		$request['status'] = isset($request['status']) ? 'Active' : 'Inactive';
			if($request->id){
				$data = array(
					'name' => $request->name,
					'status' => $request->status,
				);
			$store = Categories::where('id', $request->id)->update($data);
			\LogActivity::addToLog("Category Update Successfull");
			return response(['status' => '1', 'msg' => "Category Update Successfull"]);
		} else {
			\LogActivity::addToLog("Category Update Failed");
			return response(['status' => '0', 'msg' => "Category Update Failed"]);
		}
	}
	public function destroy(Request $request) {
		$res=Categories::find($request->id)->delete();
	if ($res) {
		\LogActivity::addToLog("Category Deleted Successfully");
		return response()->json(
			[
				'status' => '1',
				'Msg' => "Category Deleted Successfully",
			]);
	} else {
		\LogActivity::addToLog("Category Delete Failed");
		return response()->json(
			[
				'status' => '0',
				'Msg' => "Category Delete Failed",
			]);
	}
	}

	public function updatestatus($id) {
		return $this->categoryServices->updatestatus($id);
	}

	public function get_subcategory_list(Request $request){
		$subCategories = SubCategories::select('id','name')->where('category_id',$request->category_id)->get();
        return response()->json($subCategories);
	}
	public function get_subcategory_lists($id){
		$data = SubCategories::where('category_id',$id)->get();
		return $data;
        //return response()->$subCategory;
	}
	public function insert_new(Request $request){
		return $this->categoryServices->CheckCategories($request);
	}
}
