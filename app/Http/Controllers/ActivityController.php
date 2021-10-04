<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Students;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function activitylog()
    {
        $studentId = Auth::user()->student_id;
        $std = Students::where('range_id' , '=' , $studentId)->first();
        $logs = LogActivity::logActivityLists(Auth::user()->student_id);
        return view('activity')->with(array('data'=>$logs,'student'=>$std));
    }
}
