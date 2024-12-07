<?php
namespace App\Repositories;
use App\Models\SubCategories;
use App\Models\Categories;

class SubCategoriesRepository {
	// insert new entry
	public function create($request) {
		$input = $request->all();
		$input['created_by'] = auth()->user()->id;
		return SubCategories::create($input);
	}

	// update existing data;
	public function update($subCategories, $request) {
		return $subCategories->update($request->all());
	}

	// softdelete existing data;
	public function delete($subCategories) {
		if ($subCategories->delete()) {
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

	// update status in database
	public function updatestatus($id) {
		$subCategories = SubCategories::findOrfail($id);
		if ($subCategories->status == 'Active') {
			$subCategories->status = 'Inactive';
		} else {
			$subCategories->status = 'Active';
		}
		if ($subCategories->save()) {
			\LogActivity::addToLog("Sub Category Updated Successfully");
			return response(['status' => '1', 'msg' => "Sub Category Updated Successfully"]);
		} else {
			\LogActivity::addToLog("Sub Category Update Failed");
			return response(['status' => '0', 'msg' => "Sub Category Update Failed"]);
		}
	}

	public function insert($request) {
		$name = $request->name;
        $category_id = $request->category_id;
        $subcategories = SubCategories::where('name',$request->name)->get();
        if(count($subcategories) > 0){
          $get_subcategories = SubCategories::select('id','name')->where('category_id',$category_id)->get();
          return response()->json(array("subcategories"=>$get_subcategories,"name"=>$name));
        }else{
          $subcategory_insert = new SubCategories([
            'category_id' => $category_id,
            'name' => $request->name
          ]);
          $subcategory_insert->save();
          $get_subcategories = SubCategories::select('id','name')->where('category_id',$category_id)->get();
          return response()->json(array("subcategories"=>$get_subcategories,"name"=>$name));
        }
	}
}