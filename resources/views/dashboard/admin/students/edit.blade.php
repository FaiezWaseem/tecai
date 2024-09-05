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
                    <h1 class="m-0">UPDATE NEW STUDENT</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('schooladmin.home.view') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">Student</li>
                        <li class="breadcrumb-item active">edit</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="POST" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Student Image </label>
                            <input accept=".png, .jpg, .jpeg, .gif" class="form-control" name="thumbnail" type="file"
                                value="">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Student Name </label>
                            <input type="text" name="name" value="{{ $student->name }}" class="form-control"
                                id="txtUserName" placeholder="Enter Student Name" maxlength="50">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Father Name </label>
                            <input type="text" name="father_name" value="{{ $student->father_name }}"
                                class="form-control" id="txtUserName" placeholder="Enter Father Name" maxlength="50">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Admission No </label>
                            <input type="number" name="admission_no" value="{{ $student->admission_no }}"
                                class="form-control" id="txtUserName" placeholder="Enter Admission No">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Group </label>
                            <input type="text" name="group" value="{{ $student->group }}" class="form-control"
                                id="txtUserName" placeholder="Enter Group Name">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">DOB <span class="text-danger">*</span></label>
                            <input type="date" name="dob" value="{{ $student->dob }}" class="form-control"
                                id="txtUserName" placeholder="Select Date of Birth">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Contact <span class="text-danger">* (+92311-xxxxx)</span></label>
                            <input type="text" name="contact" value="{{ $student->contact }}" class="form-control"
                                id="txtUserName" placeholder="Enter Contact details">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ $student->email }}" class="form-control"
                                id="txtUserName" placeholder="Enter Email">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Gender <span class="text-danger">*</span></label>
                            <select class="form-control" name="gender" value="{{ $student->gender }}">
                                <option value="male">MALE</option>
                                <option value="female">FEMALE</option>
                            </select>

                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtPassword">New Password </label>
                            <input type="text" name="password" class="form-control" id="txtPassword"
                                placeholder="Enter new Password" maxlength="50">
                            <span id="txtPassword_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Class </label>
                            <input type="text" name="class" value="{{ $student->class }}" class="form-control" id="txtPassword"
                                placeholder="Enter Class" maxlength="50">

                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Sec <span class="text-danger">*</span></label>
                            <input type="text" name="section" value="{{ $student->section }}" class="form-control" id="txtPassword"
                                placeholder="Enter Section" maxlength="50">

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
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
