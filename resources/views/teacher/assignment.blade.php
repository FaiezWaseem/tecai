@extends('layout')
@section('title', 'Home Page')
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
                        <div class="col-6 mt-2">
                            <form action="{{ route('teacher.assignment.show.filter') }}"
                                class="d-flex justify-content-center align-items-center" method="POST">
                                @csrf
                                <div>
                                    <select name="class" id="school" class="form-control">
                                        <option value="">Select a Class</option>
                                        @foreach ($classes as $filter)
                                            <option value="{{ $filter->class_id }}">{{ $filter->class_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <select name="course" id="school" class="form-control">
                                        <option value="">Select a Course</option>
                                        @foreach ($courses as $filter)
                                            <option value="{{ $filter->id }}">{{ $filter->course_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </form>
                        </div>
                    </div>

                    @foreach ($activities as $activity)
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Title : {{ $activity->title }}</h6>
                                <h6 class="m-0 text-secondary">Class : {{ $activity->class_name }}</h6>
                                <h6 class="m-0 text-secondary">Subject : {{ $activity->course_name }}</h6>
                                <h6 class="m-0 text-black">Chapter : {{ $activity->chapter }}</h6>
                                <h6 class="m-0 text-secondary">Topic : {{ $activity->topic }}</h6>
                                <h6 class="m-0 text-secondary">deadline :    <?php
                                    $dateTime = new DateTime($activity->deadline);
                                    $formattedDate = $dateTime->format('l g:i a Y');
                                    echo $formattedDate;
                                    echo " - ".$activity->deadline
                                    ?></h6>
                                <h6 class="m-0 text-secondary">Created At :
                                    <?php
                                    $dateTime = new DateTime($activity->created_at);
                                    $formattedDate = $dateTime->format('l g:i a Y');
                                    echo $formattedDate; ?>
                                </h6>
                                <a href="{{ route('teacher.assignment.view', ['id' => $activity->id, 'teacher' => true]) }}"
                                    class="btn btn-primary btn-sm float-right">

                                    View
                                    <i class="fas fa-eye"></i>
                                </a>
                                {{-- <a href="" class="btn btn-warning btn-sm float-right mr-2">
                                    Edit
                                    <i class="fas fa-edit"></i>
                                </a> --}}
                                <form method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="text" hidden name="id" value="{{ $activity->id }}">
                                    <button type="submit" class="btn btn-danger btn-sm float-right mr-2">
                                        Delete
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach


                    {{ $activities->links() }}



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
