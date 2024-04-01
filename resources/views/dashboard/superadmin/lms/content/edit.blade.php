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
                    <h1 class="m-0">EDIT CONTENT</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('superadmin.home.view') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">LMS</li>
                        <li class="breadcrumb-item">Content</li>
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
            <form method="POST" enctype="multipart/form-data" id="submitForm">
                @method('PUT')
                @csrf
                <div class="row">


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtUserName">Content Thumbnail </label>
                            <input accept=".png, .jpg, .jpeg, .gif" class="form-control" name="thumbnail" type="file"
                                value="">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtUserName">Content File </label>
                            <input accept=".png, .jpg, .jpeg, .gif, .pdf, .mp4, .zip, .rar, .swf" class="form-control"
                                name="content_link" type="file" onchange="validateFileSize(this)" value="">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Content Type <span class="text-danger">*</span></label>
                            <select name="content_type" class="form-control">
                                <option value="0">--Select--</option>
                                <option value="Video" {{ $content->content_type === 'Video' ? 'selected' : '' }}>Video</option>
                                <option value="Pdf" {{ $content->content_type === 'Pdf' ? 'selected' : '' }}>Pdf</option>
                                <option value="Flash" {{ $content->content_type === 'Flash' ? 'selected' : '' }}>Flash</option>
                                <option value="GIF" {{ $content->content_type === 'GIF' ? 'selected' : '' }}>GIF</option>
                                <option value="Ppt" {{ $content->content_type === 'Ppt' ? 'selected' : '' }}>PowerPoint</option>
                                <option value="Web" {{ $content->content_type === 'Web' ? 'selected' : '' }}>Web</option>
                            </select>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Board </label>
                            <select name="tboard_id" class="form-control">
                                @foreach ($boards as $item)
                                    <option value="{{ $item->id }}"  {{  $content->tboard_id === $item->id ? 'selected' : '' }}> {{ $item->board_name }} </option>
                                @endforeach
                            </select>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Class </label>
                            <select name="tclass_id" class="form-control">
                                @foreach ($classes as $item)
                                    <option value="{{ $item->id }}"  {{  $content->tclass_id === $item->id ? 'selected' : '' }} > {{ $item->class_name }} </option>
                                @endforeach
                            </select>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Course  </label>
                            <select name="tcourse_id" class="form-control" id="classes">
                                <option value="-1"> --Select-- </option>
                                @foreach ($courses as $item)
                                    <option value="{{ $item->id }}" {{  $content->tcourse_id === $item->id ? 'selected' : '' }}> {{ $item->course_name }} </option>
                                @endforeach
                            </select>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Chapter </label>
                            <select name="tchapter_id" class="form-control" id="chapters">
                            </select>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Title  </label>
                            <input type="text" name="content_title" class="form-control" value="{{ $content->content_title }}" >
                            <span id="txtUserName_Error" class="error invalid-feedback hide"  ></span>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-11">
                        <input type="submit" value="UPDATE" class="btn btn-success">
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
        document.querySelector('#submitForm').addEventListener('submit', function(e) {
            e.preventDefault();
            showLoader();
            e.target.submit();
        });
    </script>
    <script>
        function validateFileSize(input) {
            if (input.files && input.files[0]) {
                var fileSize = input.files[0].size; // Size in bytes
                var maxSize = 15 * 1024 * 1024; // 15MB in bytes

                if (fileSize > maxSize) {
                    input.value = ''; // Clear the selected file
                    showToast('File size exceeds the limit of 15MB. Please choose a smaller file.')
                }
            }
        }
        $('#classes').change(function() {
            // Get the selected option value
            const selectedValue = $(this).val();

            // Get the CSRF token value from the <meta> tag
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            console.log(selectedValue, csrfToken)


            $.ajax({
                url: '{{ route('superadmin.lms.filter.chapter') }}', // Current page URL
                type: 'POST', // or 'GET', 'PUT', etc. depending on your needs
                data: {
                    _token: csrfToken, // Include the CSRF token in the request data
                    course_id: selectedValue
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
        $('#chapters').change(function() {
            // Get the selected option value
            const selectedValue = $(this).val();

            // Get the CSRF token value from the <meta> tag
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            console.log(selectedValue, csrfToken)


            $.ajax({
                url: '{{ route('superadmin.lms.filter.slo') }}', // Current page URL
                type: 'POST', // or 'GET', 'PUT', etc. depending on your needs
                data: {
                    _token: csrfToken, // Include the CSRF token in the request data
                    chapter_id: selectedValue
                },
                dataType: 'json', // Specify the expected response data type
                success: function(data) {
                    // Handle the response from the server

                    console.log(data)

                    $('#slo').html('');
                    $('#slo').append('  <option value="0">--Select--</option>');
                    data.slo.forEach(slo => {
                        $('#slo').append(
                            `   <option value="${slo.id}">${slo.topic_title}</option>`
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
    </script>
@endsection
