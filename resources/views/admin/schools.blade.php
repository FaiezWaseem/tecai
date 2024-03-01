@extends('layout')
@section('title', 'Schools')
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

                    <div >
                        <h2>Quick Links</h2>
                        <button class="btn btn-danger mb-3 mt-3" data-toggle="modal" data-target="#ShowModal" >Add New</button>
                        <button class="btn btn-success my-3" onclick="window.location.reload()" >Reload</button>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 ">
                            <h6 class="m-0 font-weight-bold text-primary">Schools</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Id</th>
                                            <th>School Name</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Action</th>
                                            <th>Id</th>
                                            <th>School Name</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>



                                        @foreach ($schools as $row)
                                            <tr>
                                                <td class="row">
                                                    <a href="{{ route('admin.show') }}" target="_blank"
                                                        rel="noopener noreferrer">
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
                                                <td>
                                                    {{ $row->id }}
                                                </td>

                                                <td>
                                                    {{ $row->school_name }}
                                                </td>
                                      
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
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
                                <label class="input-group-text" for="inputGroupSelect01">School Name</label>
                            </div>
                            <input type="text" class="form-control" name="school_name" placeholder="Enter School Name">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-danger" type="submit" id="continue">create</button>
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