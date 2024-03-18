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
                    <h1 class="m-0">Attendance View</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Attendance</li>
                        <li class="breadcrumb-item active">Views</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <form  method="post" class="d-flex justify-content-start">
                        @csrf
                        @method('POST')
                        <input type="date" name="date" value="{{ $date ?? '' }}" class="form-control">
                       <input type="submit" value="filter" class="btn btn-primary">
                    </form>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-2">
                    <a  href="{{ route('schooladmin.attendance.create') }}" class="btn btn-primary">Add Attendance</a>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
          
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Attendance</h3>
                </div>
               
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Student</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($attendance as $item)
                                <tr>
                                    <td  >
                                        <a href="#">
                                        Edit
                                        </a>
                                    </td>
                                
                                    <td>{{ $item->name }}</td>
                                    <td
                                    style="color: {{ $item->status == 'present' ? 'green' : ($item->status == 'late' ? 'orange' : 'red') }};
                                    font-weight: bold;"
                                    >{{ $item->status }}</td>
                                    <td>{{ $item->date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Actions</th>
                                <th>Student</th>
                                <th>Status</th>
                                <th>Date</th>
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
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });
    </script>
@endsection
