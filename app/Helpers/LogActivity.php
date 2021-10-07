<?php
namespace App\Helpers;
use App\LogActivity as LogActivityModel;
use Request;
class LogActivity
{

    public static function addToLog($userId)
    {
        //dd(Request::ip());
        $log = [];
    	$log['representative_id'] = $userId;
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	LogActivityModel::create($log);
    }

}