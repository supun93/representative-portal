<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Students;
use App\Inputf;
use App\Studentregcourses;
use App\Transfer;
use App\BatchStudent;
use App\Conversations;
use App\Typesbatch;
use App\NoticeBoard;
use App\StudentPaymentPlanCardsE;
use App\Studentsdetailschangesrequests;
use App\Studentstransfer;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{

    public function readMessage($id)
    {
        $read = NoticeBoard::find($id);
        $read->view = 1;
        $read->save();
    }
    public  function closeConversation(Request $request)
    {
        $close = Conversations::find($request->conversation_id);
        $close->conversation_status = 1;
        $close->save();

        return response()->json(array('msg' => 1), 200);
    }
    public function sendMessages(Request $request)
    {
        $student_id = Auth::user()->student_id;

        $conversation = Conversations::whereStudentId($student_id)->where('category_id', $request->category_id)->where('category_title_id', $request->category_title_id)->where('conversation_status', 0)->latest()->first();
        if ($conversation != null) {
            $conversationId = $conversation->conversation_id;
        } else {
            $new = new Conversations;
            $new->category_id = $request->category_id;
            $new->category_title_id = $request->category_title_id;
            $new->student_id = $student_id;
            $new->save();

            $conversation = Conversations::whereStudentId($student_id)->where('category_id', $request->category_id)->where('category_title_id', $request->category_title_id)->where('conversation_status', 0)->latest()->first();
            $conversationId = $conversation->conversation_id;
        }
        $notice_id = NoticeBoard::latest()->first();
        if ($notice_id == null) {
            $notice_id =  1;
        } else {
            $notice_id = $notice_id->slo_notice_id + 1;
        }

        $send = new NoticeBoard;
        $send->student_id = $student_id;
        $send->notice_title = $request->title;
        $send->notice_text = $request->message;
        $send->slo_notice_id = $notice_id;
        $send->only_student = 1;
        $send->notice_type = 1;
        $send->view = 1;
        $send->conversation_id = $conversationId;
        $send->category_id = $request->category_id;
        $send->category_title_id = $request->category_title_id;
        $send->save();

        $update = Conversations::find($conversationId);
        $update->student_reply_status = 1;
        $update->slo_reply_status = 0;
        $update->save();

        return response()->json(array('msg' => 1), 200);
    }
    public function maindetailschangestore(Request $request)
    {
        $user_id = Auth::user()->student_id;
        $save = new Studentsdetailschangesrequests;
        $save->student_id = $user_id;
        $save->new_data = $request->new_value;
        $save->old_data = $request->old_value;
        $save->fid = $request->fid;
        $save->input_id = $request->input_id;
        $save->data_type = $request->data_type;
        if ($save->save()) {
            return response()->json(array('msg' => 1), 200);
        } else {
            return response()->json(array('msg' => 2), 200);
        }
    }
    public function generaldetailschangestore(Request $request)
    {
        $user_id = Auth::user()->student_id;
        $save = new Studentsdetailschangesrequests;
        $save->student_id = $user_id;
        $save->new_data = $request->new_value;
        $save->old_data = $request->old_value;
        $save->fid = $request->fid;
        $save->input_id = $request->input_id;
        $save->data_type = $request->data_type;
        if ($save->save()) {
            return response()->json(array('msg' => 1), 200);
        } else {
            return response()->json(array('msg' => 2), 200);
        }
    }
    public function coursedetailschangestore(Request $request)
    {
        $user_id = Auth::user()->student_id;
        $save = new Studentsdetailschangesrequests;
        $save->student_id = $user_id;
        $save->new_data = $request->new_value;
        $save->old_data = $request->old_value;
        $save->fid = $request->fid;
        $save->input_id = $request->input_id;
        $save->data_type = $request->data_type;
        $save->course_id = $request->course_id;
        if ($save->save()) {
            return response()->json(array('msg' => 1), 200);
        } else {
            return response()->json(array('msg' => 2), 200);
        }
    }
    
///////////////////////// save transfer requests//////////////////////////////
public function batchTypeTransferSubmit(Request $request)
{
    $studentId = Auth::user()->student_id;
    $lastStatus = Studentstransfer::where('student_id', $studentId)->latest()->first();
    $lastStatus =  $lastStatus->status ?? "1";
    if ($lastStatus == 0) {
        return response()->json(array('msg' => 2), 200);
    }
    $add = new Studentstransfer;
    $add->student_id = $studentId;
    $add->reason = $request->reason;
    $add->type = "BATCH TYPE TRANSFER";
    $add->status = 0;
    $add->from_course_id = $request->course_id;
    $add->from_batch_type = $request->from_batch_type;
    $add->to_batch_type = $request->to_batch_type;
    $add->save();
    return response()->json(array('msg' => 1), 200);
}
public function courseTransferSubmit(Request $request)
{
    $studentId = Auth::user()->student_id;
    $lastStatus = Studentstransfer::where('student_id', $studentId)->latest()->first();
    $lastStatus =  $lastStatus->status ?? "1";
    if ($lastStatus == 0) {
        return response()->json(array('msg' => 2), 200);
    }
    $add = new Studentstransfer;
    $add->student_id = $studentId;
    $add->reason = $request->reason;
    $add->type = "COURSE TRANSFER";
    $add->status = 0; 
    $add->from_course_id = $request->from_course_id;
    $add->to_course_id = $request->to_course_id;
    $add->save();
    return response()->json(array('msg' => 1), 200);
} 
public function batchTransferSubmit(Request $request)
{
    $studentId = Auth::user()->student_id;
    $studentPrimary = Students::whereRangeId($studentId)->first();
    $paymentCard = StudentPaymentPlanCardsE::whereStudentId($studentPrimary->student_id)->whereBatchId($request->from_batch_id)->whereStatus('APPROVED');
    if ($paymentCard->get()->count() == 0) {
        return response()->json(array('msg' => 'no payment card'), 200);
    }
    $paymentCard = $paymentCard->first();
    $lastStatus = Studentstransfer::where('student_id', $studentId)->latest()->first();
    $lastStatus =  $lastStatus->status ?? "1";
    if ($lastStatus == 0) {
        return response()->json(array('msg' => 'pending request'), 200);
    }
    $add = new Studentstransfer;
    $add->student_id = $studentId;
    $add->reason = $request->reason;
    $add->description = $request->description;
    $add->type = "BATCH TRANSFER";
    $add->status = 0;
    $add->from_course_id = $request->course_id;
    $add->from_batch_id = $request->from_batch_id;
    $add->to_batch_id = $request->to_batch_id;
    $add->save();

    return response()->json(array('msg' => 1), 200);
}
public function groupTransferSubmit(Request $request)
{
    $studentId = Auth::user()->student_id;
    $lastStatus = Studentstransfer::where('student_id', $studentId)->latest()->first();
    $lastStatus =  $lastStatus->status ?? "1";
    if ($lastStatus == 0) {
        return response()->json(array('msg' => 2), 200);
    }
    $add = new Studentstransfer;
    $add->student_id = $studentId;
    $add->reason = $request->reason;
    $add->type = "GROUP TRANSFER";
    $add->status = 0;
    $add->from_course_id = $request->course_id;
    $add->from_group_id = $request->from_group_id;
    $add->to_group_id = $request->to_group_id;
    $add->save();
    return response()->json(array('msg' => 1), 200);
}
public function subGroupTransferSubmit(Request $request)
{
    $studentId = Auth::user()->student_id;
    $lastStatus = Studentstransfer::where('student_id', $studentId)->latest()->first();
    $lastStatus =  $lastStatus->status ?? "1";
    if ($lastStatus == 0) {
        return response()->json(array('msg' => 2), 200);
    }
    $add = new Studentstransfer;
    $add->student_id = $studentId;
    $add->reason = $request->reason;
    $add->type = "SUBJECT GROUP TRANSFER";
    $add->status = 0;
    $add->from_course_id = $request->course_id;
    $add->from_batch_id = $request->batch_id;
    $add->from_group_id = $request->group_id;
    $add->from_sgroup_id = $request->from_sg_id;
    $add->to_sgroup_id = $request->to_sg_id;
    $add->save();
    return response()->json(array('msg' => 1), 200);
}
    public function paymentPlanRequested(Request $request)
    {
        $spacialArray = json_encode($request->change_plan);
        
        $studentId = Auth::user()->student_id;
        $lastStatus = Studentstransfer::where('student_id', $studentId)->latest()->first();
        $lastStatus =  $lastStatus->status ?? "1";
        if ($lastStatus == 0) {
            return response()->json(array('msg' => 2), 200);
        }
        $add = new Studentstransfer();
        $add->student_id = $studentId;
        $add->reason = $request->reason;
        $add->type = "PAYMENT PLAN TRANSFER";
        $add->status = 0;
        $add->from_course_id = $request->course_id;
        $add->from_batch_id = $request->batch_id;
        $add->special_array = $spacialArray;
        $add->save();
        return response()->json(array('msg' => 1), 200);
    }
    
}
