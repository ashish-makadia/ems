<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Services\RoleServices;
use Illuminate\Http\Request;

class RoleController extends Controller {
	protected $roleServices;

	public function __construct() {
		$this->middleware('auth');
		$this->roleServices = new RoleServices;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		$breadcrumb[0]['name'] = 'Dashboard';
		$breadcrumb[0]['url'] = url('dashboard');
		$breadcrumb[0]['editname'] =  __('messages.edit role');
		$breadcrumb[1]['name'] =  __('messages.rolelisting');
		$breadcrumb[1]['url'] = '';

		$roles = $this->roleServices->getRoles();

		return view('admin.roles.index', compact('roles', 'breadcrumb'))->with('i', ($request->input('page', 1) - 1) * 5);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$breadcrumb[0]['name'] = 'Dashboard';
		$breadcrumb[0]['url'] = url('dashboard');
		$breadcrumb[1]['name'] = 'Role Listing';
		$breadcrumb[1]['url'] = url('roles');
		$breadcrumb[2]['name'] = 'Add Role';
		$breadcrumb[2]['url'] = '';

		$permission = $this->roleServices->getPermission();

		return view('admin.roles.create', compact('permission', 'breadcrumb'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(RoleRequest $request) {
		return $this->roleServices->createRole($request);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$data = $this->roleServices->getSingleRole($id);

		$role = $data['role'];
		$rolePermissions = $data['rolePermissions'];

		return view('admin.roles.show', compact('role', 'rolePermissions'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$breadcrumb[0]['name'] = 'Dashboard';
		$breadcrumb[0]['url'] = url('dashboard');
		$breadcrumb[1]['name'] = 'Role Listing';
		$breadcrumb[1]['url'] = url('roles');
		$breadcrumb[2]['name'] = 'Edit Role';
		$breadcrumb[2]['url'] = '';

		$data = $this->roleServices->getEditData($id);

		$role = $data['role'];
		$permission = $data['permission'];
		$rolePermissions = $data['rolePermissions'];
		return view('admin.roles.edit', compact('role', 'permission', 'rolePermissions', 'breadcrumb'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(RoleRequest $request, Role $role) {
		return $this->roleServices->updateRole($request, $role);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		abort(404);
	}
}
