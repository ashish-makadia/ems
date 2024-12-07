<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Authorizable;
use App\Models\Customer;
use App\Models\Categories;
use App\Models\SubCategories;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Validator;
use App\Models\Country;
use App\Models\Region;
use App\Models\Province;
use App\Models\Municipality;
use Illuminate\Support\Facades\Session;


class CustomerController extends Controller
{
    use Authorizable;
	protected $customerModel;

	public function __construct() {
		$this->customerModel = new CustomerRepository;
		$this->middleware('auth');
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $breadcrumb[0]['name'] = 'customer';
        $breadcrumb[0]['url'] = url('customer');
        $breadcrumb[1]['name'] = 'customer';
        $breadcrumb[1]['datatable'] = 'Customer';
        $breadcrumb[0]['editname'] = 'Edit Customer';
        $breadcrumb[1]['url'] = '';



        if ($request->ajax()) {
			return json_encode($this->customerModel->getDatatable($request));
		}

        return view('customer.index', compact('breadcrumb'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categories::get();
        $subcategories = SubCategories::get();
        $regions = Region::get();
        $country = Country::get();
        $province = Province::get();
        $municipality = Municipality::get();
        return view('customer.create', compact('categories','subcategories','regions','country','province','municipality'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $inputData = $request->except('_token');
        // $inputData['designation_id'] = $request->designation_id;

        $inputData['status'] = 'Active';
        $res = $this->customerModel->create($inputData);

        return $res;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $customer = Customer::find($id);
        $categories = Categories::get();
        $subcategories = SubCategories::get();
        $regions = Region::get();
        $country = Country::get();
        $province = Province::get();
        $municipality = Municipality::get();
        return view('customer.edit', compact('customer','categories','subcategories','regions','country','province','municipality'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
     {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'subCategory' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $inputData = $request->except('_token', '_method');

        // $inputData['designation_id'] = $request->designation_id;
        $inputData['status'] = 'Active';

        return $this->customerModel->update($id, $inputData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function destroy($id)
    {
        return $this->customerModel->delete($id);
    }
    public function updatestatus($id) {
        $message["success"] =  "Customer stataus updated Successfully";
        $message["error"] =  "Customer stataus not updated Successfully";
        return changeStatus(Customer::class,$message,$id);
    }

    //mail send using trait comon function

}
