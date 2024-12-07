<?php

namespace App\Exports;

use App\Models\Agents;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
use Auth;

class AgentsExport implements FromCollection,WithHeadings
{
	public function __construct(Array $agent_id = null,Array $region = null,String $from_date = null,String $to_date = null,Array $province = null,Array $municipality = null,String $type = null,String $id = null)
    {
        $this->agent_id = $agent_id;
        $this->region = $region;
        $this->from_date = $from_date;
        $this->to_date = $to_date; 
        $this->province = $province;
        $this->municipality = $municipality;
        $this->type = $type;
        $this->id = $id;
    }

    public function headings(): array{
    	if(Auth::user()->role == 'Super Admin'){
            $user = "0";
        }else{
            $user = "1";                
        }
        $get_data = DB::table('manage_options')->select('screen_options')->where('is_view','=',$user)->where('view_type','=','Agent')->first();
        if($get_data){
          $get_screen_option = json_decode($get_data->screen_options,true);
        }
        $get_option_data = DB::table('manage_options')->select('scren_option_array_en')->where('is_view','=',$user)->where('view_type','=','Agent')->first();
        if($get_option_data){
            $array = json_decode($get_option_data->scren_option_array_en,true); 
        }

        $footerArray = array();
        if($get_option_data){
            foreach($array as $custom_array) {
                foreach ($custom_array as $key => $value) {
                    if(!in_array($value['name'],$get_screen_option)){
                        continue;
                    }
                    $array_check = array("action","map_info");
                    if(!in_array($value['name'],$array_check)){
                        $footerArray[] = $key;
                    }
                } 
            } 
        	return $footerArray;
        }else{
        	return [
        		'id',
        		'order number',
        		'order total',
        		'company name',
        		'phone',
        		'email',
        		'region',
        		'province',
        		'municipality',	
        	];
        }
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return Agents::all();
        if(Auth::user()->role == 'Super Admin'){
            $user = "0";
        }else{
            $user = "1";                
        }
        $get_data = DB::table('manage_options')->select('screen_options')->where('is_view','=',$user)->where('view_type','=','Agent')->first();
        if($get_data){
          $get_screen_option = json_decode($get_data->screen_options,true);
        }
        $get_option_data = DB::table('manage_options')->select('scren_option_array_en')->where('is_view','=',$user)->where('view_type','=','Agent')->first();
        if($get_option_data){
            $array = json_decode($get_option_data->scren_option_array_en,true); 
        }

        $sql = Agents::select('agents.*','province.province_name','region.region_name','municipalities.municipality_name','booking_system.total_price as order_total','booking_system.woo_order_id as order_number')->leftjoin('province','province.id','=','agents.province')->leftjoin('region','region.id','=','agents.region')->leftjoin('municipalities','municipalities.id','=','agents.municipality')->leftjoin('booking_system','booking_system.agent_id','=','agents.id')->orderBy('booking_system.created_at', 'DESC');
            if($this->id && $this->id != "All"){
                $sql->where('agents.id',$this->id);
            }
			if ($this->agent_id) {
			 $sql->whereIn('agents.id',$this->agent_id);
			}
			if ($this->region) {
			 $sql->whereIn('agents.region',$this->region);
			}
			if ($this->province) {
			 $sql->whereIn('agents.province',$this->province);
			}
			if ($this->municipality){
			 $sql->whereIn('agents.municipality',$this->municipality);
			}
			if($this->from_date && $this->to_date){
			  $fromdate = date("Y-m-d",strtotime($this->from_date));
			  $todate = date("Y-m-d",strtotime($this->to_date));
			  $sql->whereBetween('booking_system.order_date',array($fromdate,$todate));
			}
		$new_sql = $sql->get();
		$new_array = array();
        foreach ($array as $array_key => $array_value) {
            foreach ($array_value as $v_key => $v_value) {
                if($v_key){
                    $new_array[] = $v_value['name'];
                }  
            }
        }
        $new_sql_array = array();
        foreach ($new_sql as $key => $value) {
        	$test = array_keys($value->toArray());
            foreach ($test as $key1 => $value1) {
               // echo "<pre>";echo $value['order_total'];die;
            	if(!empty($new_array[$key1])){
                    if(in_array($new_array[$key1], $get_screen_option)){
                    	if($new_array[$key1] == "order_total"){
                    		$new_sql_array[$key][$new_array[$key1]] = $value[$new_array[$key1]]." €";
                    	}elseif($new_array[$key1] == "commission"){
                            $order_value = $value['order_total'];
                            $commission_value = ((int)$order_value/1.22 *0.7*0.2);
                            $new_sql_array[$key][$new_array[$key1]] = round($commission_value, 3);
                        }else{
                            $field_array = array("action","map_info");
                            if(!in_array($new_array[$key1],$field_array)){
                    		  $new_sql_array[$key][$new_array[$key1]] = $value[$new_array[$key1]];
                            }
                    	}
                    }
                }
            }
        }
        return collect($new_sql_array);
        //echo "<pre>";print_r($new_sql_array);die();
    }
}
