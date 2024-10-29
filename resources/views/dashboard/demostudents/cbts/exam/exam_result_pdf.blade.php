
@section('content')
    <h1 class="text-center">{{ $result->first()->school_name }}</h1>
    <h2 class="text-center">Exam: {{ $result->first()->exam_name }}</h2>

    <div>
        @if ($result->isEmpty())
            <p>No results found.</p>
        @else
            @foreach ($result as $examResult)
                <div>
                    <h3>Student: {{ $examResult->student_name }}</h3>
                    <p>Class: {{ $examResult->class }}</p>
                    <p>Subject: {{ $examResult->subject_name }}</p>
                    <h4>Performance Summary</h4>
                    <p>Total Questions: {{ $examResult->total_question }}</p>
                    <p>Total Correct Answers: {{ $examResult->total_correct_answer }}</p>
                    <p>Total Incorrect Answers: {{ $examResult->total_incorrect_answer }}</p>
                    <p>Total Marks: {{ $examResult->total_mark }}</p>
                    <p>Total Obtained Marks: {{ $examResult->total_obtain_mark }}</p>
                    <p>Result Status: {{ $examResult->result_status }}</p>
                    <hr>
                </div>
            @endforeach
        @endif

       
    
    </div>
