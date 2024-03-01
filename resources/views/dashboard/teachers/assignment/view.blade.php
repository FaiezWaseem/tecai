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
                    <h1 class="m-0">Teacher Assignment View</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('teacher.home.view') }}">Home</a></li>
                        <li class="breadcrumb-item">assignment</li>
                        <li class="breadcrumb-item active">Views</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6 mt-2">
                    <form action="{{ route('teacher.assignments.show.filter') }}"
                        class="d-flex justify-content-center align-items-center" method="POST">
                        @csrf
                        <div>
                            <select name="class" id="school" class="form-control">
                                <option value="">Select a Class</option>
                                @foreach ($classes as $filter)
                                    <option value="{{ $filter->class_id }}">{{ $filter->class_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select name="course" id="school" class="form-control">
                                <option value="">Select a Course</option>
                                @foreach ($courses as $filter)
                                    <option value="{{ $filter->id }}">{{ $filter->course_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>
            </div>

            @foreach ($activities as $activity)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Title : {{ $activity->title }}</h6>
                        <h6 class="m-0 text-secondary">Class : {{ $activity->class_name }}</h6>
                        <h6 class="m-0 text-secondary">Subject : {{ $activity->course_name }}</h6>
                        <h6 class="m-0 text-black">Chapter : {{ $activity->chapter }}</h6>
                        <h6 class="m-0 text-secondary">Topic : {{ $activity->topic }}</h6>
                        <h6 class="m-0 text-secondary">deadline : <?php
                        $dateTime = new DateTime($activity->deadline);
                        $formattedDate = $dateTime->format('l g:i a Y');
                        echo $formattedDate;
                        echo ' - ' . $activity->deadline;
                        ?></h6>
                        <h6 class="m-0 text-secondary">Created At :
                            <?php
                            $dateTime = new DateTime($activity->created_at);
                            $formattedDate = $dateTime->format('l g:i a Y');
                            echo $formattedDate; ?>
                        </h6>
                        <a href="{{ route('teacher.assignment.view', ['id' => $activity->id, 'teacher' => true]) }}"
                            class="btn btn-primary btn-sm float-right">

                            View
                            <i class="fas fa-eye"></i>
                        </a>
                        <button class="btn btn-outline-danger" data-toggle="modal" data-target="#DeleteModal"
                            onclick="setdeleteModalId({{ $activity->id }})">
                            <i class="fa fa-trash text-danger"></i>
                        </button>
                    </div>
                </div>
            @endforeach


            {{ $activities->links() }}



        </div>
    </section>
    <!-- /.content -->
@endsection


@section('footer')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });
    </script>
@endsection
