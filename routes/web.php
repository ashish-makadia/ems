<?php

/*use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\RoleController;*/
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/



// Route::get('/schedule-run', function() {

//     $artisan = \Artisan::call('schedule:run');
//     return \Artisan::output();
//  });

if(!function_exists('autoVersion')){
    function autoVersion($file)
    {
        $mtime = filemtime(public_path($file));
        return preg_replace('{\\.([^./]+)$}', ".$1?$mtime", $file);
    }
}



require __DIR__ . '/auth.php';
/*frontend routes */
Route::resource('/', 'FrontendController');
Route::get('/contactcustomer', 'FrontendController@customercreate')->name('frontend.customer');
Route::get('/customersupport', 'FrontendController@customersupport')->name('customer.support');
Route::post('/customersupport/store', 'FrontendController@customersupportstore')->name('customer.supportstore');
Route::get('/customer-support/{ticket_id}', 'FrontendController@customerfeedbackView')->name('customer.feedbackView');
Route::get('/customerfeedback', 'FrontendController@customerfeedback')->name('customer.feedback');
Route::get('/customerfeedback/{ticket_id?}', 'FrontendController@customerfeedbackView')->name('customer.feedbackView');
// Route::get('/', 'Auth\\AuthenticatedSessionController@create')->middleware('guest');

 Route::get('/customer-support/ticket_id', 'FrontendController@customerfeedback');
