@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.superadmin.sidebar')
    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ADD NEW CONTENT</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('superadmin.home.view') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">LMS</li>
                        <li class="breadcrumb-item">Content</li>
                        <li class="breadcrumb-item active">Create</li>
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
                @method('POST')
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
                            <input type="text" name="content_link" id="content_link" style="display: none;">
                            <input type="button" id="browseFile" class="btn btn-primary" value="Select file">
                            <div style="display: none" class="progress mt-3" style="height: 25px">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                    style="width: 75%; height: 100%">75%</div>
                            </div>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>


                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Content Type <span class="text-danger">*</span></label>
                            <select name="content_type" class="form-control" id="content_type" >
                                <option value="0">--Select--</option>
                                <option value="Video">Video</option>
                                <option value="Pdf">Pdf</option>
                                <option value="Flash">Flash</option>
                                <option value="GIF">GIF</option>
                                <option value="Ppt">PowerPoint</option>
                                <option value="Web">Web</option>
                                <option value="Vimeo">Vimeo</option>
                            </select>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Board <span class="text-danger">*</span></label>
                            <select  id="subjects" name="boards[]" class="form-control selectpicker"
                                required multiple data-live-search="true">
                                @foreach ($boards as $item)
                                    <option value="{{ $item->id }}"> {{ $item->board_name }} </option>
                                @endforeach
                            </select>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Class <span class="text-danger">*</span></label>
                            <select name="tclass_id" class="form-control" id="class" >
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
                            <select name="tcourse_id" class="form-control" id="course">
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
                            <label for="txtUserName">Chapter <span class="text-danger">*</span></label>
                            <select name="tchapter_id" class="form-control" id="chapters">
                            </select>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Title <span class="text-danger">*</span></label>
                            <input type="text" name="content_title" class="form-control">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script>
        function validateFileSize(input) {
            if (input.files && input.files[0]) {
                var fileSize = input.files[0].size; // Size in bytes
                var maxSize = 51 * 1024 * 1024; // 50MB in bytes

                if (fileSize > maxSize) {
                    input.value = ''; // Clear the selected file
                    showToast('File size exceeds the limit of 50MB. Please choose a smaller file.')
                }
            }
        }
        $('#content_type').change(function() {
            const selectedValue = $(this).val();
            console.log(selectedValue)
            if(selectedValue == "Vimeo"){
                $('#browseFile').hide();
                $('#content_link').show();
            }else{
                $('#browseFile').show();
                // $('#content_link').val(response.filename)
                $('#content_link').hide();
            }
        })

        $('#course').change(function() {
            // Get the selected option value
            const selectedValue = $(this).val();
            const class_id = $('#class').val();

            // Get the CSRF token value from the <meta> tag
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            
            console.log(class_id ,selectedValue, csrfToken)


            $.ajax({
                url: '{{ route('superadmin.lms.filter.chapter') }}', // Current page URL
                type: 'POST', // or 'GET', 'PUT', etc. depending on your needs
                data: {
                    _token: csrfToken, // Include the CSRF token in the request data
                    course_id: selectedValue,
                    class_id,
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
    <script type="text/javascript">
        let browseFile = $('#browseFile');
        let resumable = new Resumable({
            target: '{{ route('upload.large.file') }}',
            query: {
                _token: '{{ csrf_token() }}'
            }, // CSRF token
            fileType: ["png", "jpg", "jpeg", "gif", "pdf", "mp4", "zip", "rar", "swf", "ppt", "pptx"],
            chunkSize: 2 * 1024 *
                1024, // default is 1*1024*1024, this should be less than your maximum limit in php.ini
            headers: {
                'Accept': 'application/json'
            },
            testChunks: false,
            throttleProgressCallbacks: 1,
        });

        resumable.assignBrowse(browseFile[0]);

        resumable.on('fileAdded', function(file) {
            showProgress();
            resumable.upload()
        });

        resumable.on('fileProgress', function(file) { // trigger when file progress update
            updateProgress(Math.floor(file.progress() * 100));
        });

        resumable.on('fileSuccess', function(file, response) { // trigger when file upload complete
            response = JSON.parse(response)
            console.log(response)
            $('#content_link').val(response.filename)
            $('.card-footer').show();
        });

        resumable.on('fileError', function(file, response) { // trigger when there is any error
            alert('file uploading error.')
        });


        let progress = $('.progress');

        function showProgress() {
            progress.find('.progress-bar').css('width', '0%');
            progress.find('.progress-bar').html('0%');
            progress.find('.progress-bar').removeClass('bg-success');
            progress.show();
        }

        function updateProgress(value) {
            progress.find('.progress-bar').css('width', `${value}%`)
            progress.find('.progress-bar').html(`${value}%`)
        }

        function hideProgress() {
            progress.hide();
        }
    </script>
   
    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker();
            $('.selectpicker-classes').selectpicker();

            $('#submitForm').submit(function(event) {
                // Prevent the default form submission
                event.preventDefault();
                showLoader();
                event.target.submit();
        
            });

        });

       
    </script>
@endsection
