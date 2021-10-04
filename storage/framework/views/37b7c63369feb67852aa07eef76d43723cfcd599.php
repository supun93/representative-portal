<?php
$pageTitle = "New Message";
$nav_slo = "active"
?>

<?php $__env->startSection('content'); ?>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<div class="content">
<div class="container-fluid behind">
  <div class="row mb-2">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashbord')); ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('messages-list.inbox')); ?>">Messages</a></li>
            <li class="breadcrumb-item active">Compose </li>
          </ol>
    </div>
  </div>
    <div class="row">
        <div class="col-md-3">
        <a href="<?php echo e(route('messages.new')); ?>" class="btn btn-primary btn-block mb-3">Compose</a>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Folders</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                  <a href="<?php echo e(route('messages-list.inbox')); ?>" class="nav-link">
                    <i class="fas fa-inbox"></i> Inbox
                    <?php
                    $newMessagesCount = App\NoticeBoard::whereStudentId($student->range_id)->whereNoticeType(1)->whereView(0)->where('created_by','!=',null)->get()->count();
                    ?>
                    <span class="badge bg-primary float-right"><?php echo e($newMessagesCount); ?></span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo e(route('messages-list.outbox')); ?>" class="nav-link">
                    <i class="far fa-envelope"></i> Sent
                  </a>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Send New Message</h3>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">

              <div class="table-responsive mailbox-messages">
              <form class="form-label-left input_mask needs-validation" method="post" action="" id="messageSubmit">
              <?php echo csrf_field(); ?>
                <table class="table table-hover table-striped">
                  <tbody>
                 <tr>
                 <td></td>
                 <td style='padding-top:20px !important'>To Category</td>
                 <td style='padding-top:20px !important'>
                 <select name='category_id' id='category_id' class='form-control' required>
                  <option value=''>Select Message Category</option>
                  <?php $__currentLoopData = $messageCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value='<?php echo e($index->category_id); ?>'><?php echo e($index->category_name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                 </td>
                 </tr>
                 <tr>
                 <td></td>
                 <td>To Title</td>
                 <td>
                 <select name='category_title_id' id='category_title_id' class='form-control' required>
                  <option value='' categoryid="none">Select Message Category Title</option>
                  <?php $__currentLoopData = $messageCategoryTitles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value='<?php echo e($index->title_id); ?>' categoryid="<?php echo e($index->category_id); ?>"><?php echo e($index->title_name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                 </td>
                 </tr>
                 <tr>
                 <td></td>
                 <td>Message Title</td>
                 <td><input type='text' class='form-control' name='title' placeholder="Message Title" required></td>
                 </tr>
                 <tr>
                 <td></td>
                 <td>Message</td>
                 <td><textarea id="summernote" name="editordata" required></textarea></td>
                 </tr>
                 <!-- <tr>
                 <td></td>
                 <td>Attachments</td>
                 <td><input type="file" name="file[]" class="form-control"  multiple></td>
                 </tr> -->
                 <tr>
                 <td></td>
                 <td></td>
                 <td style='padding-top:10px !important'><button class='btn btn-success' id='checkenb'>SEND</button></td>
                 </tr>
                  </tbody>
                </table>
                </form>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
              <div class="mailbox-controls">
                <!-- Check all button -->

                <!-- /.float-right -->
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>



</div>
</div>

<script>
$(document).ready(function(){
    $("#category_title_id").children('option').hide();
    $('#summernote').summernote({
        height: 120
    });

    $("#category_id").change(function (){
        $('#category_title_id').prop('selectedIndex',0);
        $("#category_title_id").children('option').hide();
        $("#category_title_id").children("option[categoryid^=none]").show();
        $("#category_title_id").children("option[categoryid^=" + $(this).val() + "]").show();
    });

    $("#messageSubmit").submit(function(event){
        event.preventDefault(); //prevent default action

        if($('#summernote').val() == ''){
            return;
        }
        var message  = $('#summernote').val();
        var form_data = new FormData(this);
        form_data.append('message', message);
        $.confirm({
            title: 'Are you sure?',
            content: "You won't be able to send this?",
            backgroundDismissAnimation: 'glow',
            type: 'orange',
            typeAnimated: true,
            autoClose: 'cancel|10000',
            buttons: {
                confirm: {
                    text: 'Yes, send it!',
                    btnClass: 'btn-success',
                    keys: ['enter', 'shift'],
                    action: function(){
                        $.ajax({
                            type:'POST',
                            url:"<?php echo e(route('messages.send')); ?>",
                            data : form_data,
                            contentType: false,
                            cache: false,
                            processData:false,
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            beforeSend:function(){
                                loadSpin.toggle();
                            },
                            success:function(data){
                                loadSpin.toggle();
                                masterAlert(1,'','');
                                location.reload();
                            },
                            error: function(xhr, status, error){
                                $.each(xhr.responseJSON.errors, function (key, item){
                                    masterAlert(2,'',item);
                                });
                                loadSpin.toggle();
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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/erpv2std.kiu.lk/resources/views/messages/messages-new.blade.php ENDPATH**/ ?>