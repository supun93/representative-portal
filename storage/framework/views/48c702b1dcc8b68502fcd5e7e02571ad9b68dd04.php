<?php
$pageTitle = "Profile";
$nav_slo = "active";
?>

<?php $__env->startSection('content'); ?>
<style>
.bg-info1{
    background-color:#43abfc;
    color:white;
}
.bg-warning1{
    background-color:#f3d74c;
    color:white;
}
.bg-success1{
    background-color:#97d881;
    color:white;
}
.bg-danger1{
    background-color:#fc4349;
    color:white;
}
.bg-gray1{
    background-color:#aaa;
    color:white;
}
hr {
    margin-top: 0.5rem !important;
    margin-bottom: 0.5rem !important;
}
h6{
    margin-top:10px
}
</style>
<div class="content">
<div class="container-fluid behind">
    <div class="row mb-2">
        <div class="col-sm-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('dashbord')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Profile Details </li>
              </ol>
        </div>
      </div>
<div class="row">
<?php if($status  == 0): ?>
<div class="card">
<div class="card-body">
No Students
</div>
</div>
</div>
</div>
<?php else: ?>
<!-- /.col -->
<div class="col-md-12">
<div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4>Registered Details</h4>
                </div>
                <div class="col-md-6">
                    <h4 class="float-sm-right">Student No : <?php echo e($student->range_id); ?></h4>
                </div>
                </div>
        </div>
    <div class="card-header p-2">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('details.main')); ?>">Main</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('details.general')); ?>">General</a></li>
        <li class="nav-item"><a class="nav-link active" href="#">Courses</a></li>
    </ul>
    </div><!-- /.card-header -->
    <div class="card-body">

    <div class="col-md-12">
        <?php
        $coursesCount = App\Studentregcourses::where('student_id' , '=' , $student->range_id)->where('deleted_at', '=' , null)->get()->count();
        $x=0;
        ?>
        <?php $__currentLoopData = $assignedC; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignedC): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $x++;
        $courseDetails = App\Courses::find($assignedC->course_id);
        ?>
        <h5><?php echo e($courseDetails->course_name); ?></h5><br/>
        <b><u>Course Details</u></b><br/><br/>
        <?php
        $special = App\Inputf::where('course_id' , '=' , $assignedC->course_id)->where('batch_type',0)->orderBy('order','ASC')->get();
        ?>
        <?php $__currentLoopData = $special; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $special): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $input = App\Stdreqdetails::where('inputname' ,'=', $special->fname)->where('std_id','=',$student->student_id)->where('course_id','=',$special->course_id)->first();
        ?>
        <div class='row'>
        <div class='col-md-3'>
        <h6><?php echo e($special->fname); ?></h6>
        </div>
        <div class='col-md-8'>
        <h6>
        <?php if($special->fid == 1): ?>
        : <?php echo e($input->text ?? ''); ?>

        <?php elseif($special->fid == 2): ?>
        <textarea class='form-control' readonly><?php echo e($input->text ?? ''); ?></textarea>
        <?php elseif($special->fid == 3): ?>
        <?php
        $option_value = App\Selectoptions::where('id' ,'=', $input->text ?? '')->where('deleted_at','=',null)->first();
        ?>
        : <?php echo e($option_value->option_value ?? ''); ?>

        <?php endif; ?>
        </h6><hr/>
        </div>
        <div class='col-md-1'>
        <?php if($input->id ?? "0" != "0"): ?>
        <a href='<?php echo e(route("details-change.course")); ?>?myid=<?php echo e($input->id ?? "0"); ?>&fid=<?php echo e($special->id); ?>' class='btn btn-xs btn-info'>Change</a>
        <?php endif; ?>
        </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php
        $input2 = App\Stdreqdetails::where('std_id','=',$student->student_id)->where('course_id','=',$assignedC->course_id)->get();
        ?>
        <?php $__currentLoopData = $input2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $input2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $input3 = App\Inputf::where('fname' ,'=', $input2->inputname)->where('course_id','=',$assignedC->course_id)->get()->count();
        ?>
        <?php if($input3 == 0): ?>
        <?php
        $inname = str_replace(' ', '', $input2->inputname);
        ?>
        <div class='row'>
        <div class='col-md-3'>
        <h6><?php echo e($input2->inputname); ?></h6>
        </div>
        <div class='col-md-9'>
        <h6>: <?php echo e($input2->text ?? ''); ?></h6></hr>
        </div>
        </div>
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php
        $courseId = $assignedC->course_id;
        $batchType = App\BatchStudent::with(['studentRegCourses'])->whereHas('studentRegCourses',function($course) use($courseId){
            $course->whereCourseId($courseId);
        })->where('student_id',$student->range_id)->whereStudentStatus(0)->first()->batchType->batch_type;
        $special = App\Inputf::where('course_id' , '=' , $assignedC->course_id)->where('batch_type',$batchType)->orderBy('order','ASC')->get();
        ?>
        <b><u>Batch Type Details</u></b><br/><br/>
        <?php $__currentLoopData = $special; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $special): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $input = App\Stdreqdetails::where('inputname' ,'=', $special->fname)->where('std_id','=',$student->student_id)->where('course_id','=',$special->course_id)->first();
        ?>
        <div class='row'>
        <div class='col-md-3'>
        <h6><?php echo e($special->fname); ?></h6>
        </div>
        <div class='col-md-8'>
        <h6>
        <?php if($special->fid == 1): ?>
        : <?php echo e($input->text ?? ''); ?>

        <?php elseif($special->fid == 2): ?>
        <textarea class='form-control' readonly><?php echo e($input->text ?? ''); ?></textarea>
        <?php elseif($special->fid == 3): ?>
        <?php
        $option_value = App\Selectoptions::where('id' ,'=', $input->text ?? '')->where('deleted_at','=',null)->first();
        ?>
        : <?php echo e($option_value->option_value ?? ''); ?>

        <?php endif; ?>
        </h6><hr/>
        </div>
        <div class='col-md-1'>
        <?php if($input->id ?? "0" != "0"): ?>
        <a href='<?php echo e(route("details-change.course")); ?>?myid=<?php echo e($input->id ?? "0"); ?>&fid=<?php echo e($special->id); ?>' class='btn btn-xs btn-info'>Change</a>
        <?php endif; ?>
        </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($coursesCount !=$x): ?>
        <hr/><br/>
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    </div>

</div>
<!-- /.col -->
</div>
<?php endif; ?>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/erpv2std.kiu.lk/resources/views/details/courses.blade.php ENDPATH**/ ?>