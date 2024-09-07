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
                    <h1 class="m-0">CREATE SCHOOL</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('superadmin.home.view') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">School</li>
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
            <form method="POST" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Logo </label>
                            <input accept=".png, .jpg, .jpeg, .gif" class="form-control" name="logo" type="file"
                                value="">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Dashboard Banner </label>
                            <input accept=".png, .jpg, .jpeg, .gif" class="form-control" name="banner" type="file"
                                value="">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtUserName">School Name <span class="text-danger">*</span></label>
                            <input type="text" name="school_name" class="form-control" id="txtUserName" placeholder="Enter School Name"
                                maxlength="255">
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
