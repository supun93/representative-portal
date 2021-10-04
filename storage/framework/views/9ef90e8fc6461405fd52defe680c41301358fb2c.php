<?php 
$pageTitle = "Transfer Request";
?>

<?php $__env->startSection('content'); ?>
<div class="content">
<br>
<div class="container-fluid behind">
<div class="card">
<div class="card-header">
<h5><?php echo e($pageTitle); ?></h5>
</div>
<div class="card-body">

<div style="display:inline-block;margin-right:-1px">
<form action="<?php echo e(route('request.batchtype-transfer')); ?>" method='post'>
<?php echo csrf_field(); ?>
<input type='hidden' id='course_id' name='course_id' value='<?php echo e($data->regCourses->course_id); ?>'>
<input type='hidden' id='batch_id' name='batch_id' value='<?php echo e($data->batchStudent->batch_id); ?>'>
<input type='hidden' id='student_id' name='student_id' value='<?php echo e($data->range_id); ?>'>
<button type='submit' class="btn btn-default">Batch Type Transfer</button>
</form>
</div>

<div style="display:inline-block;margin-right:-1px">
<form action="<?php echo e(route('request.course-transfer')); ?>" method='post'>
<?php echo csrf_field(); ?>
<input type='hidden' id='course_id' name='course_id' value='<?php echo e($data->regCourses->course_id); ?>'>
<input type='hidden' id='batch_id' name='batch_id' value='<?php echo e($data->batchStudent->batch_id); ?>'>
<input type='hidden' id='student_id' name='student_id' value='<?php echo e($data->range_id); ?>'>
<button type='submit' class="btn btn-default">Course Transfer</button>
</form>
</div>

<div style="display:inline-block;margin-right:-1px">
<form action="<?php echo e(route('request.batch-transfer')); ?>" method='post'>
<?php echo csrf_field(); ?>
<input type='hidden' id='course_id' name='course_id' value='<?php echo e($data->regCourses->course_id); ?>'>
<input type='hidden' id='batch_id' name='batch_id' value='<?php echo e($data->batchStudent->batch_id); ?>'>
<input type='hidden' id='student_id' name='student_id' value='<?php echo e($data->range_id); ?>'>
<button type='submit' class="btn btn-default">Batch Transfer</button>
</form>
</div>

<div style="display:inline-block;margin-right:-1px">
<form action="<?php echo e(route('request.group-transfer')); ?>" method='post'>
<?php echo csrf_field(); ?>
<input type='hidden' id='course_id' name='course_id' value='<?php echo e($data->regCourses->course_id); ?>'>
<input type='hidden' id='batch_id' name='batch_id' value='<?php echo e($data->batchStudent->batch_id); ?>'>
<input type='hidden' id='student_id' name='student_id' value='<?php echo e($data->range_id); ?>'>
<button type='submit' class="btn btn-default">Main Group Transfer</button>
</form>
</div>

<div style="display:inline-block;margin-right:-1px">
<form action="<?php echo e(route('request.subgroup-transfer')); ?>" method='post'>
<?php echo csrf_field(); ?>
<input type='hidden' id='course_id' name='course_id' value='<?php echo e($data->regCourses->course_id); ?>'>
<input type='hidden' id='batch_id' name='batch_id' value='<?php echo e($data->batchStudent->batch_id); ?>'>
<input type='hidden' id='group_id' name='group_id' value='<?php echo e($data->batchStudent->mg_id); ?>'>
<input type='hidden' id='student_id' name='student_id' value='<?php echo e($data->range_id); ?>'>
<button type='submit' class="btn btn-default">Subject Group Transfer</button>
</form>
</div>

<?php if($pPlan !=0): ?>
<div style="display:inline-block;margin-right:-1px">
    <form action="<?php echo e(route('request.pp-transfer')); ?>" method='post'>
    <?php echo csrf_field(); ?>
    <input type='hidden' id='course_id' name='course_id' value='<?php echo e($data->regCourses->course_id); ?>'>
    <input type='hidden' id='batch_id' name='batch_id' value='<?php echo e($data->batchStudent->batch_id); ?>'>
    <input type='hidden' id='group_id' name='group_id' value='<?php echo e($data->batchStudent->mg_id); ?>'>
    <input type='hidden' id='student_id' name='student_id' value='<?php echo e($data->range_id); ?>'>
    <button type='submit' class="btn btn-primary">Payment Plan Transfer</button>
    </form>
