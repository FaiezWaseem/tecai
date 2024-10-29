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
                    <h1 class="m-0">CREATE DEMO LINK</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('superadmin.home.view') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">Demo Link</li>
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
                <div class="col-md-4">
                        <div class="form-group">
                            <label for="board_id">Board <span class="text-danger">*</span></label>
                            <select name="board_id" class="form-control" required>
                                <option value="">--Select--</option>
                                @foreach ($boards as $board)
                                    <option value="{{ $board->id }}" >
                                        {{ $board->board_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="ex_board_id_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtUserName">Class <span class="text-danger">*</span></label>
                            <select name="class" id="classes_id" class="form-control">
                            <option value=""> --Select-- </option>
                                @foreach ($classes as $item)
                                    <option value="{{ $item->class_name }}"> {{ $item->class_name }} </option>
                                @endforeach
                            </select>
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtUserName">Unique Username <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="txtUserName" placeholder="Enter Username"
                                maxlength="50">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtPassword">New Password <span class="text-danger">*</span></label>
                            <input type="text" name="password" class="form-control" id="txtPassword" placeholder="Enter new Password"
                                maxlength="50">
                            <span id="txtPassword_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">

                        <input type="submit" value="CREATE" class="btn btn-success">
                    </div>
                </div>
            </form>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
