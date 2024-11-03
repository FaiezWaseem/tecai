        @extends('dashboard.common')

        @section('sidebar')
            @include('dashboard.superadmin.sidebar')
            <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
        @endsection

        @section('content')
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">ADD NEW Question</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('superadmin.home.view') }}">Home</a></li>
                                <li class="breadcrumb-item">CBTS</li>
                                <li class="breadcrumb-item">Question Bank</li>
                                <li class="breadcrumb-item active">Create</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <form id="importForm" method="POST" enctype="multipart/form-data" action="">
                    @method('PUT')
            
                    @csrf
                        
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="school">School <span class="text-danger">*</span></label>
                                    <input type="hidden" name="school_id" value="{{ $schools->id ?? '' }}">
                                    <input type="text" class="form-control" name="school_name" value="{{ $schools->school_name ?? '' }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="cboard_id">Board <span class="text-danger">*</span></label>
                                    <input type="hidden" name="cboard_id" required value="{{ $boards->id }}" readonly>
                                    <input type="text" class="form-control" name="board_name" required value="{{ $boards->board_name }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="cclass_id">Class <span class="text-danger">*</span></label>
                                    <input type="hidden" name="cclass_id" required value="{{ $classes->id }}" readonly>
                                    <input type="text" class="form-control" name="course_name" required value="{{ $classes->class_name }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="ccourse_id">Course <span class="text-danger">*</span></label>
                                    <input type="hidden" name="ccourse_id" required value="{{ $courses->id }}" readonly>
                                    <input type="text" class="form-control" name="course_name" required value="{{ $courses->course_name }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="cchapter_id">Chapter <span class="text-danger">*</span></label>
                                    <input type="hidden" name="cchapter_id" required value="{{ $chapters->id }}" readonly>
                                    <input type="text" class="form-control" name="chapter_name" required value="{{ $chapters->chapter_title }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="cqtype_id">Question Type <span class="text-danger">*</span></label>
                                    <select name="cqtype_id" class="form-control" id="cqtype_id" required>
                                        <option value="">--Select--</option>
                                        <option value="mcqs">MCQs</option>
                                        <option value="fill_in_the_blanks">Fill in the blanks</option>
                                        <option value="true_false">True/False</option>
                                        <option value="single_line_answer">Single Line Answer</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
        <div class="form-group">
                <label for="question_file">Upload File:</label>
                <input type="file" class="form-control"  accept=".xlsx,.csv,.xls" name="file" id="question_file">
            </div>
        </div>

        <div class="row mt-4 mr-5">
            <div class="col-md-12"> 
                <a href="{{ route('download.mcqs') }}" class="btn btn-primary">Generate MCQS CSV</a>
            </div>
        </div>
        <div class="row mt-4 ">
            <div class="col-md-12"> 
                <a href="{{ route('download.questionbank') }}" class="btn btn-primary">Generate CSV</a>
            </div>
        </div>
                            <div id="answerContainer" class="col-md-12">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-11">
                                <input type="submit" value="ADD" class="btn btn-success">
                            </div>
                        </div>
                    </form>

                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Id</th>
                                    <th>School</th>
                                    <th>Board</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Chapter</th>
                                    <th>Question Type</th>
                                    <th>Question</th>
                                    <th>Mark</th>
                                    <th>Image</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($questionsbank as $item)
                                    <tr>
                                        <td>
                                            <a href="{{ route('superadmin.cbts.questionbank.edit', ['id' => $item->id, 'bank_id' => $item->bank_id]) }}">
                                                <i class="fa fa-edit text-primary"></i>
                                            </a>
                                            <button id="delete" data-id="{{$item->id }}" onclick="deleteClicked(this)" class="btn submit-button">
                                                <i class="fa fa-trash-alt" style="color : red;"></i>
                                            </button>
                                        </td>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->school_name }}</td>
                                        <td>{{ $item->board_name }}</td>
                                        <td>{{ $item->class_name }}</td>
                                        <td>{{ $item->course_name }}</td>
                                        <td>{{ $item->chapter_title }}</td>
                                        <td>{{ $item->cqtype }}</td>
                                        <td>{{ $item->cquestion }}</td>
                                        <td>{{ $item->mark }}</td>
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
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center">No questions available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Action</th>
                                    <th>Id</th>
                                    <th>School</th>
                                    <th>Board</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Chapter</th>
                                    <th>Question Type</th>
                                    <th>Question</th>
                                    <th>Mark</th>
                                    <th>Image</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                            </tfoot>
                        </table>

                        {{ $questionsbank->links() }} 
                    </div>
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
                

                function deleteClicked(e) {
                    var id = $(e).attr('data-id');
                    console.log(id)
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: window.location.href, 
                        method: 'DELETE',
                        data: {
                            id: id
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            showToast('Delete request', 'Delete request successful', 'success');
                        },
                        error: function(xhr, status, error) {
                            showToast('AJAX delete request error:', status, 'error');
                        }
                    });
                };

            </script>
        @endsection
