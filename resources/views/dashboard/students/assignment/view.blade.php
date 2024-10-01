@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.students.sidebar')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Student Assignment View</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('student.home.view') }}">Home</a></li>
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

     

            @foreach ($activities as $activity)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Title : {{ $activity->title }}</h6>
                        <h6 class="m-0 font-weight-bold text-primary">Course : {{ $activity->course_name }}</h6>
                        <h6 class="m-0 font-weight-bold text-primary">Teacher : {{ $activity->teacher_name }}</h6>
                       
                        <h6 class="m-0 text-secondary font-weight-bold">deadline : <?php
                        $dateTime = new DateTime($activity->deadline);
                        $formattedDate = $dateTime->format('l g:i a Y');
                        echo $formattedDate;
                        echo ' - ' . $activity->deadline;
                        ?></h6>
                        <h6 class="m-0 text-secondary font-weight-bold">Created At :
                            <?php
                            $dateTime = new DateTime($activity->created_at);
                            $formattedDate = $dateTime->format('l g:i a Y');
                            echo $formattedDate; ?>
                        </h6>
                        <a href="{{ route('student.assignment.view', ['id' => $activity->id, 'student' => true]) }}"
                            class="btn btn-primary btn-sm float-right">

                            View
                            <i class="fas fa-eye"></i>
                        </a>
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
