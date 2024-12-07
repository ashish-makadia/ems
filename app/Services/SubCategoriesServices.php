<?php

namespace App\Services;

use App\Models\SubCategories;
use App\Repositories\SubCategoriesRepository;

class SubCategoriesServices
{
	protected $subCategoriesRepository;

	public function __construct()
	{
		$this->subCategoriesRepository = new SubCategoriesRepository;
	}

	// show datatable
	public function getDatatable(object $request)
	{
		$json = array();


		$sql = SubCategories::select('categories.name as category_name', 'sub_categories.*')->leftjoin('categories', 'categories.id', '=', 'sub_categories.category_id')->where(function ($query) use ($request) {
			$query->where('categories.name', 'like', '%' . $request->search['value'] . '%')
				->orWhere('sub_categories.name', 'like', '%' . $request->search['value'] . '%')
				->orWhere('sub_categories.status', 'like', '%' . $request->search['value'] . '%');
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
	public function createsubCategories($request)
	{
		if ($this->subCategoriesRepository->create($request)) {
			\LogActivity::addToLog("Sub Category Inserted Successfully");
			return response(['status' => '1', 'msg' => "Sub Category Inserted Successfully"]);
		} else {
			\LogActivity::addToLog("Sub Category Insert Failed");
			return response(['status' => '0', 'msg' => "Sub Category Insert Failed"]);
		}
	}

	// update existing data;
	public function updatesubCategories($subCategories, $request)
	{
		$request['updated_by'] = auth()->user()->id;
		$request['status'] = isset($request['status']) ? 'Active' : 'Inactive';

		if ($this->subCategoriesRepository->update($subCategories, $request)) {
			\LogActivity::addToLog("Sub Category Updated Successfully");
			return response(['status' => '1', 'msg' => "Sub Category Updated Successfully"]);
		} else {
			\LogActivity::addToLog("Sub Category Update Failed");
			return response(['status' => '0', 'msg' => "Sub Category Update Failed"]);
		}
	}

	// softdelete existing data;
	public function deletesubCategories($subCategories)
	{
		return $this->subCategoriesRepository->delete($subCategories);
	}

	// update status
	public function updatestatus($id)
	{
		return $this->subCategoriesRepository->updatestatus($id);
	}

	public function insert($request)
	{
		return $this->subCategoriesRepository->insert($request);
	}
}
