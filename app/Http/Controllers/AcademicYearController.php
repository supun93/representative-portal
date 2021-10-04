<?php

    namespace App\Http\Controllers;

    use App\AcademicYear;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller;

    class AcademicYearController extends Controller
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

                $query = AcademicYear::query()
                    ->select("academic_year_id", "year_name")
                    ->orderBy("year_no");

                if ($limit === null) {

                    $query->limit(10);
                } else {

                    $limit = intval($limit);
                    if ($limit > 0) {

                        $query->limit($limit);
                    }
                }

                if ($searchText != "") {
                    $query = $query->where("year_name", "LIKE", "%" . $searchText . "%");
                }

                if ($idNot != "") {
                    $idNot = json_decode($idNot, true);
                    $query = $query->whereNotIn("academic_year_id", $idNot);
                }

                $data = $query->get();

                return response()->json($data, 201);
            }

            abort("403", "You are not allowed to access this data");
        }
    }
