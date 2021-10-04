<?php

namespace App\Http\Filter;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Students;
use App\Inputf;
use App\Studentregcourses;
use App\Batch;
use App\Courses;
use App\Faculty;
use App\Departments;
use App\BatchStudent;
use App\Transfer;
use App\Stdreqdetails;
use App\Subgroups;
use App\Groupes;
use App\NoticeBoard;
use App\Studentstransfer;
use App\StudentsTransferReasons;
use App\StudentPaymentPlanCardsE;
use Illuminate\Support\Facades\DB;

class FilterData extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */


    public static function filterDataModules($faculty, $department, $course, $batch, $batchtypes, $coursereqs, $ids)
    {
        if ($faculty != 0) {
            $data = Faculty::find($faculty)->departmentsSelect;
        } else if ($department != 0) {
            $data = Departments::find($department)->coursesSelect;
        } else if ($course != 0) {
            $data = Courses::find($course)->batchesSelect;
        } else if ($batch != 0) {
            $data =  DB::table('groupe_batches')
                ->join('groupes', 'groupes.GroupID', '=', 'groupe_batches.group_id')
                ->select('groupes.GroupID as id', 'groupes.GroupName as text')
                ->where('groupe_batches.batch_id', '=', $batch)
                ->where('groupes.deleted_at', '=', null)
                ->where('groupe_batches.deleted_at', '=', null)->get();
        } else if ($batchtypes != 0) {
            $data =  DB::table('types_batch')
                ->join('batch_types', 'batch_types.id', '=', 'types_batch.type_id')
                ->join('batches', 'batches.batch_id', '=', 'types_batch.batch_id')
                ->join('courses', 'courses.course_id', '=', 'batches.course_id')
                ->select('types_batch.type_id as id', 'batch_types.description as text')
                ->where("courses.course_id", "=", $batchtypes)
                ->distinct()->get();
        } else if ($coursereqs != 0) {
            $data =  DB::table('inputfs')
                ->select('inputfs.id', 'inputfs.fname as text')
                ->where('inputfs.course_id', '=', $coursereqs)->get();
        } else if ($ids != 0) {
            $data =  DB::table('id_ranges')
                ->select('id_ranges.start', 'id_ranges.end')
                ->where('id_ranges.course_id', '=', $ids)->where('deleted_at', '=', null)->where('hold', '=', 0);
            if ($data->count() != 0) {
                $data = $data->latest()->first();
            } else {
                $data = [];
            }
        }
        return $data;
    }
    public static function filterDataToSubjectGroupes($id)
    {
        $old_subject_group = Subgroups::find($id); //dd($old_subject_group);
        $old_subject_group_id = $old_subject_group->id;
        $old_subject_group_semester = $old_subject_group->semester;
        $old_subject_group_dm = $old_subject_group->dm_id;
        $old_subject_group_mg = $old_subject_group->main_gid;
        $old_subject_group_year = $old_subject_group->year;
        $data = Subgroups::select('id', 'sg_name as text')->where('year', $old_subject_group_year)->whereSemester($old_subject_group_semester)
            ->whereDmId($old_subject_group_dm)->whereMainGid($old_subject_group_mg)
            ->whereColumn('assigned', '<', 'max_students')->where('id', '!=', $old_subject_group_id)->get();
        //dd($to_subject_groupes);
        return $data;
    }
}
