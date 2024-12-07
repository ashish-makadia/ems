<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use DB;
use Redirect;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumb[0]['name'] = 'Dashboard';
        $breadcrumb[0]['url'] = url('dashboard');
        $breadcrumb[0]['editname'] = "Edit Permission";
        $breadcrumb[1]['name'] = 'Permission Listing';
        $breadcrumb[1]['url'] = '';
        $permissions = Permission::orderBy('id','DESC')->paginate(10);
        return view('admin.permissions.index',compact('permissions'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumb[0]['name'] = 'Dashboard';
        $breadcrumb[0]['url'] = url('dashboard');
        $breadcrumb[1]['name'] = 'Permission Listing';
        $breadcrumb[1]['url'] = url('permissions');
        $breadcrumb[2]['name'] = 'Add Permission';
        $breadcrumb[2]['url'] = '';
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Permission::create(['name' => 'view ' . $request->input('name'),'guard_name' => 'web']);
        Permission::create(['name' => 'add ' . $request->input('name') ,'guard_name' => 'web']);
        Permission::create(['name' => 'edit ' . $request->input('name') ,'guard_name' => 'web']);
        Permission::create(['name' => 'delete ' . $request->input('name') ,'guard_name' => 'web']);
        return redirect()->route('permissions.index')->with('success_message','Permission added successfully');
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
    public function edit($id)
    {
        $breadcrumb[0]['name'] = 'Dashboard';
        $breadcrumb[0]['url'] = url('dashboard');
        $breadcrumb[1]['name'] = 'Permission Listing';
        $breadcrumb[1]['url'] = url('permissions');
        $breadcrumb[2]['name'] = 'Edit Permission';
        $breadcrumb[2]['url'] = '';
       $permission = Permission::findOrFail($id);
        return view('admin.permissions.edit',compact('permission'));
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
        $permission = Permission::findOrFail($id);
        $permission->name = $request->input('name');
        $permission->save();
        return redirect()->route('permissions.index')->with('success_message','Permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return back();
    }
}
