  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light bg-danger">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i
                      class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
              <a href="{{ route('superadmin.home.view') }}" class="nav-link text-white">Home</a>
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
      <a href="index3.html" class="brand-link">
          <img src="{{ route('school.logo') }}" alt="tec infinity Logo"
              class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Tec Infinity</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                      alt="User Image">
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

                  <li class="nav-item {{ request()->is('dashboard/superadmin/admins*') ? 'menu-open' : '' }}">
                      <a href="#"
                          class="nav-link {{ request()->is('dashboard/superadmin/admins*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Admins
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('superadmin.admins.view') }}"
                                  class="nav-link {{ request()->is('dashboard/superadmin/admins/view') ? 'active' : '' }}">
                                  <i class="far fa fa-eye nav-icon"></i>
                                  <p>View Super Admins</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('superadmin.admins.create') }}"
                                  class="nav-link {{ request()->is('dashboard/superadmin/admins/create') ? 'active' : '' }}">
                                  <i class="far fa fa-plus-square nav-icon"></i>
                                  <p>Add New Super Admins</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('superadmin.schooladmins.view') }}"
                                  class="nav-link {{ request()->is('dashboard/superadmin/admins/school/view') ? 'active' : '' }}">
                                  <i class="far fa fa-eye nav-icon"></i>
                                  <p>View School Admins</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('superadmin.schooladmins.create') }}"
                                  class="nav-link {{ request()->is('dashboard/superadmin/admins/school/create') ? 'active' : '' }}">
                                  <i class="far fa fa-plus-square nav-icon"></i>
                                  <p>Add New School Admins</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item {{ request()->is('dashboard/superadmin/school*') ? 'menu-open' : '' }}">
                      <a href="#"
                          class="nav-link {{ request()->is('dashboard/superadmin/school*') ? 'active' : '' }}">
                          <i class="nav-icon fa fa-school"></i>
                          <p>
                              School
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('superadmin.schools.view') }}"
                                  class="nav-link {{ request()->is('dashboard/superadmin/school/view') ? 'active' : '' }}">
                                  <i class="far fa fa-eye nav-icon"></i>
                                  <p>View School</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('superadmin.schools.create') }}"
                                  class="nav-link {{ request()->is('dashboard/superadmin/school/create') ? 'active' : '' }}">
                                  <i class="far fa fa-plus-square nav-icon"></i>
                                  <p>Add School</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-item {{ request()->is('dashboard/superadmin/students*') ? 'menu-open' : '' }}">
                      <a href="#"
                          class="nav-link {{ request()->is('dashboard/superadmin/students*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-user-graduate"></i>
                          <p>
                              Students
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('superadmin.students.view') }}"
                                  class="nav-link {{ request()->is('dashboard/superadmin/students/view') ? 'active' : '' }}">
                                  <i class="far fa fa-eye nav-icon"></i>
                                  <p>View Students</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('superadmin.students.create') }}"
                                  class="nav-link {{ request()->is('dashboard/superadmin/students/create') ? 'active' : '' }}">
                                  <i class="far fa fa-plus-square nav-icon"></i>
                                  <p>Add New Student</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item {{ request()->is('dashboard/superadmin/teachers*') ? 'menu-open' : '' }}">
                      <a href="#"
                          class="nav-link {{ request()->is('dashboard/superadmin/teachers*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-chalkboard-teacher"></i>
                          <p>
                              Teachers
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('superadmin.teachers.view') }}"
                                  class="nav-link {{ request()->is('dashboard/superadmin/teachers/view') ? 'active' : '' }}">
                                  <i class="far fa fa-eye nav-icon"></i>
                                  <p>View Teachers</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('superadmin.teachers.create') }}"
                                  class="nav-link {{ request()->is('dashboard/superadmin/teachers/create') ? 'active' : '' }}">
                                  <i class="far fa fa-plus-square nav-icon"></i>
                                  <p>Add New Teacher</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-header">CBTS</li>
                  <li class="nav-item {{ request()->is('dashboard/superadmin/lms*') ? 'menu-open' : '' }}">
                      <a href="#"
                          class="nav-link {{ request()->is('dashboard/superadmin/lms*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-book"></i>
                          <p>
                              CBTS
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>
                                      Question Bank
                                      <i class="right fas fa-angle-left"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview" style="display: none;">
                                  <li class="nav-item">
                                      <a href="{{ route('superadmin.cbts.questionbank.view') }}"
                                          class="nav-link {{ request()->is('dashboard/superadmin/lms/questionbank/view') ? 'active' : '' }}">
                                          <i class="far fa fa-eye nav-icon"></i>
                                          <p>View Question Bank</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="{{ route('superadmin.cbts.questionbank.create') }}"
                                          class="nav-link {{ request()->is('dashboard/superadmin/cbts/questionbank/create') ? 'active' : '' }}">
                                          <i class="far fa fa-plus-square nav-icon"></i>
                                          <p>Add Question Bank</p>
                                      </a>
                                  </li>
                              </ul>
                          </li>
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>
                                      Exam
                                      <i class="right fas fa-angle-left"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview" style="display: none;">
                                  <li class="nav-item">
                                      <a href="{{ route('superadmin.cbts.exam.view') }}"
                                          class="nav-link {{ request()->is('dashboard/superadmin/cbts/exam/view') ? 'active' : '' }}">
                                          <i class="far fa fa-eye nav-icon"></i>
                                          <p>View Exam</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="{{ route('superadmin.cbts.exam.create') }}"
                                          class="nav-link {{ request()->is('dashboard/superadmin/cbts/exam/create') ? 'active' : '' }}">
                                          <i class="far fa fa-plus-square nav-icon"></i>
                                          <p>Add Exam</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="{{ route('superadmin.cbts.exam.result') }}"
                                          class="nav-link {{ request()->is('dashboard/superadmin/cbts/exam/result') ? 'active' : '' }}">
                                          <i class="far fa fa-eye nav-icon"></i>
                                          <p>Result</p>
                                      </a>
                                  </li>

                              </ul>
                          </li>


                      </ul>
                  </li>

                  <li class="nav-header">LMS</li>
                  <li class="nav-item {{ request()->is('dashboard/superadmin/lms*') ? 'menu-open' : '' }}">
                      <a href="#"
                          class="nav-link {{ request()->is('dashboard/superadmin/lms*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-book"></i>
                          <p>
                              LMS Content
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>
                                      Content
                                      <i class="right fas fa-angle-left"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview" style="display: none;">
                                  <li class="nav-item">
                                      <a href="{{ route('superadmin.lms.content.view') }}"
                                          class="nav-link {{ request()->is('dashboard/superadmin/lms/content/view') ? 'active' : '' }}">
                                          <i class="far fa fa-eye nav-icon"></i>
                                          <p>View Content</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="{{ route('superadmin.lms.content.create') }}"
                                          class="nav-link {{ request()->is('dashboard/superadmin/lms/content/create') ? 'active' : '' }}">
                                          <i class="far fa fa-plus-square nav-icon"></i>
                                          <p>Add Content</p>
                                      </a>
                                  </li>
                              </ul>
                          </li>
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>
                                      Class
                                      <i class="right fas fa-angle-left"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview" style="display: none;">
                                  <li class="nav-item">
                                      <a href="{{ route('superadmin.lms.classes.view') }}"
                                          class="nav-link {{ request()->is('dashboard/superadmin/lms/classes/view') ? 'active' : '' }}">
                                          <i class="far fa fa-eye nav-icon"></i>
                                          <p>View Classes</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="{{ route('superadmin.lms.classes.create') }}"
                                          class="nav-link {{ request()->is('dashboard/superadmin/lms/classes/create') ? 'active' : '' }}">
                                          <i class="far fa fa-plus-square nav-icon"></i>
                                          <p>Add Classes</p>
                                      </a>
                                  </li>
                              </ul>
                          </li>
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>
                                      Board
                                      <i class="right fas fa-angle-left"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview" style="display: none;">
                                  <li class="nav-item">
                                      <a href="{{ route('superadmin.lms.boards.view') }}"
                                          class="nav-link {{ request()->is('dashboard/superadmin/lms/boards/view') ? 'active' : '' }}">
                                          <i class="far fa fa-eye nav-icon"></i>
                                          <p>View Boards</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="{{ route('superadmin.lms.boards.create') }}"
                                          class="nav-link {{ request()->is('dashboard/superadmin/lms/boards/create') ? 'active' : '' }}">
                                          <i class="far fa fa-plus-square nav-icon"></i>
                                          <p>Add Boards</p>
                                      </a>
                                  </li>
                              </ul>
                          </li>
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>
                                      Subject
                                      <i class="right fas fa-angle-left"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview" style="display: none;">

                                  <li class="nav-item">
                                      <a href="{{ route('superadmin.lms.subjects.view') }}"
                                          class="nav-link {{ request()->is('dashboard/superadmin/lms/subjects/view') ? 'active' : '' }}">
                                          <i class="far fa fa-eye nav-icon"></i>
                                          <p>View Subject</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="{{ route('superadmin.lms.subjects.create') }}"
                                          class="nav-link {{ request()->is('dashboard/superadmin/lms/subjects/create') ? 'active' : '' }}">
                                          <i class="far fa fa-plus-square nav-icon"></i>
                                          <p>Add Subject</p>
                                      </a>
                                  </li>
                              </ul>
                          </li>
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>
                                      Chapters
                                      <i class="right fas fa-angle-left"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview" style="display: none;">
                                  <li class="nav-item">
                                      <a href="{{ route('superadmin.lms.chapters.view') }}"
                                          class="nav-link {{ request()->is('dashboard/superadmin/lms/chapters/view') ? 'active' : '' }}">
                                          <i class="far fa fa-eye nav-icon"></i>
                                          <p>View Chapters</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="{{ route('superadmin.lms.chapters.create') }}"
                                          class="nav-link {{ request()->is('dashboard/superadmin/lms/chapters/create') ? 'active' : '' }}">
                                          <i class="far fa fa-plus-square nav-icon"></i>
                                          <p>Add Chapters</p>
                                      </a>
                                  </li>
                              </ul>
                          </li>
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>
                                      SLO's
                                      <i class="right fas fa-angle-left"></i>
                                  </p>
                              </a>
                              <ul class="nav nav-treeview" style="display: none;">
                                  <li class="nav-item">
                                      <a href="{{ route('superadmin.lms.slo.view') }}"
                                          class="nav-link {{ request()->is('dashboard/superadmin/lms/chapters/view') ? 'active' : '' }}">
                                          <i class="far fa fa-eye nav-icon"></i>
                                          <p>View SLO's</p>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="{{ route('superadmin.lms.slo.create') }}"
                                          class="nav-link {{ request()->is('dashboard/superadmin/lms/chapters/create') ? 'active' : '' }}">
                                          <i class="far fa fa-plus-square nav-icon"></i>
                                          <p>Add SLO's</p>
                                      </a>
                                  </li>
                              </ul>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-item {{ request()->is('dashboard/superadmin/ecoaching*') ? 'menu-open' : '' }}">
                      <a href="#" class="nav-link {{ request()->is('dashboard/superadmin/ecoaching*') ? 'active' : '' }}">
                          <i class="nav-icon far fa-plus-square"></i>
                          <p>
                              E-Coaching
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                   Students
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">
                                <li class="nav-item">
                                    <a href="{{ route('superadmin.ecoaching.students.view') }}"
                                        class="nav-link {{ request()->is('dashboard/superadmin/ecoaching/students/view') ? 'active' : '' }}">
                                        <i class="far fa fa-eye nav-icon"></i>
                                        <p>View Students</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('superadmin.ecoaching.students.create') }}"
                                        class="nav-link {{ request()->is('dashboard/superadmin/lms/chapters/create') ? 'active' : '' }}">
                                        <i class="far fa fa-plus-square nav-icon"></i>
                                        <p>Add Student</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Teachers
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">
                                <li class="nav-item">
                                    <a href="{{ route('superadmin.lms.slo.view') }}"
                                        class="nav-link {{ request()->is('dashboard/superadmin/lms/chapters/view') ? 'active' : '' }}">
                                        <i class="far fa fa-eye nav-icon"></i>
                                        <p>View Teachers</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('superadmin.lms.slo.create') }}"
                                        class="nav-link {{ request()->is('dashboard/superadmin/lms/chapters/create') ? 'active' : '' }}">
                                        <i class="far fa fa-plus-square nav-icon"></i>
                                        <p>Add Teachers</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Plan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">
                                <li class="nav-item">
                                    <a href="{{ route('superadmin.ecoaching.plans.view') }}"
                                        class="nav-link {{ request()->is('dashboard/superadmin/ecoaching/plans/view') ? 'active' : '' }}">
                                        <i class="far fa fa-eye nav-icon"></i>
                                        <p>View Plans</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('superadmin.ecoaching.plans.create') }}"
                                        class="nav-link {{ request()->is('dashboard/superadmin/ecoaching/plans/create') ? 'active' : '' }}">
                                        <i class="far fa fa-plus-square nav-icon"></i>
                                        <p>Add Plan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Live Session
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">
                                <li class="nav-item">
                                    <a href="{{ route('superadmin.live_session.view') }}"
                                        class="nav-link {{ request()->is('dashboard/superadmin/ecoaching/live_session/view') ? 'active' : '' }}">
                                        <i class="far fa fa-eye nav-icon"></i>
                                        <p>View LiveSessions</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('superadmin.live_session.create') }}"
                                        class="nav-link {{ request()->is('dashboard/superadmin/ecoaching/plans/create') ? 'active' : '' }}">
                                        <i class="far fa fa-plus-square nav-icon"></i>
                                        <p>Add LiveSessions</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Notes
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">
                                <li class="nav-item">
                                    <a href="{{ route('superadmin.notes.view') }}"
                                        class="nav-link {{ request()->is('dashboard/superadmin/ecoaching/plans/view') ? 'active' : '' }}">
                                        <i class="far fa fa-eye nav-icon"></i>
                                        <p>View Notes</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('superadmin.notes.create') }}"
                                        class="nav-link {{ request()->is('dashboard/superadmin/ecoaching/plans/create') ? 'active' : '' }}">
                                        <i class="far fa fa-plus-square nav-icon"></i>
                                        <p>Add Notes</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                      </ul>
                  </li>

              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