</div> 
<?php endif; ?>

</div>

<form novalidate  method="post" action="" id="transfer_req" class="form-label-left input_mask needs-validation">
<?php echo csrf_field(); ?>
<div class="card-body row">
    <div class="form-group col-md-4">
        <label for="exam-group">Course</label>
        <select class='form-control' id='course_id' name='course_id' readonly>
        <option value='<?php echo e($data->regCourses->course->course_id); ?>'><?php echo e($data->regCourses->course->course_name); ?></option>
        </select>
    </div>
    
    <div class="form-group col-md-4">
        <label for="exam-group">Batch</label>
        <select class='form-control' id='batch_id' name='batch_id'>
        <option value='<?php echo e($data->batchStudent->batch->batch_id); ?>'><?php echo e($data->batchStudent->batch->batch_name); ?></option>
        </select>
    </div>
    <div class="form-group col-md-4">
        <label for="exam-group">Reason</label>
        <textarea class='form-control' id='reason' name='reason' required='true' placeholder='Reason' style='height:38px'></textarea>
    </div>
    <div class="form-group col-md-8">
        <table class="table">
            <tr>
                <th>
                    My Payment Plan Types
                </th>
                <th>
                    Available Payment Plan Types
                </th>
            </tr>
            
            <?php $__currentLoopData = $paymentPlan->studentFeeDefinition; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $studentFeeDefinition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
            <tr>
                <td>
                    <?php
                    $myType = $studentFeeDefinition->installment_type;
                    $myTypeName = $studentFeeDefinition->myPaymentPlanType->commonPaymentPlanTypes->name;
                    ?>
                    <?php echo e($myType); ?> - <?php echo e($myTypeName); ?>

                </td>
                <td class="row">
                    <?php $__currentLoopData = $studentFeeDefinition->batchPaymentPlanTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batchPaymentPlanTypes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($studentFeeDefinition->myPaymentPlanType->id == $batchPaymentPlanTypes->id): ?>
                            <?php continue; ?>
                        <?php endif; ?>
                        <?php
                            $typeName = $batchPaymentPlanTypes->commonPaymentPlanTypes->name;
                        ?>
                        <div class="col-md-3">
                            <input type="radio" name="change_plan[<?php echo e($myType); ?>]" id="" value="<?php echo e($typeName); ?>"> <?php echo e($typeName); ?>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
        </table>
        
    </div>

    </div>
    <div class='card-body' align='center'>
        
    <?php if($lastStatus != '0'): ?>
    <button class="btn btn-sm btn-success" type='submit'>Send Trasfer Request</button>
    <?php endif; ?>
    </div>
</div>
</form>

</div>

</div>
</div>
</div>

<script>
$(document).ready(function () {

    $("#transfer_req").submit(function(event){
        event.preventDefault(); //prevent default action
        var reqlength = $('[required="true"]').length;
        var value = $('[required="true"]').filter(function () {
            return this.value != '';
        });

        if (value.length>=0 && (value.length !== reqlength)) {
            masterAlert(2,'','Please make sure all required fields are filled out correctly');
            return;
        }
        var form_data = new FormData(this);
        
        $.confirm({
        title: 'Are you sure?',
        content: "You won't be able to do this?",
        backgroundDismissAnimation: 'glow',
        type: 'orange',
        typeAnimated: true,
        autoClose: 'cancel|10000',
        buttons: {
        confirm: {
            text: 'Yes, do it!',
            btnClass: 'btn-success',
            keys: ['enter', 'shift'],
            action: function(){
                $.ajax({
                type:'POST',
                url:"<?php echo e(route('request.pp-transfer.submit')); ?>",
                data : form_data,
                contentType: false,
                cache: false,
                processData:false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                    if(data.msg == 1){
                        masterAlert(1,'','');
                        location.reload();
                    }else{
                        masterAlert(2,'','');
                    }
                },
                error: function(xhr, status, error) 
                    {
                    $.each(xhr.responseJSON.errors, function (key, item) 
                    {
                        masterAlert(2,'',item);
                    });
                    }
                });
            }
        },
        cancel: {
            text: 'Cancel',
            btnClass: 'btn-danger',
            keys: ['esc'],
            action: function(){
                
            }
        }
        }
        });
    });
    
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xamppp\htdocs\push student portal\kiu-student-portal\resources\views/transfer/paymentplantransfer.blade.php ENDPATH**/ ?>