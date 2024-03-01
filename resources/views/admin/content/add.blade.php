@extends('layout')
@section('title', 'Home Page')
@section('content')
<style>
    .error {
        font-size: 12px;
        color: red !important;
    }
</style>
<div class="container-fluid d-flex justify-content-center align-items-center flex-column">

    @if ($errors->any())
        <div class="card mb-2 border-left-warning bg-danger text-white">
            <div class="card-body">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="row" style="width: 100%; margin-top: 1%;">
        <div class="col-md-12">

            <div class=" card">

                <div class="card-header bg-primary d-flex justify-content-between">
                    <h3 class="card-title text-white">Create new Content</h3>
                    <div class="card-tools">

                    </div>
                </div>

                <div class="card-body">

                    <form enctype="multipart/form-data" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <p class="admission-form-title"><strong>Basic Information : </strong></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="txtStudentName"> Topic Title <span class="error">*</span></label>
                                    <input class="form-control" maxlength="50" name="topic_title" placeholder="Enter Topic title"
                                        required="required" type="text">
                                    <span id="txtStudentName_Error" class="error invalid-feedback hide"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="txtFatherName">Topic Description <span class="error">*
                                        </span></label>
                                    <input class="form-control" required name="topic_description"
                                        placeholder="Enter Topic Description" type="text" value="">
                                    <span id="txtFatherName_Error" class="error invalid-feedback hide"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lblGender">Content Type <span class="error">*</span></label>
                                    <select class="form-control" name="content_type" required>
                                        <option value="0">--Select--</option>
                                        <option value="Video">Video</option>
                                        <option value="Pdf">Pdf</option>
                                        <option value="Flash">Flash</option>
                                        <option value="Web">Web</option>
                                  
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="txtFatherName">Link <span class="error">*
                                        </span></label>
                                    <input class="form-control" required name="content_link"
                                        placeholder="Enter Content Link" type="text" value="">
                                    <span id="txtFatherName_Error" class="error invalid-feedback hide"></span>
                                </div>
                            </div>
                        </div>

               

                 
                        <div class="row mt-2">
                            <div class="col-md-12 col-sm-12">
                                <p class="admission-form-title"><strong>required:</strong></p>
                            </div>
                        </div>
                        <div class="row" id="roles">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lblGender">Board <span class="error">*</span></label>
                                    <select class="form-control" name="tboard_id" required>
                                        <option value="0">--Select--</option>
                                        @foreach ($boards as $role)
                                            <option value="{{ $role->id }}">{{ $role->board_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lblGender">Class<span class="error">*</span></label>
                                    <select class="form-control" name="tclass_id"  required>
                                        <option value="0">--Select--</option>
                                        @foreach ($classes as $role)
                                            <option value="{{ $role->id }}">{{ $role->class_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lblGender">Subject<span class="error">*</span></label>
                                    <select class="form-control" name="tcourse_id" id="classes"  required>
                                        <option value="0">--Select--</option>
                                        @foreach ($courses as $role)
                                        <option value="{{ $role->id }}">{{ $role->course_name }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lblGender">Chapter Title<span class="error">*</span></label>
                                    <select class="form-control" name="tchapter_id" id="chapters" required>
                                        <option value="-1">--Select--</option>

                                    </select>
                                </div>
                            </div>

                        </div>
                



                        <div class="row" style="float:right !important">
                            <input type="submit" value="CREATE" class="btn btn-primary">
                        </div>
                    </form>
                </div>


            </div>

        </div>

    </div>

</div>

@include('components.footer')
@endsection
@section('footer')
    <script>
        $('#classes').change(function() {
            // Get the selected option value
            const selectedValue = $(this).val();

            // Get the CSRF token value from the <meta> tag
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            console.log(selectedValue, csrfToken)


            $.ajax({
                url: '{{ route("admin.content.addnew.filter") }}' , // Current page URL
                type: 'POST', // or 'GET', 'PUT', etc. depending on your needs
                data: {
                    _token: csrfToken, // Include the CSRF token in the request data
                    course_id : selectedValue
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
    </script>
@endsection
