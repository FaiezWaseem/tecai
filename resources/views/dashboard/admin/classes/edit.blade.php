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
                    <h1 class="m-0">EDIT CLASS</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('schooladmin.home.view') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">Class</li>
                        <li class="breadcrumb-item active">Edit</li>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtUserName">Class Name <span class="text-danger">*</span></label>
                            <input type="text" name="class_name" class="form-control" id="txtUserName"
                                placeholder="Enter Class Name" maxlength="255" value="{{ $class->class_name }}">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>

                </div>
                <div>

                    <h3>Select Courses</h3>
                    <ul>

                        @foreach ($courses as $item)
                            <li>
                                @php
                                    $isSelected = false;
                                    foreach ($selectedCourses as $sitem) {
                                        if ($sitem->course_id == $item->id) {
                                            $isSelected = true;
                                            break;
                                        }
                                    }
                                @endphp

                                <input class="form-check-input" type="checkbox" id="switch{{ $item->id }}"
                                    onchange="handleCheckboxChange({{ $item->id }})"
                                    @if ($isSelected) checked @endif>
                                <label>{{ $item->course_name }}</label>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-11">
                        <input type="submit" value="CREATE" class="btn btn-success">
            </form>
        </div>
        <button class="btn btn-danger" onclick="window.location.back()">CANCEL</button>
        </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


@section('footer')
    <script>
        function handleCheckboxChange(courseId) {
            var checkbox = $('#switch' + courseId);
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            console.log(checkbox)
            const isChecked = checkbox.is(':checked');
            console.log(isChecked, courseId)


            // Checkbox is checked, send the AJAX request
            $.ajax({
                url: window.location.href, // Replace with your actual route URL
                type: 'PUT', // Or 'GET' depending on your server-side implementation
                data: {
                    isChecked,
                    courseId,
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
