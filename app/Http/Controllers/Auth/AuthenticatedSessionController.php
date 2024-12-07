<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CruiseSchedule;
use App\Models\Cruise;
use App\Models\User;
use App\Models\CruiseManagement;
use App\Models\CruiseScheduleChild;
use App\Models\Master\CabinTypes;
use App\Models\Master\CruiseLocation;
use App\Models\ShipCompany;
use App\Models\BookingSystem;
use App\Models\Port;
use App\Models\Boat;
use App\Models\ManageView;
use App\Models\CruiseDuration;
use Illuminate\Validation\ValidationException;
use DB;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if($user && $user->status == 'Inactive'){
            throw ValidationException::withMessages([
                'email' => 'This user is not yet activated!!',
            ]);
        }
        
        $request->authenticate();
        $request->session()->regenerate();
        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function get_dashboard(){
        //$role = Auth::user()->roles->first()->name;
        $login_id = Auth::id();
        $getAllcruise = CruiseManagement::select('cruise_management.name','cruise_management.ship_company_id','cruise_management.cruise_duration_hours_or_weekly','cruise_management.cruise_duration','cruise_management.id','cruise_management.cruise_duration','cruise_ports.cruise_id as cruise_id','cruise_durations.name as duration_limit','cruise_ports.porttype_id as port_id','ports.name as portname','cruise_locations.name as location_name','cruise_management.cruise_code')
            ->leftjoin('cruise_ports', 'cruise_ports.cruise_id', '=', 'cruise_management.id')
            ->leftjoin('cruise_locations','cruise_locations.id','=','cruise_management.locations')
            ->leftjoin('cruise_durations', 'cruise_durations.id', '=', 'cruise_management.cruise_duration')
            ->leftjoin('ports','ports.id','=','cruise_ports.port_id')->leftjoin('ship_companies','ship_companies.id','=','cruise_management.ship_company_id')->where('ship_companies.user_id',$login_id)->where('cruise_ports.porttype_id','=','1')->where('cruise_management.status','!=','D')->groupBy('cruise_management.id')->get();
       // echo "<pre>";print_r($getAllcruise);die();
        $getCompanies = ShipCompany::get();
        $getschedule = CruiseSchedule::select('cruise_schedules.*','cruise_management.cruise_duration','cruise_management.name as cruise_name','cruise_management.locations','cruise_schedule_child.adult_per_price_regular as adult_price','cruise_schedule_child.price_per_child as child_price','cruise_schedule_child.cabin_count','cruise_schedule_child.cruise_schedule_id as check_sid','cruise_schedule_child.available_seat','cruise_schedule_child.cabin_count_offline','cruise_schedule_child.available_seat_offline')
            ->leftjoin('cruise_management', 'cruise_management.id', '=', 'cruise_schedules.cruise_id')
            ->join('cruise_schedule_child', 'cruise_schedule_child.cruise_schedule_id', '=', 'cruise_schedules.id')->get();

        foreach ($getschedule as $key => $value) {
            //if($value->check_sid == $value->id){
                $get_sum = CruiseScheduleChild::select(DB::raw('SUM(cruise_schedule_child.cabin_count) AS sum_of_cabin'))->where('cruise_schedule_id',$value->id)->first();
                
                 $online_IncomeData = BookingSystem::select('booking_system.book_date',DB::raw('SUM(booking_system.total_price_adults) as price_adults'),DB::raw('SUM(booking_system.total_price_children) as total_price_children'))->where('booking_system.book_date',$value->start_date)->where('booking_system.add_booking_status',"=",'1')->where('booking_system.booking_Data_status','A')->get();
                //echo "<pre>";print_r($online_IncomeData);die();
                $offline_IncomeData = BookingSystem::select('booking_system.book_date',DB::raw('SUM(booking_system.total_price_adults) as price_adults'),DB::raw('SUM(booking_system.total_price_children) as total_price_children'))->where('booking_system.book_date',$value->start_date)->where('booking_system.add_booking_status',"=",'2')->where('booking_system.booking_Data_status','A')->get();

                $online_income = $online_IncomeData[0]->price_adults + $online_IncomeData[0]->total_price_children;
                $offline_income = $offline_IncomeData[0]->price_adults + $offline_IncomeData[0]->total_price_children;
            
                $online_sold_ticket = $value->cabin_count - $value->available_seat;
                $offline_sold_ticket = $value->cabin_count_offline - $value->available_seat_offline;

                $total_seat_count = $value->cabin_count + $value->cabin_count_offline;
                $total_count = $online_sold_ticket + $offline_sold_ticket;
                $total_remaining_count = $total_seat_count - $total_count;

                $online_sellable_ticket = $value->available_seat;
                $offline_sellable_ticket = $value->available_seat_offline;

                $getschedule[$key]['online_sold_ticket'] = $online_sold_ticket;
                $getschedule[$key]['offline_sold_ticket'] = $offline_sold_ticket;
                $getschedule[$key]['total_seat_count'] = $total_seat_count;
                $getschedule[$key]['remaining_sellable_tickets'] = $total_remaining_count;
                $getschedule[$key]['online_sellable_ticket'] = $online_sellable_ticket;
                $getschedule[$key]['offline_sellable_ticket'] = $offline_sellable_ticket;
                $getschedule[$key]['cruise_capacity'] = !empty($get_cabin_name->cruise_capacity) ? $get_cabin_name->cruise_capacity : "0";
                $getschedule[$key]['sum'] =   $get_sum->sum_of_cabin;
                $getschedule[$key]['cruise_name'] = str_replace(' ', '', $value->cruise_name);
                $getschedule[$key]['online_income'] = $online_income." &euro;";
                $getschedule[$key]['offline_income'] = $offline_income." &euro;";
                $current_date =  date('Y-m-d h:i:s');
                $yday = date('Y-m-d h:i:s', strtotime("-1 day"));
                $get_last_time = BookingSystem::select('created_at')->where('cruise_id',$value->cruise_id)->orderBy('id', 'DESC')->first();
                $get_last_24_time = BookingSystem::select(DB::raw('SUM(booking_system.cabin_count) AS sum_of_last_24h'))->where('booking_system.cruise_id',$value->cruise_id)->where('booking_Data_status','A')->whereBetween('created_at',[$yday,$current_date])->first();
                $get_Cruise_druation = CruiseDuration::select('name')->where('id',$value->cruise_duration)->first();
                $array = explode(",", $value->locations);
                $getlocation = CruiseLocation::select('name')->whereIn('id',$array)->first();
                $getport = CruiseManagement::select('cruise_management.id','cruise_ports.cruise_id as cruise_id','cruise_ports.porttype_id as port_id','ports.name as portname')
                ->leftjoin('cruise_ports', 'cruise_ports.cruise_id', '=', 'cruise_management.id')
                ->leftjoin('ports','ports.id','=','cruise_ports.port_id')->where('cruise_ports.porttype_id','=','1')->where('cruise_ports.cruise_id','=',$value->cruise_id)->where('cruise_management.status','!=','D')->first();
                //echo "<pre>";print_r($getport);die();
                if(!empty($get_last_time)){
                    $getschedule[$key]['last_time'] = $get_last_time->created_at->format('d/m/Y H:i');
                }else{
                    $getschedule[$key]['last_time'] = "No Found";
                }
                if($get_last_24_time->sum_of_last_24h){
                    $getschedule[$key]['sum_of_last_24h'] = $get_last_24_time->sum_of_last_24h;
                }else{
                    $getschedule[$key]['sum_of_last_24h'] = "No Found";
                }
                $getschedule[$key]['durationName'] = empty($get_Cruise_druation) ? "" : $get_Cruise_druation->name;
                $getschedule[$key]['locationName'] = empty($getlocation) ? "" : $getlocation->name;
                $getschedule[$key]['portName'] = empty($getport) ? "" : $getport->portname;
           
                $calendar = ManageView::first();
                if($calendar){
                    $getschedule[$key]['calendar_id'] = $calendar->calendar_id;
                }else{
                    $custom_array = array("cruise_name_checkbox");
                    $new_json = json_encode($custom_array);
                    $get_calendar = new ManageView;
                    $get_calendar->calendar_id = '2';
                    $get_calendar->display_column = $new_json;
                    $get_calendar->save();
                }
           // }
        }
        if(empty($calendar)) { $calendar = ManageView::first(); }else{ $calendar; }
        $get_calc_id = ManageView::select('calendar_id')->first();
        $calendar_id = $get_calc_id->calendar_id;
        $get_calendar_data = json_decode($calendar->display_column);
        //echo "<pre>";print_r($get_calendar_data);die();
        //$getLocations = CruiseLocation::get();
        $getLocations = CruiseLocation::select('cruise_locations.*')->leftjoin('cruise_management','cruise_management.locations','=','cruise_locations.id')->leftjoin('ship_companies','ship_companies.id','=','cruise_management.ship_company_id')->where('ship_companies.user_id',$login_id)->groupBy("cruise_locations.id")->get();
        
       // echo "<pre>";print_r($getLocations);die();
        //$getPorts = Port::where('porttype_id','1')->get();
        $getPorts = Port::select('ports.*')
            ->leftjoin('cruise_ports', 'cruise_ports.port_id', '=', 'ports.id')
            ->where('cruise_ports.porttype_id','=','1')->where('ports.deleted_at',NULL)->groupBy("ports.id")->get();
        $getships = ShipCompany::where('user_id',$login_id)->first();
        if($getships){
            $shipid = $getships->id;
            $getBoats = Boat::where('ship_company_id',$shipid)->get();  
        }else{
            $getBoats = Boat::get(); 
        }
        $cruiseDuration = CruiseDuration::select('cruise_durations.*')->leftjoin('cruise_management','cruise_management.cruise_duration','=','cruise_durations.id')->leftjoin('ship_companies','ship_companies.id','=','cruise_management.ship_company_id')->where('ship_companies.user_id',$login_id)->groupBy("cruise_durations.id")->get();
        $date = date('Y-m-d');
        $tomorrow_date = date('Y-m-d', strtotime("+1 day"));
        $todaycruise = CruiseManagement::select('cruise_management.name','cruise_management.cruise_duration_hours_or_weekly','cruise_management.id','cruise_management.cruise_duration','cruise_ports.cruise_id as cruise_id','cruise_ports.porttype_id as port_id','ports.name as portname','cruise_ports.cruise_time','cruise_ports.cruise_date','cruise_schedules.start_date as scheduleDate',DB::raw('TIME_FORMAT(cruise_ports.cruise_time, "%H:%i") as cruise_time'))
            ->leftjoin('cruise_ports', 'cruise_ports.cruise_id', '=', 'cruise_management.id')
            ->leftjoin('cruise_schedules', 'cruise_schedules.cruise_id', '=', 'cruise_management.id')
            ->leftjoin('ports','ports.id','=','cruise_ports.port_id')
            ->leftjoin('ship_companies','ship_companies.id','=','cruise_management.ship_company_id')->where('ship_companies.user_id',$login_id)
            ->where('cruise_ports.porttype_id','=','1')->where('cruise_management.status','!=','D')->where('cruise_schedules.start_date','=',$date)->groupBy('cruise_management.id')->get();
        foreach ($todaycruise as $today_key => $today_value) {
            $today_time = $today_value->cruise_time;
            $todaycruise[$today_key]['cruise_time'] = $today_time;
            $todaycruise[$today_key]['cruise_date'] = date("d/m/y",strtotime($today_value->scheduleDate));
        }
        $tomorrowcruise = CruiseManagement::select('cruise_management.name','cruise_management.cruise_duration_hours_or_weekly','cruise_management.id','cruise_management.cruise_duration','cruise_ports.cruise_id as cruise_id','cruise_ports.porttype_id as port_id','ports.name as portname','cruise_ports.cruise_time','cruise_ports.cruise_date','cruise_schedules.start_date as scheduleDate',DB::raw('TIME_FORMAT(cruise_ports.cruise_time, "%H:%i") as cruise_time'))
            ->leftjoin('cruise_ports', 'cruise_ports.cruise_id', '=', 'cruise_management.id')
            ->leftjoin('cruise_schedules', 'cruise_schedules.cruise_id', '=', 'cruise_management.id')
            ->leftjoin('ports','ports.id','=','cruise_ports.port_id')->where('cruise_ports.porttype_id','=','1')->where('cruise_management.status','!=','D')
            ->leftjoin('ship_companies','ship_companies.id','=','cruise_management.ship_company_id')->where('ship_companies.user_id',$login_id)
            ->where('cruise_schedules.start_date','=',$tomorrow_date)->groupBy('cruise_management.id')->get();
        foreach ($tomorrowcruise as $tommorow_key => $tommorow_value) {
            $time = $tommorow_value->cruise_time;
            $tomorrowcruise[$tommorow_key]['cruise_time'] = $time;
            $tomorrowcruise[$tommorow_key]['cruise_date'] = date("d/m/y",strtotime($tommorow_value->scheduleDate));
        }
        //echo "<pre>";print_r($tomorrowcruise);die();
        $monday = strtotime("last monday");
        $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
        $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
        $this_week_sd = date("Y-m-d",$monday);
        $this_week_ed = date("Y-m-d",$sunday);
        $show_today_date =  date("d/m/y");
        $tommorow_date = date('d/m/y', strtotime("+1 day"));
        $weekly_data = CruiseManagement::select('cruise_management.name','cruise_management.cruise_duration_hours_or_weekly','cruise_management.id','cruise_management.cruise_duration','cruise_ports.cruise_id as cruise_id','cruise_ports.porttype_id as port_id','ports.name as portname','cruise_ports.cruise_time','cruise_ports.cruise_date','cruise_schedules.start_date as scheduleDate',DB::raw('TIME_FORMAT(cruise_ports.cruise_time, "%H:%i") as cruise_time'))
            ->leftjoin('cruise_ports', 'cruise_ports.cruise_id', '=', 'cruise_management.id')
            ->leftjoin('cruise_schedules', 'cruise_schedules.cruise_id', '=', 'cruise_management.id')
            ->leftjoin('ports','ports.id','=','cruise_ports.port_id')
            ->leftjoin('ship_companies','ship_companies.id','=','cruise_management.ship_company_id')->where('ship_companies.user_id',$login_id)
            ->where('cruise_ports.porttype_id','=','1')->where('cruise_management.status','!=','D')->whereBetween('cruise_schedules.start_date',array($this_week_sd,$this_week_ed))->groupBy('cruise_management.id')->get();
        foreach ($weekly_data as $weekly_key => $week_value) {
            $week_time = $week_value->cruise_time;
            $weekly_data[$weekly_key]['cruise_time'] = $week_time;
            $weekly_data[$weekly_key]['cruise_date'] = date("d/m/y",strtotime($week_value->scheduleDate));
        }

        //echo "<pre>";print_r($getschedule->count());die();
        return view('dashboard',compact('getAllcruise','getCompanies','getschedule','getLocations','getPorts','getBoats','cruiseDuration','todaycruise','tomorrowcruise','weekly_data','get_calendar_data','show_today_date','tommorow_date','calendar_id'));
    }
}
