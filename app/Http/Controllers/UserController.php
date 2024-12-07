<?php

namespace App\Http\Controllers;

use App\Authorizable;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\Employee;
use Hash;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Auth;
use Session;

class UserController extends Controller
{

	use Authorizable;
	protected $userServices;

	public function __construct()
	{
		$this->userServices = new UserServices;
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$breadcrumb[0]['name'] = 'userdata';
		$breadcrumb[0]['url'] = url('user');
		$breadcrumb[1]['name'] =  __('messages.userlisting');
		$breadcrumb[1]['datatable'] = 'UserListing';
		$breadcrumb[0]['editname'] =  __('messages.edituser');
		$breadcrumb[1]['url'] = '';

		if ($request->ajax()) {
			return json_encode($this->userServices->getDatatable($request));
		}

		return view('user.index', compact(['breadcrumb']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{

		// $roles = Role::orderBy('name', 'ASC')->pluck('name', 'id')->except(1);
		$roles = Role::orderBy('name', 'ASC')->get()->except(1);
		$data['view'] = view('user.create', compact('roles'))->render();
		return response()->json($data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(UserRequest $request)
	{
		$user = $this->userServices->createUser($request);
		$userData = json_decode(json_encode($user), 1);
		$userId = $userData["original"]["userId"];

		$role = Role::where("name", "Employee")->first();
		if (empty($role)) {
			$role = Role::create([
				'name' => "Employee",
				'guard' => 'web'
			]);
		}

        if($role->id == $request->role){
            $employeeData = array(
                'user_id' => $userId,
                'name' => $request->name,
                'email' => $request->email,
                'role' => $role->id,
                'password' => Hash::make($request->password),
                'phone' => $request->mobile_no,
                'status' => "Active",
            );
            $res = Employee::create($employeeData);
        }

		 // dd($employeeData);
		return $user;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return back();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(User $user)
	{
		$roles = Role::orderBy('name', 'ASC')->get()->except(1);
		// $user->role = $user->roles[0]->id;
		$data['view'] = view('user.create', compact('roles', 'user'))->render();
		return response()->json($data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UserRequest $request, User $user)
	{
		$res =  $this->userServices->updateUser($user, $request);
        $employee = Employee::where('user_id', $user->id)->first();

        $role = Role::where("name", "Employee")->first();
        if (empty($role)) {
            $role = Role::create([
                'name' => "Employee",
                'guard' => 'web'
            ]);
        }

        if($role->id == $request->role){
            if(empty($employee) ){
                $employeeData = array(
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'role' => $role->id,
                    'password' => Hash::make($request->password),
                    'phone' => $request->mobile_no,
                    'status' => "Active",
                );
                Employee::create($employeeData);
            } else {
                $employeeData = array(
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->mobile_no,
                    'status' => "Active",
                );
                Employee::where('user_id', $user->id)->update($employeeData);
            }
        }
		return $res;
	}
	public function edit_profile(Request $request)
	{
		$user = Auth::user();
		$employee = Employee::where('user_id', $user->id)->first();
		return view('user.profile', compact('user','employee'));
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user)
	{
		$employee = Employee::where('user_id', $user->id);
		if (!$employee) {
			Session::flash('danger', 'Employee not found!');
			// $this->flashMessage('warning', 'Category not found!', 'danger');
			return response()->json([
				'status' => false,
				'message' => 'Employee not found!'
			]);
		}
		$employee->delete();
		return $this->userServices->deleteUser($user);
	}

	/**
	 * change status the specified resource from database.
	 *
	 * @param id
	 * @return \Illuminate\Http\Response
	 */
    public function updatestatus($id) {
        $message["success"] =  __('messages.userstasucs');
        $message["error"] =  __('messages.userstafail');
        return changeStatus(User::class,$message,$id);
    }
	public function updateprofile(Request $request, $id)
	{
		//echo $request->image; exit;
		$profile = array(
			'name' => $request->name,
			'email' => $request->email,
			'mobile_no' => $request->mobile_no,
		);
	//	echo $request->image; exit;
		$employee = Employee::where('user_id', $id)->first();
		if ($employee) {
			if($request->has('image')){
				$inputData['image'] =  $imageName = time().'.'.$request['image']->getClientOriginalExtension();
				$request->image->move(public_path('images/'.Employee::$uploadFolderName), $imageName);
			}else{
				$inputData['image'] =$request->old_image;
			}
			$inputData['name'] = $request->name;
			$inputData['email'] = $request->email;
			$inputData['phone'] = $request->mobile_no;
			$inputData['address'] = $request->address;
			$inputData['pincode'] = $request->pincode;
			$inputData['pan'] = $request->pan;
			Employee::where('user_id', $id)->update($inputData);
		}
		User::where('id', $id)->update($profile);
		Session::flash('success', 'Profile Updated Successfull!');
		return redirect()->back();
	}
	public function password_change(Request $request)
	{
		$user = Auth::user();
		if (Hash::check($request->o_password, $user->password)) {
			if ($request->n_password == $request->c_password) {
				$inputData['password'] = Hash::make($request->c_password);
				User::where('id', $user->id)->update($inputData);
				Session::flash('success', 'Password Changed');
				return redirect()->back();
			} else {
				Session::flash('danger', 'New and Confirm Password Not Matched!');
				return redirect()->back();
			}
		} else {
			Session::flash('danger', 'Old Password Not Valid!');
			return redirect()->back();
		}
	}
	public function changelocale($locale)
	{
		\Session::put('locale', $locale);
		return redirect()->back();
	}
}
