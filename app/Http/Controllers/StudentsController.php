<?php

namespace App\Http\Controllers;

use App\Students;
use App\Inputf;
use App\Studentregcourses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $studentId = Auth::user()->student_id;
        if ($studentId > 0) {
            $status = 1;
            $std = Students::where('range_id', '=', $studentId)->first();
            $data = DB::table('batch_student')
                ->join('batches', 'batches.batch_id', '=', 'batch_student.batch_id')
                ->join('courses', 'courses.course_id', '=', 'batches.course_id')
                ->join('departments', 'departments.dept_id', '=', 'courses.dept_id')
                ->join('faculties', 'faculties.faculty_id', '=', 'departments.faculty_id')
                ->select('batches.*', 'courses.*', 'departments.*', 'faculties.*', 'batch_student.mg_id')
                ->where('batch_student.student_id', '=', $studentId)
                ->get();

            $batch = DB::table('batch_student')
                ->join('batches', 'batches.batch_id', '=', 'batch_student.batch_id')
                ->select('batches.*')
                ->where('batch_student.student_id', '=', $studentId)
                ->get();

            $genaral = Inputf::where('course_id', '=', 0)->get();
            $assignedC = Studentregcourses::where('student_id', '=', $studentId)->where('deleted_at', '=', null)->get();
            return view('profile')->with(array('genaral' => $genaral, 'assignedC' => $assignedC, 'data' => $data, 'batch', $batch, "student" => $std, 'status' => $status));
        } else {
            $status = 0;

            return view('profile')->with(array('status' => $status));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function show(Students $students)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function edit(Students $students)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Students $students)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function destroy(Students $students)
    {
        //
    }
}
