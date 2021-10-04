<?php

namespace App\Http\Middleware;

use App\LogActivity;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LastStudentsActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $log_user = Auth::user()->student_id;
            $student = LogActivity::where('student','=',$log_user)->orderBy('id', 'desc')->first();
            $student->updated_at = Carbon::now();
            $student->save();
        }
        return $next($request);
    }
}
