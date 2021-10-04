<!-- Navbar -->
<style>
.abc {
  max-width: 1000px !important;
}
</style>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
      <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item">
        <a href="<?php echo e(route('dashbord')); ?>" class="nav-link">Home</a>
      </li>
      <li class="nav-item">
        <a href="<?php echo e(route('activity.list')); ?>" class="nav-link">Activity</a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">Contact</a>
      </li>
  </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <?php
          $newMessagesCount = App\NoticeBoard::whereStudentId($student->range_id)->whereNoticeType(1)->whereView(0)->where('created_by','!=',null)->get()->count();
          $newMessages = App\NoticeBoard::select('category_title_id','category_id','notice_id','conversation_id')->with(['category','categoryTitle'])->whereStudentId($student->range_id)->whereNoticeType(1)->whereView(0)->where('created_by','!=',null)->orderBy('created_at','DESC')->groupBy(['category_id','category_title_id'])->get();
          ?>
          <!-- Notifications Dropdown Menu -->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-comments"></i>
              <span class="badge badge-danger navbar-badge"><?php echo e($newMessagesCount); ?> </span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right abc">
              <span class="dropdown-header"><?php echo e($newMessagesCount); ?> New Messages</span>
              <?php $x=1; ?>
              <?php $__currentLoopData = $newMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if($x == 6): ?>
              <?php continue; ?>
              <?php endif; ?>
              <?php
              $x++;
              $count = App\NoticeBoard::select('category_title_id')->whereStudentId($student->range_id)->whereNoticeType(1)->whereCategoryTitleId($message->category_title_id)->whereView(0)->where('created_by','!=',null)->get()->count();
              if($count == 1){
                $count = "New 1 Message from ".$message->category->category_name." - ".$message->categoryTitle->title_name;
              }else{
                $count = "New ".$count." Messages from ".$message->category->category_name." - ".$message->categoryTitle->title_name;
              }
              $messageId = $message->conversation_id;
              ?>
              <a href="<?php echo e(route('messages.show',$messageId  ?? 0)); ?>" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo e($count); ?>

                <span class="float-right text-muted text-sm"><?php echo e($message->created_at); ?></span>
              </a>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <div class="dropdown-divider"></div>
              <a href="<?php echo e(route('messages-list.inbox')); ?>" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
          </li>
          <?php
          $newMessagesCount = App\NoticeBoard::whereStudentId($student->range_id)->whereNoticeType(0)->whereView(0)->where('created_by','!=',null)->get()->count();
          $newMessages = App\NoticeBoard::select('category_title_id','category_id')->with(['category','categoryTitle'])->whereStudentId($student->range_id)->whereNoticeType(0)->whereView(0)->where('created_by','!=',null)->orderBy('created_at','DESC')->groupBy('category_id','category_title_id')->get();
          ?>
          <!-- Right Side Of Navbar -->


          <!-- Notice Dropdown Menu -->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-bell"></i>
              <span class="badge badge-warning navbar-badge"><?php echo e($newMessagesCount); ?> </span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right abc">
              <span class="dropdown-header"><?php echo e($newMessagesCount); ?> New Notice</span>
              <?php $x=1; ?>
              <?php $__currentLoopData = $newMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if($x == 6): ?>
              <?php continue; ?>
              <?php endif; ?>
              <?php
              $x++;
              $count = App\NoticeBoard::select('category_title_id')->whereStudentId($student->range_id)->whereNoticeType(0)->whereCategoryTitleId($message->category_title_id)->whereView(0)->where('created_by','!=',null)->get()->count();
              $count = "New ".$count." Notice from ".$message->category->category_name." - ".$message->categoryTitle->title_name;
              ?>
              <a href="<?php echo e(route('noticeboard.view')); ?>" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> <?php echo e($count); ?>

                <span class="float-right text-muted text-sm"><?php echo e($message->created_at); ?></span>
              </a>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <div class="dropdown-divider"></div>
              <a href="<?php echo e(route('noticeboard.view')); ?>" class="dropdown-item dropdown-footer">See All Notice</a>
            </div>
          </li>
          <!-- Right Side Of Navbar -->

      <!-- Authentication Links -->
      <?php if(auth()->guard()->guest()): ?>
          <li class="nav-item">
              <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
          </li>
          <?php if(Route::has('register')): ?>
              <li class="nav-item">
                  <a class="nav-link" href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a>
              </li>
          <?php endif; ?>
      <?php else: ?>
          <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
              </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                      <?php echo e(__('Logout')); ?>

                  </a>

                  <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                      <?php echo csrf_field(); ?>
                  </form>
              </div>
          </li>
      <?php endif; ?>

        </ul>

    </nav>
    <!-- /.navbar -->
<?php /**PATH /var/www/erpv2std.kiu.lk/resources/views/layouts/topnavi.blade.php ENDPATH**/ ?>