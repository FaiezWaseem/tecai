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
                    <h1 class="m-0">EDIT ACADEMIC YEAR </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('schooladmin.home.view') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">ACADEMIC YEAR</li>
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
        <div class="container-fluid">
            <form method="POST">
                @method('POST')
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Year Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" class="form-control" id="txtUserName"
                                placeholder="Enter Class Name" maxlength="255" value="{{ $academicYear->start_date }}">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Year End Date <span class="text-danger">*</span></label>
                            <input type="date" name="end_date" class="form-control" id="txtUserName"
                                placeholder="Enter Class Name" maxlength="255" value="{{ $academicYear->end_date }}">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">Year <span class="text-danger">*</span></label>
                            <input type="text" name="year" class="form-control" id="txtUserName"
                                placeholder="Enter Year Ex : 2024" maxlength="255" value="{{ $academicYear->year }}">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="txtUserName">Active <span class="text-danger">*</span></label>
                            @if ($academicYear->active === 1)
                                <input type="checkbox" name="active" class="form-control" id="txtUserName"
                                    placeholder="Enter Year Ex : 2024" maxlength="255"
                                    checked
                                    >
                            @else
                                <input type="checkbox" name="active" class="form-control" id="txtUserName"
                                    placeholder="Enter Year Ex : 2024" maxlength="255">
                            @endif

                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="txtUserName">School <span class="text-danger">*</span></label>
                            <input type="text" name="school" class="form-control" id="txtUserName"
                                placeholder="Enter Year Ex : 2024" maxlength="255" value="{{ $school->school_name }}"
                                disabled>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-11">
                        <input type="submit" value="UPDATE" class="btn btn-success">
            </form>
        </div>

        </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
