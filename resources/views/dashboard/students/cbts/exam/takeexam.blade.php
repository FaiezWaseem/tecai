@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.students.sidebar')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">CBTS Take Exam View</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">CBTS</li>
                        <li class="breadcrumb-item">Take Exam</li>
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
                <div class="card" style="border-radius: 10px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); background-color: #f9f9f9; margin: 20px;">
               
                <div class="card-header" style="background-color: #2196F3; color: white; padding: 15px; text-align: center;">
        <h3 class="card-title">Take Exam</h3>
    </div>
    
    <div class="row instructions" style="padding: 10px 20px;">
        <div class="col-12" style="color: #333; margin: 5px 0;">
            <i class="fa fa-exclamation-circle"></i> Please be aware of the following:
        </div>
        <div class="col-12" style="color: #333; margin: 5px 0;">
            <i class="fa fa-exclamation-circle"></i> Do not press the back button.
        </div>
    </div>
    
    <div class="row instructions" style="padding: 10px 20px; margin-top: 10px;">
        <div class="col-12" style="color: #333; margin: 5px 0;">
            <h4><i class="fa fa-book"></i> Exam Title:{{ $exams->ex_title }}</h4>
        </div>
        <div class="col-12" style="color: #333; margin: 5px 0;">
            <h4><i class="fa fa-info-circle"></i> Instructions:{{ $exams->ex_instraction }}</h4>
        </div>
    </div>                                                        

    <div class="card-body" style="text-align: center; padding: 20px;">
    <a href="{{ route('student.cbts.exam.startexam', ['exam_id' => $exams->id ,'start_time'=> date('Y-m-d H:i:s')       ] ) }}"
       style="background-color: #28a745; color: white; padding: 12px 20px; font-size: 18px; border-radius: 5px; text-decoration: none; transition: background-color 0.3s;"
       onmouseover="this.style.backgroundColor='#218838';"
       onmouseout="this.style.backgroundColor='#28a745';">
        Start Exam
    </a>
</div>


            <!-- /.row -->
            <!-- Main row -->
        </div><!-- /.container-fluid -->
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
                "info": false,
                "autoWidth": false,
                paging: false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
