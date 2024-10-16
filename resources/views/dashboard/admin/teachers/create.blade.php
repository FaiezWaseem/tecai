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
                    <h1 class="m-0">ADD NEW TEACHER</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('superadmin.home.view') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">Teacher</li>
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
          
                <div class="my-3">
                    <h4>General Information</h4>
                </div>
                <div class="row" >
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Picture <span class="text-danger">*</span></label>
                            <input type="file" name="cnic" class="form-control" id="txtUserName" placeholder="Enter CNIC"
                                maxlength="50">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="cnic" class="form-control" id="txtUserName" placeholder="Enter CNIC"
                                maxlength="50">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="cnic" class="form-control" id="txtUserName" placeholder="Enter CNIC"
                                maxlength="50">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Phone No <span class="text-danger">*</span></label>
                            <input type="text" name="cnic" class="form-control" id="txtUserName" placeholder="Enter CNIC"
                                maxlength="50">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">DOB <span class="text-danger">*</span></label>
                            <input type="date" name="cnic" class="form-control" id="txtUserName" placeholder="Enter CNIC"
                                maxlength="50">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Address <span class="text-danger">*</span></label>
                            <input type="text" name="cnic" class="form-control" id="txtUserName" placeholder="Enter CNIC"
                                maxlength="50">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Gender <span class="text-danger">*</span></label>
                            <select class="form-control" name="gender" >
                                <option value="male">Male</option>
                                <option value="female">FeMale</option>
                            </select>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Teacher CNIC <span class="text-danger">*</span></label>
                            <input type="text" name="cnic" class="form-control" id="txtUserName" placeholder="Enter CNIC"
                                maxlength="50">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                </div>

                <div class="my-3">
                    <h4>Academics</h4>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Institute Name <span class="text-danger"></span></label>
                            <input type="text" name="teacher_name" class="form-control" id="txtUserName" placeholder="Enter Institute Name"
                                maxlength="50">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="txtPassword">Board <span class="text-danger">*</span></label>
                            <input type="text" name="password" class="form-control" id="txtPassword" placeholder="Enter new Password"
                                maxlength="50">
                            <span id="txtPassword_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="txtPassword">Year <span class="text-danger">*</span></label>
                            <input type="text" name="password" class="form-control" id="txtPassword" placeholder="Enter new Password"
                                maxlength="50">
                            <span id="txtPassword_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="txtPassword">Marks <span class="text-danger">*</span></label>
                            <input type="text" name="password" class="form-control" id="txtPassword" placeholder="Enter new Password"
                                maxlength="50">
                            <span id="txtPassword_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtPassword">Document <span class="text-danger">*</span></label>
                            <input type="file" name="password" class="form-control" id="txtPassword" placeholder="Enter new Password"
                                maxlength="50">
                            <span id="txtPassword_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
        
                </div>
                <div class="my-3">
                    <h4>Experience</h4>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Company <span class="text-danger"></span></label>
                            <input type="text" name="teacher_name" class="form-control" id="txtUserName" placeholder="Enter Institute Name"
                                maxlength="50">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="txtPassword">Year <span class="text-danger">*</span></label>
                            <input type="text" name="password" class="form-control" id="txtPassword" placeholder="Enter new Password"
                                maxlength="50">
                            <span id="txtPassword_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="txtPassword">Domain <span class="text-danger">*</span></label>
                            <input type="text" name="password" class="form-control" id="txtPassword" placeholder="Enter new Password"
                                maxlength="50">
                            <span id="txtPassword_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="txtPassword">Salary <span class="text-danger">*</span></label>
                            <input type="text" name="password" class="form-control" id="txtPassword" placeholder="Enter new Password"
                                maxlength="50">
                            <span id="txtPassword_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
               
        
                </div>
                <div class="my-3">
                    <h4>Login Credentials</h4>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Username <span class="text-danger">* (spaces not allowed)</span></label>
                            <input type="text" name="teacher_name" class="form-control" id="txtUserName" placeholder="Enter Username"
                                maxlength="50">
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
