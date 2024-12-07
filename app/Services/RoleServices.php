<?php

namespace App\Services;
use App\Models\Permission;
use App\Models\Role;
use App\Repositories\RoleRepository;
use DB;

class RoleServices {

	protected $roleRepository;

	public function __construct() {
		$this->roleRepository = new RoleRepository;
	}

	//get the roles
	public function getRoles() {
		return Role::orderBy('id', 'DESC')->paginate(5)->except(1);
	}

	//get the permission
	public function getPermission() {
		return Permission::get();
	}

	// insert new entry
	public function createRole($request) {
		return $this->roleRepository->create($request);
	}

	// get single role
	public function getSingleRole($id) {
		$data['role'] = Role::find($id);
		$data['rolePermissions'] = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")->where("role_has_permissions.role_id", $id)->get();
		return $data;
	}

	//get edit data
	public function getEditData($id) {
		$data['role'] = Role::find($id);
		$data['permission'] = Permission::get();
		$data['rolePermissions'] = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')->all();
		return $data;
	}

	//update the data
	public function updateRole($request, $role) {
		return $this->roleRepository->update($request, $role);
	}
}