
{{-- {{ request() }} --}}
{{-- {{ request()->is('dashboard') }} --}}
<!-- Sidebar -->

<style>
    .nav-item.active {
        background: red;
        margin: 4px;
        border-radius: 8px;
    }
    .sidebar .nav-item .nav-link{
        padding: none;
    }
</style>

           <ul class="navbar-nav bg-gradient-white sidebar sidebar-dark accordion" id="accordionSidebar">

               <!-- Sidebar - Brand -->
               <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                   <img src="{{ asset('images/tec.png') }}" alt="" width="180px">
               </a>

               <!-- Divider -->
               <hr class="sidebar-divider my-0">

               <!-- Nav Item - Dashboard -->
               <li class="nav-item">
                
                <a class="nav-link" >
                    <img class="img-profile rounded-circle"
                    src="https://placehold.co/600x400.png">
                    <span class="mr-2 d-none d-lg-inline">{{ session('user')['name']  }}</span>
            </a>
               </li>
               <hr class="sidebar-divider">
               <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                   <a class="nav-link" href="">
                       <i class="fas fa-fw fa-tachometer-alt"></i>
                       <span>Dashboard</span></a>
               </li>




               @if (!session('admin'))
                   <!-- Nav Item - Pages Collapse Menu -->
                   <li class="nav-item">
                       <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                           aria-expanded="true" aria-controls="collapseTwo">
                           <i class="fas fa-fw fa-cog"></i>
                           <span>Assignments</span>
                       </a>
                       <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                           data-parent="#accordionSidebar">
                           <div class="bg-white py-2 collapse-inner rounded">
                               <a class="collapse-item" href="{{ route('teacher.assignment.show') }}">My Assignment</a>
                               <a class="collapse-item" href="{{ route('teacher.assignment.create') }}">Create
                                   Assignment</a>
                           </div>
                       </div>
                   </li>
               @endif




               @if (App\Http\Controllers\UserPermission::isAdmin())

                   @if (App\Http\Controllers\UserPermission::isSuperAdmin())
                       <li class="nav-item {{ request()->is('dashboard/admins') ? 'active' : '' }}">
                           <a class="nav-link" href="{{ route('admin.show') }}">
                               <i class="fas fa-fw fa-users"></i>
                               <span>School Admins</span></a>
                       </li>

                       <li class="nav-item {{ request()->is('dashboard/schools') ? 'active' : '' }}">
                           <a class="nav-link" href="{{ route('school.show') }}">
                               <i class="fas fa-fw fa-school"></i>
                               <span>Schools</span></a>
                       </li>

                       <li class="nav-item">
                           <a class="nav-link collapsed" href="#" data-toggle="collapse"
                               data-target="#tecContent" aria-expanded="true" aria-controls="collapseUtilities">
                               <i class="fas fa-fw fa-wrench"></i>
                               <span>Tec Content</span>
                           </a>
                           <div id="tecContent" class="collapse" aria-labelledby="headingUtilities"
                               data-parent="#accordionSidebar">
                               <div class="bg-white py-2 collapse-inner rounded">
                                   <a class="collapse-item" href="{{ route('admin.content.view') }}">Content</a>
                                   <a class="collapse-item" href="{{ route('admin.content.classes.view') }}">Classes</a>
                                   <a class="collapse-item" href="{{ route('admin.content.board.view') }}">Boards</a>
                                   <a class="collapse-item" href="{{ route('admin.content.subject.view') }}">Subject</a>
                                   <a class="collapse-item" href="{{ route('admin.content.chapters.view') }}">Chapters</a>
                               </div>
                           </div>
                       </li>
                       <li class="nav-item">
                           <a class="nav-link collapsed" href="#" data-toggle="collapse"
                               data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                               <i class="fas fa-fw fa-wrench"></i>
                               <span>Tec ECoaching</span>
                           </a>
                           <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                               data-parent="#accordionSidebar">
                               <div class="bg-white py-2 collapse-inner rounded">
                                   <a class="collapse-item" href="{{ route('admin.content.schedule.view') }}">Time Table</a>
                                   <a class="collapse-item" href="{{ route('admin.content.livesessions.view') }}">Live Sessions</a>
                                   <a class="collapse-item" href="{{ route('admin.content.recordlectures.view') }}">Recorded Lectures</a>
                               </div>
                           </div>
                       </li>
                   @endif

                   <li class="nav-item {{ request()->is('dashboard/students') ? 'active' : '' }}" >
                       <a class="nav-link" href="{{ route('students.show') }}">
                           <i class="fas fa-fw fa-user"></i>
                           <span>students</span></a>
                   </li>
                   <li class="nav-item {{ request()->is('dashboard/teachers') ? 'active' : '' }}">
                       <a class="nav-link" href="{{ route('teachers.show') }}">
                           <i class="fas fa-fw fa-user-graduate"></i>
                           <span>Teachers</span></a>
                   </li>
                   @if (!session('user')['super_admin'])
                       <li class="nav-item">
                           <a class="nav-link" href="{{ route('courses.show') }}">
                               <i class="fas fa-fw fa-book"></i>
                               <span>Courses</span></a>
                       </li>
                       <li class="nav-item">
                           <a class="nav-link" href="{{ route('classes.show') }}">
                               <i class="fas fa-fw fa-chalkboard-teacher"></i>
                               <span>Classes</span></a>
                       </li>
                       <li class="nav-item">
                           <a class="nav-link" href="{{ route('courses.show') }}">
                               <i class="fas fa-fw fa-layer-group"></i>
                               <span>Section</span></a>
                       </li>
                   @endif
               @else
                   <li class="nav-item">
                       <a class="nav-link" href="{{ route('teacher.classes.show') }}">
                           <i class="fas fa-fw fa-chart-area"></i>
                           <span>Classes</span></a>
                   </li>

                   <li class="nav-item">
                       <a class="nav-link" href="#">
                           <i class="fas fa-fw fa-eye"></i>
                           <span>Grade Assignments</span></a>
                   </li>
               @endif



               <!-- Divider -->
               <hr class="sidebar-divider d-none d-md-block">

               <!-- Sidebar Toggler (Sidebar) -->
               <div class="text-center d-none d-md-inline">
                   <button class="rounded-circle border-0" id="sidebarToggle"></button>
               </div>

           </ul>
           <!-- End of Sidebar -->
