@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.demostudents.sidebar')
@endsection

@section('content')
<style>
    .question-section {
        padding: 10px 0;
        margin-bottom: 20px;
    }
    .question-count {
        font-size: 20px;
        font-weight: bold;
        background: #fff1c9;
        text-align: center;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 20px;
    }
    .question-title {
        font-size: 18px;
        font-weight: bold;
        padding-bottom: 10px;
    }
    .table > tbody > tr > td {
        border: 0;
    }
    .exam-left-section {
        border: 1px solid #d5d5d5;
        padding: 20px;
        margin-bottom: 25px;
        border-radius: 6px;
    }
    .exam-question-box li {
        list-style: none;
        display: inline-block;
    }
    .exam-question-box li a {
        color: #FFF;
        padding: 12px 16px;
        border-radius: 100%;
        cursor: pointer;
        font-weight: bold;
        float: left;
        width: 40px;
        text-align: center;
    }
    .gsms-not-answered { background: red; }
    .gsms-answered { background: green; }
    .gsms-marked { background: purple; }
    .gsms-not-visited { background: blue; }
</style>

<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">CBTS Stat Exam View</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item">CBTS</li>
                    <li class="breadcrumb-item">Take Exam</li>
                    <li class="breadcrumb-item active">Views</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid row">
        <!-- Take Exam Card -->
        <div class="col-md-8" style="margin: 20px 0;">
            <div class="card" style="border-radius: 15px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);">
                <div class="card-header text-center" style="background-color: #2196F3; color: white; padding: 20px;">
                    <h3 class="card-title" style="font-weight: bold;">Take Exam</h3>
                </div>

                <div class="row instructions">
                    <div class="col-md-12 text-warning text-center mt-3 mb-3">
                        <i class="fa fa-exclamation-triangle"></i> Please do not press back during the exam.
                    </div>
                </div>

                <form id="fn_online_exam_form" method="post">
                    @csrf

                    <!-- Camera Section -->
                    <div class="camera-section text-center mb-3">
                        <video id="video" width="640" height="480" autoplay></video>
                        <button type="button" id="captureButton" class="btn btn-warning">Capture</button>
                        <canvas id="canvas" width="640" height="480" style="display: none;"></canvas>
                    </div>

                    <div class="box wizard" id="fn_question_wizard">
                        <div class="steps-container">
                            <ul class="steps" style="margin-left: 0; display: flex; justify-content: center;">
                                @foreach ($examQuestion as $key => $question)
                                    <li data-step="{{ $key + 1 }}" class="{{ $key == 0 ? 'active' : '' }}">
                                        <div></div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="step-content">
                            @if ($examQuestion->isNotEmpty())
                                @foreach ($examQuestion as $key => $question)
                                    <div class="step-pane {{ $key == 0 ? 'active' : '' }}" data-questionID="{{ $question->id }}" data-step="{{ $key + 1 }}">
                                        <div class="question-section" style="padding: 20px; background-color: #f9f9f9; border-radius: 10px; margin-bottom: 15px;">
                                            <div class="question-count" style="margin-bottom: 10px;">
                                                <strong style="font-size: 1.5em;">Question {{ $key + 1 }} of {{ $examQuestion->count() }}</strong>
                                                <span class="badge badge-info" style="font-size: 1.2em;">{{ $question->mark ? 'Mark: ' . $question->mark : '' }}</span>
                                            </div>
                                            <div class="question-title" style="text-align: center; font-size: 2em; font-weight: bold;">{{ $question->question }}</div>
                                            @if ($question->image)
                                                <img src="{{ asset('images/' . $question->image) }}" 
                                                     alt="Question Image" 
                                                     style="max-width: 100%; margin-top: 10px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);" />
                                            @endif
                                            <input type="hidden" name="total_marks[{{ $question->id }}]" value="{{ $question->mark }}" />
                                        </div>

                                        <div class="answer-section">
                                            <table class="table table-bordered" style="font-size: 2em;text-align: center;">
                                                @if ($question->cqtype == 'true_false' || $question->cqtype == 'mcqs')
                                                    <tr>
                                                        @foreach ($examanswers as $option)
                                                            @if ($question->q_id == $option->q_Id)
                                                                <td>
                                                                    <input id="option{{ $option->id }}" value="{{ $option->id }}" name="answer[{{ $question->cqtype }}][{{ $question->q_id }}][]" type="radio">
                                                                    <label for="option{{ $option->id }}">{{ $option->answer }}</label>
                                                                </td>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                @elseif ($question->cqtype == 'fill_in_the_blanks')
                                                    <tr>
                                                        <td colspan="2">
                                                            <input type="text" name="answer[fill_in_the_blanks][{{ $question->id }}][]" 
                                                                   class="form-control" 
                                                                   placeholder="Your answer here" 
                                                                   style="font-size: 50px; width: 100%; height: 70px;">
                                                        </td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class='text-center'>No data found.</p>
                            @endif

                            <div class="question-answer-button text-center mb-5">
                                <button class="btn btn-prev btn-primary" type="button" id="gsms-prevbutton" disabled>
                                    <i class="fa fa-angle-left"></i> Previous
                                </button>
                                <button class="btn btn-primary" type="button" id="gsms-reviewbutton">Mark for Review</button>
                                <button class="btn btn-next btn-primary" type="button" id="gsms-nextbutton">Next <i class="fa fa-angle-right"></i></button>
                                <button class="btn btn-primary" type="button" id="gsms-clearbutton">Reset Answer</button>
                                <button class="btn btn-primary" type="submit" id="gsms-finishedbutton">Completed</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Exam Info Card -->
        <div class="col-md-4" style="padding: 20px;">
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
                <div class="card-header text-center" style="background-color: #2196F3; color: white;">
                    <h3 class="card-title">Exam Title</h3>
                </div>
                <div class="card-body">
                    <h5 class="time-title">{{ $exam->first()->ex_title }}</h5>
                </div>
            </div>

            <!-- Exam Statistics Card -->
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); margin-top: 20px;">
                <div class="card-header text-center" style="background-color: #2196F3; color: white;">
                    <h3 class="card-title">Exam Statistics</h3>
                </div>
                <div class="card-body">
                    <h5 class="section-title">Total Questions: {{ $examQuestion->count() }}</h5>
                    <div class="row">
                        <div class="col-sm-6">
                            <h6>Total Time:</h6>
                            <h6 class="time-clock fn_exam_duration">00:00:00</h6>
                        </div>
                        <div class="col-sm-6">
                            <h6>Remaining Time:</h6>
                            <h6 id="fn_timer_container" class="time-clock" style="color: red; font-weight: bold;"></h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Question Navigation Card -->
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); margin-top: 20px;">
                <div class="card-header text-center" style="background-color: #2196F3; color: white;">
                    <h3 class="card-title">Question Navigation</h3>
                </div>
                <div class="card-body">
                    <h5 class="section-title">Total Questions: {{ $examQuestion->count() }}</h5>
                    <ul class="exam-question-box fn_question_statistics">
                        @foreach ($examQuestion as $q_key => $q_obj)
                            <li>
                                @php
                                    // Example status logic, replace with actual logic
                                    $statusClass = 'gsms-not-visited'; // Default status
                                    if (isset($answeredQuestions[$q_obj->id])) {
                                        $statusClass = 'gsms-answered';
                                    } elseif (isset($markedQuestions[$q_obj->id])) {
                                        $statusClass = 'gsms-marked';
                                    }
                                @endphp
                                <a class="{{ $statusClass }} default-bg" id="question{{ $q_key + 1 }}" href="javascript:void(0);" onclick="gsms_jump_question({{ $q_key + 1 }})">
                                    {{ $q_key + 1 }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@section('footer')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
    let currentStep = 1;
    const totalSteps = {{ $examQuestion->count() }};
    const answeredQuestions = {};
    const markedQuestions = {};
    let examActive = true; // To track if the exam is ongoing
    let timerInterval;
    let hours, minutes, seconds;

    // Camera functionality
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureButton = document.getElementById('captureButton');
    
    // Access the camera
    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            video.srcObject = stream;
        })
        .catch((error) => {
            console.error("Error accessing camera: ", error);
        });

    // Capture the image
    captureButton.addEventListener('click', () => {
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = canvas.toDataURL('image/png');

        // Send the image data to the server
        fetch('/upload-image', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ image: imageData })
        }).then(response => {
            if (response.ok) {
                alert('Image captured and uploaded successfully!');
            } else {
                alert('Error uploading image');
            }
        }).catch(error => {
            console.error('Error:', error);
        });
    });

    function showStep(step) {
        $('.step-pane').removeClass('active').hide();
        $('.step-pane[data-step="' + step + '"]').addClass('active').show();

        // Update the step indicators
        $('.steps li').removeClass('active');
        $('.steps li[data-step="' + step + '"]').addClass('active');

        $('#gsms-prevbutton').prop('disabled', step === 1);
    }

    $('#gsms-nextbutton').click(function() {
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
    });

    $('#gsms-prevbutton').click(function() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    $('#gsms-clearbutton').click(function() {
        const currentQuestionPane = $('.step-pane.active');
        currentQuestionPane.find('input[type="radio"]:checked').prop('checked', false);
        currentQuestionPane.find('input[type="text"]').val('');
        const currentStep = currentQuestionPane.data('step');
        $('#question' + currentStep).removeClass('gsms-answered gsms-marked').addClass('gsms-not-answered');
    });

    $('#gsms-reviewbutton').click(function() {
        const currentQuestionPane = $('.step-pane.active');
        const currentStep = currentQuestionPane.data('step');
        markedQuestions[currentStep] = true;
        $('#question' + currentStep).removeClass('gsms-answered').addClass('gsms-marked');
    });

    $(document).ready(function() {
        showStep(1);
        startTimer({{ $exam->first()->ex_duration }}); // Start timer with exam duration
    });

    function time_counter() {
        timerInterval = setInterval(function() {
            if (!examActive) return; // Exit if exam is no longer active

            if (hours === 0 && minutes === 0 && seconds === 0) {
                clearInterval(timerInterval);
                submitExam();
                return;
            }

            seconds--;
            if (seconds < 0) {
                seconds = 59;
                minutes--;
            }
            if (minutes < 0) {
                minutes = 59;
                hours--;
            }

            $('#fn_timer_container').text(`${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`);
        }, 1000);
    }

    function formatTime(seconds) {
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const remainingSeconds = seconds % 60;

        return (
            String(hours).padStart(2, '0') + ':' +
            String(minutes).padStart(2, '0') + ':' +
            String(remainingSeconds).padStart(2, '0')
        );
    }

    function startTimer(durationInMinutes) {
        hours = Math.floor(durationInMinutes / 60);
        minutes = durationInMinutes % 60;
        seconds = 0; // Reset seconds
        time_counter();
    }

    function submitExam() {
        examActive = false; // Mark the exam as inactive
        clearInterval(timerInterval); // Stop the timer
        document.getElementById('fn_online_exam_form').submit(); // Submit the form
    }

    $(document).ready(function() {
        const totalTimeInMinutes = {{ $exam->first()->ex_duration }};
        const totalTimeInSeconds = totalTimeInMinutes * 60; // Convert minutes to seconds
        $('.fn_exam_duration').text(formatTime(totalTimeInSeconds));
    });

    function gsms_jump_question(step) {
        currentStep = step;
        showStep(currentStep);
    }

    // Event listeners for visibility and blur
    document.addEventListener('visibilitychange', function() {
        if (examActive && document.visibilityState === 'hidden') {
            submitExam(); // Automatically submit the exam if the user switches tabs
        }
    });

    window.addEventListener('blur', function() {
        if (examActive && !modalOpen) {
            submitExam(); // Automatically submit the exam if the window loses focus
        }
    });
    </script>
    <style>
    /* Other styles remain the same */

    .camera-section {
        position: absolute; /* Position the camera section absolutely */
        top: 30px; /* Adjust top position */
        left: 20px; /* Adjust left position */
        z-index: 1000; /* Ensure it's on top of other elements */
        background-color: rgba(255, 255, 255, 0.8); /* Optional: make it slightly transparent */
        padding: 5px; /* Reduced padding */
        border-radius: 10px; /* Optional: round the corners */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); /* Optional: add shadow */
    }

    #video {
        width: 120px; /* Set a smaller width */
        height: auto; /* Maintain aspect ratio */
        border-radius: 5px; /* Optional: round corners */
    }

    #captureButton {
        margin-top: 5px; /* Reduced space between video and button */
        font-size: 12px; /* Smaller button text */
    }
</style>

@endsection
