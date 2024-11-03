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
            <form method="POST" enctype="multipart/form-data" id="submitForm">
            @method('PUT')

                @csrf
                <div class="row">
                    <div class="col-md-2">
                    <div class="form-group">
    <label for="school">School <span class="text-danger">*</span></label>

    <!-- Hidden input to save the school ID -->
    <input type="hidden" 
           name="school" 
           value="{{ $schools->id ?? '' }}">

    <!-- Visible input to display the school name -->
    <input type="text" 
           class="form-control" 
           name="school_name" 
           value="{{ $schools->school_name ?? '' }}" 
           readonly>
           
    <span class="error invalid-feedback hide"></span>
</div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="cboard_id">Board <span class="text-danger">*</span></label>
                            <input  type="hidden"  name="cboard_id" required
                            value="{{ $boards->id }}" readonly>
                            <input type="text" class="form-control"  name="board_name" required
                            value="{{ $boards->board_name }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="txtUserName">Class <span class="text-danger">*</span></label>
                            <input type="hidden"  name="cclass_id" required
                            value="{{ $classes->id }}" readonly>
                            <input type="text" class="form-control"  name="course_name" required
                            value="{{ $classes->class_name }}" readonly>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="txtUserName">Course <span class="text-danger">*</span></label>
                            <input  type="hidden" name="ccourse_id" required
                            value="{{ $courses->id}}" readonly>
                            <input type="text" class="form-control" name="course_namae" required
                            value="{{ $courses->course_name}}" readonly>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="cchapter_id">Chapter <span class="text-danger">*</span></label>
                            <input type="hidden" name="cchapter_id" required
                            value="{{ $chapters->id}}" readonly>
                            <input type="text" class="form-control" name="chapter_name" required
                            value="{{ $chapters->chapter_title }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cquestion">Question <span class="text-danger">*</span></label>
                            <input type="text" name="cquestion" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-2">
                    <div class="form-group">
                        <label for="image">Upload Image:</label>
                        <input type="file" class="form-control" name="image" id="image" >
                    </div>
                </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="mark">Mark <span class="text-danger">*</span></label>
                            <input type="text" name="mark" class="form-control" required>
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
                    <div class="col-md-2" id="optionsContainer" style="display: none;">
                        <div class="form-group">
                            <label for="totalOptions">Total Options <span class="text-danger">*</span></label>
                            <select name="content_type" class="form-control" id="totalOptions" required>
                                <option value="">--Select--</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div id="answerContainer" class="col-md-12">
                        <!-- Dynamic answer inputs will be added here -->
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
                <a href="{{ route('superadmin.cbts.questionbank.edit', ['id' => $item->id,'bank_id' => $item->bank_id]) }}">
                    <i class="fa fa-edit text-primary"></i>
                </a>
                <button id="delete" data-id="{{$item->id }}"
                                                onclick="deleteClicked(this)" class="btn submit-button">
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
                                    <td>{{ $item->mark}}</td>

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
        <!-- Delete Confirmation Modal -->
<div class="modal fade" id="DeleteModal1" tabindex="-1" role="dialog" aria-labelledby="DeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="DeleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this question?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
            </div>
        </div>
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
                "info": false,
                "autoWidth": false,
                paging: false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });
        

    </script>
    <script>


        document.querySelector('#submitForm').addEventListener('submit', function(e) {
            e.preventDefault();
            showLoader(); 
            e.target.submit();
        });

        document.getElementById('cqtype_id').addEventListener('change', function() {
            const qtype = this.value;
            const optionsContainer = document.getElementById('optionsContainer');
            const answerContainer = document.getElementById('answerContainer');
            answerContainer.innerHTML = '';

            if (qtype === "mcqs") {
                optionsContainer.style.display = 'block';
            } else {
                optionsContainer.style.display = 'none';
                document.getElementById('totalOptions').value = 1;
            }
            if (qtype === "true_false") {
                answerContainer.innerHTML = `
                  <div class="form-check form-check-inline mb-5 text-lg">
                      <input type="radio" class="form-check-input" name="correct_answer" id="true_answer" value="true" required>
                      <label class="form-check-label font-weight-bold" for="true_answer">True</label>
                  </div>
                  <div class="form-check form-check-inline mb-5 text-lg ">
                      <input type="radio" class="form-check-input" name="correct_answer" id="false_answer" value="false" required>
                      <label class="form-check-label font-weight-bold" for="false_answer">False</label>
                  </div>
                `;
            } else if (qtype === "fill_in_the_blanks" || qtype === "single_line_answer") {
                answerContainer.innerHTML = `
                                  <div class="form-check form-check-inline w-100">

                    <label for="answer" >Your Answer <span class="text-danger">*</span></label>
                    <input type="text" name="answer" class="form-control w-25 ml-5" required>
                                      </div>

                    `;
            }
        });

        document.getElementById('totalOptions').addEventListener('change', function() {
            const qtype = document.getElementById('cqtype_id').value;
            const numberOfOptions = parseInt(this.value);
            const answerContainer = document.getElementById('answerContainer');
            answerContainer.innerHTML = '';

            if (qtype === "mcqs" && numberOfOptions > 0) {
                const row = document.createElement('div');
                row.className = 'row';
                for (let i = 1; i <= numberOfOptions; i++) {
                    const col = document.createElement('div');
                    col.className = 'col-md-4 mb-2';
                    col.innerHTML = `
                        <label for="answer${i}">Option ${i} <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="answer[]" class="form-control" id="answer${i}" placeholder="Option ${i}" required>
                            <div class="input-group-append" style="margin-left: -30px;">
                                <div class="form-check" style="margin-top: 5px;">
                                    <input type="radio" class="form-check-input" name="correct_answer" value="${i}" required>
                                </div>
                            </div>
                        </div>`;
                    row.appendChild(col);
                }
                answerContainer.appendChild(row);
            }
        });

        $(document).ready(function() {

            $('#classes').change(function() {
            const selectedValue = $(this).val();
            const classValue = $('#classes_id').val();
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            console.log(selectedValue, csrfToken)
            $.ajax({
                url: '{{ route('superadmin.cbts.filter.chapter') }}', 
                type: 'POST', 
                data: {
                    _token: csrfToken, 
                    course_id: selectedValue,
                    class_id: classValue

                },
                dataType: 'json', 
                success: function(data) {
                    console.log(data)
                    $('#chapters').html('');
                    $('#chapters').append('  <option value="0">--Select--</option>');
                    data.chapters.forEach(chapter => {
                        $('#chapters').append(
                            `   <option value="${chapter.id}">${chapter.chapter_title}</option>`
                        );
                    });


                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Failed to fetched Departments :  ERROR : ' + error)
                }
            });
        });
      
        });
    </script>


<script>
       

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
