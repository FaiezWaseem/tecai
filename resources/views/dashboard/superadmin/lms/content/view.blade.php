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
            <form method="POST">
                @method('POST')
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Board <span class="text-danger">*</span></label>
                            <select name="tboard_id" class="form-control">
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
                            <select name="tclass_id" class="form-control">
                                <option value="0">--Select--</option>
                                @foreach ($classes as $item)
                                    <option value="{{ $item->id }}">{{ $item->class_name }}</option>
                                @endforeach
                            </select>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Subject <span class="text-danger">*</span></label>
                            <select name="tcourse_id" class="form-control">
                                <option value="0">--Select--</option>
                                @foreach ($courses as $item)
                                    <option value="{{ $item->id }}">{{ $item->course_name }}</option>
                                @endforeach
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
            <div class="row">
                <div class="col-xs-12 col-sm-9">
                    <ul class="list-inline footer-action">
                        <li class="list-inline-item">
                            <a class="btn btn-small btn-outline-primary btn-2" id="check-all"><i
                                    class="fa fa-check-square"></i> Select all </a>
                        </li>
                        <li class="list-inline-item"><a class="btn btn-small btn-outline-primary btn-2" id="uncheck-all"><i
                                    class="fa fa-window-close"></i> Unselect all </a></li>

                        <li class="list-inline-item">
                            <a id="delete" class="btn btn-small btn-outline-primary btn-2"><i class="fa fa-trash"></i>
                                Delete </a>
                        </li>
                        <li class="list-inline-item">
                            <a id="copy" class="btn btn-small btn-outline-primary btn-2"><i class="fa fa-files-o"></i>
                                Copy </a>
                        </li>
                    </ul>
                </div>
                <div class="col-3 d-none d-sm-block"><a target="_blank" class="float-right text-muted">Quick Options</a>
                </div>
            </div>
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
                                <th><input type="checkbox" id="select-all"></th>
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
                                    <td><input type="checkbox" class="row-select"></td>
                                    <td>
                                        <a href="{{ route('preview.file', ['id' => $item->id]) }}">
                                            <i class="fa fa-eye text-success"></i>
                                        </a>
                                        {{-- <a href="{{ Storage::disk('local')->temporaryUrl($item->content_link, now()->addMinutes(120)) }}">
                                        <i class="fa fa-eye text-success"  ></i>
                                    </a> --}}
                                        <a href="{{ route('superadmin.lms.content.edit', ['id' => $item->id]) }}">
                                            <i class="fa fa-edit text-primary"></i>
                                        </a>
                                        <button class="btn" data-toggle="modal" data-target="#DeleteModal"
                                            onclick="setdeleteModalId({{ $item->id }})">
                                            <i class="fa fa-trash text-danger"></i>
                                        </button>
                                    </td>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        @if ($item->thumbnail)
                                            <img src="{{ Storage::disk('local')->temporaryUrl($item->thumbnail, now()->addMinutes(10)) }}"
                                                alt="thumbnail_image" loading='lazy' width="50px" height="50px">
                                        @endif
                                    </td>
                                    <td contenteditable="true">{{ $item->chapter_title }} </td>
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
                                <th><input type="checkbox" id="select-all"></th>
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
                    {{ $content->links() }}
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
        function getCheckedRows() {
            var checkedRows = [];
            $('#example1 .row-select:checked').each(function() {
                var rowData = $(this).closest('tr').find('td:not(:first-child)'); // Exclude the checkbox cell
                var rowInfo = Number(rowData.eq(1).text())
                checkedRows.push(rowInfo);
            });
            return checkedRows;
        }

        function checkAllRows(checked) {
            $('#example1 .row-select').each(function() {
                this.checked = checked;
            });
            $('#select-all').prop('checked', checked);
        }

        $('#check-all').on('click', function() {
            checkAllRows(true);
        });

        $('#uncheck-all').on('click', function() {
            checkAllRows(false);
        });
        $('#delete').on('click', function() {
            var checkedRows = getCheckedRows();
            console.log(checkedRows);

            const selectedOption = confirm('Are you sure you want to delete the selected rows?');

            if (selectedOption) {
                const ajaxRoute = "{{ route('superadmin.lms.content.bulk.delete') }}";
                console.log(ajaxRoute);

                $.ajax({
                    url: ajaxRoute, // Replace with your endpoint
                    type: 'DELETE',
                    data: {
                        ids: checkedRows // An array of IDs to delete
                    },
                    success: function(response) {
                        console.log(response.message);
                        window.location.reload();
                        // Handle success (e.g., refresh the table)
                    },
                    error: function(xhr) {
                        console.error(xhr.responseJSON.message);
                        // Handle error
                    }
                });
            }

            console.log(selectedOption)

        });
        $('#copy').on('click', function() {
            var checkedRows = getCheckedRows();
        });

        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


            // Handle select all checkbox
            $('#select-all').on('click', function() {
                var checked = this.checked;
                $('#example1 .row-select').each(function() {
                    this.checked = checked;
                });
            });

            // Handle individual checkbox click to manage the select all checkbox
            $('#example1 tbody').on('change', '.row-select', function() {
                if (!this.checked) {
                    $('#select-all').prop('checked', false);
                }
                if ($('#example1 .row-select:checked').length === $('#example1 .row-select').length) {
                    $('#select-all').prop('checked', true);
                }
            });

        });
    </script>
@endsection
