@extends('layout')
@section('title', 'Schedule')
@section('style')
    <style>
        .bg-light-gray {
            background-color: #f7f7f7;
        }

        .table-bordered thead td,
        .table-bordered thead th {
            border-bottom-width: 2px;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6;
        }


        .bg-sky.box-shadow {
            box-shadow: 0px 5px 0px 0px #00a2a7
        }

        .bg-orange.box-shadow {
            box-shadow: 0px 5px 0px 0px #af4305
        }

        .bg-green.box-shadow {
            box-shadow: 0px 5px 0px 0px #4ca520
        }

        .bg-yellow.box-shadow {
            box-shadow: 0px 5px 0px 0px #dcbf02
        }

        .bg-pink.box-shadow {
            box-shadow: 0px 5px 0px 0px #e82d8b
        }

        .bg-purple.box-shadow {
            box-shadow: 0px 5px 0px 0px #8343e8
        }

        .bg-lightred.box-shadow {
            box-shadow: 0px 5px 0px 0px #d84213
        }


        .bg-sky {
            background-color: #02c2c7
        }

        .bg-orange {
            background-color: #e95601
        }

        .bg-green {
            background-color: #5bbd2a
        }

        .bg-yellow {
            background-color: #f0d001
        }

        .bg-pink {
            background-color: #ff48a4
        }

        .bg-purple {
            background-color: #9d60ff
        }

        .bg-lightred {
            background-color: #ff5722
        }

        .padding-15px-lr {
            padding-left: 15px;
            padding-right: 15px;
        }

        .padding-5px-tb {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .margin-10px-bottom {
            margin-bottom: 10px;
        }

        .border-radius-5 {
            border-radius: 5px;
        }

        .margin-10px-top {
            margin-top: 10px;
        }

        .font-size14 {
            font-size: 14px;
        }

        .text-light-gray {
            color: #d6d5d5;
        }

        .font-size13 {
            font-size: 13px;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .table td,
        .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
    </style>
@endsection
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
                    <div class="row">
                        <div class="col-3">
                            {{-- <select class="form-control" name="board_id" >
                                <option value="X">Board 1</option>
                                <option value="X">Board 2</option>
                                <option value="X">Board 3</option>
                            </select> --}}
                        </div>
                        <div class="col-3">
                            <select class="form-control" name="course_id">
                                @foreach ($clasess as $class)
                                    <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            {{-- <select class="form-control" name="course_id" >
                                <option value="X">Course 1</option>
                                <option value="X">Course 2</option>
                                <option value="X">Course 3</option>
                            </select> --}}
                        </div>
                        <div class="col-3">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#ShowModal">Add New</button>
                        </div>
                    </div>


                    <div class="container">
                        <div class="timetable-img text-center">
                            <img src="img/content/timetable.png" alt="">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr class="bg-light-gray">

                                        <th class="text-uppercase">Monday</th>
                                        <th class="text-uppercase">Tuesday</th>
                                        <th class="text-uppercase">Wednesday</th>
                                        <th class="text-uppercase">Thursday</th>
                                        <th class="text-uppercase">Friday</th>
                                        <th class="text-uppercase">Saturday</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($schedulesByDay as $day => $schedules)
                                        <tr>

                                            @foreach ($daysOfWeek as $weekDay)
                                                <td>

                                                    @foreach ($schedules as $schedule)
                                                        @if ($weekDay === Carbon\Carbon::parse($schedule->date)->format('l'))
                                                            <div
                                                                class="{{ $weekDay == "Tuesday" ? 'bg-sky' : 'bg-green' }} padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">
                                                                {{ $schedule->course_name }}<br>
                                                            </div>
                                                            <div class="margin-10px-top font-size14">
                                                                {{ Carbon\Carbon::parse($schedule->time)->format('h:i A') }}
                                                            </div>
                                                            <div class="margin-10px-top font-size14">
                                                                {{ $schedule->class_name }}
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>



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



    <!-- Show Modal-->
    <div class="modal fade" id="ShowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="post">

                    @csrf
                    <div class="modal-body">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Course Name</label>
                            </div>
                            <input type="text" class="form-control" name="course_name" placeholder="Enter course Name">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Select Date</label>
                            </div>
                            <input type="date" class="form-control" name="date" placeholder="Enter course Name">
                            <input type="time" class="form-control" name="time" placeholder="Enter course Name">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Board</label>
                            </div>
                            <select name="tboard_id" id="" class="form-control">
                                <option value="">---Select Course----</option>
                                @foreach ($boards as $board)
                                    <option value="{{ $board->id }}">{{ $board->board_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Class</label>
                            </div>
                            <select name="tclass_id" id="" class="form-control">
                                <option value="">---Select Course----</option>
                                @foreach ($clasess as $class)
                                    <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Course</label>
                            </div>
                            <select name="tcourse_id" class="form-control">
                                <option value="0">---Select Course----</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit" id="continue">create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




@endsection
