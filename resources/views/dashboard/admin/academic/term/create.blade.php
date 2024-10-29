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
                    <h1 class="m-0">ADD TERM GRADING </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('schooladmin.home.view') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">Term</li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        @if ($errors->any())
            <div class="card mb-2 border-left-warning">
                <div class="card-body">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if (isset($schools))
            <div>
                <h1>Select A School</h1>
            </div>
            <div class="container-fluid d-flex">

                @foreach ($schools as $item)
                    <div class="card m-2 bg-image hover-zoom" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->school_name }}</h5>
                            <br>
                            <a href="{{ route('schooladmin.academic.term.create', ['school_id' => $item->id]) }}"
                                class="btn btn-primary">
                                Select</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="container-fluid">

                @csrf
                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Class <span class="text-danger">*</span></label>
                            <select name="class_id" id="class_id" class="form-control">
                                <option value="--select--">--Select--</option>
                                @foreach ($classes as $item)
                                    <option value="{{ $item->id }}">{{ $item->class_name }}</option>
                                @endforeach
                            </select>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Subject <span class="text-danger">*</span></label>
                            <select name="class_id" id="course_id" class="form-control">
                                <option value="--select--">--Select--</option>
                            </select>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>


                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" class="form-control" id="txtUserName"
                                placeholder="Enter Head ex : Final Term" maxlength="255">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Total Marks <span class="text-danger">*</span></label>
                            <input type="text" id="total" class="form-control" id="txtUserName"
                                placeholder="Enter Total Marks ex : 50" maxlength="255">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input id="add" value="ADD" class="btn btn-success">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12" >
                        <table class="table" >
                            <thead>
                                <tr>
                                    <th scope="col">Head</th>
                                    <th scope="col">Marks</th>
                                </tr>
                            </thead>
                            <tbody id="show_data" >

                            </tbody>
                        </table>


                    </div>

                </div>
            </div>
        @endif
    </section>





@endsection




@section('footer')
    <script>
        $(document).ready(function() {


            $('#class_id').change(function() {

                var class_id = $(this).val();
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                const ajaxUrl = `/dashboard/school_admin/academic/courses/${class_id}`
                console.log(class_id, ajaxUrl);

                $('#show_data').html('')



                $.ajax({
                    url: ajaxUrl,
                    type: 'GET',
                    // data: {
                    //     _token: csrfToken,
                    // },
                    dataType: 'json',
                    success: function(data) {
                        // Handle the response from the server

                        console.log(data)

                        $('#course_id').html('');
                        $('#course_id').append('  <option value="0">--Select--</option>');
                        data.courses.forEach(courses => {
                            $('#course_id').append(
                                `   <option value="${courses.id}">${courses.course_name}</option>`
                            );
                        });


                    },
                    error: function(xhr, status, error) {
                        // Handle any errors that occurred during the request
                        console.error(error);
                        alert('Failed to fetched Departments :  ERROR : ' + error)
                    }
                });

            })
            $('#add').click(function() {
                const urlParams = new URLSearchParams(window.location.search);
                const school_id = urlParams.get('school_id');

                const class_id = $('#class_id').val();
                const course_id = $('#course_id').val();
                const title = $('#title').val();
                const total = $('#total').val();
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Construct the URL using the retrieved school_id
                const url =
                    "{{ route('schooladmin.academic.create.term.heads', ['school_id' => ':school_id']) }}"
                    .replace(':school_id', school_id);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: csrfToken,
                        class_id: class_id,
                        course_id: course_id,
                        title: title,
                        total: total,
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    // dataType: 'json',
                    success: function(data) {
                        // Handle the response from the server
                        console.log(data);

                        // Clear the form fields
                        $('#title').val('');
                        $('#total').val('');


                        $('#show_data').append(`
                         <tr>
                                    <td>${data.academicYear.title}</td>
                                    <td>${data.academicYear.total}</td>
                                </tr>
                        `);
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors that occurred during the request
                        console.error(error);
                        alert('Failed to fetch Departments: ERROR: ' + error);
                    }
                });
            });



        })
    </script>
@endsection
