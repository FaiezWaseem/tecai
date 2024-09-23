@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.superadmin.sidebar')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">School Schools View</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Schools</li>
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
            <!-- Small boxes (Stat box) -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Schools</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>LMS Permissions</th>
                                <th>School Logo</th>
                                <th>School Banner</th>
                                <th>School Name</th>
                                <th>School Prefix</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($schools as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('superadmin.schools.edit', ['id' => $item->id]) }}">
                                            <i class="fa fa-edit text-primary"></i>
                                        </a>
                                        <button class="btn" data-toggle="modal" data-target="#DeleteModal"
                                            onclick="setdeleteModalId({{ $item->id }})">
                                            <i class="fa fa-trash text-danger"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <a href="{{ route('superadmin.school.permissions.view', ['id' => $item->id]) }}">
                                            <i class="fa fa-edit text-primary"></i>
                                            Permissions
                                        </a>
                                    </td>
                                    <td>
                                        @if ($item->logo)
                                            <img src="{{ Storage::disk('local')->temporaryUrl($item->logo, now()->addMinutes(3)) }}"
                                                alt="thumbnail_image" loading='lazy' width="50px" height="50px">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->banner)
                                            <img src="{{ Storage::disk('local')->temporaryUrl($item->banner, now()->addMinutes(3)) }}"
                                                alt="thumbnail_image" loading='lazy' width="50px" height="50px">
                                        @endif
                                    </td>
                                    <td>{{ $item->school_name }}</td> 
                                    <td>{{ $item->prefix }}</td> 
                                    <td>{{ $item->created_at }}</td>
                                
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Actions</th>
                                <th>LMS Permissions</th>
                                <th>School Logo</th>
                                <th>School Banner</th>
                                <th>School Name</th>
                                <th>School Prefix</th>
                                <th>Created At</th>
                      
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
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
