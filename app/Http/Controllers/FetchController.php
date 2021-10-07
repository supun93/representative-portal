<?php

namespace App\Http\Controllers;

use App\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FetchController extends Controller
{


    public function dashboard()
    {
        
        return view('home');
    }

    public function activityLog  (){
        return view('activity-log');
    }
    public function activityLogLoad(Request $request){
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");
        $info = LogActivity::withTrashed()->where('representative_id', Auth::user()->marketing_representative_id);

        //$searchKey = $request->get('search')['value'];
        //$info = $info->where('exam_category', 'like', '%' . $searchKey . '%');
        $totalRecords = $info->count();
        $records = $info->skip($start)->take($rowperpage)->get();

        $data = array();
        foreach ($records as $item) {
            $data[] = array(
                "Login Time" => $item->created_at,
                "Ip Address" => $item->ip,
                "Browser" => substr($item->agent,0,50),
            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
        );

        echo json_encode($response);
        exit;
    }
}
