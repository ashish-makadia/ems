<?php
namespace App\Repositories;
use App\Models\Role;
use App\Models\User;
use App\Models\ShipCompany;

use App\Models\LogActivity as LogActivityModel;
use App\Models\RoleHasPermission;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserRepository {
	// insert new entry
	public function create($request) {
		$role = Role::findOrFail($request['role']);
		$user = new User;
		$user->name = $request['name'];
		$user->email = $request['email'];
		$user->mobile_no = $request['mobile_no'];
		$user->status = 'Active';
		$user->role = $role->name;
		$user->password = Hash::make($request['password']);

		if ($user->save()) {
			$user->syncRoles($request['role']);
			$permissions = RoleHasPermission::where('role_id', $role->id)->pluck('permission_id')->toArray();
			$user->syncPermissions($permissions);

			// $user->syncPermissions($request['permissions'][$request['role']]);
			\LogActivity::addToLog(__('messages.userinssucc'));
			return response(['status' => '1', 'msg' => __('messages.userinssucc'),'userId'=>$user->id]);
		} else {
			\LogActivity::addToLog(__('messages.usernotinssucc'));
			return response(['status' => '1', 'msg' => __('messages.usernotinssucc')]);
		}
	}

	// update existing data;
	public function update($user, $request) {
		if(Auth::user()->role == 'Super Admin'){
			$newrole = $request['role'];
			$status = $request['status'] ? 'Active' : 'Inactive';

			$agent = User::where('email',$user->email)->first();
			if($agent){
				$nameinpunt = $request->name;
				if (str_contains($nameinpunt, "-")){
					$name = explode("-", $nameinpunt);
				} else if(str_contains($nameinpunt, " ")){
					$name = explode(" ", $nameinpunt);
				} else {
					$name1 = $nameinpunt;
				}


				$agent->email = $request->email;
				$agent->mobile_no = $request->mobile_no;
				$agent->status = $request['status'] ? 'Active' : 'Inactive';
				$agent->save();
			}
		}else{
			$status = 'Active';
			$newrole = 3;
		}
		//echo $newrole;
		$user->name = $request->name;
		$user->email = $request->email;
		$user->mobile_no = $request->mobile_no;
		$role = Role::findOrFail($newrole);
		//echo "<pre>";print_r($role);die();
		$user->role = $role->name;
		$user->status = $status;
		$user->role = $role->name;
		if (isset($request->password) && $user->password != $request->password) {
			$user->password = Hash::make($request->password);
		}
		if(isset($user) && $user->role == 'Ship Company'){
			$ship_company = ShipCompany::where('user_id',$user->id)->first();
			$ship_company->first_name = $request->name;
			$ship_company->email = $request->email;
			$ship_company->save();
		}
		if ($user->save()) {
			if(Auth::user()->role == 'Super Admin'){
				$user->syncRoles($request->role);
				if (isset($request->permissions) && isset($request->permissions[$request->role])) {
					$user->syncPermissions($request->permissions[$request->role]);
				} else {
					$user->syncPermissions();
				}
			}

			\LogActivity::addToLog(__('messages.userupdsucc'));
			return response(['status' => '1', 'msg' => __('messages.userupdsucc')]);

		} else {
			\LogActivity::addToLog(__('messages.usernotupdsucc'));
			return response(['status' => '1', 'msg' => __('messages.usernotupdsucc')]);

		}
	}

	// softdelete existing data;
	public function delete($user) {
		$user = User::where('email',$user->email)->first();
		// if($agent){
		// 	return response(['status' => '0', 'msg' => __('messages.usrcntdlt')]);
		// } else {
			if ($user->delete()) {
				\LogActivity::addToLog(__('messages.userdelsucc'));
				return response(['status' => '1', 'msg' => __('messages.userdelsucc')]);
			} else {
				\LogActivity::addToLog(__('messages.userdelfail'));
				return response(['status' => '0', 'msg' => __('messages.userdelfail')]);
			}
		// }
	}
}
