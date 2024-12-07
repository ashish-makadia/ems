<?php
namespace App\Repositories;
use App\Models\Role;
use App\Models\RoleHasPermission;

class RoleRepository {
	// insert new entry
	public function create($request) {
		$role = Role::create(['name' => $request->input('name'), 'guard_name' => 'web']);
		if ($request->input('permission')) {
			foreach ($request->input('permission') as $key => $permission) {
				RoleHasPermission::create(['permission_id' => $permission, 'role_id' => $role->id]);
			}
		}
		\LogActivity::addToLog(__('messages.roleinssucc'));
		return redirect()->route('roles.index')->with('success_message', __('messages.roleinssucc'));
	}

	//update record
	public function update($request, $role) {
		$role = Role::find($role->id);
		$role->name = $request->name;
		$role->guard_name ="web";
		$role->save();
		if ($request->has('permission')) {
			$role->haspermissions()->delete();
			foreach ($request->input('permission') as $key => $permission) {
				RoleHasPermission::create(['permission_id' => $permission, 'role_id' => $role->id]);
			}
		} else {
			$role->haspermissions()->delete();
		}
		\LogActivity::addToLog(__('messages.roleupdsucc'));
		return redirect()->route('roles.index')->with('success_message', __('messages.roleupdsucc'));
	}
}