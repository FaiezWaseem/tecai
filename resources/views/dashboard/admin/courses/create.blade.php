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
                    <h1 class="m-0">CREATE COURSE</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('schooladmin.home.view') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">Course</li>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtUserName">Course Name <span class="text-danger">*</span></label>
                            <input type="text" name="course_name" class="form-control" id="txtUserName" placeholder="Enter Course Name"
                                maxlength="255">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">School <span class="text-danger">*</span></label>
                            <select class="form-control" name="school_id" >
                                @foreach ($schools as $item)
                                <option value="{{ $item->id }}">{{  $item->school_name }}</option>
                                    
                                @endforeach
                            </select>

                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-11">
                        <input type="submit" value="CREATE" class="btn btn-success">
                    </form>
                </div>
                <button class="btn btn-danger" onclick="window.location.back()" >CANCEL</button>
                </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
