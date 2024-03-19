  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light bg-danger">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('schooladmin.home.view') }}" class="nav-link text-white">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('home') }}" class="nav-link text-white">Content</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link text-white" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar text-white" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link text-white" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link text-white" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('auth.logout') }}" >
          <i class="fas fa-power-off"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-danger elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('dist/img/logo.png') }}" alt="tec infinity Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Tec Infinity</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{  asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ session('user')['name'] }} </a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">   
          <li class="nav-item {{ request()->is('dashboard/school_admin/students*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('dashboard/school_admin/students*') ? 'active' : '' }}" >
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>
                Students
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('schooladmin.students.view') }}" class="nav-link {{ request()->is('dashboard/school_admin/students/view') ? 'active' : '' }}">
                  <i class="far fa fa-eye nav-icon"></i>
                  <p>View Students</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('schooladmin.students.create') }}" class="nav-link {{ request()->is('dashboard/school_admin/students/create') ? 'active' : '' }}">
                  <i class="far fa fa-plus-square nav-icon"></i>
                  <p>Add New Student</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('schooladmin.attendance.view') }}" class="nav-link {{ request()->is('dashboard/school_admin/attendance/create') ? 'active' : '' }}">
                  <i class="far fa fa-eye nav-icon"></i>
                  <p>View Attendance</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ request()->is('dashboard/school_admin/teachers*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('dashboard/school_admin/teachers*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>
                Teachers
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('schooladmin.teachers.view') }}" class="nav-link {{ request()->is('dashboard/school_admin/teachers/view') ? 'active' : '' }}">
                  <i class="far fa fa-eye nav-icon"></i>
                  <p>View Teachers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('schooladmin.teachers.create') }}" class="nav-link {{ request()->is('dashboard/school_admin/teachers/create') ? 'active' : '' }}">
                  <i class="far fa fa-plus-square nav-icon"></i>
                  <p>Add New Teacher</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ request()->is('dashboard/school_admin/courses*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('dashboard/school_admin/courses*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-book-reader"></i>
              <p>
                Courses
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('schooladmin.courses.view') }}" class="nav-link {{ request()->is('dashboard/school_admin/courses/view') ? 'active' : '' }}">
                  <i class="far fa fa-eye nav-icon"></i>
                  <p>View Courses</p>
                </a>
              </li>
              <li class="nav-item">
                <a href=" {{ route('schooladmin.courses.create') }}" class="nav-link {{ request()->is('dashboard/school_admin/courses/create') ? 'active' : '' }}">
                  <i class="far fa fa-plus-square nav-icon"></i>
                  <p>Add New Course</p>
                </a>
              </li>

            </ul>
          </li>
          <li class="nav-item {{ request()->is('dashboard/school_admin/classes*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('dashboard/school_admin/classes*') ? 'active' : '' }}">
              <i class="fas fa-fw fa-chalkboard-teacher"></i>
              <p>
                Classes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('schooladmin.classes.view')}}" class="nav-link {{ request()->is('dashboard/school_admin/classes/view') ? 'active' : '' }}">
                  <i class="far fa fa-eye nav-icon"></i>
                  <p>View Classes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('schooladmin.classes.create')}}" class="nav-link {{ request()->is('dashboard/school_admin/classes/create') ? 'active' : '' }}">
                  <i class="far fa fa-plus-square nav-icon"></i>
                  <p>Add New Class</p>
                </a>
              </li>

            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>