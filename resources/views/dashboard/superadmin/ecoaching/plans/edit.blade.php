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
                    <h1 class="m-0">EDIT PLAN</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('superadmin.home.view') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">Edit</li>
                        <li class="breadcrumb-item">Plan</li>
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
            <form method="POST">
                @method('POST')
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Plan Name <span class="text-danger">*</span></label>
                            <input type="text" name="plan_name" class="form-control" id="txtUserName"
                                placeholder="Enter Plan Name" value="{{ $ePlan->plan_name }}" maxlength="255">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Plan Details <span class="text-danger">*</span></label>
                            <input type="text" name="plan_details" class="form-control" id="txtUserName"
                                placeholder="Enter Plan Details" value="{{ $ePlan->plan_details }}" maxlength="255">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Plan Price <span class="text-danger">*</span></label>
                            <input type="text" name="plan_price" class="form-control" id="txtUserName"
                                placeholder="Enter Plan Price" value="{{ $ePlan->plan_price }}" maxlength="255">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
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

        <div class="row my-3">
            <div class="col-8">
                <h3>Add Courses To Plan</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="txtUserName">Board <span class="text-danger">*</span></label>
                    <select name="tboard_id" class="form-control" id="tboard_id">
                        @foreach ($boards as $item)
                            <option value="{{ $item->id }}"> {{ $item->board_name }} </option>
                        @endforeach
                    </select>
                    <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="txtUserName">Course <span class="text-danger">*</span></label>
                    <select name="tboard_id" class="form-control" id="tcourse_id">
                        @foreach ($courses as $item)
                            <option value="{{ $item->id }}"> {{ $item->course_name }} </option>
                        @endforeach
                    </select>
                    <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-center align-items-center">
                <button class="btn btn-warning" onclick="AddCourse()">Add</button>
            </div>
        </div>
        <div class="row">
            <table class="table bg-white shadow-md table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Board</th>
                        <th>Course</th>
                    </tr>
                </thead>
                <tbody id="course_list">
                    @foreach ($plan_courses as $item)
                    <tr>
                        <td>{{ $item->board_name }}</td>
                        <td>{{ $item->course_name }}</td>
                    </tr>
                    @endforeach


                </tbody>
                <tfoot>
                    <tr>
                        <th>Board</th>
                        <th>Course</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


@section('footer')
    <script>
        function AddCourse() {
            const tboard_id = $('#tboard_id').val();
            const tcourse_id = $('#tcourse_id').val();
            console.log('add course', tboard_id, tcourse_id);

            $.ajax({
                url: "{{ route('e-learning.plan.addCourse' , ['id' => $id]) }}",
                type: "POST",
                data: {
                    tboard_id: tboard_id,
                    tcourse_id: tcourse_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        showToast('Course Added Successfully' , '' ,'success');

                        $('#course_list').append(`<tr>
                            <td>${response.course.board_name}</td>
                            <td>${response.course.course_name}</td>
                            </tr>`);

                    }else if(response.status == 201){
                        showToast(response.success , '' ,'warning');
                    }
                }
            })
        }
    </script>
@endsection
