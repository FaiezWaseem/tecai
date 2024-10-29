@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.demostudents.sidebar')
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
            

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-7 connectedSortable">



             



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
                                @if ($item->ex_start_date <= $currentDate)
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




                    
                </section>
                <!-- /.Left col -->
                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-5 connectedSortable">


                </section>
                <!-- right col -->
            </div>
            <!-- /.row (main row) -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('footer')
    
@endsection
