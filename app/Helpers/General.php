<?php

use App\Models\Designation;
use App\Models\Employee;
function convertToMinutes($hour){
    $hourArr = explode(':',$hour);

    $minutes = ($hourArr[0]*60)+$hourArr[1]??0;
    return $minutes;
}
function convertToHour($minutes){
    $hour = (int)$minutes / 60;
    $remMin = $minutes - ((int)$hour*60);
    $time = (int)$hour.":".$remMin;
    return date("H:i",strtotime($time));
}
function countHour($start_time,$end_time){
    $startTime = strtotime($start_time);
    $endTime = strtotime($end_time);
    $diff = ($endTime -$startTime)/ 60;
    return $diff;
}
function getLeaderEmployeeIds($employee_id=null){
        $employees =  Employee::where('status',1)->get();
        $empIds = [];

        foreach ($employees as $key => $emp) {
            $name = str_replace(" ","",strtolower("Team Leader"));
           
            \Log::info($name);


            $designation = Designation::whereRaw("REPLACE(LOWER(`name`),' ','') = 'teamleader'")->orWhere("REPLACE(LOWER(`name`),' ','') = 'manager'")->orWhere("REPLACE(LOWER(`name`),' ','') = 'companyowner'")->first();

            \Log::info(json_encode($designation));
            if($designation->id == $emp->designation_id)
                $empIds[] =  $emp->id;
            // $designIdArr = json_decode($emp->designation_id);
            // if(is_array($designIdArr) && in_array(7,$designIdArr) || in_array(8,$designIdArr) || in_array(9,$designIdArr))
            //     $empIds[] =  $emp->id;
        }
        return $empIds;
    }

    function changeStatus($model,$message,$id){
        $data = $model::findOrfail($id);
        if($data){
            if ($data->status == 'Active') {
				$data->status = 'Inactive';
			} else {
				$data->status = 'Active';
			}
            if ($data->save()) {
				return response(['status' => '1', 'msg' => $message["success"]]);
			} else {
				\LogActivity::addToLog($message["error"],$data->id);
				return response(['status' => '0', 'msg' => $message["error"]]);
			}
        }
        else {
            \LogActivity::addToLog($message["error"],$data->id);
            return response(['status' => '0', 'msg' => $message["error"]]);
        }
    }
?>
