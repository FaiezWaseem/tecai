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





               <!-- Divider -->
               <hr class="sidebar-divider d-none d-md-block">

               <!-- Sidebar Toggler (Sidebar) -->
               <div class="text-center d-none d-md-inline">
                   <button class="rounded-circle border-0" id="sidebarToggle"></button>
               </div>

           </ul>
           <!-- End of Sidebar -->
