@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.admin.sidebar')
@endsection

@section('content')
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">EDIT TEACHER</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('schooladmin.home.view') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">Teacher</li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section>
        <div class="container-fluid">




            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 ">
                    <h6 class="m-0 font-weight-bold text-primary">Teachers</h6>
                </div>
                <div class="card-body" id="form-list">

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="staticEmail" name="teacher_name" required
                                value="{{ $teacher->name }}" readonly>
                        </div>
                    </div>

                    <form method="POST" id="my-form">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-5 form-group">
                                <label for="subjects">Classes</label>
                                <select id="classes" name="classes[]" class="form-control selectpicker-classes"
                                    data-live-search="true" required>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}"
                                            {{ in_array($class->id, $classes_taken) ? 'selected' : '' }}>
                                            {{ $class->class_name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-5 form-group">
                                <label for="subjects">Subjects</label>
                                <select id="subjects" name="subjects[]" class="form-control selectpicker" required multiple
                                    data-live-search="true">
                                    @foreach ($courses as $subject)
                                        <option value="{{ $subject->id }}"
                                            {{ in_array($subject->id, $courses_id) ? 'selected' : '' }}>
                                            {{ $subject->course_name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <input type="submit" value="Add" class="btn btn-primary">
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody id="courses">

                                @foreach ($courses_all as $course)
                                    <tr>
                                        <td>{{ $course->id }}</td>
                                        <td>{{ $course->class_name }} </td>
                                        <td> {{ $course->course_name }} </td>
                                        <td>

                                            <button id="delete" data-id="{{ $course->id }}"
                                                onclick="deleteClicked(this)" class="btn submit-button">
                                                <i class="fa fa-trash-alt" style="color : red;"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>


                </div>
            </div>




        </div>
    </section>
@endsection



@section('footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker();
            $('.selectpicker-classes').selectpicker();

            $('#my-form').submit(function(event) {
                // Prevent the default form submission
                event.preventDefault();

                // Get the form data
                var formData = $(this).serialize();

                // Make an AJAX POST request to the server
                $.ajax({
                    url: window.location.href, // Replace with the actual server URL
                    method: 'POST',
                    data: formData,
                    success: function(response) {

                        console.log(response)

                        showToast('Update', 'Information Updated', 'success')

                        $('#courses').empty();

                        // Loop through the 'coursesData' array and append <tr> elements
                        response.courses.forEach(function(course) {
                            var row = $('<tr>');
                            row.append('<td>' + course.id + '</td>');
                            row.append('<td>' + course.class_name + '</td>');
                            row.append('<td>' + course.course_name + '</td>');
                            row.append(`
                            <td>
                                <button id="delete" data-id="${course.id}" onclick="deleteClicked(this)" class="btn submit-button">
                                                    <i class="fa fa-trash-alt" style="color : red;"></i>
                                                </button>
                            </td>
                            `);
                            $('#courses').append(row);
                        });

                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.log('AJAX request error:', status, error);
                    }
                });
            });

        });

        function deleteClicked(e) {
            var id = $(e).attr('data-id');
            console.log(id)
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            // Send AJAX delete request
            $.ajax({
                url: window.location.href, // Replace with your actual delete endpoint
                method: 'DELETE',
                data: {
                    id: id
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    // Handle successful response
                    showToast('Delete request', 'Delete request successful', 'success');

                    // Optionally, you can remove the element from the DOM
                    $(e).closest('tr').remove();
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    showToast('AJAX delete request error:', status, 'error');
                }
            });
        };
    </script>
@endsection
