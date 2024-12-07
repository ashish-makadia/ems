<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use App\Models\Team;
use Hash;
use App\Models\Project;
// use Illuminate\Support\Facades\Hash;
use App\Services\EmployeeServices;
use App\Services\UserServices;
use App\Models\Role;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Department;
use App\Models\Designation;

// use Carbon\Carbon;
use App\Models\LogActivity as LogActivityModel;

class EmployeeController extends Controller
{
    protected $employeeServices,$userServices,$userRepository;
    public function __construct() {
        $this->employeeServices = new EmployeeServices;
        $this->userServices = new UserServices;
        $this->userRepository = new UserRepository;
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $breadcrumb[0]['name'] = 'employeedata';
        $breadcrumb[0]['url'] = url('employee');
        $breadcrumb[1]['name'] =  __('messages.employeelisting');
        $breadcrumb[1]['datatable'] = 'EmployeeListing';
        $breadcrumb[0]['editname'] =  __('messages.editemployee');
        $breadcrumb[1]['url'] = '';

        if ($request->ajax()) {
            return json_encode($this->employeeServices->getDatatable($request));
        }

        return view('employee.index', compact(['breadcrumb']));
    }

    public function create(){
        $categories = Department::where('status',"Active")->get();
        $designations = Designation::where('status',"Active")->get();
        $team = Team::where('status',"Active")->get();
        $employee_type = ['Full Time','Part Time','Half Time'];
        return view('employee.create',compact('categories','designations','employee_type','team'));
    }

    // public function getEmployeeProject(Request $request){
    //     $emp_id = $request->employee_id;
    //     $project = Project::whereJsonContains('team_members',$emp_id)->get();
    //     // $project = Project::whereIn('team_members',$emp_id)->get();
    //     return response()->json([
    //         'status' => true,
    //         'project' => $project
    //     ]);
    // }

     public function getEmployee(Request $request){

        $project = Project::find($request->id);
        $empIds = !empty($project->team_members)?json_decode($project->team_members):[];
        // $employee = Employee::whereIn('id',$empIds)->get();
        $employees = Employee::get();

        $html = "";
        $html = "<option value=''>...............</option>";
        foreach($employees as $emp){
            $selected = "";
            if(in_array($emp->id,$empIds)){
                $selected = "selected";
            }
            $html .= "<option value=".$emp->id." ".$selected.">".$emp->name."</option>";
        }

        // $project = Project::whereIn('team_members',$emp_id)->get();
        return response()->json([
            'status' => true,
            'employee' => $html,
            'projectEmp' => $empIds
        ]);
    }

    public function getEmployeeProject(Request $request){
        if(isset($request->employee_id)){
            $project =  Project::where('team_members','like','%"'.$request->employee_id.'"%')->get();
        } else {
            $project = Project::find($request->id);
        }
        $empIds = !empty($project->team_members)?json_decode($project->team_members):[];
        $employees = Employee::whereIn('id',$empIds)->get();

        $html = "";
        $html = "<option value=''>...............</option>";

        // $project = Project::whereIn('team_members',$emp_id)->get();
        return response()->json([
            'status' => true,
            'employee' => $employees,
            'projectEmp' => $empIds,
            'project' => $project
        ]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required'
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
        $inputData['employee_type']=implode(" ",$request->employee_type);
        if($request->has('image')){
            $inputData['image'] =  $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/'.Employee::$uploadFolderName), $imageName);
        }else{
            $inputData['image'] ='';
        }
        $role = Role::where("name","Employee")->first();
        if(empty($role)){
           $role = Role::create([
                'name' => "Employee",
                'guard_name' => 'web'
            ]);
        }
        $userData = array(
            'name' => $inputData['name'],
            'email' => $inputData['email'],
            'role' => $role->id,
            'password' => Hash::make('User@1234'),
            'mobile_no' => $inputData['phone'],
            'status' => "Active",
        );


        $user = $this->userRepository->create($userData);
        $userData = json_decode(json_encode($user),1);
        $userId = $userData["original"]["userId"];

        $inputData['user_id'] = $userId;
        $inputData['team_id'] = $request->team_id??0;
        $res = Employee::create($inputData);
        // dd($inputData);
        $message = "Employee Created Successfully !!";
        session()->flash('success', $message);
        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    public function show(Employee $employee){
        $projectList = Project::where('team_members','like','%"'.$employee->id.'"%')->get();
        return view('employee.employeeProject',compact('projectList'));
    }

    public function edit(Employee $employee){
         $categories = Department::where('status',"Active")->get();
        $designations = Designation::where('status',"Active")->get();
        $team = Team::where('status',"Active")->get();
        $employee_type = ['Full Time','Part Time','Half Time'];
        // $empDesig = json_decode($employee->designation_id);
        return view('employee.edit',compact('categories','designations','employee','employee_type','team'));
    }

    public function updatestatus($id) {
        $message["success"] =  __('messages.employeestasucs');
        $message["error"] =  __('messages.employeestafail');
        return changeStatus(Employee::class,$message,$id);
        // return $this->employeeServices->updatestatus($id);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // 'email' => 'required',
            // 'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        $inputData = $request->except('_token','_method','old_image');
        $inputData['status'] = 'Active';
        $inputData['designation_id'] = $request->designation_id;
        $inputData['team_id'] = $request->team_id;
        $inputData['employee_type']=implode(" ",$request->employee_type);
        if($request->has('image')){
            $inputData['image'] =  $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/'.Employee::$uploadFolderName), $imageName);
        }else{
            $inputData['image'] =$request->old_image;
        }
        $employee = Employee::find($id);
        $userData = array(
            'name' => $inputData['name'],
            'email' => $inputData['email'],
            'mobile_no' => $inputData['phone'],
            'status' => "Active",
        );

        $res1 = User::where('id',$employee->user_id)->update($userData);
        $res = $employee->where('id',$employee->id)->update($inputData);

        $message = "Employee Edit Successfully !!";
        session()->flash('success', $message);
        return response()->json([
            'status' => true,
            'message' => $message
        ]);


    }
    public function destroy(Employee $employee) {
       // echo "as"; exit;
        $user = User::find($employee->user_id);

       if (!$user) {
            Session::flash('danger', 'User not found!');
            // $this->flashMessage('warning', 'Category not found!', 'danger');
            return response()->json([
                'status' => false,
                'message' => 'User not found!'
            ]);
        }
        $user->delete();
        if (!$employee) {
            Session::flash('danger', 'Employee not found!');
            // $this->flashMessage('warning', 'Category not found!', 'danger');
            return response()->json([
                'status' => false,
                'message' => 'Employee not found!'
            ]);
        }
        $employee->delete();
        Session::flash('success', 'User successfully deleted!');
        return response()->json([
            'status' => true,
            'message' => 'Employee successfully deleted!'
        ]);

    }
    public function resetpassword($id) {
        $user = User::find($id);
        if (!$user) {
             Session::flash('danger', 'User not found!');
             return response()->json([
                 'status' => false,
                 'message' => 'User not found!'
             ]);
         }
         $inputData['password'] = Hash::make('User@1234');
         User::where('id', $id)->update($inputData);
         Session::flash('success', 'Password successfully Reseted!');
         return response()->json([
             'status' => true,
             'message' => 'Password successfully Reseted!'
         ]);

     }
     public function change_password(){
        return view('employee.change_password');
    }
    public function tree_view(){
        // $categories = Department::where('status',"Active")->get();
        // $designations = Designation::where('status',"Active")->get();
        // $team = Team::where('status',"Active")->get();
        // $employee_type = ['Full Time','Part Time','Half Time'];
        return view('treeview.index');
    }
}
