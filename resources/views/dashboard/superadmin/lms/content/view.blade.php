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
                    <h1 class="m-0">LMS Content View</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">LMS</li>
                        <li class="breadcrumb-item">Content</li>
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
                    <h3 class="card-title">CONTENT</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Id</th>
                                <th>Thumbnail</th>
                                <th>Chapter</th>
                                <th>Topic Title</th>
                                <th>Board</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Type</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($content as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('preview.file', ['id' => $item->id]) }}">
                                        <i class="fa fa-eye text-success"  ></i>
                                    </a>
                                    {{-- <a href="{{ Storage::disk('local')->temporaryUrl($item->content_link, now()->addMinutes(120)) }}">
                                        <i class="fa fa-eye text-success"  ></i>
                                    </a> --}}
                                    <a href="{{ route('superadmin.students.edit', ['id'=> $item->id]) }}">
                                        <i class="fa fa-edit text-primary"  ></i>
                                    </a>
                                    <button class="btn" data-toggle="modal" data-target="#DeleteModal" onclick="setdeleteModalId({{$item->id}})">
                                        <i class="fa fa-trash text-danger"  ></i>
                                    </button>
                                </td>
                                <td>{{ $item->id }}</td>
                                <td>
                                    @if ($item->thumbnail)
                                    <img src="{{ Storage::disk('local')->temporaryUrl($item->thumbnail, now()->addMinutes(3)) }}" alt="thumbnail_image" loading='lazy' width="50px" height="50px"> 
                                    @endif
                                </td>
                                <td contenteditable="true" >{{ $item->chapter_title }} </td>
                                <td>{{ $item->topic_title }} </td>
                                <td>{{ $item->board_name }} </td>
                                <td>{{ $item->class_name }} </td>
                                <td>{{ $item->course_name }} </td>
                                <td>{{ $item->content_type }} </td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Actions</th>
                                <th>Id</th>
                                <th>Thumbnail</th>
                                <th>Chapter</th>
                                <th>Topic Title</th>
                                <th>Board</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Type</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{$content->links() }}
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
                paging: false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });
    </script>
@endsection
