@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.superadmin.sidebar')
@endsection

<style>
    .custom-radio:checked {
        accent-color: green; /* For modern browsers */
        background-color: green; /* Fallback for older browsers */
    }

    .custom-radio:disabled {
        cursor: not-allowed; /* Change cursor to indicate disabled state */
        opacity: 0.5; /* Optional: make disabled buttons look less prominent */
                accent-color: green; /* For modern browsers */

    }
</style>

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">CBTS Exam View</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">CBTS</li>
                        <li class="breadcrumb-item">Exam</li>
                        <li class="breadcrumb-item active">Result</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-info text-white text-center">
                    <h3 class="card-title">School Result Card</h3>
                </div>
                <div class="card-body text-lg">
                    @if ($result->isEmpty())
                        <p class="text-center">No results found.</p>
                    @else
                        @foreach ($result as $examResult)
                            <h2 class="font-weight-bold text-center ">{{ $examResult->school_name }}</h2>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="border rounded p-4 text-center ">
                                        <h4 class="font-weight-bold">Student Information</h4>
                                        <p><strong>Student:</strong> {{ $examResult->student_name }}</p>
                                        <p><strong>Class:</strong> {{ $examResult->class }} <strong>Section:</strong> {{ $examResult->section }}</p>
                                    </div>
                                    <div class="border rounded p-4 text-center ">
                                        <h4 class="font-weight-bold">Subject Result</h4>
                                        <table class="table table-bordered table-striped    table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>Subject</th>
                                                    <th>Total Questions</th>
                                                    <th>Total Correct Answers</th>
                                                    <th>Total Incorrect Answers</th>
                                                    <th>Total Unanswered</th>
                                                    <th>Total Marks</th>
                                                    <th>Marks Obtained</th>
                                                    <th>Result Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $examResult->subject_name }}-

                                                    @foreach ($examchapter as $chapter)
                                @if ($chapter->exam_id == $examResult->exam_id)
                                {{ $chapter->chapter_name }}
                                @endif
                                @endforeach 
                                                    </td>
                                                    <td>{{ $examResult->total_question }}</td>
                                                    <td>{{ $examResult->total_correct_answer }}</td>
                                                    <td>{{ $examResult->total_incorrect_answer }}</td>
                                                    <td>{{ $examResult->not_answer }}</td>
                                                    <td>{{ $examResult->total_mark }}</td>
                                                    <td>{{ $examResult->total_obtain_mark }}</td>
                                                    <td>{{ $examResult->result_status }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="border rounded p-4 text-center ">
                                        <h4 class="font-weight-bold">{{ $examResult->exam_name }}</h4>
                                        <h4 class="font-weight-bold">Test Info</h4>
                                        <table class="table table-bordered table-striped w-100 text-center ">
                                            <tbody>
                                                <tr>
                                                    <th>Start Date</th>
                                                    <td>{{ $examResult->ex_start_date }}</td>
                                                </tr>
                                                <tr>
                                                    <th>End Date</th>
                                                    <td>{{ $examResult->ex_end_date }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Start Time</th>
                                                    <td>{{ $examResult->start_time }}</td>
                                                </tr>
                                                <tr>
                                                    <th>End Time</th>
                                                    <td>{{ $examResult->end_time }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Test Time</th>
                                                    <td>{{ $examResult->ex_duration }} Minute</td>
                                                </tr>
                                                <tr>
                                                    <th>Time Taken</th>
                                                    <td>{{ $examResult->time_taken }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Passing Marks</th>
                                                    <td>{{ $examResult->ex_pass_mark }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    
                                        <h4 class="font-weight- text-center text-bold">Test Details</h4>

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

                            @php $count = 0; @endphp 

                                @foreach($examanswers as $obj)
                                    @if($obj->q_Id == $item2->id)
                                        <div class="question-answer col-md-12 ml-5" style="margin-top: 10px;">
                                            @if($obj->cqtype == 'true_false')
                                            <div style="display:inline-flex; align-items: center;">
    <input type="radio" 
           class="custom-radio" 
           name="ans{{ $obj->id }}[]" 
           value="{{ $obj->value }}" 
           {{ $obj->is_correct ? 'checked' : '' }} 
           style="margin-right: 10px; accent-color: green;"> 
</div>


@foreach($studentanswers as $obj2)

@if($obj2->q_id == $item2->id)


<div style="display:inline-flex; align-items: center;">
<input type="radio" 
class="custom-radio" 
name="ans{{ $obj2->id }}[]" 
value="{{ $obj2->value }}" 
{{ $obj2->answer == $obj->answer ? 'checked' : '' }} 
style="margin-right: 10px; accent-color: {{ $obj->is_correct  ? 'green' : 'red' }};"> 
</div>

@endif

@endforeach




 {{ $obj->answer }} <!-- Incorrect answer -->


                                            @elseif($obj->cqtype == 'fill_in_the_blanks')
                                                <div>
                                                @foreach($studentanswers as $obj2)
                                                @if($obj2->q_id == $item2->id)

                                            @if($obj2->answer != $obj->answer)
                                           Wrong answer: {{ $obj2->answer }}</br>
                                            @endif
                                            @endif

                                    @endforeach
                                                   Right answer: {{ $obj->answer }}
                                                </div>
                                            @elseif($obj->cqtype == 'mcqs')
                                           <div style="display:inline-flex; align-items: center;">
                                           @php $count++; @endphp 
                                           <strong class="mr-3">{{ $count }}:</strong>  <input type="radio" class="custom-radio" name="ans{{ $obj->id }}[]" value="{{ $obj->value }}" {{ $obj->is_correct ? 'checked' : '' }} style="margin-right: 10px; accent-color: green;"> </div>
                                            @foreach($studentanswers as $obj2)
                                            @if($obj2->q_id == $item2->id)
                                            <div style="display:inline-flex; align-items: center;">
                                                <input type="radio" class="custom-radio mr-3" name="ans{{ $obj2->id }}[]" value="{{ $obj2->value }}" {{ $obj2->answer == $obj->answer ? 'checked' : '' }} style="margin-right: 10px; accent-color: {{ $obj->is_correct  ? 'green' : 'red' }};"> 
                                            </div>@endif
                                    @endforeach
                                  {{ $obj->answer }}
                                    @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                        </div>
                    @endforeach
                    <div class="row mb-4 text-center">
                        <div class="col-md-6">
                            <canvas id="pieChart" height="200" width="200"></canvas>
                        </div>
                    </div>
                    <a href="{{ route('superadmin.cbts.exam.results.pdf', ['exam_id' => $exam_id]) }}" class="btn btn-primary mb-3">Download PDF</a>

                </div>
           
            </div>
        </div>
    </section>
@endsection

@section('footer')
<script>
    $(function() {
      
        // Chart Data Preparation
        const totalCorrect = {{ $result->sum('total_correct_answer') }};
        const totalIncorrect = {{ $result->sum('total_incorrect_answer') }};
        const totalUnanswered = {{ $result->sum('not_answer') }};
        const labels = ['Correct', 'Incorrect', 'Unanswered'];

        // Pie Chart
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Answer Distribution',
                    data: [totalCorrect, totalIncorrect, totalUnanswered],
                    backgroundColor: [
                        'rgba(0,128,0)',  // Green for correct answers
                        'rgb(255, 0, 0)', // Red for incorrect answers
                        'rgba(255, 255, 0)' // Yellow for unanswered questions
                    ],
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
    </script>
@endsection
