<?php
namespace App\Repositories;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

use App\Models\LogActivity as LogActivityModel;
class CustomerRepository {
    // insert new entry
	public function create($request) {
		$customer = Customer::create($request);

		if ($customer) {
			\LogActivity::addToLog('Customer Inserted Successfully');
            session()->flash('success', 'Customer Inserted Successfully');
			return response()->json(['status' => '1', 'msg' => 'Customer Inserted Successfully']);
		} else {
			\LogActivity::addToLog('Customer Insert Failed');
            session()->flash('success', 'Customer Insert Failed');
			return response()->json(['status' => '1', 'msg' => 'Customer Insert Failed']);
		}
	}

    public function getDatatable(object $request) {
		$json = array();

			if (isset($request->search['value'])) {
				$sql = Customer::with("subCategory","category")->where(function ($query) use ($request) {
					$query->where('company_name', 'like', '%' . $request->search['value'] . '%')
						->orWhere('zipcode', 'like', '%' . $request->search['value'] . '%')
						->orWhere('address', 'like', '%' . $request->search['value'] . '%')
						->orWhere('company_email', 'like', '%' . $request->search['value'] . '%')
						->orWhere('company_phone', 'like', '%' . $request->search['value'] . '%')
						->orWhere('company_mobile', 'like', '%' . $request->search['value'] . '%')
						->orWhere('website', 'like', '%' . $request->search['value'] . '%')
						->orWhere('fiscal_code', 'like', '%' . $request->search['value'] . '%')
						->orWhere('vat_id', 'like', '%' . $request->search['value'] . '%');

				})->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			} else {
				$sql = Customer::with("subCategory","category")->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']);
			}

		$recordsTotal = $sql->count();
		$data = $sql->limit($request->length)->skip($request->start)->get();
		$recordsFiltered = count($data);

		$json['data'] = $data;
		$json['draw'] = $request->draw;
		$json['recordsTotal'] = $recordsFiltered;
		$json['recordsFiltered'] = $recordsTotal;

		return $json;
	}

	// update existing data;
	public function update($id, $request) {

        $customer = Customer::where('id',$id);
        if(!$customer->first()){
            session()->flash('danger', __('messages.emailtemplatestafail'));
            return response(['status' => '0', 'msg' => __('messages.emailtemplatestafail')]);
        }

		if ($customer->update($request)) {
			\LogActivity::addToLog("customer updated successfully");
            $message = __('messages.emailtemplateupdsucc');
            session()->flash('success', $message);
			return response()->json(['status' => '1', 'msg' => $message]);
		} else {
			\LogActivity::addToLog("customer not updated successfully");
            session()->flash('danger', __('messages.emailtemplatenotupdsucc'));
			return response(['status' => '1', 'msg' => __('messages.emailtemplatenotupdsucc')]);
		}
	}

	// softdelete existing data;
	public function delete($id) {
		$customer = Customer::findOrfail($id);
		if (!$customer) {
            session()->flash('danger', __('messages.emailtemplatestafail'));
            return response(['status' => '0', 'msg' => __('messages.emailtemplatestafail')]);
		} else {
			if ($customer->delete()) {
				\LogActivity::addToLog("customer not deleted");
                $message = __('messages.emailtemplatedelsucc');
                session()->flash('success', $message);
				return response(['status' => '1', 'msg' => __('messages.emailtemplatedelsucc')]);
			} else {
				\LogActivity::addToLog("customer not deleted successfully");
                session()->flash('danger', __('messages.emailtemplatedelfail'));
				return response(['status' => '0', 'msg' => __('messages.emailtemplatedelfail')]);
			}
		}
	}

	// update status in database
	public function updatestatus($id) {
		$customer = Customer::findOrfail($id);
		if ($customer) {
			if ($customer->status == 'Active') {
				$customer->status = 'Inactive';
			} else {
				$customer->status = 'Active';
			}

			if ($customer->save()) {
				return response(['status' => '1', 'msg' => __('messages.emailtemplatestasucs')]);
			} else {
				\LogActivity::addToLog(__('messages.emailtemplatedelfail'));
				return response(['status' => '0', 'msg' => __('messages.emailtemplatestafail')]);
			}
		} else {
			\LogActivity::addToLog(__('messages.emailtemplatedelfail'));
			return response(['status' => '0', 'msg' => __('messages.emailtemplatestafail')]);
		}
	}
}