//checkip
Route::middleware(['auth'])->group(function () {
	Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.dashboard');
	Route::get('/dashboard/orders', [App\Http\Controllers\HomeController::class, 'orders'])->name('admin.orders');
	Route::get('/dashboard/orders', [App\Http\Controllers\HomeController::class, 'orders'])->name('admin.orders');
	Route::get('/attendance/insert_new', [App\Http\Controllers\HomeController::class, 'attendance_insert'])->name('attendance.insert_new');
	Route::get('/attendance/attendance_out_insert/{id}', [App\Http\Controllers\HomeController::class, 'attendance_out_insert'])->name('attendance.attendance_out_insert');
	//Department
	Route::resource('department', 'DepartmentController');
	Route::get('department/statuschange/{id}', 'DepartmentController@updatestatus');
	Route::post('department/get_designation_list', 'DepartmentController@get_designation_list')->name('department.get_designation_list');
	Route::post('department/insert_new', 'DepartmentController@insert_new')->name('department.insert_new');
	// Designation
	Route::resource('designation', 'DesignationController');
	Route::get('designation/statuschange/{id}', 'DesignationController@updatestatus');
	Route::post('designation/insert_new', 'DesignationController@insert_new')->name('designation.insert_new');
	// Category
	Route::resource('categories', 'CategoriesController');
	Route::get('categories/statuschange/{id}', 'CategoriesController@updatestatus');
	Route::post('categories/get_subcategory_list', 'CategoriesController@get_subcategory_list')->name('categories.get_subcategory_list');
	Route::post('categories/insert_new', 'CategoriesController@insert_new')->name('categories.insert_new');
	Route::get('/get_subcategory_lists/{id}','CategoriesController@get_subcategory_lists');
	//Sub Category
	Route::resource('sub_categories', 'SubCategoriesController');
	Route::get('sub_categories/statuschange/{id}', 'SubCategoriesController@updatestatus');
	Route::post('sub_categories/insert_new', 'SubCategoriesController@insert_new')->name('sub_categories.insert_new');
	//Customer
	Route::resource('/customer', 'CustomerController');
    Route::get('/customer/destroy/{id}', 'CustomerController@destroy')->name('customer.destroy');
    Route::get('customer/statuschange/{id}', 'CustomerController@updatestatus');

	Route::resource('roles', 'RoleController');
	Route::resource('permissions', 'PermissionController');

    // TemplateType
    Route::resource('templatetype', 'TemplateTypeController');
    Route::get('templatetype/statuschange/{id}', 'TemplateTypeController@updatestatus');
	Route::post('templatetype/get_template_list', 'TemplateTypeController@get_template_list')->name('department.get_designation_list');

	/* user routes */
	Route::resource('user', 'UserController');
	Route::get('user/statuschange/{id}', 'UserController@updatestatus');
	Route::get('user/changelocale/{locale}', 'UserController@changeLocale');
	Route::get('profile/edit_profile', 'UserController@edit_profile')->name('profile.index');
	Route::post('profiles/update/{id}', 'UserController@updateprofile')->name('profiles.update');
	Route::get('profile/password_change', 'UserController@password_change')->name('profile.password_change');

	/* Activity Logs */
	Route::resource('logactivity', 'ActivityLogController');

	/* Access Ips */
	Route::resource('accessips', 'AccessIpsController');
	Route::get('accessips/statuschange/{id}', 'AccessIpsController@updatestatus');

	/* user routes */
	Route::resource('employee', 'EmployeeController');
	Route::get('employee/statuschange/{id}', 'EmployeeController@updatestatus');
	Route::get('employee/resetpassword/{id}', 'EmployeeController@resetpassword');
	Route::get('employee/changelocale/{locale}', 'EmployeeController@changeLocale');
	Route::post('employee/getProject', 'EmployeeController@getEmployeeProject')->name('getEmployeeProject');
	Route::get('tree-view', 'EmployeeController@tree_view')->name('tree-view');
    Route::post('employee/getProject', 'EmployeeController@getEmployeeProject')->name('getEmployeeProject');
    Route::post('employee/getEmployee', 'EmployeeController@getEmployee')->name('getEmployee');
    Route::get('tree-view', 'EmployeeController@tree_view')->name('tree-view');
	Route::get('change_password', 'EmployeeController@change_password')->name('change_password');

	Route::resource('project', 'ProjectController');
	Route::get('project/statuschange/{id}', 'ProjectController@updatestatus');
	Route::get('project/changelocale/{locale}', 'ProjectController@changeLocale');
    Route::post('project/getTask', 'ProjectController@getProjectTask')->name('getProjectTask');
    Route::post('project/attachment', 'ProjectController@addProjectAttachment')->name('project.attachment');
    Route::post('project/assignmember', 'ProjectController@assignMembers')->name('project.assignmember');
    Route::resource('projectattachment', 'ProjectAttachmentController');

	Route::resource('task', 'TaskController');
	Route::get('task/changelocale/{locale}', 'TaskController@changeLocale');
	Route::get('task/statuschange/{id}', 'TaskController@updatestatus');
	Route::get('task/work_log/{id}', 'TaskController@addTaskWorkLog');

	Route::resource('work_log', 'WorkLogController');
	Route::get('work_log/changelocale/{locale}', 'WorkLogController@changeLocale');
	Route::get('work_log/statuschange/{id}', 'WorkLogController@updatestatus');
	Route::post('work_log/checktimespent', 'WorkLogController@checkTimeSpent')->name('work_log.checktimespent');

    Route::resource('/email-template', 'EmailTemplateController');
    Route::get('/email-template/destroy/{id}', 'EmailTemplateController@destroy')->name('email-template.destroy');
     Route::get('email-template/statuschange/{id}', 'EmailTemplateController@updatestatus');
    Route::get('/send-mail/{id}', 'EmailTemplateController@sendMail');

	Route::resource('attendance', 'AttendanceController');
	Route::get('attendances/attendance_report', 'AttendanceController@attendance_report')->name('attendances.attendance_report');
	Route::get('attendances/report', 'AttendanceController@report')->name('attendances.report');
	Route::get('attendances/get_calender', 'AttendanceController@get_calender')->name('attendances.get_calender');

	Route::get('hour-management/index', 'HourManagementController@index')->name('hour-management.index');
	Route::get('hour-management/store', 'HourManagementController@store')->name('hour-management.store');

	Route::get('reports/worklog_report', 'ReportController@workLogReport')->name('reports.worklog_reports');
	Route::post('reports/worklog_report', 'ReportController@getWorkLogReport')->name('reports.getWorkLogReport');

	Route::resource('leave-management', 'LeaveManagementController');
	Route::post('leave-management/insert_leave', 'LeaveManagementController@insert_leave')->name('leave-management.insert_leave');
	Route::get('leave-management/show', 'LeaveManagementController@show')->name('leave-management.show');
	Route::get('/leave-management/change_status/{id}/{status}', 'LeaveManagementController@change_status')->name('leave-management.change_status');

	Route::resource('holiday', 'HolidayController');
	Route::get('holiday/statuschange/{id}', 'HolidayController@updatestatus');
	Route::post('holiday/insert_new', 'HolidayController@insert_new')->name('holiday.insert_new');

	Route::resource('team', 'TeamController');
	Route::get('team/statuschange/{id}', 'TeamController@updatestatus');
	Route::post('team/insert_new', 'TeamController@insert_new')->name('team.insert_new');

	Route::post('reports/worklog_report_excel', 'ReportController@getWorkLogExcel')->name('reports.getWorkLogExcel');
	Route::post('home/getWorkLogData', 'HomeController@getWorkLogData')->name('home.getWorkLogData');
	Route::post('reports/checkworklogTime', 'ReportController@checkworklogTime')->name('reports.checkworklogTime');


    Route::resource('team-lead', 'TeamLeadController');

    Route::resource('customer-support', 'CustomersupportController');
    Route::get('/customer-support/show/{ticket_id}', 'CustomersupportController@show')->name('customersupport.show');
	Route::post('customer-support/statuschange', 'CustomersupportController@updatestatus');
Route::post('customer-support/assignmember', 'CustomersupportController@assignMembers')->name('customer-support.assignmember');
Route::post('employee/getCustomer', 'CustomersupportController@getCustomer')->name('getCustomer');


});
