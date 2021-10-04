<?php
$pageTitle = "Read Message";
$nav_slo = "active"
?>

<?php $__env->startSection('content'); ?>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<style> 
  .clearfix:after{
      content:".";
      display:block;
      height:0;
      clear:both;
      visibility:hidden;
  }
  
  .column-left, .column-right{
      margin: 10px;
      padding: 10px;
      background: #e2e8e8;
      border-radius: 10px;
      text-align: left !important
  }
  .column-left{
      float: left;       
  }
  .column-right{
      float: right;
  }
</style>
<div class="content">
<div class="container-fluid behind">
  <div class="row mb-2">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashbord')); ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('messages-list.inbox')); ?>">Messages</a></li>
            <li class="breadcrumb-item active">Read </li>
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
    </div>
  </div>
  <!-- /.col -->

  <!-- col start -->
  <div class="col-md-9">
        
  <div class="card card-primary card-outline">
    <?php if($data->conversation_status == 0): ?>
    <div class="row">
      <div class="col-md-6"></div><div class="col-md-6" style="text-align: right">
        <form action="" id="close_conversation">
          <?php echo csrf_field(); ?>
          <button class="btn btn-primary" type="submit">Close This Conversation</button>
          <input type="hidden" value="<?php echo e($data->conversation_id); ?>" id='conversation_id' name='conversation_id'>
        </form>
      </div>
    </div>
    <?php endif; ?>
  <div class="card-body p-0">
  <input type='hidden' id='selection' value='0'>
  <ul class="todo-list ui-sortable" data-widget="todo-list"> 
      <?php $__currentLoopData = $data->messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php
      if($message->view == 0){
          $status = '<small class="badge badge-success" id="message_status'.$message->notice_id.'">Unread</small>';
      }else{
          $status = "";
      }
      if($message->created_by == null){
          $style = 'right';
      }else{
          $style = 'left';
      }
      ?>

      <li style="text-align: <?php echo e($style); ?>">
      <!-- drag handle -->
      
      <input type='hidden' class='message_id' value='<?php echo e($message->notice_id); ?>'>
      <input type='hidden' class='read_status' value='<?php echo e($message->view); ?>'>
      <a class='readMessage' href='#'>
      <span class="handle ui-sortable-handle">
      <i class="fas fa-ellipsis-v"></i>
      <i class="fas fa-ellipsis-v"></i>
      </span>
      <!-- todo text -->
      <span class="text"><?php echo e($message->notice_title); ?></span>
      <!-- Emphasis label -->
      <small class="badge badge-secondary"><i class="far fa-clock"></i> <?php echo e($message->created_at); ?></small> <?php echo $status; ?>

      <!-- General tools such as edit or delete-->
      </a>

      <div class="collapse clearfix" style="border-bottom:1px solid #cecbcb;" id="demo<?php echo e($message->notice_id); ?>">
      <div class="card-body column-<?php echo e($style); ?>">
      <?php echo $message->notice_text; ?>

      <?php
          $attachments = App\NoticeAttachments::where('notice_id', '=' , $message->slo_notice_id)->orWhere('notice_id_inc', '=' , $message->notice_id)->get();
      ?>
      <?php if(count($attachments) != 0): ?>
      <br/>
      <?php endif; ?>
      <?php $x =1; ?>
      <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <a href="<?php echo e(ENV('MAIN_LINK_URL')); ?>/storage/<?php echo e($item->file); ?>" target="_black">Attachment <?php echo e($x); ?></a><br/>
      <?php
      $x++;
      ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      </div>
      </li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </ul>
  <hr/>
  </div>
  <div class="card-footer p-0">
    <div class="mailbox-controls">
      <!-- Check all button -->
      <div class="float-right">
      
        <!-- /.btn-group -->
      </div>
      <!-- /.float-right -->
    </div>
  </div>
  <div class='card-body'>

