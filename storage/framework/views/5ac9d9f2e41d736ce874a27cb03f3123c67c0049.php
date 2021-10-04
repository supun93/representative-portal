<?php if(!empty($result)): ?>
    <table class="table">
        <tr>
            <th>
                Description
            </th>
            <th>
                Due Amount
            </th>
            <th>
                Paid Amount
            </th>
            <th>
                Installment Discount
            </th>
            <th>
                Balance
            </th>
            <th>
                Status
            </th>
            <th>
                Receipt Id
            </th>
            <th>
                Due Date
            </th>
            <th>
                Paid Date
            </th>
            <th>
                Collection Date
            </th>
        </tr>
        <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>
                    <?php echo e($data->payment_name); ?>

                </td>
                <td>
                    <?php echo e(number_format($data->due_amount, 2)); ?> <?php echo e($data->paid_currency); ?>

                </td>
                <td>
                    <?php echo e(number_format($data->paid_amount, 2)); ?> <?php echo e($data->paid_currency); ?>

                </td>
                <td>
                    <?php echo e(number_format($data->installment_discount, 2)); ?> <?php echo e($data->paid_currency); ?>

                </td>
                <td>
                    <?php echo e(number_format($data->due_amount - $data->paid_amount - $data->installment_discount, 2)); ?>

                    <?php echo e($data->paid_currency); ?>

                </td>
                <td>
                    <?php echo e($data->payment_status); ?>

                </td>
                <td>
                    <a
                        href="<?php echo e(url('/finance/receipt-print-view')); ?>/<?php echo e($data->receipt_increment_id); ?>/other-payments"><?php echo e($data->receipt_increment_id); ?></a>
                </td>
                <td>
                    <?php echo e($data->due_date); ?>

                </td>
                <td>
                    <?php echo e($data->actual_paid_date); ?>

                </td>
                <td>
                    <?php echo e($data->collection_date); ?>

                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
<?php else: ?>
    <div class="col-md-12">
        <h4>
            No records to display!
        </h4>
    </div>
<?php endif; ?>
<?php function ordinal($number)
{
$ends = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
if ($number % 100 >= 11 && $number % 100 <= 13) { return $number . 'th' ; } else { return $number . $ends[$number % 10];
    } } ?>
<?php /**PATH C:\xamppp\htdocs\push student portal\kiu-student-portal\resources\views/payments/other-payment-history.blade.php ENDPATH**/ ?>