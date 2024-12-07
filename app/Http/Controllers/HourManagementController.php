<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HourManagement;
use App\Models\LogActivity as LogActivityModel;
use Session;

class HourManagementController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $hoursmanage = HourManagement::where('id', 1)->first();
        if($hoursmanage){
            $hours=$hoursmanage;
        }else{
            $hours="";
        }
        return view('hourmanagement.index',compact(['hours']));
    }
    public function store(Request $request)
    {
        $id = $request->id;
        if($id){
            $data = array(
                'fulltime_hours' => $request->fulltime_hours,
                'parttime_hours' => $request->parttime_hours,
                'halftime_hours' => $request->halftime_hours,
            );
            $store = HourManagement::where('id', $id)->update($data);
        }else{
            $data = array(
                'fulltime_hours' => $request->fulltime_hours,
                'parttime_hours' => $request->parttime_hours,
                'halftime_hours' => $request->halftime_hours,
            );
            $store = HourManagement::create($data);
        }
        if ($store) {
            Session::flash('success', 'Settings update successfully!');
        } else {
            Session::flash('danger', 'Something went worng! Please contact to administrator');
        }
        return redirect()->back();
    }
   
    
}
