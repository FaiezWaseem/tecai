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
                    <h1 class="m-0">ADD NEW STUDENT</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('superadmin.home.view') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">Student</li>
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
                            <label for="txtUserName">Student Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="txtUserName" placeholder="Enter Student Name"
                                maxlength="50">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Father Name <span class="text-danger">*</span></label>
                            <input type="text" name="father_name" class="form-control" id="txtUserName" placeholder="Enter Father Name"
                                maxlength="50">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Admission No <span class="text-danger">*</span></label>
                            <input type="number" name="admission_no" class="form-control" id="txtUserName" placeholder="Enter Admission No">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Group </label>
                            <input type="text" name="group" class="form-control" id="txtUserName" placeholder="Enter Group Name">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">DOB  <span class="text-danger">*</span></label>
                            <input type="date" name="dob" class="form-control" id="txtUserName" placeholder="Select Date of Birth">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Contact  <span class="text-danger">* (+92311-xxxxx)</span></label>
                            <input type="text" name="contact" class="form-control" id="txtUserName" placeholder="Enter Contact details">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Email  <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" id="txtUserName" placeholder="Enter Email">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Gender <span class="text-danger">*</span></label>
                            <select class="form-control" name="gender" >
                                <option value="male">MALE</option>
                                <option value="female">FEMALE</option>
                            </select>

                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
       
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtPassword">New Password <span class="text-danger">*</span></label>
                            <input type="text" name="password" class="form-control" id="txtPassword" placeholder="Enter new Password"
                                maxlength="50">
                            <span id="txtPassword_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">School <span class="text-danger">*</span></label>
                            <select class="form-control" name="school" >
                                @foreach ($schools as $item)
                                <option value="{{ $item->id }}">{{  $item->school_name }}</option>
                                    
                                @endforeach
                            </select>

                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Class <span class="text-danger">*</span></label>
                            <input type="text" name="class" class="form-control" id="txtPassword" placeholder="Enter Class"
                            maxlength="50">

                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Sec <span class="text-danger">*</span></label>
                            <input type="text" name="section" class="form-control" id="txtPassword" placeholder="Enter Section"
                            maxlength="50">

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
