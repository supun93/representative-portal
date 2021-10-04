<?php
$pageTitle = "My Courses";
$nav_slo = "active";
?>

<style>
.lead {
    font-size: 1.2rem !important;
}
</style>
<?php $__env->startSection('content'); ?>
<div class="content">
<div class="container-fluid behind">
    <div class="row mb-2">
        <div class="col-sm-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('dashbord')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Course Enrollements </li>
              </ol>
        </div>
      </div>
      <div class="row">
        <input type="hidden" id="student_id" value="<?php echo e($student->range_id); ?>">
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        if($data->mg_id != null){
            $group = App\Groupes::find($data->mg_id);
        }
        ?>

        <div class="col-12 col-sm-3">
            <div class="card bg-light">
                <div class="card-body pb-0">
                  <div class="row">
                    <div class="col-12">
                    <?php if($data->student_status == 0): ?>
                      <h2 class="lead"><b><?php echo e($data->abbreviation); ?></b></h2>
                      <p class="text-muted text-sm"><b>Status: </b> <b style="color: green">Active</b> </p>
                    <?php elseif($data->student_status == 1): ?>
                    <h2 class="lead"><b><?php echo e($data->abbreviation); ?></b></h2>
                      <p class="text-muted text-sm"><b>Status: </b> <b style="color: red">Inactive</b> </p>
                    <?php elseif($data->student_status == 2): ?>
                    <h2 class="lead"><b><?php echo e($data->abbreviation); ?></b></h2>
                      <p class="text-muted text-sm"><b>Status: </b> <b style="color: red">Temporary Drop</b> </p>
                    <?php elseif($data->student_status == 3): ?>
                    <h2 class="lead"><b><?php echo e($data->abbreviation); ?></b></h2>
                      <p class="text-muted text-sm"><b>Status: </b> <b style="color: red">Permenant Suspend</b> </p>
                    <?php elseif($data->student_status == 4): ?>
                    <h2 class="lead"><b><?php echo e($data->abbreviation); ?></b></h2>
                      <p class="text-muted text-sm"><b>Status: </b> <b style="color: red">Temporary Suspend</b> </p>
                    <?php elseif($data->student_status == 5): ?>
                    <h2 class="lead"><b><?php echo e($data->abbreviation); ?></b></h2>
                      <p class="text-muted text-sm"><b>Status: </b> <b style="color: green">Completed</b> </p>
                    <?php endif; ?>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-center">
                    <a href="#goHere" class="info-box-number text-center text-muted mb-0">
                        <input type="hidden" id="course_id" value="<?php echo e($data->course_id ?? ''); ?>">
                        <button class='btn btn-info btn-block btn-xs showBut'> View Details </button>
                    </a></a>
                  </div>
                </div>
              </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
<div class="row">
<!-- /.col -->
<div class="col-md-12">
<div class="card card-info card-outline">
<div class="card-body" id="goHere">
    <div id="courseDet"></div>
</div>
</div>
</div>
<!-- /.col -->
</div>

</div>
</div>

<script>
$(document).ready(function () {
    $(".showBut").click(function() {
        var row = $(this).closest("div"),
        course_id = row.find("#course_id").val();
        $("#courseDet").load("<?php echo e(route('course-groupes.load','')); ?>/"+course_id);
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xamppp\htdocs\push student portal\kiu-student-portal\resources\views/courses.blade.php ENDPATH**/ ?>