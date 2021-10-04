<!-- Brand Logo -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-dark-danger">


    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            
                <img src="{{ENV('MAIN_LINK_URL')}}/storage/{{$student->image}}" class="elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><b>{{$student->std_title}}. {{$student->name_initials}}</b></a>
                <a href="#" class="d-block"><b>STD ID : {{$student->range_id}}</b></a>
                <a href="#" class="d-block"><b>Exam ID : {{$student->range_id}}</b></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview"
                role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ (request()->segment(1) == 'dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('courses.list')}}" class="nav-link {{ (request()->segment(1) == 'courses') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>Courses</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('fulltimetable.view')}}" class="nav-link {{ (request()->segment(1) == 'timetable') ? 'active' : '' }} ">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>Timetable</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('exam-timetable.list')}}" class="nav-link {{ (request()->segment(1) == 'details') ? 'active' : '' }} ">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>Exam TimeTable</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('noticeboard.view')}}" class="nav-link {{ (request()->segment(1) == 'noticeboard') ? 'active' : '' }} ">
                        <i class="nav-icon far fa-clipboard"></i>
                        <p>Noticeboard</p>
                        <?php
                          $newNoticeCount = App\NoticeBoard::whereStudentId($student->range_id)->whereNoticeType(0)->whereView(0)->where('created_by','!=',null)->get()->count();
                          ?>
                          <span class="badge badge-danger right">{{$newNoticeCount}}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('messages-list.inbox')}}" class="nav-link {{ (request()->segment(1) == 'messages') ? 'active' : '' }}">
                    <i class="nav-icon far fa-envelope"></i>
                      <p>Messages</p>
                      <?php
                            $newMessagesCount = App\NoticeBoard::whereStudentId($student->range_id)->whereNoticeType(1)->whereView(0)->where('created_by','!=',null)->get()->count();
                        ?>
                        <span class="badge badge-warning right">{{$newMessagesCount}}</span>
                    </a>
                  
                  </li>

                <li class="nav-item">
                    <a href="/details/main" class="nav-link {{ (request()->segment(1) == 'details') ? 'active' : '' }} ">
                        <i class="nav-icon fa fa-user"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <br>
                <a href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                      <button type="button" class="btn btn-block btn-secondary btn-sm">Logout</button>
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
