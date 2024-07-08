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
                    <h1 class="m-0">Assignment Grade View</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Student</li>
                        <li class="breadcrumb-item">Assignment</li>
                        <li class="breadcrumb-item">Grade</li>
                        <li class="breadcrumb-item active">Views</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
 
   
    <!-- Main content -->
    <section class="content">
     
        <div class="container-fluid">
         
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">CONTENT</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Obtained</th>
                                <th>Total</th>
                                <th>Attempted</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                              $index =0;    
                            @endphp
                            
                            @foreach ($marks as $item)
                            
                            <tr>

                                <td>{{ ++$index }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->obtained }}</td>
                                <td>{{ $item->total }}</td>
                                <td>{{ date('h:i A D/M/Y', strtotime($item->attempted_date)) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Obtained</th>
                                <th>Total</th>
                                <th>Attempted</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.row -->
            <!-- Main row -->

            <!-- /.row (main row) -->
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
                paging: true,
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });
    </script>
@endsection
