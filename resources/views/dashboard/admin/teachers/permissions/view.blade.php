@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.admin.sidebar')
@endsection

/**
* Renders the teacher permissions view page.
*
* Loops through boards, classes, and courses to display a checkbox for each course.
* The checkbox is checked if the teacher has permission for that course.
* Uses Blade template inheritance and includes.
* Handles form submission to update permissions via JavaScript.
*/
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Teacher LMS Permissions</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Teacher</li>
                        <li class="breadcrumb-item">Permission</li>
                        <li class="breadcrumb-item active">Views</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            @foreach ($boards as $item)
                <div class="row">
                    <h2> {{ $item->board_name }}</h2>
                </div>
                <div class="flex flex-col">
                    <ul>
                        @foreach ($classes as $class)
                            <li>
                                <label>{{ $class->class_name }}</label>

                                <ul>
                                    <div class="flex flex-col">
                                        <ul class="d-flex justify-content-between flex-wrap">
                                            @foreach ($courses as $course)
                                                @php
                                                    $hasPermission = false;
                                                    foreach ($permissions as $permission) {
                                                        if (
                                                            $permission->board_id === $item->id &&
                                                            $permission->class_id === $class->id &&
                                                            $permission->course_id === $course->id
                                                        ) {
                                                            $hasPermission = true;
                                                            break;
                                                        }
                                                    }
                                                @endphp

                                                <li>
                                                    @if ($hasPermission)
                                                        <input class="form-check-input" type="checkbox"
                                                            board-id="{{ $item->id }}" id="switch{{ $course->id }}"
                                                            checked
                                                            onchange="handleCheckboxChange( {{ $course->id }} ,{{ $class->id }} , {{ $item->id }})">
                                                        <label>{{ $course->course_name }}</label>
                                                    @else
                                                        <input class="form-check-input" type="checkbox"
                                                            board-id="{{ $item->id }}" id="switch{{ $course->id }}"
                                                            onchange="handleCheckboxChange( {{ $course->id }} ,{{ $class->id }} , {{ $item->id }})">
                                                        <label>{{ $course->course_name }}</label>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach


        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


@section('footer')
    <script>
        function handleCheckboxChange(courseId, classId, boardId) {
            var checkbox = $('#switch' + courseId);
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            console.log(checkbox)
            const isChecked = checkbox.is(':checked');


            // Checkbox is checked, send the AJAX request
            $.ajax({
                url: window.location.href, // Replace with your actual route URL
                type: 'PUT', // Or 'GET' depending on your server-side implementation
                data: {
                    isChecked,
                    courseId,
                    classId,
                    boardId
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    // Handle the response from the server
                    console.log(response);
                    showToast('Updated', '', 'success')
                },
                error: function(xhr) {
                    showToast('Error', xhr.responseText.toString(), 'error')
                    console.log('Error', xhr.responseText, 'error')

                }
            });

        }
    </script>
@endsection
