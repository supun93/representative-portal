<div class="row">
    <div class="col-md-7">
        <div class="row">
            <div class="col-md-5 text-left">
                Batch Name
            </div>
            <div class="col-md-7 text-right">
                <?php echo e($data->batch->batch_name); ?>

            </div>
        </div>
        <div class="row">
            <div class="col-md-5 text-left">
                Course Name
            </div>
            <div class="col-md-7 text-right">
            <?php echo e($data->batch->course->course_name); ?>

            </div>
        </div>
        <div class="row">
            <div class="col-md-5 text-left">
                Departement Name
            </div>
            <div class="col-md-7 text-right">
            <?php echo e($data->batch->course->department->dept_name); ?>

            </div>
        </div>
        <div class="row">
            <div class="col-md-5 text-left">
                Faculty Name
            </div>
            <div class="col-md-7 text-right">
            <?php echo e($data->batch->course->department->faculty->faculty_name); ?>

            </div>
        </div>
        <hr>
        <div class="row">
            <div class="text-right col-md-12">
                <div class="form-group">
                    <a class="btn btn-info payment-history"
                    data-postdata='{"_token": "<?php echo e(csrf_token()); ?>", "payment_card_id": "<?php echo e($paymentCard->id ?? 0); ?>"}'
                    data-url="<?php echo e(route('student-payment.history')); ?>"
                        href="#">Payment History</a>
                    <a class="btn btn-primary pending-payments"
                    data-postdata='{"_token": "<?php echo e(csrf_token()); ?>", "payment_card_id": "<?php echo e($paymentCard->id ?? 0); ?>"}'
                    data-url="<?php echo e(route('student-payment.pending')); ?>"
                        href="#">Outstanding Payments</a>
                    <a class="btn btn-dark other-payment-history"
                        data-postdata='{"_token": "<?php echo e(csrf_token()); ?>", "payment_card_id": "<?php echo e($paymentCard->id ?? 0); ?>"}'
                        data-url="<?php echo e(route('student-other-payment.history')); ?>"
                            href="#">Other Payment History</a>
                    <a class="btn btn-warning other-payment-history"
                        data-postdata='{"_token": "<?php echo e(csrf_token()); ?>", "payment_card_id": "<?php echo e($paymentCard->id ?? 0); ?>"}'
                        data-url="<?php echo e(route('student-other-payment.outstanding')); ?>"
                            href="#">Outstanding Other Payment</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    $('.payment-history').on('click', function(e) {
        e.preventDefault();
        var elem = $(this);
        var url = elem.data('url');
        var postData = elem.data('postdata');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: url,
            data: $.param(postData),
            success: function(response) {
                $('#holder').html(response);
            }
        });
    });
    $('.pending-payments').on('click', function(e) {
        e.preventDefault();
        var elem = $(this);
        var url = elem.data('url');
        var postData = elem.data('postdata');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: url,
            data: $.param(postData),
            success: function(response) {
                $('#holder').html(response);
            }
        });
    });
    $('.other-payment-history').on('click', function(e) {
      e.preventDefault();
      var elem = $(this);
      var url = elem.data('url');
      var postData = elem.data('postdata');
      $.ajax({
          type: 'POST',
          dataType: 'json',
          url: url,
          data: $.param(postData),
          success: function(response) {
              $('#holder').html(response);
          }
      });
  });
});
</script>
<?php /**PATH C:\xamppp\htdocs\push student portal\kiu-student-portal\resources\views/ajaxblades/paymentCourseDetails.blade.php ENDPATH**/ ?>