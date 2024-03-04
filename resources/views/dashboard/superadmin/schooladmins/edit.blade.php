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
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="txtUserName">Unique Username</label>
                            <input type="text" name="name" class="form-control" id="txtUserName"
                                placeholder="Enter Username" maxlength="50" value="{{ $user->name }}">
                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtPassword">New Password</label>
                            <input type="text" name="password" class="form-control" id="txtPassword"
                                placeholder="Enter new Password" maxlength="50">
                            <span id="txtPassword_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>
                    <div class="col-md-3 justify-center">
                        <button class="btn btn-danger" onclick="window.location.back()">CANCEL</button>
                        <input type="submit" value="UPDATE" class="btn btn-success">
                    </div>
                </div>


            </form>
            <form method="POST">
                @method('POST')
                @csrf
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="txtUserName">School <span class="text-danger">*</span></label>
                            <select class="form-control" name="school_id">
                                @foreach ($schools as $item)
                                    <option value="{{ $item->id }}">{{ $item->school_name }}</option>
                                @endforeach
                            </select>

                            <span id="txtUserName_Error" class="error invalid-feedback hide"></span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <input type="submit" value="Add" class="btn btn-outline-success">
                    </div>
                </div>


            </form>

            <div class="card mt-5">
                <div class="card-header">
                    <h3 class="card-title">Admin Schools</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Id</th>
                                <th>School Name</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($userSchools as $item)
                                <tr>
                                    <td>

                                        <button id="delete" data-id="{{ $item->id }}" onclick="deleteClicked(this)"
                                            class="btn submit-button">
                                            <i class="fa fa-trash-alt" style="color : red;"></i>
                                        </button>
                                    </td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->school_name }}</td>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Actions</th>
                                <th>Id</th>
                                <th>School Name</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection



@section('footer')
    <script>
        function deleteClicked(e) {
            var id = $(e).attr('data-id');
            console.log(id)
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            // Send AJAX delete request
            $.ajax({
                url: window.location.href, // Replace with your actual delete endpoint
                method: 'DELETE',
                data: {
                    school_id: id
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    // Handle successful response
                    showToast('Delete request', 'Delete request successful', 'success');

                    // Optionally, you can remove the element from the DOM
                    $(e).closest('tr').remove();
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    showToast('AJAX delete request error:', status, 'error');
                }
            });
        };
    </script>
@endsection
