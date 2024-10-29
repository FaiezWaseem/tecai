@extends('dashboard.common')

@section('sidebar')     
    @include('dashboard.superadmin.sidebar')     
    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script> 
@endsection  

@section('content')     
    <div class="content-header">         
        <div class="container-fluid">             
            <div class="row mb-2">                 
                <div class="col-sm-6">                     
                    <h1 class="m-0">EDIT Question</h1>                 
                </div>                 
                <div class="col-sm-6">                     
                    <ol class="breadcrumb float-sm-right">                         
                        <li class="breadcrumb-item">                             
                            <a href="{{ route('superadmin.home.view') }}">Home</a>                         
                        </li>                         
                        <li class="breadcrumb-item">CBTS</li>                         
                        <li class="breadcrumb-item">Question Bank</li>                         
                        <li class="breadcrumb-item active">Edit</li>                     
                    </ol>                 
                </div>             
            </div>         
        </div>     
    </div>     

    <section class="content">         
        <div class="container-fluid">             
            <form method="POST" enctype="multipart/form-data" id="submitForm">
                @csrf
                @method('PUT')

                <div class="row">                     
                    <div class="col-md-4">                         
                        <div class="form-group">                             
                            <label for="school">School <span class="text-danger">*</span></label>                             
                            <select class="form-control" id="schools" name="school" required disabled>                             
                                <option value="">--Select--</option>                                 
                                @foreach ($schools as $item)                                     
                                    <option value="{{ $item->id }}" {{ $item->id == $question->school_id ? 'selected' : '' }}>{{ $item->school_name }}</option>                                 
                                @endforeach                             
                            </select>                             
                        </div>                     
                    </div>                     

                    <div class="col-md-4">                         
                        <div class="form-group">                             
                            <label for="cboard_id">Board <span class="text-danger">*</span></label>                             
                            <select name="cboard_id" class="form-control" required>                                 
                                @foreach ($boards as $item)                                     
                                    <option value="{{ $item->id }}" {{ $item->id == $question->cboard_id ? 'selected' : '' }}>{{ $item->board_name }}</option>                                 
                                @endforeach                             
                            </select>                         
                        </div>                     
                    </div>                     

                    <div class="col-md-4">                         
                        <div class="form-group">                             
                            <label for="cclass_id">Class <span class="text-danger">*</span></label>                             
                            <select name="cclass_id" id="classes" class="form-control" required>                             
                                <option value="">--Select--</option>                             
                                @foreach ($classes as $class)                                     
                                    <option value="{{ $class->id }}" {{ $class->id == $question->cclass_id ? 'selected' : '' }}>{{ $class->class_name }}</option>                                 
                                @endforeach                             
                            </select>
                            @error('cclass_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror                         
                        </div>                     
                    </div>                     

                    <div class="col-md-4">                         
                        <div class="form-group">                             
                            <label for="ccourse_id">Course <span class="text-danger">*</span></label>                             
                            <select name="ccourse_id" class="form-control" id="courses" required>                                 
                                <option value="">--Select--</option>                                 
                                @foreach ($courses as $item)                                     
                                    <option value="{{ $item->id }}" {{ $item->id == $question->ccourse_id ? 'selected' : '' }}>{{ $item->course_name }}</option>                                 
                                @endforeach                             
                            </select>                         
                        </div>                     
                    </div>                     

                    <div class="col-md-4">                         
                        <div class="form-group">                             
                            <label for="cchapter_id">Chapter <span class="text-danger">*</span></label>                             
                            <select name="cchapter_id" class="form-control" id="chapters" >                                 
                                <option value="">--Select--</option> 
                               
                            </select>
                        </div>                     
                    </div>                     

                    <div class="col-md-4">                         
                        <div class="form-group">                             
                            <label for="cquestion">Question <span class="text-danger">*</span></label>                             
                            <input type="text" name="cquestion" class="form-control" value="{{ old('cquestion', $question->cquestion) }}" required>                         
                        </div>                     
                    </div>      

                    <div class="form-group">         
                        <label for="image">Upload Image:</label>         
                        <input type="file" class="form-control" name="image" id="image"> <!-- Optional upload -->
                    </div>                     

                    <div class="col-md-4">                         
                        <div class="form-group">                             
                            <label for="mark">Mark <span class="text-danger">*</span></label>                             
                            <input type="text" name="mark" class="form-control" value="{{ old('mark', $question->mark) }}" required>                         
                        </div>                     
                    </div>                     

                    <div class="form-group">
                        <label for="cqtype_id">Question Type</label>
                        <select id="cqtype_id" name="cqtype_id" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="mcqs" {{ $question->cqtype == 'mcqs' ? 'selected' : '' }}>Multiple Choice</option>
                            <option value="true_false" {{ $question->cqtype == 'true_false' ? 'selected' : '' }}>True/False</option>
                            <option value="fill_in_the_blanks" {{ $question->cqtype == 'fill_in_the_blanks' ? 'selected' : '' }}>Fill in the Blanks</option>
                            <option value="single_line_answer" {{ $question->cqtype == 'single_line_answer' ? 'selected' : '' }}>Single Line Answer</option>
                        </select>
                    </div>

                    <div class="form-group" id="optionsContainer" style="display: {{ $question->cqtype == 'mcqs' ? 'block' : 'none' }};">
                        <label for="totalOptions">Total Options</label>
                        <input type="number" id="totalOptions" name="totalOptions" class="form-control" min="1" value="{{ count($answers) }}" required>
                    </div>

                    <div id="answerContainer" class="form-group">
                        @if ($question->cqtype == 'mcqs')
                            @foreach ($answers as $index => $answer)
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <label for="answer{{ $index + 1 }}">Option {{ $index + 1 }} <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="answer[]" class="form-control" id="answer{{ $index + 1 }}" placeholder="Option {{ $index + 1 }}" value="{{ old('answer.' . $index, $answer->answer) }}" required>
                                            <div class="input-group-append">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" name="correct_answer" id="correct{{ $index + 1 }}" value="{{ $index + 1 }}" {{ $answer->is_correct ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="correct{{ $index + 1 }}">Correct</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @elseif ($question->cqtype == 'true_false')
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="correct_answer" id="true_answer" value="true" {{ $question->correct_answer == 'true' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="true_answer">True</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="correct_answer" id="false_answer" value="false" {{ $question->correct_answer == 'false' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="false_answer">False</label>
                            </div>
                        @elseif ($question->cqtype == 'fill_in_the_blanks' || $question->cqtype == 'single_line_answer')
                            <label for="answer">Your Answer <span class="text-danger">*</span></label>
                            <input type="text" name="answer" class="form-control" value="{{ old('answer', $answers->first()->answer ?? '') }}" required>
                        @endif
                    </div>
                </div>                  

                <div class="row">                     
                    <div class="col-md-11">                         
                        <input type="submit" value="UPDATE" class="btn btn-success">                     
                    </div>                     
                    <button type="button" class="btn btn-danger" onclick="window.location.back()">CANCEL</button>                  
                </div>             
            </form>         
        </div>     
    </section>     

@endsection  

@section('footer')     
 
@endsection  