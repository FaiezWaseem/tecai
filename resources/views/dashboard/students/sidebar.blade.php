  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light bg-danger">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i
                      class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
              <a href="{{ route('student.home.view') }}" class="nav-link text-white">Home</a>
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
                          <input class="form-control form-control-navbar" type="search" placeholder="Search"
                              aria-label="Search">
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
              <a class="nav-link text-white" href="{{ route('auth.logout') }}">
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
          <img src="{{ route('school.logo') }}" alt="tec infinity Logo" class="brand-image img-circle elevation-3"
              style="opacity: .8">
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
                  <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                      aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">

                  <li class="nav-item {{ request()->is('dashboard/students/assignments*') ? 'menu-open' : '' }}">
                      <a href="#"
                          class="nav-link {{ request()->is('dashboard/students/assignments*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-tasks"></i>
                          <p>
                              Assignment
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('student.assignments.view') }}"
                                  class="nav-link {{ request()->is('dashboard/students/assignments/view') ? 'active' : '' }}">
                                  <i class="far fa fa-eye nav-icon"></i>
                                  <p>View Assignments</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('student.assignments.grade.view') }}"
                                  class="nav-link {{ request()->is('dashboard/students/assignments/grade/view') ? 'active' : '' }}">
                                  <i class="far fa fa-eye nav-icon"></i>
                                  <p>Assignment Grades</p>
                              </a>
                          </li>
                      </ul>
                  </li>



                  <li class="nav-item {{ request()->is('dashboard/students/homework*') ? 'menu-open' : '' }}">
                      <a href="#"
                          class="nav-link {{ request()->is('dashboard/students/homework/view') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-folder-open"></i>
                          <p>
                              HomeWork
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('student.homework.view') }}"
                                  class="nav-link {{ request()->is('dashboard/students/homework/view') ? 'active' : '' }}">
                                  <i class="far fa fa-eye nav-icon"></i>
                                  <p>View all HomeWork</p>
                              </a>
                          </li>

                      </ul>
                  </li>
                  <li class="nav-item {{ request()->is('dashboard/students/reportcard*') ? 'menu-open' : '' }}">
                      <a href="#"
                          class="nav-link {{ request()->is('dashboard/students/reportcard/view') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-folder-open"></i>
                          <p>
                              Report Card
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('student.reportcard.view') }}"
                                  class="nav-link {{ request()->is('dashboard/students/homework/view') ? 'active' : '' }}">
                                  <i class="far fa fa-eye nav-icon"></i>
                                  <p>View Report Card</p>
                              </a>
                          </li>

                      </ul>
                  </li>
                  <li class="nav-item {{ request()->is('dashboard/students/exam*') ? 'menu-open' : '' }}">
                      <a href="#"
                          class="nav-link {{ request()->is('dashboard/students/exam/takeexam') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-folder-open"></i>
                          <p>
                              CBTS
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('student.cbts.exam.view') }}"
                                  class="nav-link {{ request()->is('dashboard/students/homework/view') ? 'active' : '' }}">
                                  <i class="far fa fa-eye nav-icon"></i>
                                  <p>Take Exam</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('student.cbts.exam.result') }}"
                                  class="nav-link {{ request()->is('dashboard/students/homework/view') ? 'active' : '' }}">
                                  <i class="far fa fa-eye nav-icon"></i>
                                  <p>Result</p>
                              </a>
                          </li>

                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('student.profile.view') }}"
                          class="nav-link {{ request()->is('dashboard/students/profile') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-user"></i>
                          <p>
                              Profile
                            
                          </p>
                      </a>

                  </li>

              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
