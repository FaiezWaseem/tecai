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
                    <h1 class="m-0">Teacher Attendance Create</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Attendance</li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
            <form method="POST">
            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="">Select Date :</label>
                    <input type="date" class="form-control" name="currentDate" >
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-4">
                    <select id="attendance-status" class="form-control">
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                        <option value="late">Late</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" id="update-attendance" class="btn btn-primary">Apply</button>
                </div>
            </div>
        </div>
    </div>

    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Classes</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>School Name</th>
                                <th>Student</th>
                                <th>Class</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                        
                                @foreach ($students as $item)
                                    <tr>
                                        <td>
                                            <a href="#">
                                                Edit
                                            </a>
                                        </td>

                                        <td>{{ $item->school_name }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->class }}</td>
                                        <td>
                                            <select name="attendance[{{ $item->id }}]" class="form-control">
                                                <option value="present">present</option>
                                                <option value="absent">absent</option>
                                                <option value="late">late</option>
                                            </select>
                                        </td>

                                    </tr>
                                @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Actions</th>
                                <th>School Name</th>
                                <th>Student</th>
                                <th>Class</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="row mt-3">
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Submit Attendance</button>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.row -->
            <!-- Main row -->

            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


@section('footer')
    <script>
        $(document).ready(function() {
            $('#update-attendance').click(function() {
                var status = $('#attendance-status').val();
                $('select[name^="attendance"]').val(status);
            });
        });
    </script>
@endsection
