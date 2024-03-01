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



                    <button class="btn btn-primary" data-toggle="modal" data-target="#ShowModal">Add New</button>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 ">
                            <h6 class="m-0 font-weight-bold text-primary">Classes</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Class Name</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th>Class Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                 
                           
                                      
                                @foreach ($classes as $row)
                                                
                                        <tr>
                                            <td>
                                                {{$row->id}}
                                            </td>
                        
                                            <td>
                                               {{$row->class_name}}
                                            </td>
                                            <td class="row">
                                                <a href="{{ route('admin.show') }}" target="_blank" rel="noopener noreferrer">
                                                    <i class="fa fa-edit"  ></i>
                                                </a>

                                                <form method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="text" name="id" value="{{$row->id}}" hidden>
                                                    <input type="text" name="delete" value="true" hidden>
                                                    <button type="submit" class="btn submit-button">
                                                        <i class="fa fa-trash-alt" style="color : red;"></i>

                                                    </button>
                                                
                                                </form>
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
                          <label class="input-group-text" for="inputGroupSelect01">Class :</label>
                      </div>
                      <input type="text" class="form-control" name="class_name" placeholder="Enter Class : ex : One,Two,Three or 1,2,3 or  I , II , III etc">
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
