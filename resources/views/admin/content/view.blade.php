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



                    <a class="btn btn-danger my-3" href="{{ route('admin.content.addnew.view') }}">Add New</a>
    
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 ">
                            <h6 class="m-0 font-weight-bold text-primary">Content</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Chapter</th>
                                            <th>Topic Title</th>
                                            <th>Topic Description</th>
                                            <th>Board</th>
                                            <th>Class</th>
                                            <th>Subject</th>
                                            <th>Type</th>
                                            <th>created at</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th>Chapter</th>
                                            <th>Topic Title</th>
                                            <th>Topic Description</th>
                                            <th>Board</th>
                                            <th>Class</th>
                                            <th>Subject</th>
                                            <th>Type</th>
                                            <th>created at</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>



                                        @foreach ($content as $item)
                                            <tr>
                                                <td>
                                                    {{ $item->id }}
                                                </td>
                                                <td>
                                                    {{ $item->chapter_title  }}
                                                </td>
                                                <td>
                                                    {{ $item->topic_title  }}
                                                </td>
                                                <td>
                                                    {{ $item->topic_description  }}
                                                </td>
                                                <td>
                                                    {{ $item->board_name  }}
                                                </td>
                                                <td>
                                                    {{ $item->class_name  }}
                                                </td>
                                                <td>
                                                    {{ $item->course_name  }}
                                                </td>
                                                <td>
                                                    {{ $item->content_type  }}
                                                </td>
                                                <td>
                                                    {{  $item->created_at }}
                                                </td>
                                                <td class="row">
                                                    <a href="{{ route('admin.show') }}" target="_blank"
                                                        rel="noopener noreferrer">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    
                                                    <a class="text-danger" href="{{ route('admin.show') }}" target="_blank"
                                                        rel="noopener noreferrer">
                                                        <i class="fa fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                {{ $content->links() }}
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
                                <label class="input-group-text" for="inputGroupSelect01">Class Name</label>
                            </div>
                            <input type="text" class="form-control" name="class_name" placeholder="Enter Class Name">
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