@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.superadmin.sidebar')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <!-- Display success or error messages -->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">CBTS Exam Question View</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">CBTS</li>
                        <li class="breadcrumb-item">Exam</li>
                        <li class="breadcrumb-item active">Views</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Questions Bank</h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Id</th>
                                <th>Question Type</th>
                                <th>Question</th>
                                <th>Chapter</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($questionsbank as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('superadmin.cbts.examquestion.create', ['id' => $item->id, 'exam_id' => $exam_id]) }}" class="btn btn-success">
                                            <i class="fa fa-plus text-white"></i> Add Question
                                        </a>
                                    </td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->cqtype }}</td>
                                    <td>{{ $item->cquestion }}</td>
                                    <td>{{ $item->chapter_title }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No questions available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Actions</th>
                                <th>Id</th>
                                <th>Question Type</th>
                                <th>Question</th>
                                <th>Chapter</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                        </tfoot>
                    </table>

                    {{ $questionsbank->appends(['id' =>  $exam_id])->links() }} 
                </div>

                <div class="card-body" style="font-size: 1.2em;">
                    <div class="card-header">
                        <h1 class="card-title" style="font-size: 2em; font-weight: bold; color: #333;">Exam Questions</h1>
                    </div>

                    @foreach ($examquestions as $questionIndex => $item2)
                        <div class="question-container" style="margin-top: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;"> 
                            <div class="row question-title" style="font-size: 1.5em;">                
                                <div class="col-md-9">   
                                    <strong>{{ $questionIndex + 1 }}.</strong> {{ $item2->question }} 
                                </div>
                                <div class="col-md-3 text-right"> 
                                    <span style="font-weight: bold;">Mark:</span> {{ $item2->mark }} 
                                </div>
                            </div>

                            @if($item2->image)
                                <div class="row question-title">                
                                    <div class="col-md-12">
                                    <img src="{{ asset('images/' . $item2->image) }}" alt="Question Image" style="width: 100%; max-height: 300px; object-fit: contain;" />
                                    </div>               
                                </div>
                            @endif

                            <div class="row"> 
                                @foreach($examanswers as $obj) 
                                    @if($obj->q_Id == $item2->id) 
                                        <div class="question-answer col-md-12" style="margin-top: 10px;">
                                            @if($obj->cqtype == 'true_false')
                                                <div style="display:inline-flex; align-items: center;">
                                                    <input type="radio" name="ans{{ $obj->id }}[]" value="{{ $obj->value }}" {{ $obj->is_correct ? 'checked' : '' }} disabled style="margin-right: 10px;"> {{ $obj->answer }} 
                                                </div>
                                            @elseif($obj->cqtype == 'fill_in_the_blanks') 
                                                <div>
                                                    {{ $obj->answer }}
                                                </div>
                                            @elseif($obj->cqtype == 'mcqs')
                                                <div class="col-md-6" style="display:inline-flex; align-items: center;">
                                                    <input type="radio" name="ans{{ $obj->id }}[]" value="{{ $obj->value }}" {{ $obj->is_correct ? 'checked' : '' }} disabled style="margin-right: 10px;"> {{ $obj->answer }} 
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="col-md-12 text-right" style="margin-top: 15px;">
                                <button class="btn btn-danger" 
                                        data-toggle="modal" 
                                        data-target="#DeleteModal2" 
                                        onclick="setDeleteModalIdd({{ $exam_id }}, {{ $item2->id }})">
                                    <i class="fa fa-trash"></i> Remove
                                </button>
                            </div>


<!-- Delete Confirmation Modal -->
<div class="modal fade" id="DeleteModal2" tabindex="-1" role="dialog" aria-labelledby="DeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="DeleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this question?
                <form id="deleteQuestionForm" method="POST" action="{{ url('/delete-question') }}">
                    @csrf
                    <input type="hidden" id="examIdInput" name="exam_id" value="">
                    <input type="hidden" id="questionIdInput" name="question_id" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="submitDeleteForm()">Delete</button>
            </div>
        </div>
    </div>
</div>
                           
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
<script>
    // Set exam_id and question_id when opening the modal
    function setDeleteModalIdd(examId, questionId) {
        document.getElementById('examIdInput').value = examId;
        document.getElementById('questionIdInput').value = questionId;
    }

   function submitDeleteForm() {
    const examId = document.getElementById('examIdInput').value;
    const questionId = document.getElementById('questionIdInput').value;

    const url = `/cbts/examquestion/view/${questionId}`; // Ensure this is correct

    fetch(url, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Ensure CSRF token is included
        },
        body: JSON.stringify({
            exam_id: examId,
            question_id: questionId
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 200) {
            alert(data.message);
            location.reload(); // Reload to show changes
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while deleting the question. See console for details.');
    });
}

</script>
