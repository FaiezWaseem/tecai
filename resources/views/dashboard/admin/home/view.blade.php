@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.admin.sidebar')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
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
            {{-- STATS --}}
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $stats['adminsCount'] }} </h3>
                            <p>Admins</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $stats['studentsCount'] }} </h3>

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
                            <h3>{{ $stats['schoolsCount'] }} </h3>

                            <p>Schools</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $stats['teachersCount'] }} </h3>

                            <p>Teachers</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            @include('dashboard.admin.quicklinks')

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
                                <select name="teacherId" id="teacherId" class="form-control">
                                    @foreach ($teachers as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane" id="revenue-chart" style="position: relative; height: 300px;">
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
                                <div class="chart tab-pane" id="revenue-chart"
                                    style="position: relative; height: 300px;">
                                    <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                                <div class="chart tab-pane active" id="sales-chart"
                                    style="position: relative; height: 300px;">
                                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
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
    @if ($outlines && count($outlines) > 0)
        <script>
            loadStudentCanvas([{{ $stats['studentsCount'] }}, {{ $stats['studentsMaleCount'] }},
                {{ $stats['studentsFemaleCount'] }}
            ]);
            loadCourseCoverageCanvas([{{ $outlines[0]->count }}, {{ $outlines[0]->count_covered }}]);
            loadAttendanceCanvas([{{ $attendance->total_present }}, {{ $attendance->total_absent }},
                {{ $attendance->total_late }}
            ]);
        </script>
        <script>
            $('#teacherId').change(function() {
                // Get the selected option value
                const selectedValue = $(this).val();

                // Get the CSRF token value from the <meta> tag
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                console.log(selectedValue, csrfToken)


                $.ajax({
                    url: window.location.href, // Current page URL
                    type: 'POST', // or 'GET', 'PUT', etc. depending on your needs
                    data: {
                        _token: csrfToken,
                        tid: selectedValue
                    },
                    dataType: 'json', // Specify the expected response data type
                    success: function(data) {
                        // Handle the response from the server

                        console.log(data)
                        if (data.chaptersCount) {
                            let count = 0, count_covered = 0;

                            data.chaptersCount.forEach(element => {
                                count += element.count
                                count_covered += element.count_covered
                            });
                            console.log(count , count_covered)
                            loadCourseCoverageCanvas([count, count_covered])
                        } else {
                            loadCourseCoverageCanvas([0, 0])
                        }


                    },
                    error: function(xhr, status, error) {
                        // Handle any errors that occurred during the request
                        console.error(error);
                        alert('Failed to fetched Departments :  ERROR : ' + error)
                    }
                });
            });
        </script>
    @endif
@endsection
