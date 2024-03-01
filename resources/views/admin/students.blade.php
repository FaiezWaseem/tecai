@extends('layout')
@section('title', 'Students')
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
                            <button class="btn btn-danger my-3" data-toggle="modal" data-target="#ShowModal">ADD NEW STUDENT</button>
                            <button class="btn btn-danger my-3" >IMPORT CSV</button>
                        </div>
                        <div class="col-6 mt-2">
                            @if (session('user')['super_admin'] == 0)
                                <form action="{{ route('students.filter') }}"
                                    class="d-flex justify-content-center align-items-center" method="POST">
                                    @csrf
                                    <div>

                                        <select name="class_name" id="class_name" class="form-control">
                                            <option value="">Select a Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->class_name }}">{{ $class->class_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-danger">Filter</button>
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
                                            <th>Name</th>
                                            <th>Father Name</th>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>Gender</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                        
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Father Name</th>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>Gender</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                   
                                    </tfoot>
                                    <tbody>
                                 
                           
                                      
                                @foreach ($students as $row)
                                                
                                        <tr>
                                            <td>
                                                {{$row->id}}
                                            </td>
                                            <td>
                                                {{$row->name}}
                                            </td>
                        
                                            <td>
                                               {{$row->father_name}}
                                            </td>
                        
                                            <td>
                                               {{$row->class}}
                                            </td>
                        
                                            <td>
                                               {{$row->section}}
                                            </td>
                                            <td>
                                               {{$row->gender}}
                                            </td>
                                            <td>
                                               {{$row->email}}
                                            </td>
                                            <td class="row">
                                                <a href="{{ route('teachers.show', ['id' => $row->id]) }}" target="_blank" rel="noopener noreferrer">
                                                    <i class="fa fa-edit"  ></i>
                                                </a>

                                                <form method="post">
                                                    @csrf
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
                                <tr>
                                    {{ $students->links() }}
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



 


@endsection


@section('footer')
<script>
    let table = new DataTable('#dataTable');
</script>
   
@endsection