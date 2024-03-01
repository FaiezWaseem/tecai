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
                    <div class="row">
                        <div class="col-10"></div>
                        <div class="col-2">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#ShowModal">Add New</button>
                        </div>
                    </div>
                    @if ($errors->any())
                        <div class="card mb-2 border-left-warning bg-danger text-white">
                            <div class="card-body">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif


                    @foreach ($recorded as $record)
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 row">
                                <div class="col-2">
                                    <h6 class="m-0 text-secondary"><img src="/{{ $record->rec_thumbnail }}"
                                            alt="thumbnail" height="100px"> </h6>
                                </div>
                                <div class="col-10">

                                    <h6 class="m-0 font-weight-bold text-primary">Title : {{ $record->rec_title }}
                                    </h6>
                                    <h6 class="m-0 text-secondary">Subtitle : {{ $record->rec_subtitle }}</h6>
                                    <h6 class="m-0 text-secondary">Created At :
                                        <?php
                                        $dateTime = new DateTime($record->created_at);
                                        $formattedDate = $dateTime->format('l g:i a Y');
                                        echo $formattedDate; ?>
                                    </h6>
                                    <a href="{{ $record->rec_link }}" class="btn btn-primary btn-sm float-right">

                                        View
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="text" hidden name="id" value="{{ $record->id }}">
                                        <button type="submit" class="btn btn-danger btn-sm float-right mr-2">
                                            Delete
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach


                    {{-- {{ $live_sessions->links() }} --}}




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
                    <h5 class="modal-title" id="exampleModalLabel">Add Recorded Lectures</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data">

                    @csrf
                    <div class="modal-body">

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="rec_title" placeholder="Enter title">
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="rec_link" placeholder="Enter Video link">
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="rec_subtitle" placeholder="Enter subtitle">
                        </div>
                        <div class="input-group mb-3">
                            <input accept="image/png, image/jpg, image/jpeg" class="form-control" name="photo"
                                type="file" value="">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




@endsection
