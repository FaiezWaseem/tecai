  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light bg-danger">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('teacher.home.view') }}" class="nav-link text-white">Home</a>
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
    <a href="./" class="brand-link">
      <img src="{{ asset('dist/img/logo.png') }}" alt="tec infinity Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Tec Infinity</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ session('user')['name'] }}</a>
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
   
          <li class="nav-item {{ request()->is('dashboard/teacher/assignments*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('dashboard/teacher/assignments*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tasks"></i>
              <p>
                Assignment
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('teacher.assignments.view') }}" class="nav-link {{ request()->is('dashboard/teacher/assignments/view') ? 'active' : '' }}">
                  <i class="far fa fa-eye nav-icon"></i>
                  <p>View Assignments</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('teacher.assignments.grade.view') }}" class="nav-link {{ request()->is('dashboard/teacher/assignments/grade/view') ? 'active' : '' }}">
                  <i class="far fa fa-eye nav-icon"></i>
                  <p>Assignment Grades</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('teacher.assignment.create') }}" class="nav-link {{ request()->is('dashboard/teacher/assignments/create') ? 'active' : '' }}">
                  <i class="far fa fa-plus-square nav-icon"></i>
                  <p>Add New Assignment</p>
                </a>
              </li>
            </ul>
          </li>
   
          <li class="nav-item {{ request()->is('dashboard/teacher/classes*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('dashboard/teacher/classes/view') ? 'active' : '' }}">
              <i class="nav-icon fas fa-chalkboard"></i>
              <p>
                Classes
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('teacher.classes.view') }}" class="nav-link {{ request()->is('dashboard/teacher/classes/view') ? 'active' : '' }}">
                  <i class="far fa fa-eye nav-icon"></i>
                  <p>View My Classes</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ request()->is('dashboard/teacher/content*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('dashboard/teacher/content/view') ? 'active' : '' }}">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                Content
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('teacher.content.view') }}" class="nav-link {{ request()->is('dashboard/teacher/content/view') ? 'active' : '' }}">
                  <i class="far fa fa-eye nav-icon"></i>
                  <p>View Content</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('teacher.content.create') }}" class="nav-link {{ request()->is('dashboard/teacher/content/create') ? 'active' : '' }}">
                  <i class="far fa fa-plus-square nav-icon"></i>
                  <p>Add New Content</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ request()->is('dashboard/teacher/homework*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('dashboard/teacher/homework/view') ? 'active' : '' }}">
              <i class="nav-icon fas fa-folder-open"></i>
              <p>
                HomeWork
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('teacher.homework.view') }}" class="nav-link {{ request()->is('dashboard/teacher/homework/view') ? 'active' : '' }}">
                  <i class="far fa fa-eye nav-icon"></i>
                  <p>View all HomeWork</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('teacher.homework.create') }}" class="nav-link {{ request()->is('dashboard/teacher/homework/create') ? 'active' : '' }}">
                  <i class="far fa fa-plus-square nav-icon"></i>
                  <p>Add New HomeWork</p>
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