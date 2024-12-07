<?php
namespace App\Repositories;
use App\Models\TemplateType;

class TemplateTypeRepository {

    public function getDatatable(object $request) {
		$json = array();

		$sql = TemplateType::where(function ($query) use ($request) {
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
	public function create($request) {
		$input = $request;
		$input['created_by'] = auth()->user()->id;
		$templateType =  TemplateType::create($input);
        if ($templateType) {
			\LogActivity::addToLog("Template Type Added");
            session()->flash('success', "Template Type Added succesfully");
			return response()->json(['status' => '1', 'msg' => "Template Type Added succesfully"]);
		} else {
			\LogActivity::addToLog("Template Type Not Added");
            session()->flash('success', "Template Type Not Added Successfully");
			return response()->json(['status' => '1', 'msg' => "Template Type Not Added Successfully"]);
		}
	}

	// update existing data;
	public function update($templatetype, $request) {
		$templateType = $templatetype->update($request->all());
        if ($templateType) {
			\LogActivity::addToLog("Template Type Added");
            session()->flash('success', "Template Type Updated succesfully");
			return response()->json(['status' => '1', 'msg' => "Template Type Updated succesfully"]);
		} else {
			\LogActivity::addToLog("Template Type Not Updated");
            session()->flash('success', "Template Type Not Updated Successfully");
			return response()->json(['status' => '1', 'msg' => "Template Type Not Updated Successfully"]);
		}
	}

	// softdelete existing data;
	public function delete($templatetype) {
		if ($templatetype->delete()) {
			\LogActivity::addToLog("TemplateType Delete");
			return response()->json(
				[
					'status' => '1',
					'Msg' => "TemplateType Delete Successfully",
				]);
		} else {
			return response()->json(
				[
					'status' => '0',
					'Msg' => "TemplateType Delete Failed",
				]);
		}
	}

	// update status in database
	public function updatestatus($id) {
		$TemplateType = TemplateType::findOrfail($id);
		\LogActivity::addToLog("TemplateType Status Change");

		if ($TemplateType->status == 'Active') {
			$TemplateType->status = 'Inactive';
		} else {
			$TemplateType->status = 'Active';
		}
		if ($TemplateType->save()) {
			return response(['status' => '1', 'msg' => "TemplateType Status Changed Successfully"]);
		} else {
			return response(['status' => '0', 'msg' => "TemplateType Status Update Failed"]);
		}
	}
}
