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



                    <button class="btn btn-primary" data-toggle="modal" data-target="#ShowModal">Add New</button>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 ">
                            <h6 class="m-0 font-weight-bold text-primary">Board</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Sno</th>
                                            <th>Board</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Sno</th>
                                            <th>Board</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                               
                           
                                      @php $i=1; @endphp
                                @foreach ($boards as $row)
                                                
                                        <tr>
                                            <td>
                                                {{$i}}
                                            </td>
                                            <td>
                                                {{$row->board_name}}
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
                                        @php $i++; @endphp
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
                          <label class="input-group-text" for="inputGroupSelect01">Board Name</label>
                      </div>
                      <input type="text" class="form-control" name="board_name" placeholder="Enter Board Name" required>
                  </div>


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