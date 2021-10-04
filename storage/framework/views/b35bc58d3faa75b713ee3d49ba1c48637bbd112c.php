<?php if(!empty($result)): ?>
    <table class="table table-striped table-bordered dt-responsive">
        <tr>
            <th>
                Description
            </th>
            <th>
                Due Date
            </th>
            <th>
                Pending Amount
            </th>

            <th>
                Status
            </th>
        </tr>
        <?php
            $x=0;
        ?>
        <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $today = date("Y-m-d");
            if ($today < $data->due_date) {
                //continue;
            }
            $x++;
        ?>
        <tr>
            <td>
                <?php echo e($data->installment_type); ?> <?php echo e(ordinal($data->installment_counter)); ?> Installment
            </td>
            <td>
                <?php echo e($data->due_date); ?>

            </td>
            <td>
                <div  class="row">
                    <div class="col-md-3"><?php echo e(number_format($data->amount - $data->total_paid, 2)); ?> <?php echo e($data->currency); ?></div>
                    
                        <?php if('2021-08-15' <= $data->due_date && '2021-09-15' >= $data->due_date): ?>
                            <div class="col-md-3"><a href="https://erpv2.kiu.lk/finance/student-online-payment/<?php echo e($data->student_payment_plan_card_id); ?>/<?php echo e($data->shedule_id); ?>" class="btn btn-success btn-xs" target="_blank">Pay Online</a></div>
                        <?php endif; ?>
                    
                </div>
            </td>

            <td>
                <?php echo e($data->status); ?>

            </td>
        </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
<?php endif; ?>
<?php
function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}
?>
<?php /**PATH C:\xamppp\htdocs\push student portal\kiu-student-portal\resources\views/payments/pending-payment.blade.php ENDPATH**/ ?>