@extends('layout')
@section('title', 'Teachers')
@section('content')

    <!-- Page Wrapper -->
    <div id="wrapper">



        @include('components.sidebar')


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('components.nav')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">


                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-danger" data-toggle="modal" data-target="#ShowModal">Add New</button>
                        </div>
                        <div class="col-6 mt-2">
                            @if (session('user')['super_admin'] == 1)
                                <form action="{{ route('teachers.filter') }}"
                                    class="d-flex justify-content-center align-items-center" method="POST">
                                    @csrf
                                    <div>

                                        <select name="school" id="school" class="form-control">
                                            <option value="">Select a school</option>
                                            @foreach ($schools as $school)
                                                <option value="{{ $school->id }}">{{ $school->school_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 ">
                            <h6 class="m-0 font-weight-bold text-primary">Teachers</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Teacher Name</th>
                                            <th>School Name</th>
                                            <th>Classes</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th>Teacher Name</th>
                                            <th>School Name</th>
                                            <th>Classes</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>



                                    @if(session('user')['super_admin'] == 0)
                        
                                        @foreach ($coursesByTeacher as $row)
                                            <tr>
                                                <td>
                                                    {{ $row['id'] }}
                                                </td>
                                                <td>
                                                    {{ $row['teacher_name'] }}
                                                </td>

                                                <td>

                                                    {{ $row['school_name'] }}
                                                </td>
                                                <td>
                                                    @foreach ($row['classes'] as $class)
                                                       Class : {{ $class->class_name }} , Subject :{{ $class->course_name }} <br>
                                                    @endforeach
                                                </td>
                                                <td class="row">
                                                    <a href="{{ route('teachers.edit', ['id' => $row['id']]) }}"
                                                        >
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <form method="post">
                                                        @csrf
                                                        <input type="text" name="id" value="{{ $row['id'] }}"
                                                            hidden>
                                                        <input type="text" name="delete" value="true" hidden>
                                                        <button type="submit" class="btn submit-button">
                                                            <i class="fa fa-trash-alt" style="color : red;"></i>

                                                        </button>

                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @foreach ($teachers as $row)
                                            <tr>
                                                <td>
                                                    {{ $row->id }}
                                                </td>
                                                <td>
                                                    {{ $row->name }}
                                                </td>

                                                <td>

                                                    {{ $row->school_name }}
                                                </td>
                                                <td>
                                                    
                                                </td>
                            
                                                <td class="row">
                                                    <a href="{{ route('teachers.edit', ['id' => $row->id]) }}"
                                                        target="_blank" rel="noopener noreferrer">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <form method="post">
                                                        @csrf
                                                        <input type="text" name="id" value="{{ $row->id }}"
                                                            hidden>
                                                        <input type="text" name="delete" value="true" hidden>
                                                        <button type="submit" class="btn submit-button">
                                                            <i class="fa fa-trash-alt" style="color : red;"></i>

                                                        </button>

                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    </tbody>
                                </table>
                                <tr>
                                    {{ $teachers->links() }}
                                </tr>
                            </div>
                        </div>
                    </div>




                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('components.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->


    <!-- Show Modal-->
    <div class="modal fade" id="ShowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="post">

                    @csrf
                    <div class="modal-body">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Username</label>
                            </div>
                            <input type="text" class="form-control" name="teacher_name"
                                placeholder="Enter Teacher username">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Password</label>
                            </div>
                            <input type="password" class="form-control" name="password"
                                placeholder="Enter Teacher Password">
                        </div>

                        @if (session('user')['super_admin'] == 1)
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">School</label>
                                </div>
                                <select class="custom-select" name="school_id" id="school_id">
                                    <?php
                        foreach ($schools as $row) {
                            ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo $row['school_name']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        @endif
                        <input type="text" name="redirect" hidden id="to">

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit" id="continue">create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection


@section('footer')
<script>
    let table = new DataTable('#dataTable');
</script>
   
@endsection