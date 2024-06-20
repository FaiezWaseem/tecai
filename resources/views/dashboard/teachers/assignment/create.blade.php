@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.teachers.sidebar')
@endsection

@section('content')

   <div id="wrapper">
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Begin Page Content -->
                    <div class="container-fluid">
           
    
                        @if ( isset($classes) && $classes)
                        <h1 class="h3 mb-2 text-gray-800">Select Class</h1>
                            <div class="container-fluid justify-content-center align-items-center flex-wrap">
                                <div class="row">
                                    @foreach ($classes as $class)
                                        <div class="card m-2 bg-image hover-zoom" style="width: 18rem;">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $class->class_name }}</h5>
                                                <br>
                                                <a href="{{ route('teacher.assignment.create', ['class_id' => $class->id]) }}" class="btn btn-primary">
                                                    Select</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
    
                        @if ( isset($courses) &&  $courses)
                        <h1 class="h3 mb-2 text-gray-800">Select Course</h1>
                            <div class="container-fluid justify-content-center align-items-center flex-wrap">
                                <div class="row">
                                    @foreach ($courses as $course)
                                        <div class="card m-2 bg-image hover-zoom" style="width: 18rem;">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $course->course_name }}</h5>
                                                <br>
                                                <a href="{{ route('teacher.assignment.create', ['course_id' => $course->course_id]) }}" class="btn btn-primary">
                                                    Select</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
    
                        @if(!isset($classes) && !isset($courses))
    
                        <div class="container-fluid justify-content-center align-items-center flex-wrap">
                            <div class="row">
                                <div class="col col-md-4" >
                                    <div data-toggle="modal" data-target="#ShowModal" 
                                        class="card m-2 bg-image hover-zoom" style="width: 18rem;"
                                        to="{{ route('teacher.assignment.create.blanks',['type' => 'blanks']) }}"
                                        >
                                        <img src="{{ asset('images/Artboard 1.png') }}" class="card-img-top object-fit-contain"
                                            alt="...">
                                    </div>
                                </div>
                                <div class="col col-md-4">
                                    <div data-toggle="modal" data-target="#ShowModal"
                                    to="{{ route('teacher.assignment.create.blanks',['type' => 'match']) }}" class="card m-2 bg-image hover-zoom"
                                        style="width: 18rem;">
                                        <img src="{{ asset('images/Artboard 2.png') }}" class="card-img-top object-fit-contain"
                                            alt="...">
                                    </div>
                                </div>
                                <div class="col col-md-4">
                                    <div data-toggle="modal" data-target="#ShowModal" 
                                    to="{{ route('teacher.assignment.create.blanks',['type' => 'crossword']) }}"
                                        class="card m-2 bg-image hover-zoom" style="width: 18rem;">
                                        <img src="{{ asset('images/Artboard 5.png') }}" class="card-img-top object-fit-contain"
                                            alt="...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-4">
                                    <div data-toggle="modal" data-target="#ShowModal" 
                                    to="{{ route('teacher.assignment.create.blanks',['type' => 'parts']) }}"
                                        class="card m-2 bg-image hover-zoom" style="width: 18rem;">
                                        <img src="{{ asset('images/Artboard 3.png') }}" class="card-img-top object-fit-contain"
                                            alt="...">
                                    </div>
                                </div>
                                <div class="col col-md-4">
                                    <div data-toggle="modal" data-target="#ShowModal" to="{{ route('teacher.assignment.create.blanks',['type' => 'truefalse']) }}"
                                        class="card m-2 bg-image hover-zoom" style="width: 18rem;">
                                        <img src="{{ asset('images/Artboard 4.png') }}" class="card-img-top object-fit-contain"
                                            alt="...">
                                    </div>
                                </div>
                                <div class="col col-md-4">
                                    <div data-toggle="modal" data-target="#ShowModal" 
                                      to="{{ route('teacher.assignment.create.blanks',['type' => 'cluegame']) }}"
                                        class="card m-2 bg-image hover-zoom" style="width: 18rem;max-height: 203px;">
                                        <img src="{{ asset('images/clue.gif') }}" class="card-img-top object-fit-contain"
                                            alt="..." 
                                            style="max-height: 203px;"
                                            
                                            >
                                    </div>
                                </div>
                            </div>
    
                        </div>
                        @endif
    
                    </div>
                    <!-- /.container-fluid -->
    
                </div>
                <!-- End of Main Content -->

    
            </div>
            <!-- End of Content Wrapper -->
   </div>


   
   <div class="modal fade" id="ShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
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
                     <input class="form-control" type="text" name="title" placeholder="Enter Assignment Title">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Assignment Marks</label>
                    </div>
                     <input class="form-control" type="number" name="total_marks" placeholder="Enter Total Marks">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Submission Deadline</label>
                    </div>
                     <input class="form-control" type="datetime-local" name="deadline" placeholder="Select Deadline">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Chapter - Topic</label>
                    </div>
                  
                    <select class="form-control" aria-label="Default select example" name="topic_id">
                        @foreach($topics as $topic)
                        <option value="{{ $topic->id }}"> {{ $topic->chapter_title }} - {{ $topic->title }}</option>
                        @endforeach
                      </select>
                </div>   
                <input type="text" name="redirect" hidden="" id="to">

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="submit" id="continue">Continue</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('footer')
   
<script>
    
    let selected = null;
        const cards = document.querySelectorAll('.card')
        cards.forEach(card => card.addEventListener('click', function () {
            selected = (card.getAttribute('to'))
            console.log(selected)
            console.log(document.getElementById('to'))
            document.getElementById('to').value = selected
        }))
    
</script>
@endsection
