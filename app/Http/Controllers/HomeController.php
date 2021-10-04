<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Students;
use App\Inputf;
use App\Studentregcourses;
use DB;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        echo 'home';
    }
    
}
