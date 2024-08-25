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
                    <h1 class="m-0">Academic Year View</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Academic Year</li>
                        <li class="breadcrumb-item active">Views</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
 
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Academic Year</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>School Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Year</th>
                                <th>Active</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($academicYear as $item)
                            <tr>
                                <td>
                                    <a href="{{  route('schooladmin.academic.edit', ['id' => $item->id]) }}" class="btn" >
                                        <i class="fa fa-edit text-primary"  ></i>
                                    </a>
                                    <button class="btn" data-toggle="modal" data-target="#DeleteModal" onclick="setdeleteModalId({{$item->id}})">
                                        <i class="fa fa-trash text-danger"  ></i>
                                    </button>
                                </td>
                                <td>{{ $item->school_name }}</td>
                                <td>{{ $item->start_date }}</td>
                                <td>{{ $item->end_date }}</td>
                                <td>{{ $item->year }}</td>
                                <td   >
                                    
                                    @if ($item->active === 1)
                                    <span class="badge bg-success">YES</span>
                                    @else
                                <span class="badge bg-secondary">NO</span>
                                @endif
                                
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Actions</th>
                                <th>School Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Year</th>
                                <th>Active</th>
                                
                            </tr>
                        </tfoot>
                    </table>
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



