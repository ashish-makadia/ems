<?php

namespace App\Http\Controllers;

use App\Authorizable;
use App\Http\Requests\SubCategoriesRequest;
use App\Models\SubCategories;
use App\Models\Categories;
use App\Services\SubCategoriesServices;
use Illuminate\Http\Request;

class SubCategoriesController extends Controller {

	use Authorizable;
	protected $subCategoriesServices;
	
	public function __construct() {
		$this->subCategoriesServices = new SubCategoriesServices;
		$this->middleware('auth');
	}

	public function index(Request $request) {

		$breadcrumb[0]['name'] = 'sub_categories';
		$breadcrumb[0]['url'] = url('sub_categories');
		$breadcrumb[1]['name'] = "Sub Categories Listing";
		$breadcrumb[0]['editname'] = "Edit Sub Categories";
		$breadcrumb[1]['url'] = '';

		if ($request->ajax()) {
			return json_encode($this->subCategoriesServices->getDatatable($request));
		}

		return view('sub_category.index', compact(['breadcrumb']));
	}

	
	public function create() {

		$category = Categories::where('status','Active')->pluck('name', 'id');
		$data['view'] = view('sub_category.create', compact('category'))->render();
		return response()->json($data);
	}

	
	public function store(SubCategoriesRequest $request) {
		return $this->subCategoriesServices->createsubCategories($request);
	}

	
	public function show(SubCategories $subCategories) {
		return back();
	}

	public function edit(SubCategories $subCategory) {
		$category = Categories::where('status','Active')->pluck('name', 'id');
		$data['view'] = view('sub_category.create', compact('subCategory', 'category'))->render();
		return response()->json($data);
	}


	public function update(SubCategoriesRequest $request, SubCategories $subCategories) {
		$request['status'] = isset($request['status']) ? 'Active' : 'Inactive';
			if($request->id){
				$data = array(
					'name' => $request->name,
					'status' => $request->status,
					'category_id' => $request->category_id,
				);
			$store = SubCategories::where('id', $request->id)->update($data);
			\LogActivity::addToLog("Sub Category Update Successfull");
			return response(['status' => '1', 'msg' => "Sub Category Update Successfull"]);
		} else {
			\LogActivity::addToLog("Sub Category Update Failed");
			return response(['status' => '0', 'msg' => "Sub Category Update Failed"]);
		}
	}

	public function destroy(Request $request) {
		$res=SubCategories::find($request->id)->delete();
	if ($res) {
		\LogActivity::addToLog("Sub Category Deleted Successfully");
		return response()->json(
			[
				'status' => '1',
				'Msg' => "Sub Category Deleted Successfully",
			]);
	} else {
		\LogActivity::addToLog("Sub Category Delete Failed");
		return response()->json(
			[
				'status' => '0',
				'Msg' => "Sub Category Delete Failed",
			]);
	}
	}

	public function updatestatus($id) {
		return $this->subCategoriesServices->updatestatus($id);
	}

	public function insert(Request $request) {
		return $this->subCategoriesServices->insert($request);
	}
	public function insert_new(Request $request)
    {
        $name = $request->name;
        $category_id = $request->category_id;
        $subcategories = SubCategories::where('name',$request->name)->get();
        if(count($subcategories) > 0){
          $get_subcategories = SubCategories::select('id','name')->where('category_id',$category_id)->get();
          return response()->json(array("subcategories"=>$get_subcategories,"name"=>$name));
        }else{
          $subcategory_insert = new SubCategories([
            'department_id' => $department_id,
            'name' => $request->name,
          ]);
          $subcategory_insert->save();
          $get_subcategories = SubCategories::select('id','name')->where('category_id',$category_id)->get();
          return response()->json(array("subcategories"=>$get_subcategories,"name"=>$name));
        }
    }
}
