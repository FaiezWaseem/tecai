@extends('layout')
@section('title', 'Courses')
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



                    <a class="btn btn-danger my-3" data-toggle="modal" data-target="#ShowModal">Add New</a>
                    <div class="row justify-content-between">
                   
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 ">
                            <h6 class="m-0 font-weight-bold text-primary">Chapters</h6>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Chapter Title </th>
                                            <th>Subject</th>
                                            <th>Class</th>
                                            <th>Actions</th>
                                        </tr>
                                        
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Chapter Title </th>
                                            <th>Subject</th>
                                            <th>Class</th>
                                            <th>Actions</th>
                                        </tr>

                                    </tfoot>
                                    <tbody>



                                        @foreach ($chapters as $row)
                                            <tr>
                                                <td>
                                                    {{ $row->chapter_title }}
                                                </td>
                                                <td>
                                                    {{ $row->course_name }}
                                                </td>
                                                <td>
                                                    {{ $row->class_name }}
                                                </td>


                                                <td class="row">
                                                    <a target="_self" rel="noopener noreferrer">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a  href="{{ route('admin.content.chapters.delete', ['id' => $row->id]) }}" target="_self" rel="noopener noreferrer">
                                                        
                                                        <i class="fa fa-trash-alt" style="color : red;"></i>
                                                        
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <tr>
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
                                <label class="input-group-text" for="inputGroupSelect01">Title</label>
                            </div>
                            <input type="text" class="form-control" name="chapter_title" placeholder="Enter Chapter title">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Subject</label>
                            </div>
                          <select class="form-control" name="tcourse_id" >
                            <option selected>Choose Subject</option>
                            @foreach ($courses as $row)
                            <option value="{{ $row->id }}">{{ $row->course_name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Class</label>
                            </div>
                          <select class="form-control" name="tclass_id" >
                            <option selected>Choose Class</option>
                            @foreach ($classes as $row)
                            <option value="{{ $row->id }}">{{ $row->class_name }}</option>
                            @endforeach
                          </select>
                        </div>

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