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
                    <h1 class="m-0">Academic Term View</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Academic Term</li>
                        <li class="breadcrumb-item active">Views</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>


    <section class="content">
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
                            <a href="{{ route('schooladmin.academic.term.view', ['school_id' => $item->id]) }}"
                                class="btn btn-primary">
                                Select</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif(isset($classes))
            <div>
                <h1>Select A Class</h1>
            </div>
            <div class="container-fluid d-flex flex-wrap">

                @foreach ($classes as $item)
                    <div class="card m-2 bg-image hover-zoom" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->class_name }}</h5>
                            <br>
                            <a href="{{ route('schooladmin.academic.term.view', ['class_id' => $item->id]) }}"
                                class="btn btn-primary">
                                Select</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif(isset($courses))
            <div>
                <h1>Select A Course</h1>
            </div>
            <div class="container-fluid d-flex flex-wrap">

                @foreach ($courses as $item)
                    <div class="card m-2 bg-image hover-zoom" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->course_name }}</h5>
                            <br>
                            <a href="{{ route('schooladmin.academic.term.view', ['course_id' => $item->id]) }}"
                                class="btn btn-primary">
                                Select</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Academic Term</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Actions</th>
                                    <th>Class</th>
                                    <th>Course </th>
                                    <th>Title</th>
                                    <th>Total Grade</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($terms as $item)
                                    <tr>
                                        <td>
                                            <i class="fa fa-edit text-primary"></i>
                                            {{-- <button class="btn" data-toggle="modal" data-target="#DeleteModal" onclick="setdeleteModalId({{$item->id}})">
                                        <i class="fa fa-trash text-danger"  ></i>
                                    </button> --}}
                                        </td>
                                        <td>{{ $class->class_name }}</td>
                                        <td>{{ $course->course_name }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>
                                            {{$item->total }}

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Actions</th>
                                    <th>Class</th>
                                    <th>Course </th>
                                    <th>Title</th>
                                    <th>Total Grade</th>

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.row -->
                <!-- Main row -->

                <!-- /.row (main row) -->
            </div>
        @endif
    </section>
@endsection
