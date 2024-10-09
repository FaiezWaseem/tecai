@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.admin.sidebar')
    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
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
                    <h1 class="m-0">Edit Exam</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('schooladmin.home.view') }}">Home</a></li>
                        <li class="breadcrumb-item">CBTS</li>
                        <li class="breadcrumb-item">Exam</li>
                        <li class="breadcrumb-item active">Edit</li>
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
                @method('PUT')

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="school">School <span class="text-danger">*</span></label>
                            <select name="school" id="schools" class="form-control" required checked disabled>
                                <option value="">--Select--</option>
                                @foreach ($schools as $item)
                                    <option value="{{ $item->id }}" {{ $exam->school_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->school_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="school_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ex_title">Title <span class="text-danger">*</span></label>
                            <input type="text" name="ex_title" class="form-control" value="{{ $exam->ex_title }}" required>
                            <span id="ex_title_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ex_board_id">Board <span class="text-danger">*</span></label>
                            <select name="ex_board_id" id="ex_board_id" class="form-control" required>
                                <option value="">--Select--</option>
                                @foreach ($boards as $item)
                                    <option value="{{ $item->id }}" {{ $exam->ex_board_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->board_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="ex_board_id_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ex_class_id">Class <span class="text-danger">*</span></label>
                            <select name="ex_class_id" id="classes" class="form-control" required checked disabled>
                                <option value="">--Select--</option>
                                @foreach ($classes as $item)
                                    <option value="{{ $item->id }}" {{ $exam->ex_class_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->class_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="ex_class_id_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ex_course_id">Course <span class="text-danger">*</span></label>
                            <select name="ex_course_id" id="courses" class="form-control" required disabled>
                                <option value="">--Select--</option>
                                @foreach ($courses as $item)
                                    <option value="{{ $item->id }}" {{ $exam->ex_course_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->course_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="ex_course_id_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="chapters">Chapters <span class="text-danger">*</span></label>
                            <div id="chapterList">
                                @foreach ($chapters as $chapter)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="chapters[]" value="{{ $chapter->id }}" id="chapter_{{ $chapter->id }}" checked disabled>
                                        <label class="form-check-label" for="chapter_{{ $chapter->id }}">{{ $chapter->chapter_title }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <span id="chapters_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ex_duration">Duration (Minutes) <span class="text-danger">*</span></label>
                            <input type="number" name="ex_duration" class="form-control" value="{{ $exam->ex_duration }}" required>
                            <span id="ex_duration_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ex_start_date">Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="ex_start_date" class="form-control" value="{{ $exam->ex_start_date }}" required>
                            <span id="ex_start_date_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ex_end_date">End Date <span class="text-danger">*</span></label>
                            <input type="date" name="ex_end_date" class="form-control" value="{{ $exam->ex_end_date }}" required>
                            <span id="ex_end_date_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ex_pass_mark">Pass Mark <span class="text-danger">*</span></label>
                            <input type="number" name="ex_pass_mark" class="form-control" value="{{ $exam->ex_pass_mark }}" required>
                            <span id="ex_pass_mark_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ex_instraction">Instruction <span class="text-danger">*</span></label>
                            <input type="text" name="ex_instraction" class="form-control" value="{{ $exam->ex_instraction }}" required>
                            <span id="ex_instruction_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ex_total_question">Total Questions <span class="text-danger">*</span></label>
                            <input type="number" name="ex_total_question" class="form-control" value="{{ $exam->ex_total_question }}" required readonly>
                            <span id="ex_total_question_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-11">
                        <input type="submit" value="UPDATE" class="btn btn-success">
                    </div>
                    <button type="button" class="btn btn-danger" onclick="window.location.back()">CANCEL</button>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('footer')
<script>
    $(document).ready(function() {
        $('#schools').change(function() {
            const selectedSchoolId = $(this).val();
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            $('#classes').html('<option value="">--Select Class--</option>');
            $('#chapterList').empty();
            $('#submitForm')[0].reset();

            if (selectedSchoolId) {
                $.ajax({
                    url: '{{ route('superadmin.cbts.filter.classes') }}',
                    type: 'POST',
                    data: { _token: csrfToken, school_id: selectedSchoolId },
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
            }
        });

        $('#courses').change(function() {
            const selectedClassId = $('#classes').val();
            const selectedCourseId = $(this).val();
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            $('#chapterList').empty();

            if (!selectedCourseId || !selectedClassId) {
                $('#chapterList').html('<option value="0">--Select--</option>');
                return;
            }

            $.ajax({
                url: '{{ route('superadmin.cbts.filter.chapter') }}',
                type: 'POST',
                data: { _token: csrfToken, course_id: selectedCourseId, class_id: selectedClassId },
                dataType: 'json',
                success: function(data) {
                    if (data.chapters && data.chapters.length) {
                        data.chapters.forEach(chapter => {
                            $('#chapterList').append(
                                `<div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="chapters[]" value="${chapter.id}" id="chapter_${chapter.id}">
                                    <label class="form-check-label" for="chapter_${chapter.id}">${chapter.chapter_title}</label>
                                </div>`
                            );
                        });
                    } else {
                        alert('No chapters found for the selected course and class.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Failed to fetch chapters: ERROR: ' + error);
                }
            });
        });

        document.querySelector('#submitForm').addEventListener('submit', function(e) {
            const selectedChapters = document.querySelectorAll('input[name="chapters[]"]:checked');
            if (selectedChapters.length === 0) {
                e.preventDefault();
                alert('Please select at least one chapter before submitting the form.');
                return;
            }
            showLoader();
            e.target.submit();
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
