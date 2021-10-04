<?php

    namespace App\Http\Controllers;

    use App\AcademicSemester;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller;

    class AcademicSemesterController extends Controller
    {
        /**
         * Search records
         * @param  Request  $request
         * @return JsonResponse
         */
        public function searchData(Request $request)
        {
            if ($request->expectsJson()) {
                $searchText = $request->post("query");
                $idNot = $request->post("idNot");
                $limit = $request->post("limit");

                $query = AcademicSemester::query()
                    ->select("semester_id", "semester_name")
                    ->orderBy("semester_no");

                if ($limit === null) {

                    $query->limit(10);
                } else {

                    $limit = intval($limit);
                    if ($limit > 0) {

                        $query->limit($limit);
                    }
                }

                if ($searchText != "") {
                    $query = $query->where("semester_name", "LIKE", "%" . $searchText . "%");
                }

                if ($idNot != "") {
                    $idNot = json_decode($idNot, true);
                    $query = $query->whereNotIn("semester_id", $idNot);
                }

                $data = $query->get();

                return response()->json($data, 201);
            }

            abort("403", "You are not allowed to access this data");
        }
    }
