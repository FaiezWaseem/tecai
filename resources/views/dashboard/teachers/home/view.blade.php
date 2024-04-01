@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.teachers.sidebar')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                    {{-- <?php
                    echo json_encode($marks);
                    ?> --}}
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Stats -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $stats['classesCount'] }}</h3>

                            <p>Classes</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $stats['studentsCount'] }}</h3>
                            <p>Students</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $stats['chaptersCount'] }}</h3>
                            <p>Chapters</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-7 connectedSortable">

                    {{-- STUDENTS CHART --}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Students
                            </h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#students-chart" data-toggle="tab">Students</a>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane" id="revenue-chart" style="position: relative; height: 300px;">
                                    <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                                <div class="chart tab-pane active" id="students-chart"
                                    style="position: relative; height: 300px;">
                                    <canvas id="students-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div>

                    {{-- Student MARKS --}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Assignments
                            </h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">


                                </ul>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <table class="table">
                                    <thead>
                                        <th>Id</th>
                                        <th>Class</th>
                                        <th>Student</th>
                                        <th>Obtained</th>
                                        <th>Total</th>
                                        <th>Attempted</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($marks as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->stdclass }}</td>
                                                <td>{{ $item->stdName }}</td>
                                                <td>{{ $item->obtained }}</td>
                                                <td>{{ $item->total }}</td>
                                                <td>{{ $item->attempted_date }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <th>Id</th>
                                        <th>Class</th>
                                        <th>Student</th>
                                        <th>Obtained</th>
                                        <th>Total</th>
                                        <th>Attempted</th>
                                    </tfoot>
                                </table>
                                {{ $marks->links() }}
                            </div>
                        </div><!-- /.card-body -->
                    </div>

                </section>
                <!-- /.Left col -->
                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-5 connectedSortable">



                    {{-- ATTENDANCE CHART --}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Attendance
                            </h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">


                                </ul>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane" id="revenue-chart" style="position: relative; height: 300px;">
                                    <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                                <div class="chart tab-pane active" id="sales-chart"
                                    style="position: relative; height: 300px;">
                                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                    {{-- COURSE COVERAGE --}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Teacher
                            </h3>
                            <div class="card-tools">
                                <style>
                                    .form-control {
                                        width: auto !important;
                                        display: inline !important;
                                    }
                                </style>

                                <select name="" id="" class="form-control">
                                    <option value="">SCHOOL</option>
                                </select>
                                <select name="" id="" class="form-control">
                                    <option value="">CLASS</option>
                                </select>
                                <select name="" id="" class="form-control">
                                    <option value="">SUBJECT</option>
                                </select>


                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane" id="revenue-chart"
                                    style="position: relative; height: 300px;">
                                    <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                                <div class="chart tab-pane active" id="course-coverage-chart"
                                    style="position: relative; height: 300px;">
                                    <canvas id="course-coverage-chart-canvas" height="300"
                                        style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div>



                </section>
                <!-- right col -->
            </div>
            <!-- /.row (main row) -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('footer')
    @if ($stats['studentGenderCounts'])
        <script>
            const total_stds = {{ $stats['studentsCount'] }};
            const total_male_stds = {{ $stats['studentGenderCounts'][1]['male'] }};
            const total_female_stds = {{ $stats['studentGenderCounts'][0]['female'] }};

            loadStudentCanvas([total_stds, total_male_stds, total_female_stds]);
            loadAttendanceCanvas([15, 4, 2]);
            loadCourseCoverageCanvas([5, 4]);
        </script>
    @endif
@endsection