<?php if($data->conversation_status == 0): ?>
<form class="form-label-left input_mask needs-validation" method="post" action="" id="messageSubmit">
  <?php echo csrf_field(); ?>
  <div class='row'>

  <div class='col-md-4'>
  <select name='category_id' id='category_id' class='form-control' required>
  <option value='<?php echo e($message->category->category_id); ?>'><?php echo e($message->category->category_name); ?></option>
  </select>
  </div>
  <div class='col-md-4'>
  <select name='category_title_id' id='category_title_id' class='form-control' required>
    <option value='<?php echo e($message->categoryTitle->title_id); ?>'><?php echo e($message->categoryTitle->title_name); ?></option>
  </select>
  </div>

  </div>
  <br/>
  <input type='text' class='form-control' name='title' placeholder="Message Title" required><br/>
  <textarea id="summernote" name="editordata" required></textarea>
  <br/>
  <input type="hidden" name="notice_type" class="form-control" value='1'>
  <input type="hidden" name="student_id" class="form-control" value='<?php echo e($student->range_id); ?>'>
  <center><button class='btn btn-success' id='checkenb'>SEND REPLY</button></center>
</form>
<?php elseif($data->conversation_status == 1): ?>
    <?php
        if ($data->updated_by == null) {
            $closedBy = $data->student->name_initials;
        } else {
            $closedBy = $data->category->category_name . ' - ' . $data->categoryTitle->title_name;
        }
    ?>
    <center>
        <h6>This conversation has been closed by <?php echo e($closedBy); ?><br />
            Closed Date: <?php echo e($data->updated_at); ?>

        </h6>
    </center>
<?php else: ?>
<center>
    <h6>This conversation has been forward by <?php echo e($data->category->category_name); ?> - <?php echo e($data->categoryTitle->title_name); ?><br />
        Forward To: <?php echo e($data->forwardTo->category->category_name); ?> - <?php echo e($data->forwardTo->categoryTitle->title_name); ?> <br/>
        Date: <?php echo e($data->updated_at); ?>

    </h6>
</center>
<?php endif; ?>
  </div>
  </div>
  </div>
  <!-- / col end -->

  </div>

</div>
</div>

<script>
$(document).ready(function(){

$("#close_conversation").submit(function (e) { 
  e.preventDefault();
  var conversation_id = $("#conversation_id").val();
  var form_data = new FormData(this);
  $.confirm({
      title: 'Are you sure?',
      content: "You won't be able to close this?",
      backgroundDismissAnimation: 'glow',
      type: 'orange',
      typeAnimated: true,
      autoClose: 'cancel|10000',
      buttons: {
          confirm: {
              text: 'Yes, close it!',
              btnClass: 'btn-success',
              keys: ['enter', 'shift'],
              action: function(){
                  $.ajax({
                      type:'POST',
                      url:"<?php echo e(route('conversation.close')); ?>",
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
  $(".readMessage").click(function() {
      var selection = $("#selection").val();
      var li = $(this).closest("li"),       // Finds the closest row <tr>
      id = li.find(".message_id").val();

      read_status = li.find(".read_status").val();
      if(read_status == 0){
          if(selection == '0'){
              loadSpin.toggle();
          }
          $.ajax({
              type: 'GET',
              url: "<?php echo e(route('message.read','')); ?>/" + id
          }).then(function (data) {

              if(selection == '0'){
                  loadSpin.toggle();
                  $("#selection").val(3);
              }else{
                  $("#selection").val(0);
              }
              li.find(".read_status").val(1);
              $("#message_status"+id).html('');
              var el = parseInt($('.float-right').text());
              $('.float-right').text(el-1);
          });
      }
      jQuery('.readMessage').not(this).siblings().slideUp("fast");
      jQuery(this).siblings().slideToggle("fast");

  });


  $('#summernote').summernote({
        height: 120
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
            content: "You won't be able to reply this?",
            backgroundDismissAnimation: 'glow',
            type: 'orange',
            typeAnimated: true,
            autoClose: 'cancel|10000',
            buttons: {
                confirm: {
                    text: 'Yes, reply it!',
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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xamppp\htdocs\push student portal\kiu-student-portal\resources\views/messages/messages-show.blade.php ENDPATH**/ ?>