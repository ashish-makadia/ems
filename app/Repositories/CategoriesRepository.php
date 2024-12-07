<?php
namespace App\Repositories;
use App\Models\Categories;

class CategoriesRepository {
	// insert new entry
	public function create($request) {
		$input = $request->all();
		$input['created_by'] = auth()->user()->id;
		return Categories::create($input);
	}

	// update existing data;
	public function update($categories, $request) {
		return $categories->update($request->all());
	}

	// softdelete existing data;
	public function delete($categories) {
		if ($categories->delete()) {
			\LogActivity::addToLog("Category Delete");
			return response()->json(
				[
					'status' => '1',
					'Msg' => "Category Delete Successfully",
				]);
		} else {
			return response()->json(
				[
					'status' => '0',
					'Msg' => "Category Delete Failed",
				]);
		}
	}

	// update status in database
	public function updatestatus($id) {
		$categories = Categories::findOrfail($id);
		\LogActivity::addToLog("Category Status Change");

		if ($categories->status == 'Active') {
			$categories->status = 'Inactive';
		} else {
			$categories->status = 'Active';
		}
		if ($categories->save()) {
			return response(['status' => '1', 'msg' => "Category Status Changed Successfully"]);
		} else {
			return response(['status' => '0', 'msg' => "Category Status Update Failed"]);
		}
	}
}
