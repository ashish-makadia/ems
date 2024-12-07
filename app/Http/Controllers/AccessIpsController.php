<?php

namespace App\Http\Controllers;

use App\Authorizable;
use App\Models\AccessIps;
use Illuminate\Http\Request;
use App\Services\AccessIpsServices;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccessipRequest;
// use Location;

class AccessIpsController extends Controller
{
    use Authorizable;
    protected $accessIpsservices;

    public function __construct()
    {   
        $this->middleware('auth');
        $this->accessIpsservices = new AccessIpsServices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumb[0]['name'] = 'accessips';
        $breadcrumb[0]['datatable'] = 'accessips';
        $breadcrumb[0]['url'] = url('accessips');
        $breadcrumb[0]['editname'] = __('messages.editrecord');
        $breadcrumb[1]['name'] =  __('messages.accessip');
        $breadcrumb[1]['url'] = '';
        if ($request->ajax())
        {
            return json_encode($this->accessIpsservices->getDatatable($request));
        }
        return view('accessips.index',compact(['breadcrumb']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['view'] = view('accessips.create')->render();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccessipRequest $request)
    {
        return $this->accessIpsservices->createAccessip($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccessIps  $accessIps
     * @return \Illuminate\Http\Response
     */
    public function show(AccessIps $accessip)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccessIps  $accessIps
     * @return \Illuminate\Http\Response
     */
    public function edit(AccessIps $accessip)
    {
        $data['view'] = view('accessips.create',compact('accessip'))->render();
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccessIps  $accessIps
     * @return \Illuminate\Http\Response
     */
    public function update(AccessipRequest $request, AccessIps $accessip)
    {
        return $this->accessIpsservices->updateAccessip($accessip,$request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccessIps  $accessIps
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccessIps $accessip)
    {
        return $this->accessIpsservices->deleteAccessip($accessip);
    }

    /**
     * change status the specified resource from database.
     *
     * @param id
     * @return \Illuminate\Http\Response
     */
    public function updatestatus($id)
    {
        return $this->accessIpsservices->updatestatus($id);
    }
}
