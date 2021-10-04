<?php 
$pageTitle = "My Inbox Messages";
$nav_slo = "active"
?>

<?php $__env->startSection('content'); ?>
<div class="content">
<div class="container-fluid behind">
  <div class="row mb-2">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashbord')); ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('messages-list.inbox')); ?>">Messages</a></li>
            <li class="breadcrumb-item active">Inbox </li>
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
              <h3 class="card-title">Inbox</h3>
              <a href="" class="btn-sm"><i class="fas fa-sync-alt"></i></a>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <!-- /.btn-group -->
               
                <div class="float-right">
                <?php echo e($data ->links()); ?>

                  <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                  <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php
                  $message = last($conversation->messages->toArray());
                  $newCount = count($conversation->messages->where('view',0));
                  if($newCount !=0){
                    $status = '<small class="badge badge-danger">'.$newCount.'  New</small>';
                    $replyStatus = "";
                  }else{
                    $status = "";
                    if($conversation['student_reply_status'] == 1){
                      $replyStatus = "";
                    }else{
                      $replyStatus = " - <i>Waiting for reply</i>";
                    }
                  }
                  $conversationStatus = '';
                  if($conversation->conversation_status == 1){
                    $conversationStatus  =" <i>- This conversation has been closed</i>";
                    $replyStatus = "";
                  }else if($conversation->conversation_status == 2){
                    $conversationStatus  =" <i>- This conversation has been forwarded</i>";
                    $replyStatus = "";
                  }
                  ?>
                  <tr>
                    <td class="mailbox-status"></td>
                    <td class="mailbox-status"><?php echo $status; ?></td>
                    <td class="mailbox-name">
                      <a href="<?php echo e(route('messages.show',$conversation->conversation_id)); ?>"><b><?php echo e($conversation->category->category_name); ?> - <?php echo e($conversation->categoryTitle->title_name); ?></b></a>
                     <?php echo $replyStatus; ?> <?php echo $conversationStatus; ?>

                    </td>
                    <td class="mailbox-subject"><b><?php echo e($message['notice_title']); ?></b></td>
                    <td class="mailbox-attachment">
                    <?php
                        $attachments = App\NoticeAttachments::where('notice_id', '=' , $message['slo_notice_id'])->get()->count();
                    ?>
                    <?php if($attachments != 0): ?>
                    <i class="fas fa-paperclip"></i>
                    <?php endif; ?>
                    </td>
                    <td class="mailbox-date">
                    <?php echo e(\Carbon\Carbon::parse($message['created_at'])->diffForHumans()); ?>

                    </td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <div class="float-right">
                <?php echo e($data ->links()); ?>

                  <!-- /.btn-group -->
                </div>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xamppp\htdocs\push student portal\kiu-student-portal\resources\views/messages/messages-inbox.blade.php ENDPATH**/ ?>