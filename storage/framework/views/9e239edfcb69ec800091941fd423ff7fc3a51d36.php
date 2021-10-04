<?php if(!empty($result)): ?>
    <table class="table table-striped table-bordered dt-responsive">
        <tr>
            <th>
                Description
            </th>
            <th>
                Paid Amount
            </th>
            <th>
                Installment Discount
            </th>
            <th>
                Late Payment
            </th>
            <th>
                Late Payment Discount
            </th>
  
            <th>
                Due Date
            </th>
            <th>
                Paid Date
            </th>
        </tr>
        <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
                <td>
                    <?php echo e($data->installment_type); ?> <?php echo e(ordinal($data->installment_counter)); ?> Installment
                </td>
                <td>
                    <?php echo e(number_format($data->paid_amount, 2)); ?> <?php echo e($data->paid_currency); ?>

                </td>
                <td>
                    <?php echo e(number_format($data->installment_discount, 2)); ?> <?php echo e($data->paid_currency); ?>

                </td>
                <td>
                    <?php echo e(number_format($data->late_payment, 2)); ?> <?php echo e($data->paid_currency); ?>

                </td>
                <td>
                    <?php echo e(number_format($data->late_payment_deduction, 2)); ?> <?php echo e($data->paid_currency); ?>

                </td>

                <td>
                    <?php echo e($data->due_date); ?>

                </td>
                <td>
                    <?php echo e($data->actual_paid_date); ?>

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
<?php /**PATH C:\xamppp\htdocs\push student portal\kiu-student-portal\resources\views/payments/payment-history.blade.php ENDPATH**/ ?>