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
                    <h1 class="m-0">EDIT STUDENT</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('superadmin.home.view') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">Student</li>
                        <li class="breadcrumb-item active">EDIT</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Student Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="txtUserName"
                                placeholder="Enter Student Name" value="{{ $student->name }}" maxlength="255">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Student Email <span class="text-danger">*</span></label>
                            <input type="text" name="email" class="form-control" id="txtUserName"
                                placeholder="Enter Student Email" value="{{ $student->email }} " maxlength="255">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Approve </label>
                            @if ($student->isApproved === 0)
                                <input type="checkbox" id="isApprove" name="isApprove" >
                            @else
                                <input type="checkbox" id="isApprove" name="isApprove" checked>
                            @endif
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
