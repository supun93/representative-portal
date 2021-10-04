<div class="row">
    <div class="col-md-12" >
    <h5 id="courseName"></h5>
    </div>
    <div class="col-md-6" >
    <div class="callout callout-success">
    <h6>Batch</h6>
    <p>
    <?php echo e($data->batchStudent->batch->batch_name); ?>

    </p>
    </div>
    </div>

    <div class="col-md-6" >
    <div class="callout callout-info">
    <h6>Main Group</h6>
    <p><?php echo e($data->batchStudent->group->GroupName ?? 'not yet'); ?></p>
    </div>
    </div>


    <div class="col-md-4" >
    <form action="<?php echo e(route('request.batchtype-transfer')); ?>" method='post'>
    <?php echo csrf_field(); ?>
    <input type='hidden' name='batch_id' value='<?php echo e($data->batchStudent->batch_id); ?>'>
    <input type='hidden' name='course_id' value='<?php echo e($data->regCourses->course_id); ?>'>
    <button type='submit' class="btn btn-primary">Request Transfer</button>
    <p></p>
    </form>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-lg-3 col-6" >
        <div class="small-box bg-info" align="center" >
            <div class="" align="center" style="padding-top:30px;padding-bottom:30px">
            <h4 class="icon"><i class="fa fa-flag"></i></h4>
            <p class="card-text"><b>Payments History</b></p>
            </div>
            <a href="<?php echo e(route('payment.dashboard',$data->regCourses->course_id)); ?>" class="small-box-footer" style="padding-top:10px;padding-bottom:10px"><b>View Details</b></a>
        </div>
    </div>
    <div class="col-lg-3 col-6" >
        <div class="small-box bg-success" align="center" >
            <div class="" align="center" style="padding-top:30px;padding-bottom:30px">
            <h4 class="icon"><i class="far fa-calendar-alt"></i></h4>
            <p class="card-text"><b>Course Timetable</b></p>
            </div>
			<?php if($data->batchStudent->mg_id !=null): ?>
				<a href="<?php echo e(route('fulltimetable.course',[$data->batchStudent->mg_id,'upcoming'])); ?>" class="small-box-footer" style="padding-top:10px;padding-bottom:10px"><b>View Details</b></a>
			<?php endif; ?>
        </div>
    </div>
    <div class="col-lg-3 col-6" >
        <div class="small-box bg-secondary" align="center" >
            <div class="" align="center" style="padding-top:30px;padding-bottom:30px">
            <h4 class="icon"><i class="far fa-calendar-alt"></i></h4>
            <p class="card-text"><b>Full Timetable</b></p>
            </div>
			<?php if($data->batchStudent->mg_id !=null): ?>
				<a href="<?php echo e(route('fulltimetable.course',[$data->batchStudent->mg_id,'full'])); ?>" class="small-box-footer" style="padding-top:10px;padding-bottom:10px"><b>View Details</b></a>
			<?php endif; ?>
        </div>
    </div>

</div>
<?php /**PATH /var/www/erpv2std.kiu.lk/resources/views/ajaxblades/coursegroupes.blade.php ENDPATH**/ ?>