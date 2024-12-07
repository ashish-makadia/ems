<?php

namespace App\Services;
use App\Models\Categories;
use App\Repositories\CategoriesRepository;

class CategoriesServices {

	protected $categoryRepository;

	public function __construct() {
		$this->categoryRepository = new CategoriesRepository;
	}

	// show datatable
	public function getDatatable(object $request) {
		$json = array();

		$sql = Categories::where(function ($query) use ($request) {
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
	public function createCategories($request) {

		if ($this->categoryRepository->create($request)) {
			\LogActivity::addToLog("Category Insert Successfull");
			return response(['status' => '1', 'msg' => "Category Insert Successfull"]);
		} else {
			\LogActivity::addToLog("Category Insert Failed");
			return response(['status' => '0', 'msg' => "Category Insert Failed"]);
		}
	}

	// update existing data;
	public function updateCategories($categories, $request) {
		$request['status'] = isset($request['status']) ? 'Active' : 'Inactive';
		if ($this->categoryRepository->update($categories, $request)) {
			\LogActivity::addToLog("Category Update Successfull");
			return response(['status' => '1', 'msg' => "Category Update Successfull"]);
		} else {
			\LogActivity::addToLog("Category Update Failed");
			return response(['status' => '0', 'msg' => "Category Update Failed"]);
		}
	}

	// softdelete existing data;
	public function deleteCategories($categories) {
		return $this->categoryRepository->delete($categories);
	}

	// update status
	public function updatestatus($id) {
		return $this->categoryRepository->updatestatus($id);
	}

	public function CheckCategories($request){
		$name = $request->categories_name;
		echo $name;
	}
}
