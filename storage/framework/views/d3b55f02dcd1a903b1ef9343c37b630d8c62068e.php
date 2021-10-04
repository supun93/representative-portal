<?php 
$pageTitle = "Payment Dashboard";
$nav_slo = "active";
?>

<?php $__env->startSection('content'); ?>
<div class="content">
<div class="container-fluid behind">
    <div class="row mb-2">
        <div class="col-sm-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('dashbord')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('courses.list')); ?>">Courses </a></li>
                <li class="breadcrumb-item active">Payment History </li>
              </ol>
        </div>
      </div>

<div class="card">
<div class='card-body'>
<H5>Select Course Enrollements Batch</H5>


<div class="card">
    <div class="card-body">
    <select name='batch_id' id='batch_id' class='form-control'>
    <option value=''>Select Batch</option>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($item->batch != null): ?>
    <option value='<?php echo e($item->batch->batch_id); ?>' data-status='<?php echo e($item->status); ?>'><?php echo e($item->batch->batch_name); ?> ( <?php if($item->status == 0): ?> Active <?php else: ?> Inactive <?php endif; ?>)</option>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <br/>
    <div id='courseDetails'></div>
    </div>
</div>

<div id="holder">
</div>

</div>
</div>
</div>
</div>

<script>
$(document).ready(function () {

    $("#batch_id").change(function(){
        var batch_id = $("#batch_id").val();
        if(batch_id != ""){
            $("#courseDetails").load("<?php echo e(route('payment-course-details.load','')); ?>/"+batch_id);
            $('#holder').html('');
        }else{
            $("#courseDetails").html('');
            $('#holder').html('');
        }
    });

});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xamppp\htdocs\push student portal\kiu-student-portal\resources\views/payments/dashboard.blade.php ENDPATH**/ ?>