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
                    <h1 class="m-0">CBTS QuestionBank View</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">CBTS</li>
                        <li class="breadcrumb-item">Question Bank</li>
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
            <form method="POST" >
                @method('POST')
                @csrf
                <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">School <span class="text-danger">*</span></label>
                            <select class="form-control" name="school" id="schools" >
                            <option value="0">--Select--</option>

                                @foreach ($schools as $item)
                                <option value="{{ $item->id }}">{{  $item->school_name }}</option>
                                    
                                @endforeach
                            </select>

                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                  
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Board <span class="text-danger">*</span></label>
                            <select name="cboard_id" class="form-control">
                                <option value="0">--Select--</option>
                                @foreach ($boards as $item)
                                <option value="{{ $item->id }}">{{ $item->board_name }}</option>
                                @endforeach
                            </select>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Class <span class="text-danger">*</span></label>
                            <select name="cclass_id"  id="classes" class="form-control">
                                <option value="0">--Select--</option>
                                
                            </select>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Subject <span class="text-danger">*</span></label>
                            <select name="ccourse_id"  id="courses"class="form-control">
                                <option value="0">--Select--</option>
                               
                            </select>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Action <span class="text-danger">*</span></label>
                            <input type="submit" name="submit" value="filter" class="form-control">
                        </div>
                    </div>
                </div>
            </form>
            <!-- Small boxes (Stat box) -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Question</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Id</th>
                                <th>School</th>
                                <th>Board</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Chapter</th>
                                <th>Question</th>
                                <th>Marks</th>
                                <th>Image</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
    @foreach ($questions as $item)
        <tr>
            <td>
                <a href="{{ route('superadmin.cbts.questionbank.edit', ['id' => $item->id]) }}">
                    <i class="fa fa-edit text-primary"></i>
                </a>
                <button class="btn" data-toggle="modal" data-target="#DeleteModal" onclick="setdeleteModalId({{ $item->id }})">
                    <i class="fa fa-trash text-danger"></i>
                </button>
            </td>
            <td>{{ $item->id }}</td>
            <td>{{ $item->school }} </td>
            <td>{{ $item->board_name }} </td>
            <td>{{ $item->class_name }} </td>
            <td>{{ $item->course_name }} </td>
            <td contenteditable="true">{{ $item->chapter_title }} </td>
            <td>{{ $item->cquestion }} </td>
            <td>{{ $item->mark }} </td>
            <td>
                @if ($item->image)
                    <img src="{{ asset('images/' . $item->image) }}" alt="Image" style="width: 100px; height: auto;">
                @else
                    No image
                @endif
            </td>
            <td>{{ $item->created_at }}</td>
            <td>{{ $item->updated_at }}</td>
        </tr>
    @endforeach
</tbody>

                        <tfoot>
                            <tr>
                            <th>Actions</th>
                                <th>Id</th>
                                <th>School</th>
                                <th>Board</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Chapter</th>
                                <th>Question</th>
                                <th>Marks</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $questions->links() }}
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
        $(document).ready(function() {
    $('#schools').change(function() {
        const selectedSchoolId = $(this).val(); 
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#classes').html('<option value="">--Select Class--</option>');
        $(this).val(selectedSchoolId); 
        if (selectedSchoolId) {
            $.ajax({
                url: '{{ route('superadmin.cbts.filter.classes') }}', 
                type: 'POST',
                data: {
                    _token: csrfToken,
                    school_id: selectedSchoolId 
                },
                dataType: 'json',
                success: function(data) {
                    if (data.classes && data.classes.length) {
                        data.classes.forEach(classItem => {
                            $('#classes').append(`<option value="${classItem.id}">${classItem.class_name}</option>`);
                        });
                    } else {
                        $('#classes').html('<option value="">No classes available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('Failed to fetch classes: ' + error);
                }
            });
            $.ajax({
                url: '{{ route('superadmin.cbts.filter.courses') }}', 
                type: 'POST',
                data: {
                    _token: csrfToken,
                    school_id: selectedSchoolId 
                },
                dataType: 'json',
                success: function(data) {
                    if (data.courses && data.courses.length) {
                        data.courses.forEach(coursesItem => {
                            $('#courses').append(`<option value="${coursesItem.id}">${coursesItem.course_name}</option>`);
                        });
                    } else {
                        $('#courses').html('<option value="">No courses available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('Failed to fetch courses: ' + error);
                }
            });
        }
    });
});

    </script>
@endsection
