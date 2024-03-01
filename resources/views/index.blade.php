@extends('layout')
@section('title', 'Home Page')
@section('content')

    <!-- Page Wrapper -->
    <div id="wrapper">



        @include('components.sidebar')


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('components.nav')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @if (isset(session('user')['super_admin']))
                        <div class="row">
                            <div class="col-lg-6 col-xl-3 mb-4 animated--grow-in">
                                <div class="card border-bottom-primary h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Total Schools</div>
                                                <div class="text-lg fw-bold h3"> {{ $stats['schoolsCount'] }} </div>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-home feather-xl">
                                                <rect x="3" y="4" width="18" height="18" rx="2"
                                                    ry="2">
                                                </rect>
                                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                                <line x1="3" y1="10" x2="21" y2="10"></line>
                                            </svg>
                                        </div>
                                    </div>
                                    {{-- <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" href="#!">View Report</a>
                                        <div class="text-white"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-4 animated--grow-in">
                                <div class="card border-bottom-warning h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Total Admins</div>
                                                <div class="text-lg fw-bold h3">{{ $stats['adminsCount'] }}</div>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-dollar-sign feather-xl text-white-50">
                                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                            </svg>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-4 animated--grow-in">
                                <div class="card border-bottom-success h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Total Teachers</div>
                                                <div class="text-lg fw-bold h3">{{ $stats['teachersCount'] }}</div>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-check-square feather-xl text-white-50">
                                                <polyline points="9 11 12 14 22 4"></polyline>
                                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                            </svg>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-4 animated--grow-in">
                                <div class="card border-bottom-danger h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Total Students</div>
                                                <div class="text-lg fw-bold h3">{{ $stats['studentsCount'] }}</div>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-message-circle feather-xl text-white-50">
                                                <path
                                                    d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <div class="chartjs-size-monitor">
                                            <div class="chartjs-size-monitor-expand">
                                                <div class=""></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                        <canvas id="myAreaChart" style="display: block; height: 320px; width: 446px;"
                                            width="669" height="480" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Topics Coverage Teacher</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <div class="chartjs-size-monitor">
                                            <div class="chartjs-size-monitor-expand">
                                                <div class=""></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                        <canvas id="myPieChart" style="display: block; height: 245px; width: 300px;"
                                            width="450" height="367" class="chartjs-render-monitor"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Total Topics
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Covered Topics
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Remaining Topics
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                        @if (session('user')['super_admin'] === 0)

                            <div class="card-header d-flex justify-content-end">
                                <div class="w-75">
                                    <h4>Teacher Course coverge </h4>
                                </div>
                                <div class="w-25">
                                    <select id="teacher_select" class="form-control">
                                        @foreach ($coursesByTeacher as $row)
                                            <option value="{{ $row['id'] }}"> {{ $row['teacher_name'] }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="graphs">
                                @foreach ($outlines as $outline)
                                    <!-- Pie Chart -->
                                    <div class="col-xl-4 col-lg-5">
                                        <div class="card shadow mb-4">
                                            <!-- Card Header - Dropdown -->
                                            <div
                                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                <h6 class="m-0 font-weight-bold text-primary">
                                                    Class : {{ $outline->class_name }} <br>
                                                    Course :
                                                    {{ $outline->course_name }}
                                                    <br> Teacher : {{ $outline->name }}
                                                </h6>
                                                <div class="dropdown no-arrow">
                                                    <a class="dropdown-toggle" href="#" role="button"
                                                        id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                        aria-labelledby="dropdownMenuLink">
                                                        <div class="dropdown-header">Dropdown Header:</div>
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card Body -->
                                            <div class="card-body">
                                                <div class="chart-pie pt-4 pb-2">
                                                    <div class="chartjs-size-monitor">
                                                        <div class="chartjs-size-monitor-expand">
                                                            <div class=""></div>
                                                        </div>
                                                        <div class="chartjs-size-monitor-shrink">
                                                            <div class=""></div>
                                                        </div>
                                                    </div>
                                                    <canvas id="myPieChart-{{ $outline->id }}"
                                                        style="display: block; height: 245px; width: 300px;"
                                                        width="450" height="367"
                                                        class="chartjs-render-monitor"></canvas>
                                                </div>
                                                <div class="mt-4 text-center small">
                                                    <span class="mr-2">
                                                        <i class="fas fa-circle text-primary"></i> Total Topics
                                                    </span>
                                                    <span class="mr-2">
                                                        <i class="fas fa-circle text-success"></i> Covered Topics
                                                    </span>
                                                    <span class="mr-2">
                                                        <i class="fas fa-circle text-info"></i> Remaining Topics
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif


                        <div class="this-is-a-teachers-table">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 ">
                                    <h6 class="m-0 font-weight-bold text-primary">Teachers</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Teacher Name</th>
                                                    <th>School Name</th>
                                                    @if (session('user')['super_admin'] == 0)
                                                        <th>Classes</th>
                                                    @endif
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Teacher Name</th>
                                                    <th>School Name</th>
                                                    @if (session('user')['super_admin'] == 0)
                                                        <th>Classes</th>
                                                    @endif
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>



                                                @if (session('user')['super_admin'] == 0)

                                                    @foreach ($coursesByTeacher as $row)
                                                        <tr>
                                                            <td>
                                                                {{ $row['id'] }}
                                                            </td>
                                                            <td>
                                                                {{ $row['teacher_name'] }}
                                                            </td>

                                                            <td>

                                                                {{ $row['school_name'] }}
                                                            </td>
                                                            <td>
                                                                @foreach ($row['classes'] as $class)
                                                                    Class : {{ $class->class_name }} , Subject
                                                                    :{{ $class->course_name }} <br>
                                                                @endforeach
                                                            </td>
                                                            <td class="row">
                                                                <a
                                                                    href="{{ route('teachers.edit', ['id' => $row['id']]) }}">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>

                                                                <form method="post">
                                                                    @csrf
                                                                    <input type="text" name="id"
                                                                        value="{{ $row['id'] }}" hidden>
                                                                    <input type="text" name="delete" value="true"
                                                                        hidden>
                                                                    <button type="submit" class="btn submit-button">
                                                                        <i class="fa fa-trash-alt"
                                                                            style="color : red;"></i>

                                                                    </button>

                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    @foreach ($teachers as $row)
                                                        <tr>
                                                            <td>
                                                                {{ $row->id }}
                                                            </td>
                                                            <td>
                                                                {{ $row->name }}
                                                            </td>

                                                            <td>

                                                                {{ $row->school_name }}
                                                            </td>


                                                            <td class="row">
                                                                <a href="#">View</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                            </tbody>
                                        </table>
                                        <tr>
                                            {{-- {{ $teachers->links() }} --}}
                                        </tr>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="this-is-a-students-table">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 ">
                                    <h6 class="m-0 font-weight-bold text-primary">Students</h6>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                    <th>Father Name</th>
                                                    <th>Class</th>
                                                    <th>Section</th>
                                                    <th>Gender</th>
                                                    <th>Email</th>
                                                    <th>Action</th>

                                                </tr>

                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                    <th>Father Name</th>
                                                    <th>Class</th>
                                                    <th>Section</th>
                                                    <th>Gender</th>
                                                    <th>Email</th>
                                                    <th>Action</th>
                                                </tr>

                                            </tfoot>
                                            <tbody>



                                                @foreach ($students as $row)
                                                    <tr>
                                                        <td>
                                                            {{ $row->id }}
                                                        </td>
                                                        <td>
                                                            {{ $row->name }}
                                                        </td>

                                                        <td>
                                                            {{ $row->father_name }}
                                                        </td>

                                                        <td>
                                                            {{ $row->class }}
                                                        </td>

                                                        <td>
                                                            {{ $row->section }}
                                                        </td>
                                                        <td>
                                                            {{ $row->gender }}
                                                        </td>
                                                        <td>
                                                            {{ $row->email }}
                                                        </td>
                                                        <td class="row">
                                                            <a href="{{ route('teachers.show', ['id' => $row->id]) }}"
                                                                target="_blank" rel="noopener noreferrer">
                                                                <i class="fa fa-edit"></i>
                                                            </a>

                                                            <form method="post">
                                                                @csrf
                                                                <input type="text" name="id"
                                                                    value="{{ $row->id }}" hidden>
                                                                <input type="text" name="delete" value="true"
                                                                    hidden>
                                                                <button type="submit" class="btn submit-button">
                                                                    <i class="fa fa-trash-alt" style="color : red;"></i>

                                                                </button>

                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                        <tr>

                                        </tr>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- TEACHER DASHBOARD --}}

                  
                        <div class="row animated--grow-in">
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Total Classes</div>
                                                <div class="text-lg fw-bold h3">
                                                    {{ $classes }}
                                                </div>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-calendar feather-xl text-white-50">
                                                <rect x="3" y="4" width="18" height="18" rx="2"
                                                    ry="2">
                                                </rect>
                                                <line x1="16" y1="2" x2="16" y2="6">
                                                </line>
                                                <line x1="8" y1="2" x2="8" y2="6">
                                                </line>
                                                <line x1="3" y1="10" x2="21" y2="10">
                                                </line>
                                            </svg>
                                        </div>
                                    </div>
                                    {{-- <div class="card-footer d-flex align-items-center justify-content-between small">
                                    <a class="text-white stretched-link" href="#!">View Report</a>
                                    <div class="text-white"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                                </div> --}}
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card border-bottom-warning h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Students</div>
                                                <div class="text-lg fw-bold h3">{{ $students }}</div>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-dollar-sign feather-xl text-white-50">
                                                <line x1="12" y1="1" x2="12" y2="23">
                                                </line>
                                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                            </svg>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-success text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Course covered</div>
                                                <div class="text-lg fw-bold h3">50%</div>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-check-square feather-xl text-white-50">
                                                <polyline points="9 11 12 14 22 4"></polyline>
                                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                            </svg>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-danger text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Assignments</div>
                                                <div class="text-lg fw-bold h3">{{ $activities }}</div>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-message-circle feather-xl text-white-50">
                                                <path
                                                    d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Students
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%"
                                            height="300px"></canvas></div>
                                    <div class="card-footer small text-muted">Updated today {{ now() }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-pie me-1"></i>
                                        Topics Covered
                                    </div>
                                    <div class="card-body"><canvas id="myPieChart" width="100%"
                                            height="300px"></canvas></div>
                                    <div class="card-footer small text-muted">Updated today {{ now() }} </div>
                                </div>
                            </div>
                        </div>
      


                    @endif





                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('components.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->




@endsection

@section('footer')
    <script src="{{ asset('js/chart.js/Chart.min.js') }}"></script>

    <script>
        let charts = [];
        @if (session('user')['super_admin'] === 0)
            @foreach ($outlines as $outline)
                var obj = {
                    total: {{ $outline->count }},
                    total_covered: {{ $outline->count_covered }},
                    id: {{ $outline->id }}
                }
                charts.push(obj);
            @endforeach
        @endif
        loadGraphs()

        $('#teacher_select').change(function() {
            // Get the selected option value
            const selectedValue = $(this).val();

            // Get the CSRF token value from the <meta> tag
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Make the AJAX request
            $.ajax({
                url: '{{ route('admin.teacher.graph.filter') }}', // Current page URL
                type: 'POST', // or 'GET', 'PUT', etc. depending on your needs
                data: {
                    _token: csrfToken, // Include the CSRF token in the request data
                    teacher_id: selectedValue
                },
                dataType: 'json', // Specify the expected response data type
                success: function(data) {
                    // Handle the response from the server
                    console.log(data);
                    charts = [];
                    $('#graphs').html('');
                    if (data.outline) {
                        for (let i = 0; i < data.outline.length; i++) {
                            const element = data.outline[i];
                            var obj = {
                                total: element.count,
                                total_covered: element.count_covered,
                                id: element.id
                            }
                            charts.push(obj);
                            $('#graphs').append(` <div class="col-xl-4 col-lg-5">
                                        <div class="card shadow mb-4">
                                            <!-- Card Header - Dropdown -->
                                            <div
                                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                <h6 class="m-0 font-weight-bold text-primary">
                                                    Class : ${element.class_name} <br>
                                                    Course :
                                                    ${element.course_name }
                                                    <br> Teacher : ${element.name}
                                                </h6>
                                            </div>
                                            <!-- Card Body -->
                                            <div class="card-body">
                                                <div class="chart-pie pt-4 pb-2">
                                                    <div class="chartjs-size-monitor">
                                                        <div class="chartjs-size-monitor-expand">
                                                            <div class=""></div>
                                                        </div>
                                                        <div class="chartjs-size-monitor-shrink">
                                                            <div class=""></div>
                                                        </div>
                                                    </div>
                                                    <canvas id="myPieChart-${element.id}"
                                                        style="display: block; height: 245px; width: 300px;"
                                                        width="450" height="367"
                                                        class="chartjs-render-monitor"></canvas>
                                                </div>
                                                <div class="mt-4 text-center small">
                                                    <span class="mr-2">
                                                        <i class="fas fa-circle text-primary"></i> Total Topics
                                                    </span>
                                                    <span class="mr-2">
                                                        <i class="fas fa-circle text-success"></i> Covered Topics
                                                    </span>
                                                    <span class="mr-2">
                                                        <i class="fas fa-circle text-info"></i> Remaining Topics
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`);
                        }
                        loadGraphs()
                    }


                },
                error: function(xhr, status, error) {
                    // Handle any errors that occurred during the request
                    console.error(error);
                    showToast('Failed Request', 'Failed To Send Request :  ERROR : ' + error, 'error')
                }
            });
        });

        function loadGraphs() {
            for (let i = 0; i < charts.length; i++) {
                const element = charts[i];
                // Pie Chart Example
                var ctx = document.getElementById(`myPieChart-${element.id}`);
                var myPieChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ["Total Topic ", "Covered Topics", "Remaining Topics"],
                        datasets: [{
                            data: [element.total, element.total_covered, (element.total - element
                                .total_covered)],
                            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            caretPadding: 10,
                        },
                        legend: {
                            display: false
                        },
                        cutoutPercentage: 80,
                    },
                });
            }
        }
    </script>


    <script>
        // Bar Chart
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito',
            '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        function number_format(number, decimals, dec_point, thousands_sep) {
            // *     example: number_format(1234.56, 2, ',', ' ');
            // *     return: '1 234,56'
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        // Bar Chart Example
        var ctx = document.getElementById("myBarChart");
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["One : English", "Two : English", "three : Maths", "Four : Maths"],
                datasets: [{
                    label: "Students ",
                    backgroundColor: "#4e73df",
                    hoverBackgroundColor: "#2e59d9",
                    borderColor: "#4e73df",
                    data: [75, 64, 49,72],
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        },
                        maxBarThickness: 25,
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 100,
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return  number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel  + number_format(tooltipItem.yLabel);
                        }
                    }
                },
            }
        });



        // Pie Chart
        var ctx = document.getElementById(`myPieChart`);
                var myPieChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ["Total Topic ", "Covered Topics", "Remaining Topics"],
                        datasets: [{
                            data: [12,24,12],
                            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            caretPadding: 10,
                        },
                        legend: {
                            display: false
                        },
                        cutoutPercentage: 80,
                    },
                });
    </script>

@endsection
