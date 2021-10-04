<?php

    namespace App\Http\Controllers;

    use App\Exports\StudentTimetableExport;
    use App\Services\ApiToken;
    use App\Students;
    use Exception;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\URL;
    use Maatwebsite\Excel\Facades\Excel;

    class TimetableController extends Controller
    {
        /**
         * @throws Exception
         */
        public function show($groupId = "", $type = "upcoming")
        {
            $upcomingOnly = "yes";
            if ($type === "full") {

                $upcomingOnly = "no";
            }

            $exportUrl = URL::to("/timetable/export");

            $student = Students::query()->where('range_id', '=', Auth::user()->student_id)->first();
            return view('timetable.view', compact('student', 'groupId', 'upcomingOnly', 'exportUrl'));
        }

        /**
         * @throws Exception
         */
        public function getTimetable($export = false)
        {
            $url = env("MAIN_LINK_URL") . "/api/academic/academic_timetable/filter_timetables";

            $groupId = request()->post("group_id");
            $upcomingOnly = request()->post("upcoming_only");
            $academicYearId = request()->post("academic_year_id");
            $semesterId = request()->post("semester_id");
            $dateFrom = request()->post("date_from");
            $dateTill = request()->post("date_till");

            $groupIds = [];
            if ($groupId !== null) {

                $groupIds[] = $groupId;
            }

            $response = Http::post($url, [
                "token" => ApiToken::generate(),
                "student_id" => Auth::user()->student_id,
                "timetable_type" => "academic",
                "group_id" => $groupIds,
                "upcoming_only" => $upcomingOnly,
                "academic_year_id" => $academicYearId,
                "semester_id" => $semesterId,
                "date_from" => $dateFrom,
                "date_till" => $dateTill,
            ]);

            $response = json_decode($response->body(), true);

            if (!isset($response["notify"]["status"])) {

                $response["notify"]["status"] = "failed";
                $response["notify"]["notify"][] = "Error occurred while getting timetable";
            }

            if ($export) {

                if ($response["notify"]["status"] === "success" && isset($response["data"]["timetable"])) {

                    $ttExport = new StudentTimetableExport();
                    $ttExport->timetable = $response["data"]["timetable"];

                    return Excel::download($ttExport, "timetable.xlsx");
                } else {

                    return redirect()->back();
                }
            } else {
                return response()->json($response, 201);
            }
        }

        public function export()
        {
            return $this->getTimetable(true);
        }
    }
