<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectAttachment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
class ProjectAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

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
            'file' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        $inputData['project_id'] = $request->project_id;
        if($request->has('file')){
            $imageName = time().'.'.$request->file->getClientOriginalName();
             // //Store in Storage Folder
            $request->file->storeAs('projects', $imageName);
            $inputData['files'] = $imageName;
        }
        ProjectAttachment::create($inputData);
        return response()->json([
            'status' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attachment = ProjectAttachment::find($id);
        $attachment->delete();
        // Session::flash('success', 'Attachment successfully deleted!');
        return response()->json([
            'status' => true,
            'msg' => 'Attachment successfully deleted!'
        ]);
    }
}
