@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.students.sidebar')
@endsection

@section('content')
    <style>
        .card-notice {

            text-decoration: none;
            color: #000;
            background: #ffc;
            display: block;
            height: auto;
            padding: 0.7em;
            -moz-box-shadow: 5px 5px 7px rgba(33, 33, 33, 1);
            -webkit-box-shadow: 5px 5px 7px rgba(33, 33, 33, .7);
            box-shadow: 5px 5px 7px rgba(33, 33, 33, .7);
            -moz-transition: -moz-transform .15s linear;
            -o-transition: -o-transform .15s linear;
            -webkit-transition: -webkit-transform .15s linear;
            word-wrap: break-word;

        }

        .card-notice:hover {
            transform: rotate(-10deg);
            cursor: pointer;
        }

        .cbts {
            text-decoration: none;
            color: #fff;
            background: green;
            display: block;
            height: auto;
            margin:10px;
            padding: 10px;
            font-size:2vb;
        }

    </style>

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
            <!-- Stats -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $assignments }} </h3>

                            <p>Assignment</p>
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
                            <h3>{{ count($marks) }} </h3>
                            <p>Graded</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ count($marks) }} </h3>
                            <p>Home Work</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>


            </div>

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-7 connectedSortable">



                    {{-- Student MARKS --}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Notice Board
                            </h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">


                                </ul>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <div class="row">

                                    @foreach ($notices as $item)
                                        <a class="card-notice .col-md-2 my-3">
                                            <p></p>
                                            <p>{!! $item->message !!}</p>
                                            <p></p>
                                            <h6>{{ $item->created_at }}</h6>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                    {{-- Student MARKS --}}





                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                CBTS Exam
                            </h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">


                                </ul>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <div class="row">
                                @foreach ($cbtsexam as $item)
                                @php
                                $currentDate = date('Y-m-d');
                                @endphp
                                @if ($item->ex_start_date > $currentDate)
                                <a class="cbts">
                                    <p>{!! $item->ex_title !!}</p>
                                    <p>Start date: {{ $item->ex_start_date }}</p>
                                    <p>End date: {{ $item->ex_end_date }}</p>
                                </a>
                                @endif
                                @endforeach

                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div>




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
                                        <th>Obtained</th>
                                        <th>Total</th>
                                        <th>Attempted</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($marks as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->obtained }}</td>
                                                <td>{{ $item->total }}</td>
                                                <td>{{ $item->attempted_date }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <th>Id</th>
                                        <th>Obtained</th>
                                        <th>Total</th>
                                        <th>Attempted</th>
                                    </tfoot>
                                </table>
                                {{-- {{ $marks->links() }} --}}
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
                                Attendance This Month
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


                </section>
                <!-- right col -->
            </div>
            <!-- /.row (main row) -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('footer')
    <script>
        let json = @json($attendance);
        loadAttendanceCanvas([{{ $present }}, {{ $absent }}, {{ $late }}]);
    </script>
    <script>
        var colors = ['#ffc', '#cfc', '#ccf', '#b54bff'];
        document.addEventListener('DOMContentLoaded', function() {
            // Get all the card-notice elements
            var cardNotices = document.querySelectorAll('.card-notice');

            // Loop through the card-notice elements and set a random background color
            cardNotices.forEach(function(cardNotice) {
                var randomColor = colors[Math.floor(Math.random() * colors.length)];
                cardNotice.style.backgroundColor = randomColor;
            });
        });
    </script>
@endsection
