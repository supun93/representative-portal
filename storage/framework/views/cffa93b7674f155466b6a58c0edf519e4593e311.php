<?php 
$pageTitle = "Dashboard";
?>

<?php $__env->startSection('content'); ?>
<div class="content">
<br>
<div class="container-fluid behind">

<div class="row">
        <div class="col-lg-2 col-6">
          <!-- small card -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>Course</h3>

              <p>My Courses</p>
            </div>
            <div class="icon">
              <i class="fas fa-graduation-cap"></i>
            </div>
            <a href="<?php echo e(route('courses.list')); ?>" class="small-box-footer">
              View <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-6">
          <!-- small card -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>Timetable</h3>

              <p>Full Timetable</p>
            </div>
            <div class="icon">
              <i class="far fa-calendar-alt"></i>
            </div>
            <a href="<?php echo e(route('fulltimetable.view')); ?>" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->

        <!-- ./col -->
        <div class="col-lg-2 col-6">
          <!-- small card -->
          <div class="small-box bg-navy">
            <div class="inner">
              <h3>Messages</h3>

              <p>Inbox / Outbox</p>
            </div>
            <div class="icon">
              <i class="fas fa-inbox"></i>
            </div>
            <a href="<?php echo e(route('messages-list.inbox')); ?>" class="small-box-footer">
              View <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-6">
          <!-- small card -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>Profile</h3>
              <p>Details</p>
            </div>
            <div class="icon">
              <i class="fas fa-user-plus"></i>
            </div>
            <a href="<?php echo e(route('details.main')); ?>" class="small-box-footer">
              View <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-6">
          <!-- small card -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>Reqest</h3>

              <p>Send Reqest</p>
            </div>
            <div class="icon">
              <i class="far fa-envelope"></i>
            </div>
            <a href="<?php echo e(route('messages.new')); ?>" class="small-box-footer">
              View <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable ui-sortable">
          <!-- Notice Board  -->
          <div class="card">
            <input type='hidden' id='selection' value='0'>
            <div class="card-header ui-sortable-handle" style="cursor: move;">
              <h3 class="card-title">
                <i class="ion ion-clipboard mr-1"></i>
                Notice Board
              </h3>

              <div class="card-tools">
              
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <ul class="todo-list ui-sortable" data-widget="todo-list">
                  <?php $__currentLoopData = $notice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                  <?php
                  if($notice->view == 0){
                    $status = '<small class="badge badge-success" id="message_status'.$notice->notice_id.'">Unread</small>';
                  }else{
                    $status = "";
                  }
                  ?>
                  <li>
                  <!-- drag handle -->
                  <input type='hidden' class='message_id' value='<?php echo e($notice->notice_id); ?>'>
                  <input type='hidden' class='read_status' value='<?php echo e($notice->view); ?>'>
                  <a class='readMessage' href='#'>
                  <span class="handle ui-sortable-handle">
                    <i class="fas fa-ellipsis-v"></i>
                    <i class="fas fa-ellipsis-v"></i>
                  </span>
                  <!-- todo text -->
                  <span class="text"><?php echo e($notice->category->category_name); ?> - <?php echo e($notice->categoryTitle->title_name); ?> <i class="fas fa-long-arrow-alt-right"></i> <?php echo e($notice->notice_title); ?></span>
                  <!-- Emphasis label -->
                  <small class="badge badge-danger"><i class="far fa-clock"></i> <?php echo e($notice->notice_date); ?></small> <?php echo $status; ?>

                  <!-- General tools such as edit or delete-->
                  </a>
                </li>
                    
                <div class="collapse direct-chat-text"  id="demo<?php echo e($notice->notice_id); ?>">
                <dl>
                <dt><?php echo e($notice->notice_title); ?></dt>
                
                <dd><?php echo $notice->notice_text; ?></dd>
                <?php
                    $attachments = App\NoticeAttachments::where('notice_id', '=' , $notice->slo_notice_id)->get();
                ?>
                <?php if(count($attachments) != 0): ?>
                <?php endif; ?>
                <?php $x =1; ?>
                <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(ENV('MAIN_LINK_URL')); ?>/storage/<?php echo e($item->file); ?>" target="_black">Attachment <?php echo e($x); ?></a><br/>
                <?php
                $x++;
                ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </dl>
                </div>
                
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
            <!-- /.card-body -->
            
          </div>
          <!-- /.card -->
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <!-- right col -->
      </div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="<?php echo e(asset('/plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>
<script>
$(document).ready(function () {
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
              
              $("#demo"+id).slideToggle("fast");
              if(selection == '0'){
                  loadSpin.toggle();
                  $("#selection").val(3);
              }else{
                  $("#selection").val(0);
              }
              li.find(".read_status").val(1);
              $("#message_status"+id).html('');
          });
      }else{
          $("#demo"+id).slideToggle("fast");
      }
      
  });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xamppp\htdocs\push student portal\kiu-student-portal\resources\views/models/dashboard.blade.php ENDPATH**/ ?>