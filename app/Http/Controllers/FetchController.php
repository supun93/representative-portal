<?php

namespace App\Http\Controllers;

use App\Students;
use App\Inputf;
use App\Studentregcourses;
use App\Batch;
use App\Courses;
use App\Stdtitles;
use App\Country;
use App\Departments;
use App\BatchStudent;
use App\Conversations;
use App\Transfer;
use App\Stdreqdetails;
use App\Groupes;
use App\NoticeBoard;
use App\Studentstransfer;
use App\StudentsTransferReasons;
use App\StudentPaymentPlanCardsE;
use App\FinanceCommonOtherPayments;
use App\FinanceStudentFeeDefinitions;
use App\FinanceStudentOtherPayments;
use App\MessageCategories;
use App\MessageCategoryTitles;
use App\MarketingStudent;
use App\Http\Filter\FilterData;
use Facade\FlareClient\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\AcademicTimeTableInformation;
use App\ExamCalendar;
use App\ExamGroupStudents;
use App\spStudentAttendanceRecords;
use App\Studentsdetailschangesrequests;
use Illuminate\Support\Facades\Session;

class FetchController extends Controller
{

    public function __construct()
    {
        
        
        
    }
    public function marketingRegistrationSubmit(Request $request)
    {
        $new = new MarketingStudent;
        $new->course = $request->course_id;
        $new->nts_batch_year = $request->nts_batch_year ?? null;
        $new->full_name = $request->full_name;
        $new->nic_passport = $request->nic ?? $request->passport;
        $new->tel_mobile1 = $request->mobile1;
        $new->address = $request->address;
        $new->email = $request->email;
        $new->gender = $request->gender;
        $new->country_id = $request->country_id;
        $new->city = $request->city;
        $new->save();
        $row_id = MarketingStudent::latest()->first()->id;
        return response()->json(array('msg' => 1, 'row_id' => $row_id), 200);
    }
    public function marketingRegistration($id)
    {
        $course = Courses::find($id);
        $country = Country::orderBy('country_name', 'ASC')->get();
        return view('marketing.registration-form', Compact('course', 'country'));
    }
    public function batchPendingPaymentOther(Request $request)
    {
        $postArray = $request->all();
        $paymentCardId = $postArray['payment_card_id'];
        $result = DB::select(DB::raw(
            "select fsop.amount as due_amount, fsop.total_paid, fsop.due_date, fsop.status as payment_status, fcop.name as payment_name, s.foreign "
                . "from finance_student_payment_plan_cards fsppc "
                . "join finance_student_other_payments fsop on (fsppc.id = fsop.payment_plan_card_id and (fsop.status = 'PENDING' or fsop.status = '')) "
                . "join finance_common_other_payments fcop on fsop.common_payment_id = fcop.id "
                . "join students s on fsppc.student_id = s.student_id "
                . "where fsppc.id = $paymentCardId"
        ));
        // dd($result);
        $view = view('payments.outstanding-other-payments', compact('result'))->render();
        return response()->json($view);
    }
    public function batchPendingPayment(Request $request)
    {
        $postArray = $request->all();
        $paymentCardId = $postArray['payment_card_id'];

        $result = DB::select(DB::raw("
        select installment_type, installment_counter, fsps.due_date, amount, total_paid, installment_discount, fsps.status, currency, fsppc.id as student_payment_plan_card_id, fsps.id as shedule_id from finance_student_payment_plan_cards fsppc
        join finance_student_payment_schedules fsps on (fsppc.id = fsps.payment_plan_card_id and (fsps.status = '' or fsps.status = 'PARTIAL'))
        join finance_student_fee_definitions fsfd on fsps.fee_definition_id = fsfd.id
        where fsppc.id = $paymentCardId
        order by fsps.due_date asc
        "));

        $pp = StudentPaymentPlanCardsE::select('student_id', 'batch_id')->find($paymentCardId)->toArray(); 
        $type = BatchStudent::select('batch_id', 'batch_type')->with('batchType:id,description')->where('batch_id', $pp['batch_id'])->where('student_inc_id', $pp['student_id'])->latest()->first()->toArray();
        $type = $type['batch_type']['id'];
        $view = view('payments.pending-payment', compact('result', 'type'))->render();
        return response()->json($view); 
    }
    public function batchPaymentHistoryOther(Request $request)
    {
        $postArray = $request->all();
        $paymentCardId = $postArray['payment_card_id'];
        $result = DB::select(DB::raw(
            "select fsop.amount as due_amount, fsop.due_date, fsop.status as payment_status, fcop.name as payment_name, "
                . "fri.paid_amount, fri.installment_discount, fpr.receipt_increment_id, fpr.actual_paid_date, fpr.paid_currency, "
                . "fpr.collection_date from finance_student_payment_plan_cards fsppc "
                . "join finance_student_other_payments fsop on (fsppc.id = fsop.payment_plan_card_id and (fsop.status = 'PAID' or fsop.status = 'PARTIAL')) "
                . "join finance_receipt_items fri on (fsop.id = fri.reference_id and fri.reference_type = 'StudentOtherPayments') "
                . "join finance_payment_receipts fpr on fri.receipt_id = fpr.id "
                . "join finance_common_other_payments fcop on fsop.common_payment_id = fcop.id "
                . "where fsppc.id = $paymentCardId"
        ));
        // dd($result);
        $view = view('payments.other-payment-history', compact('result'))->render();
        return response()->json($view);
    }
    public function batchPaymentHistory(Request $request)
    {
        $postArray = $request->all();
        $paymentCardId = $postArray['payment_card_id'];
        $result = DB::select(DB::raw("
        select installment_type, installment_counter, paid_currency, fri.paid_amount, fri.installment_discount, late_payment, late_payment_deduction, receipt_increment_id, fsps.due_date, actual_paid_date, collection_date, fpr.id as receipt_id from finance_student_payment_plan_cards fsppc
        join finance_payment_receipts fpr on fsppc.id = fpr.payment_plan_card_id
        join finance_receipt_items fri on fpr.id = fri.receipt_id
        join finance_student_payment_schedules fsps on (fri.reference_id = fsps.id and fri.reference_type = 'StudentPaymentSchedules' and (fsps.status = 'PAID' or fsps.status = 'PARTIAL'))
        join finance_student_fee_definitions fsfd on fsps.fee_definition_id = fsfd.id
        where fsppc.id = $paymentCardId
        "));
        $view = view('payments.payment-history', compact('result'))->render();
        return response()->json($view);
    }
    public function paymentCourseDetails($batch)
    {
        $student = Students::whereRangeId(Auth::user()->student_id)->first();
        $data = BatchStudent::with(['batch' => function ($c) {
            $c->with(['course' => function ($d) {
                $d->with(['department' => function ($f) {
                    $f->with(['faculty'])->get();
                }])->get();
            }])->get();
        }])->whereStudentId($student->range_id)->whereBatchId($batch)->first();
        $paymentCard = StudentPaymentPlanCardsE::whereStudentId($student->student_id)->whereBatchId($batch)->whereStatus('APPROVED')->first();
        return view('ajaxblades.paymentCourseDetails', Compact('data', 'paymentCard'));
    }
    public function paymentDashboard($course)
    {
        $student = Students::whereRangeId(Auth::user()->student_id)->first();
        $data = BatchStudent::with(['batch' => function ($c) use ($course) {
            $c->with(['course' => function ($d) {
                $d->with(['department' => function ($f) {
                    $f->with(['faculty'])->get();
                }])->get();
            }])->whereCourseId($course)->get();
        }])->whereStudentId($student->range_id)->orderBy('status', 'ASC')->get();
        return view('payments.dashboard', Compact('student', 'data'));
    }

    /////////////////////// Messages //////////////////////////////////
    public function messagesListInbox()
    {
        $rangeId = Auth::user()->student_id;
        $student = Students::whereRangeId($rangeId)->first();
        $data = Conversations::with(['messages', 'category', 'categoryTitle'])->whereHas('messages',function($m){
            $m->where('created_by','!=',null)->orderBy('view','asc');
        })->orderBy('updated_at','desc')->whereStudentId($rangeId)->paginate(25);

        return view('messages.messages-inbox', Compact('student', 'data'));
    }
    public function messagesListOutbox()
    {
        $rangeId = Auth::user()->student_id;
        $student = Students::whereRangeId($rangeId)->first();
        $data = NoticeBoard::with(['conversation', 'category', 'categoryTitle'])->whereStudentId($rangeId)->whereNoticeType(1)->where('created_by', '=', null)->orderBy('created_at', 'DESC')->paginate(25);
        return view('messages.messages-outbox', Compact('student', 'data'));
    }
    public function messagesNew()
    {
        $rangeId = Auth::user()->student_id;
        $student = Students::whereRangeId($rangeId)->first();
        $messageCategories = MessageCategories::whereDeletedAt(null)->get();
        $messageCategoryTitles = MessageCategoryTitles::whereDeletedAt(null)->get();
        return view('messages.messages-new', Compact('student', 'messageCategories', 'messageCategoryTitles'));
    }
    public function messagesShow($id)
    {
        $message = NoticeBoard::find($id);
        $rangeId = Auth::user()->student_id;
        $student = Students::whereRangeId($rangeId)->first();

        $data = Conversations::with(['student','forwardFrom','forwardTo','category','categoryTitle','messages'=>function($e){
            $e->where('notice_type', 1);
        }])->find($id);

        if ($data->student_id != $rangeId) {
            return back();
        }
        
        return view('messages.messages-show', Compact('student', 'data'));
    }
    
    public function coursesList()
    {
        $rangeId = Auth::user()->student_id;
        $student = Students::whereRangeId($rangeId)->first();
        $data = DB::table('batch_student')
            ->join('batches', 'batches.batch_id', '=', 'batch_student.batch_id')
            ->join('courses', 'courses.course_id', '=', 'batches.course_id')
            ->join('departments', 'departments.dept_id', '=', 'courses.dept_id')
            ->join('faculties', 'faculties.faculty_id', '=', 'departments.faculty_id')
            ->select('batches.*', 'courses.*', 'departments.*', 'faculties.*', 'batch_student.mg_id', 'batch_student.student_status')
            ->where('batch_student.student_id', '=', $rangeId)
            ->where('batch_student.status', '=', 0)
            ->get();
        return view('courses', Compact('student', 'data'));
    }

    public function dashboard()
    {
        $rangeId = Auth::user()->student_id;
        $student = Students::whereRangeId($rangeId)->first();
        $notice = NoticeBoard::with(['category', 'categoryTitle'])->whereStudentId($rangeId)->whereNoticeType(0)->orderBy('notice_date', 'DESC')->paginate(15);
        return view('models/dashboard', Compact('student', 'notice'));
    }
    public function noticeboard()
    {
        $messageCategories = MessageCategories::whereDeletedAt(null)->get();
        $messageCategoryTitles = MessageCategoryTitles::whereDeletedAt(null)->get();
        $rangeId = Auth::user()->student_id;
        $student = Students::whereRangeId($rangeId)->first();
        $notice = NoticeBoard::with(['category', 'categoryTitle'])->whereStudentId($rangeId)->whereNoticeType(0)->orderBy('notice_date', 'DESC')->paginate(15);
        return view('noticeboard/view', Compact('student', 'notice', 'messageCategories', 'messageCategoryTitles'));
    }
    public function noticeboardLoad(Request $request)
    {
        $rangeId = Auth::user()->student_id;
        $student = Students::whereRangeId($rangeId)->first();
        $notice = NoticeBoard::with(['category', 'categoryTitle'])->whereStudentId($rangeId)->whereNoticeType(0);
        if ($request->category_id != "") {
            $notice = $notice->where('category_id', $request->category_id);
        }
        if ($request->category_title_id != "") {
            $notice = $notice->where('category_title_id', $request->category_title_id);
        }
        $notice = $notice->orderBy('notice_id', 'DESC')->paginate(15);
        $view = view('ajaxblades.notice', compact('notice'))->render();
        return response()->json($view);
    }
    public function loadCourseGroupes($id)
    {
        $rangeId = Auth::user()->student_id;
        $model = new Students;
        $data = $model->getAllStudentsGroupes($rangeId, $id);
        //dd($data);
        return view('ajaxblades/coursegroupes', Compact('data'));
    }
    public function studentMainDetails()
    {
        $studentId = Auth::user()->student_id;
        return $data = DB::table('batch_student')
            ->join('batches', 'batches.batch_id', '=', 'batch_student.batch_id')
            ->join('courses', 'courses.course_id', '=', 'batches.course_id')
            ->join('departments', 'departments.dept_id', '=', 'courses.dept_id')
            ->join('faculties', 'faculties.faculty_id', '=', 'departments.faculty_id')
            ->select('batches.*', 'courses.*', 'departments.*', 'faculties.*', 'batch_student.mg_id','batch_student.status as student_status')
            ->where('batch_student.student_id', '=', $studentId)
            ->where('batch_student.student_status', '=', 0)
            ->get();
    }
    public function maindetails()
    {
        $studentId = Auth::user()->student_id;
        if ($studentId > 0) {
            $status = 1;
            $std = Students::with(['getCountry', 'postalCountry', 'permenantProvince', 'postalProvince', 'permenantDistrict', 'postalDistrict', 'permenantCity', 'postalCity', 'DivisionalSecretariatDivisionId'])->where('range_id', '=', $studentId)->first();
            $data = $this->studentMainDetails();

            $batch = DB::table('batch_student')
                ->join('batches', 'batches.batch_id', '=', 'batch_student.batch_id')
                ->select('batches.*')
                ->where('batch_student.student_id', '=', $studentId)
                ->where('batch_student.student_status', '=', 0)
                ->get();

            $genaral = Inputf::where('course_id', '=', 0)->orderBy('order', 'ASC')->get();
            $assignedC = Studentregcourses::where('student_id', '=', $studentId)->where('deleted_at', '=', null)->get();
            return view('details/main')->with(array('genaral' => $genaral, 'assignedC' => $assignedC, 'data' => $data, 'batch', $batch, "student" => $std, 'status' => $status));
        } else {
            $status = 0;

            return view('details/main')->with(array('status' => $status));
        }
    }
    public function generaldetails()
    {
        $studentId = Auth::user()->student_id;
        if ($studentId > 0) {
            $status = 1;
            $std = Students::where('range_id', '=', $studentId)->first();
            $data = $this->studentMainDetails();

            $batch = DB::table('batch_student')
                ->join('batches', 'batches.batch_id', '=', 'batch_student.batch_id')
                ->select('batches.*')
                ->where('batch_student.student_id', '=', $studentId)
                ->get();

            $genaral = Inputf::where('course_id', '=', 0)->orderBy('order', 'ASC')->get();
            $assignedC = Studentregcourses::where('student_id', '=', $studentId)->where('deleted_at', '=', null)->get();
            return view('details/general')->with(array('genaral' => $genaral, 'assignedC' => $assignedC, 'data' => $data, 'batch', $batch, "student" => $std, 'status' => $status));
        } else {
            $status = 0;

            return view('details/general')->with(array('status' => $status));
        }
    }
    public function generaldetailschange(Request $request)
    {
        $studentId = Auth::user()->student_id;
        $std_id = Students::where('range_id', '=', $studentId)->first();
        $check_rights = Stdreqdetails::find($request->myid);
        $check_rights2 = $check_rights->std_id ?? 0;
        if ($check_rights2 == 0) {
            return back();
        } else if ($check_rights->std_id != $std_id->student_id) {
            return back();
        }
        $status = 1;
        $std = Students::where('range_id', '=', $studentId)->first();
        $data = $this->studentMainDetails();

        $batch = DB::table('batch_student')
            ->join('batches', 'batches.batch_id', '=', 'batch_student.batch_id')
            ->select('batches.*')
            ->where('batch_student.student_id', '=', $studentId)
            ->get();

        $genaral = Inputf::find($request->fid);
        if ($genaral->fname != $check_rights->inputname) {
            return back();
        } 
        $studentsPendingRequests = Studentsdetailschangesrequests::where('student_id', $studentId)->where('status', 0)->count();
        $assignedC = Studentregcourses::where('student_id', '=', $studentId)->where('deleted_at', '=', null)->get();
        return view('details/generalchanges')->with(array('studentsPendingRequests' => $studentsPendingRequests, 'check_rights' => $check_rights, 'genaral' => $genaral, 'assignedC' => $assignedC, 'data' => $data, 'batch', $batch, "student" => $std, 'status' => $status));
    }
    public function coursesdetails()
    {
        $studentId = Auth::user()->student_id;
        if ($studentId > 0) {
            $status = 1;
            $std = Students::where('range_id', '=', $studentId)->first();
            $data = $this->studentMainDetails();

            $batch = DB::table('batch_student')
                ->join('batches', 'batches.batch_id', '=', 'batch_student.batch_id')
                ->select('batches.*')
                ->where('batch_student.student_id', '=', $studentId)
                ->first();

            $genaral = Inputf::where('course_id', '=', 0)->orderBy('order', 'ASC')->get();
            $assignedC = Studentregcourses::where('student_id', '=', $studentId)->where('deleted_at', '=', null)->get();
            return view('details/courses')->with(array('genaral' => $genaral, 'assignedC' => $assignedC, 'data' => $data, 'batch', $batch, "student" => $std, 'status' => $status));
        } else {
            $status = 0;

            return view('details/courses')->with(array('status' => $status));
        }
    }
    public function coursedetailschange(Request $request)
    {
        $studentId = Auth::user()->student_id;
        $std_id = Students::where('range_id', '=', $studentId)->first();
        $check_rights = Stdreqdetails::find($request->myid);
        $check_rights2 = $check_rights->std_id ?? 0;
        if ($check_rights2 == 0) {
            return back();
        } else if ($check_rights->std_id != $std_id->student_id) {
            return back();
        }
        $status = 1;
        $std = Students::where('range_id', '=', $studentId)->first();
        $data = $this->studentMainDetails();

        $batch = DB::table('batch_student')
            ->join('batches', 'batches.batch_id', '=', 'batch_student.batch_id')
            ->select('batches.*')
            ->where('batch_student.student_id', '=', $studentId)
            ->get();

        $course = Inputf::find($request->fid);
        if ($course->fname != $check_rights->inputname) {
            return back();
        }
        $studentsPendingRequests = Studentsdetailschangesrequests::where('student_id', $studentId)->where('status', 0)->count();
        $assignedC = Studentregcourses::where('student_id', '=', $studentId)->where('deleted_at', '=', null)->get();
        return view('details/coursechanges')->with(array('studentsPendingRequests' => $studentsPendingRequests, 'check_rights' => $check_rights, 'course' => $course, 'assignedC' => $assignedC, 'data' => $data, 'batch', $batch, "student" => $std, 'status' => $status));
    }
    public function maindetailschange(Request $request)
    {
        $studentId = Auth::user()->student_id;
        $std_id = Students::where('range_id', '=', $studentId)->first();
        if ($request->det == 'fullname') {
            $input_id = 1;
            $input_name = 'Full Name';
            $old_data = $std_id->full_name;
        } else if ($request->det == 'name_initials') {
            $input_id = 2;
            $input_name = 'Name with Initials';
            $old_data = $std_id->name_initials;
        } else if ($request->det == 'address') {
            $input_id = 3;
            $input_name = 'Permanant Address';
            $old_data = $std_id->per_address;
        } else if ($request->det == 'mobile1') {
            $input_id = 4;
            $input_name = '1st Mobile Number';
            $old_data = $std_id->tel_mobile1;
        } else if ($request->det == 'mobile2') {
            $input_id = 4;
            $input_name = '2nd Mobile Number';
            $old_data = $std_id->tel_mobile2;
        } else if ($request->det == 'email') {
            $input_id = 5;
            $input_name = 'Personal Email';
            $old_data = $std_id->email1;
        } else if ($request->det == 'postal_address') {
            $input_id = 3;
            $input_name = 'Postal Address';
            $old_data = $std_id->postal_address;
        }

        $status = 1;
        $std = Students::where('range_id', '=', $studentId)->first();
        $data = $this->studentMainDetails();

        $batch = DB::table('batch_student')
            ->join('batches', 'batches.batch_id', '=', 'batch_student.batch_id')
            ->select('batches.*')
            ->where('batch_student.student_id', '=', $studentId)
            ->get();
        
        $studentsPendingRequests = Studentsdetailschangesrequests::where('student_id', $studentId)->where('status', 0)->count();
        return view('details/mainchanges')->with(array('studentsPendingRequests' => $studentsPendingRequests, 'input_id' => $input_id, 'input_name' => $input_name, 'old_data' => $old_data, 'data' => $data, 'batch', $batch, "student" => $std, 'status' => $status));
    }



    //////////////////////////////////////transfer request////////////////////////////////////////////////
    public function batchTypeTransfer(Request $request)
    {
        $studentId = Auth::user()->student_id;
        $student = Students::where('range_id', '=', $studentId)->first();
        $lastStatus = Studentstransfer::where('student_id', $studentId)->latest()->first();
        $batchTypes = Batch::with(['batchTypes'])->find($request->batch_id);
        $model = new Students;
        $data = $model->getAllStudentsGroupes($studentId, $request->course_id); 
        $lastStatus = $lastStatus->status ?? '';
        $pPlan = StudentPaymentPlanCardsE::whereStudentId($student->student_id)->whereBatchId($request->batch_id)->whereStatus('APPROVED');
        $paymentPlan = $pPlan->first();
        $pPlan = $pPlan->get()->count();
        
        return view('transfer.batchtypetransfer', Compact('batchTypes', 'data', 'lastStatus', 'student','pPlan','paymentPlan'));
    }

    public function courseTransfer(Request $request)
    {
        $studentId = Auth::user()->student_id;
        $student = Students::where('range_id', '=', $studentId)->first();
        $lastStatus = Studentstransfer::where('student_id', $request->student_id)->latest()->first();
        $model = new Students;
        $data = $model->getAllStudentsGroupes($request->student_id, $request->course_id);
        $courses = Departments::find($data->regCourses->department->dept_id)->coursesSelect;
        $lastStatus = $lastStatus->status ?? '';
        $pPlan = StudentPaymentPlanCardsE::whereStudentId($student->student_id)->whereBatchId($request->batch_id)->whereStatus('APPROVED');
        $paymentPlan = $pPlan->first();
        $pPlan = $pPlan->get()->count();
        return view('transfer.coursetransfer', Compact('courses', 'data', 'lastStatus', 'student','pPlan','paymentPlan'));
    }

    public function batchTransfer(Request $request)
    {
        $studentId = Auth::user()->student_id;
        $student = Students::where('range_id', '=', $studentId)->first();
        $reasons = StudentsTransferReasons::whereDeletedAt(null)->get();
        $lastStatus = Studentstransfer::where('student_id', $request->student_id)->latest()->first();
        $model = new Students;
        $data = $model->getAllStudentsGroupes($request->student_id, $request->course_id); // dd($dd);
        $batches = Courses::find($data->regCourses->course->course_id)->batchesSelect;
        $lastStatus = $lastStatus->status ?? '';
        $pPlan = StudentPaymentPlanCardsE::whereStudentId($student->student_id)->whereBatchId($request->batch_id)->whereStatus('APPROVED');
        $paymentPlan = $pPlan->first();
        $pPlan = $pPlan->get()->count();
        return view('transfer.batchtransfer', Compact('batches', 'data', 'lastStatus', 'reasons', 'student','pPlan','paymentPlan'));
    }

    public function groupTransfer(Request $request)
    {
        $studentId = Auth::user()->student_id;
        $student = Students::where('range_id', '=', $studentId)->first();
        $lastStatus = Studentstransfer::where('student_id', $request->student_id)->latest()->first();
        $model = new Students;
        $data = $model->getAllStudentsGroupes($request->student_id, $request->course_id); //dd($data);
        $groupes = FilterData::filterDataModules(0, 0, 0, $data->batchStudent->batch_id, 0, 0, 0);
        $lastStatus = $lastStatus->status ?? '';
        $pPlan = StudentPaymentPlanCardsE::whereStudentId($student->student_id)->whereBatchId($request->batch_id)->whereStatus('APPROVED');
        $paymentPlan = $pPlan->first();
        $pPlan = $pPlan->get()->count();
        return view('transfer.grouptransfer', Compact('groupes', 'data', 'lastStatus', 'student','pPlan','paymentPlan'));
    }

    public function subGroupTransfer(Request $request)
    {
        $studentId = Auth::user()->student_id;
        $student = Students::where('range_id', '=', $studentId)->first();
        $lastStatus = Studentstransfer::where('student_id', $request->student_id)->latest()->first();
        $model = new Students;
        $data = $model->getAllStudentsGroupes($request->student_id, $request->course_id); //dd($data);
        $lastStatus = $lastStatus->status ?? '';
        $pPlan = StudentPaymentPlanCardsE::whereStudentId($student->student_id)->whereBatchId($request->batch_id)->whereStatus('APPROVED');
        $paymentPlan = $pPlan->first();
        $pPlan = $pPlan->get()->count();
        return view('transfer.subjectgrouptransfer', Compact('data', 'lastStatus', 'student','pPlan','paymentPlan'));
    }

    public function loadPaymentPlansForTransfer(Request $request)
    {
        $studentId = Auth::user()->student_id;
        $student = Students::where('range_id', '=', $studentId)->first();
        $lastStatus = Studentstransfer::where('student_id', $request->student_id)->latest()->first();
        $model = new Students;
        $data = $model->getAllStudentsGroupes($request->student_id, $request->course_id); //dd($data);
        $lastStatus = $lastStatus->status ?? '';
        $pPlan = StudentPaymentPlanCardsE::with(['studentFeeDefinition.batchPaymentPlanTypes.commonPaymentPlanTypes','studentFeeDefinition.myPaymentPlanType.commonPaymentPlanTypes'])->whereStudentId($student->student_id)->whereBatchId($request->batch_id)->whereStatus('APPROVED');
        $paymentPlan = $pPlan->first();
        $pPlan = $pPlan->get()->count();
        return view('transfer.paymentplantransfer', Compact('data', 'lastStatus', 'student','pPlan','paymentPlan'));
    }

    //////////////////// filter data/////////////////////////
    public function filterData($type, $id)
    {
        if ($type == 'to_subject_groupes') {
            $xx = FilterData::filterDataToSubjectGroupes($id);
            return response()->json($xx);
        }
    }

    ///////////////// attendance verify form ///////////////
    public function studentAttendanceSubmitVerifyForm ($id){
        
        $infoId = base64_decode($id);
        $item = AcademicTimeTableInformation::with(['module','academictimetable'])->find($infoId);
        $verified = 0;
        if(Session::get('verifiedStudentId') != null){
            $verified = 1;
        }
        $submitted = spStudentAttendanceRecords::where('a_t_information_id', $infoId)->where('student_id', Session::get('verifiedStudentId'))->get()->count();
        return view('attendance.verify-form', Compact('item', 'id', 'verified', 'submitted'));
    }
    public function studentAttendanceSubmitVerifyFormAgain ($id){
        Session::forget('verifiedStudentId');
        return back();
    }
    public function studentAttendanceSubmitVerifyFormSubmit ($id, Request $request){
        $infoId = base64_decode($id);

        $studentId = $request->student_id;
        $nicPassport = $request->nic_passport;
        $kiuEmail = $request->kiu_email;

        $check = Students::where('range_id', $studentId)->where('nic_passport', $nicPassport)->where('kiu_mail', $kiuEmail)->first();
        if($check == false){
            return response()->json('invalid');
        }

        Session::put('verifiedStudentId', $studentId);
        return response()->json('success');
    }
    ///////////////// attendance submit form ///////////////
    public function studentAttendanceSubmitForm ($id){
        
        if(Session::get('verifiedStudentId') == null){
            return redirect()->route('student-attendance-verify.form', $id);
        }

        $infoId = base64_decode($id);

        $item = AcademicTimeTableInformation::with(['module','academictimetable','lecturers.lecturer'])->find($infoId);
        $studentId = Session::get('verifiedStudentId');

       

        $check = AcademicTimeTableInformation::with(['subgroupesinfo.subgroupstudents'=>function($e) use($studentId){
            $e->where('std_id', $studentId)->get()->count();

        }])->whereHas('subgroupesinfo', function($p){

        })->find($infoId);
        $loop = $check->subgroupesinfo;
        $check = 0;
        foreach($loop as $row1){ 
            foreach($row1->subgroupstudents as $row){
                $check = $row->where('std_id', $studentId)->where('sg_id',$row->sg_id)->get()->count();
            }
        }
        $studentDetails = Students::where('range_id', $studentId)->first();
        $submitted = spStudentAttendanceRecords::where('a_t_information_id', $infoId)->where('student_id', $studentId)->get()->count();
        
        return view('attendance.submit-form', Compact('item', 'id', 'check', 'submitted', 'studentDetails'));
        
    }

    public function studentAttendanceSubmit ($id, Request $request){
        $infoId = base64_decode($id);
        
        if(Session::get('verifiedStudentId') == null){
            return response()->json('expire');
        }
        if($request->lecturer_id == null){
            return response()->json('no lecturers');
        }
        
        $x = 0;
        foreach ($request->lecturer_id as $key => $value) {
            $lecturerId = $value; 
            $rating = $request->rating[$x];
            $note = $request->note[$x];

            $add = new spStudentAttendanceRecords;
            $add->student_id = Session::get('verifiedStudentId');
            $add->a_t_information_id = $infoId;
            $add->lecturer_id = $lecturerId;
            $add->rating = $rating;
            $add->note = $note;
            $add->save();

            $x++;
        }
        return response()->json('success');
    }

    ///////////////// exam-approval verify form ///////////////
    public function studentExamApprovalSubmitVerifyForm ($id){
        $item = AcademicTimeTableInformation::with(['module','academictimetable'])->find($id);
        $verified = 0;
        if(Session::get('verifiedStudentId') != null){
            $verified = 1;
        }
        return view('exam-approval.verify-form', Compact('item', 'id', 'verified'));
    }
    public function studentExamApprovalSubmitVerifyFormAgain ($id){
        Session::forget('verifiedStudentId');
        return back();
    }
    public function studentExamApprovalSubmitVerifyFormSubmit ($id, Request $request){

        $studentId = $request->student_id;
        $nicPassport = $request->nic_passport;
        $kiuEmail = $request->kiu_email;

        $check = Students::where('range_id', $studentId)->where('nic_passport', $nicPassport)->where('kiu_mail', $kiuEmail)->first();
        if($check == false){
            return response()->json('invalid');
        }

        Session::put('verifiedStudentId', $studentId);
        return response()->json('success');

    }

    ///////////////// exam-approval submit form ///////////////
    public function studentExamApprovalSubmitSubmitForm ($id){
        
        if(Session::get('verifiedStudentId') == null){
            return redirect()->route('student-exam-approval-verify.form', $id);
        }
        $studentId = Session::get('verifiedStudentId');

        $item = ExamCalendar::with(['academicTimeTableInformation','examGroupStudent' => function($e) use($studentId){
            $e->where('student_id', $studentId);
        }])->where('academic_timetable_information_id', $id)->first();
        
        $studentDetails = Students::where('range_id', $studentId)->first();

        return view('exam-approval.submit-form', Compact('item', 'studentDetails', 'id'));
        
    }

    public function studentExamApprovalSubmitSubmit ($id, Request $request){
        
        $add = ExamGroupStudents::find($id);
        $add->student_approved = 1;
        $add->save();
        return response()->json('success');
    }

    /////////////////// exam approve form in student portal //////////////////////////
    function examApproveForm ($id){
        $studentId = Auth::user()->student_id;
        $item = ExamCalendar::with(['academicTimeTableInformation','examGroupStudent' => function($e) use($studentId){
            $e->where('student_id', $studentId);
        }])->where('academic_timetable_information_id', $id)->first();

        $student = Students::whereRangeId($studentId)->first();
        
        return view('exam-approval.index', Compact('student', 'item'));
    }

    public function examTimeTableList (){

        $studentId = Auth::user()->student_id;
        $student = Students::whereRangeId($studentId)->first();
        $list = AcademicTimeTableInformation::with(['academictimetable.academicyear', 'academictimetable.semester', 'module', 'examCategory', 'examType','examCalendar.examGroupStudent' => function ($u) use($studentId){
            $u->with(['examSpaceStudent.spaces.spaceCategoryName.spacecategory','examSpaceStudent.spaces.spaceType'])->where('student_id', $studentId);
        }])->where('exam_type_id', '!=', 0)->where('exam_category_id', '!=', 0)->whereHas('examCalendar', function($e) use($studentId){
            $e->whereHas('examGroupStudent', function ($qu) use ($studentId){
                $qu->where('student_id', $studentId);
            })->where('status', 0);
        })->get();

        //dd($list);
        return view('exam-approval.list', Compact('student', 'list'));

    }
}
