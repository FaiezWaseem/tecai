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
                    <h1 class="m-0">UPDATE SCHOOL ADMIN</h1>

                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('superadmin.home.view') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">School Admin</li>
                        <li class="breadcrumb-item active">Update</li>
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
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtUserName">Unique Username</label>
                            <input type="text" name="name" class="form-control" id="txtUserName"
                                placeholder="Enter Username" maxlength="50" value="{{ $user->name }}">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtPassword">New Password</label>
                            <input type="text" name="password" class="form-control" id="txtPassword"
                                placeholder="Enter new Password" maxlength="50">
                            <span id="txtPassword_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtUserName">School</label>
                            <select class="form-control" name="school_id">
                                @foreach ($schools as $item)
                                    @if ($item->id == $user->school_id)
                                        <option value="{{ $item->id }}" @selected(true)>
                                            {{ $item->school_name }}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->school_name }}</option>
                                    @endif
                                @endforeach
                            </select>

                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-danger" onclick="window.location.back()" >CANCEL</button>
                        <input type="submit" value="UPDATE" class="btn btn-success">
                    </div>
                </div>
            </form>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
