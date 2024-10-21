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
                <form method="POST">
                    @method('POST')
                    @csrf
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtUserName">Class <span class="text-danger">*</span></label>
                                <select name="class_id" id="class_id" class="form-control">
                                    <option value="--select--">--Select--</option>
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtUserName">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" id="txtUserName"
                                    placeholder="Enter Head ex : Final Term" maxlength="255">
                                <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtUserName">Total Marks <span class="text-danger">*</span></label>
                                <input type="text" name="total" class="form-control" id="txtUserName"
                                    placeholder="Enter Total Marks ex : 50" maxlength="255">
                                <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-11">
                            <input type="submit" value="SAVE" class="btn btn-success">
                </form>
            </div>

            </div>
            </div><!-- /.container-fluid -->
        @endif
    </section>
    <!-- /.content -->
@endsection
