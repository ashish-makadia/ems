<?php
namespace App\Helpers;

use App\Models\FrontActivityLog;
use Request;
use App\Models\LogActivity as LogActivityModel;
use Carbon\Carbon;
class LogActivity
{


    public static function addToLog($subject,$inserted_user="")
    {
        $log = [];
        $log['subject'] = $subject;
        $log['url'] = Request::fullUrl();
        $log['request_data'] = \json_encode(Request::all());
        $log['method'] = Request::method();
        $log['ip'] = Request::ip();
        $log['agent'] = Request::header('user-agent');
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        $log['data_user_id'] = $inserted_user;
         /*echo "<pre>";
         print_r($log);
         die();*/
        LogActivityModel::create($log);
    }

    public static function addToFrontLog($subject,$inserted_user="",$status="",$type="")
    {
        $log = [];
        $log['subject'] = $subject;
        $log['url'] = Request::fullUrl();
        $log['request_data'] = \json_encode(Request::all());
        $log['method'] = Request::method();
        $log['ip'] = Request::ip();
        $log['agent'] = Request::header('user-agent');
        if($type == "front")
            $log['user_id'] = 0;
        else
            $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        $log['data_user_id'] = $inserted_user;
        $log['status'] = $status;
        FrontActivityLog::create($log);
    }

    public static function logActivityLists()
    {
        return LogActivityModel::latest()->get();
    }
}
