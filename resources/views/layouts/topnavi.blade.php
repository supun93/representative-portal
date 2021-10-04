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
        <a href="{{route('dashbord')}}" class="nav-link">Home</a>
      </li>
      <li class="nav-item">
        <a href="{{route('activity.list')}}" class="nav-link">Activity</a>
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
              <span class="badge badge-danger navbar-badge">{{$newMessagesCount}} </span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right abc">
              <span class="dropdown-header">{{$newMessagesCount}} New Messages</span>
              <?php $x=1; ?>
              @foreach($newMessages as $message)
              @if($x == 6)
              @continue
              @endif
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
              <a href="{{ route('messages.show',$messageId  ?? 0) }}" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> {{$count}}
                <span class="float-right text-muted text-sm">{{$message->created_at}}</span>
              </a>
              @endforeach
              <div class="dropdown-divider"></div>
              <a href="{{route('messages-list.inbox')}}" class="dropdown-item dropdown-footer">See All Messages</a>
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
              <span class="badge badge-warning navbar-badge">{{$newMessagesCount}} </span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right abc">
              <span class="dropdown-header">{{$newMessagesCount}} New Notice</span>
              <?php $x=1; ?>
              @foreach($newMessages as $message)
              @if($x == 6)
              @continue
              @endif
              <?php
              $x++;
              $count = App\NoticeBoard::select('category_title_id')->whereStudentId($student->range_id)->whereNoticeType(0)->whereCategoryTitleId($message->category_title_id)->whereView(0)->where('created_by','!=',null)->get()->count();
              $count = "New ".$count." Notice from ".$message->category->category_name." - ".$message->categoryTitle->title_name;
              ?>
              <a href="{{route('noticeboard.view')}}" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> {{$count}}
                <span class="float-right text-muted text-sm">{{$message->created_at}}</span>
              </a>
              @endforeach
              <div class="dropdown-divider"></div>
              <a href="{{route('noticeboard.view')}}" class="dropdown-item dropdown-footer">See All Notice</a>
            </div>
          </li>
          <!-- Right Side Of Navbar -->

      <!-- Authentication Links -->
      @guest
          <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
          </li>
          @if (Route::has('register'))
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
              </li>
          @endif
      @else
          <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ Auth::user()->name }} <span class="caret"></span>
              </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
              </div>
          </li>
      @endguest

        </ul>

    </nav>
    <!-- /.navbar -->
