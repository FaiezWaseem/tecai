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
            <form method="POST" enctype="multipart/form-data" id="submitForm">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="school">School <span class="text-danger">*</span></label>
                            <select class="form-control" id="schools" name="school" required>
                                <option value="">--Select--</option>
                                @foreach ($schools as $item)
                                    <option value="{{ $item->id }}">{{ $item->school_name }}</option>
                                @endforeach
                            </select>
                            <span class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cboard_id">Board <span class="text-danger">*</span></label>
                            <select name="cboard_id" class="form-control" required>
                                @foreach ($boards as $item)
                                    <option value="{{ $item->id }}">{{ $item->board_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Class <span class="text-danger">*</span></label>
                            <select name="cclass_id" id="classes_id" class="form-control">
                            <option value="-1"> --Select-- </option>

                                @foreach ($classes as $item)
                                    <option value="{{ $item->id }}"> {{ $item->class_name }} </option>
                                @endforeach
                            </select>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Course <span class="text-danger">*</span></label>
                            <select name="ccourse_id" class="form-control" id="classes">
                                <option value="-1"> --Select-- </option>
                                @foreach ($courses as $item)
                                    <option value="{{ $item->id }}"> {{ $item->course_name }} </option>
                                @endforeach
                            </select>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cchapter_id">Chapter <span class="text-danger">*</span></label>
                            <select name="cchapter_id" class="form-control" id="chapters" required>
                                <option value="">--Select--</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cquestion">Question <span class="text-danger">*</span></label>
                            <input type="text" name="cquestion" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="image">Upload Image:</label>
                        <input type="file" class="form-control" name="image" id="image" required>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mark">Mark <span class="text-danger">*</span></label>
                            <input type="text" name="mark" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
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
                    <div class="col-md-4" id="optionsContainer" style="display: none;">
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
                        <input type="submit" value="CREATE" class="btn btn-success">
                    </div>
                    <button type="button" class="btn btn-danger" onclick="window.location.back()">CANCEL</button>
                </div>
            </form>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('footer')
    <script>
        document.querySelector('#submitForm').addEventListener('submit', function(e) {
            e.preventDefault();
            showLoader(); // Ensure this function is defined
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
                  <div class="form-check form-check-inline">
                      <input type="radio" class="form-check-input" name="correct_answer" id="true_answer" value="true" required>
                      <label class="form-check-label font-weight-bold" for="true_answer">True</label>
                  </div>
                  <div class="form-check form-check-inline">
                      <input type="radio" class="form-check-input" name="correct_answer" id="false_answer" value="false" required>
                      <label class="form-check-label font-weight-bold" for="false_answer">False</label>
                  </div>
                `;
            } else if (qtype === "fill_in_the_blanks" || qtype === "single_line_answer") {
                answerContainer.innerHTML = `
                    <label for="answer">Your Answer <span class="text-danger">*</span></label>
                    <input type="text" name="answer" class="form-control" required>`;
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
            // Get the selected option value
            const selectedValue = $(this).val();
            const classValue = $('#classes_id').val();



            // Get the CSRF token value from the <meta> tag
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            console.log(selectedValue, csrfToken)


            $.ajax({
                url: '{{ route('superadmin.cbts.filter.chapter') }}', // Current page URL
                type: 'POST', // or 'GET', 'PUT', etc. depending on your needs
                data: {
                    _token: csrfToken, // Include the CSRF token in the request data
                    course_id: selectedValue,
                    class_id: classValue

                },
                dataType: 'json', // Specify the expected response data type
                success: function(data) {
                    // Handle the response from the server

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
                    // Handle any errors that occurred during the request
                    console.error(error);
                    alert('Failed to fetched Departments :  ERROR : ' + error)
                }
            });
        });
      
        });
    </script>
@endsection
