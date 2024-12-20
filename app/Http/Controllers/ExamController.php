<?php

namespace App\Http\Controllers;

use App\Models\{
    Cquestion,
    Canswer,
    Exam,
    ExamQuestion,
    Tboards,
    TCourses,
    TClasses,
    Classes,
    Tchapters,
    school,
    students,
    StudentImage,
    demostudents,
    ExamChapter,
    ExamAnswer,
    ExamResult
};
use Carbon\Carbon;

use PDF; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExamController extends Controller
{
    // ----------------------View Exam-------------------------------------

    public function SuperAdminViewCBTSExam(Request $request)
    {
        $boards = Tboards::all();
        $schools = School::all();
        $classes = TClasses::all();
        $courses = TCourses::all();
        $rqMethod = $request->method();
    
        if ($rqMethod === 'GET') {
            $exams = Exam::join('tboards', 'tboards.id', '=', 'exam.ex_board_id')
    ->join('tclasses', 'tclasses.id', '=', 'exam.ex_class_id')
    ->join('tcourse', 'tcourse.id', '=', 'exam.ex_course_id')
    ->join('school', 'school.id', '=', 'exam.school_id')       
    ->select(
        'exam.*',
        'school.school_name as school',
        'tclasses.class_name',
        'exam.ex_title AS title',
        'tboards.board_name',
        'tcourse.course_name'
    )
    ->paginate(10);


    $examschapter = ExamChapter::join('exam', 'exam.id', '=', 'exam_chapter.exam_id') 
        ->join('tchapters', 'tchapters.id', '=', 'exam_chapter.chapter_id')

        ->select(
            'exam_chapter.*', 
            'tchapters.chapter_title as chapter_name'
        )
        ->paginate(10);
    

return view('dashboard.superadmin.cbts.exam.view')
    ->with('exams', $exams)
    ->with('examschapter', $examschapter) 
    ->with('boards', $boards)    
    ->with('classes', $classes)
    ->with('schools', $schools)
    ->with('courses', $courses);
    }
        
        // ----------------------Exam filter-------------------------------------
        elseif ($rqMethod === 'POST') {
            
    $examschapter = ExamChapter::join('exam', 'exam.id', '=', 'exam_chapter.exam_id') 
    ->join('tchapters', 'tchapters.id', '=', 'exam_chapter.chapter_id')

    ->select(
        'exam_chapter.*', 
        'tchapters.chapter_title as chapter_name'
    )
    ->paginate(10);


            $exams = Exam::where('exam.ex_board_id', $request->ex_board_id)
            ->where('exam.ex_class_id', $request->ex_class_id)
            ->where('exam.ex_course_id', $request->ex_course_id)
            ->where('exam.school_id', $request->school)
            ->join('tboards', 'tboards.id', '=', 'exam.ex_board_id')
            ->join('school', 'school.id', '=', 'exam.school_id')       
            ->join('tclasses', 'tclasses.id', '=', 'exam.ex_class_id')
            ->join('tcourse', 'tcourse.id', '=', 'exam.ex_course_id')
            ->select(
                'exam.*', 
                'tclasses.class_name', 
                'tboards.board_name',
                'school.school_name as school',
                'exam.ex_title AS title', 
                'tcourse.course_name'
            )
            ->paginate(50);
        
     
    
            return view('dashboard.superadmin.cbts.exam.view')
                ->with('exams', $exams) 
                ->with('examschapter', $examschapter) 
                ->with('boards', $boards)
                ->with('classes', $classes)
                ->with('schools', $schools)
                ->with('courses', $courses);
        }
    }

    
    // ---------------------- Student View Exam-------------------------------------

    public function StudentViewCBTSExamView(Request $request){
      
    
        $rqMethod = $request->method();
        if ($rqMethod === 'GET') {
           
            $studentId = session('user.id'); 
            $student = students::where('students.id', $studentId)
                ->join('school', 'students.school', '=', 'school.id') 
                ->select('students.*', 'school.school_name') 
                ->first();
            
            if (!$student) {
                return redirect()->back()->withErrors(['Student not found.']);
            }
            
            $class = Classes::where('class_name', $student->class)->where('school_id', session('user.school')        )->first();
            
            if (!$class) {
                return redirect()->back()->withErrors(['Class not found.']);
            }
            
            $userClassId = $class->id;
            $userSchoolId = session('user.school'); 

        
            $exams = Exam::join('tboards', 'tboards.id', '=', 'exam.ex_board_id')
                ->join('tclasses', 'tclasses.id', '=', 'exam.ex_class_id')
                ->join('tcourse', 'tcourse.id', '=', 'exam.ex_course_id')
                ->join('school', 'school.id', '=', 'exam.school_id')
                ->where('exam.ex_school_class_id', $userClassId)
                ->where('exam.school_id', $userSchoolId)
                                    
  
    ->select(
        'exam.*',
        'school.school_name as school',
        'tclasses.class_name',
        'exam.ex_title AS title',
        'tboards.board_name',
        'tcourse.course_name'
    )
    ->paginate(10);


    $examschapter = ExamChapter::join('exam', 'exam.id', '=', 'exam_chapter.exam_id') 
        ->join('tchapters', 'tchapters.id', '=', 'exam_chapter.chapter_id')

        ->select(
            'exam_chapter.*', 
            'tchapters.chapter_title as chapter_name'
        )
        ->paginate(10);
    

return view('dashboard.students.cbts.exam.view')
    ->with('exams', $exams)
    ->with('examschapter', $examschapter);
    }

    }




    
    public function DemoStudentViewCBTSExamView(Request $request){
      
    
        $rqMethod = $request->method();
        if ($rqMethod === 'GET') {
           
            $boardId = $request->id;
            $studentId = session('user.id'); 
            $student = demostudents::where('democbts.id', $studentId)->first();
            
            if (!$student) {
                return redirect()->back()->withErrors(['Student not found.']);
            }
            
            $class = Tclasses::where('class_name', $student->class)->first();
            
            if (!$class) {
                return redirect()->back()->withErrors(['Class not found.']);
            }
            
            $userClassId = $class->id;

        
            $exams = Exam::join('tboards', 'tboards.id', '=', 'exam.ex_board_id')
                ->join('tclasses', 'tclasses.id', '=', 'exam.ex_class_id')
                ->join('tcourse', 'tcourse.id', '=', 'exam.ex_course_id')
                ->join('school', 'school.id', '=', 'exam.school_id')
                ->where('exam.ex_class_id', $userClassId)
                ->where('exam.ex_board_id', $student->board_id)
                                
  
    ->select(
        'exam.*',
        'school.school_name as school',
        'tclasses.class_name',
        'exam.ex_title AS title',
        'tboards.board_name',
        'tcourse.course_name'
    )
    ->paginate(10);


    $examschapter = ExamChapter::join('exam', 'exam.id', '=', 'exam_chapter.exam_id') 
        ->join('tchapters', 'tchapters.id', '=', 'exam_chapter.chapter_id')

        ->select(
            'exam_chapter.*', 
            'tchapters.chapter_title as chapter_name'
        )
        ->paginate(10);
    

return view('dashboard.demostudents.cbts.exam.view')
    ->with('exams', $exams)                   

    
    ->with('examschapter', $examschapter);
    }

    }


    // ----------------------Take  Exam screen-------------------------------------


    public function StudentViewCBTSTakeExam(Request $request)
    {
        $boards = Tboards::all();
        $tclasses = Tclasses::all();
        $TCourses = TCourses::all();
        $schools = School::all();
    
        $rqMethod = $request->method();
        if ($rqMethod === 'GET') {
        

        
            $exams= Exam::where('id', $request->exam_id)->first(); 
                         

return view('dashboard.students.cbts.exam.takeexam')
    ->with('exams', $exams);
    }
        
        
    }


    
    

    public function DemoStudentViewCBTSTakeExam(Request $request)
    {
        $boards = Tboards::all();
        $tclasses = Tclasses::all();
        $TCourses = TCourses::all();
        $schools = School::all();
    
        $rqMethod = $request->method();
        if ($rqMethod === 'GET') {
        

        
            $exams= Exam::where('id', $request->exam_id)->first(); 
                         

return view('dashboard.demostudents.cbts.exam.takeexam')
    ->with('exams', $exams);

    }
        
        
    }
  
        // ----------------------Start Exam-------------------------------------
        public function StudentViewCBTSStartExam(Request $request)
        {
            $boards = Tboards::all();
            $tclasses = TClasses::all();
            $TCourses = TCourses::all();
            $schools = School::all();
            $exam= Exam::where('id', $request->exam_id)->first(); 

            if (!$exam) {
                return redirect()->back()->with('error', 'Exam not found.');
            }
            $currentDate = date('Y-m-d');
            if ($exam->ex_end_date < $currentDate) {
    return redirect()->back()->withErrors(['message' => "Exam time already expired"]);
}

// Check if the exam has not started yet
if ($exam->ex_start_date > $currentDate) {
    return redirect()->back()->withErrors(['message' => "Please wait for the exam to start"]);
}

    // Check if the student has already completed the exam in the exam_taken_exam table
    $studentId = session('user')['id'];
    $examTaken = ExamResult::where('student_id', $studentId)
        ->where('exam_id', $exam->id)
        ->where('exam_status', 1) 
        ->first();

    if ($examTaken) {
        return redirect()->back()->withErrors(['message' => "You have already completed this exam."]);
    }
            if ($request->isMethod('GET')) {
        
                $exams = Exam::join('tboards', 'tboards.id', '=', 'exam.ex_board_id')
                    ->join('tclasses', 'tclasses.id', '=', 'exam.ex_class_id')
                    ->join('tcourse', 'tcourse.id', '=', 'exam.ex_course_id')
                    ->join('school', 'school.id', '=', 'exam.school_id')

                    ->select(
                        'exam.*',
                        'school.school_name as school',
                        'tclasses.class_name',
                        'exam.ex_title AS title',
                        'tboards.board_name',
                        'tcourse.course_name'
                    )

                    ->paginate(10);
        
                $examQuestion = ExamQuestion::join('c_questionbank', 'c_questionbank.id', '=', 'exam_question.q_id')
                    ->select('exam_question.*', 'c_questionbank.*', 'c_questionbank.cquestion AS question')
                    ->where('exam_question.exam_id', $request->exam_id)
                    ->inRandomOrder() 
                    ->get();
        
                $examAnswers = Canswer::join('exam_question', 'exam_question.q_id', '=', 'c_answer.q_Id')
                    ->join('c_questionbank', 'c_questionbank.id', '=', 'c_answer.q_Id')
                    ->select('exam_question.*', 'c_questionbank.*', 'c_answer.*')
                    ->where('exam_question.exam_id', $request->exam_id )
                    ->inRandomOrder() 
                    ->get();
                    $exam= Exam::where('id', $request->exam_id)->get(); 

        
                return view('dashboard.students.cbts.exam.startexam', [
                    'schools' => $schools,
                    'exam' => $exam,
                    'examQuestion' => $examQuestion,
                    'examanswers' => $examAnswers,
                    'boards' => $boards,
                    'tclasses' => $tclasses,
                    'TCourses' => $TCourses,
                ]);
            }
            if ($request->isMethod('POST')) {
                $exam = Exam::find($request->exam_id);

                if (!$exam) {
                    return redirect()->back()->with('error', 'Exam not found.');
                }
                
               
                $negativeMarkingPenalty = 1;

                if (!empty($answers)) {
                    foreach ($answers as $ans_key => $answer) {
                        if (in_array($ans_key, ['mcqs', 'true_false'])) {
                            foreach ($answer as $q_key => $obj) {
                                $answer_id = $obj[0];
                                $result = Canswer::find($answer_id);
                                if ($result && $result->is_correct) {
                                    $total_correct_answer++;
                                    $total_obtain_mark += $total_marks[$q_key] ?? 0;
                                } else {
                                    $total_incorrect_answer++;
                                    $total_obtain_mark -= $negativeMarkingPenalty; 
                                }
                            }
                        } elseif ($ans_key == 'fill_in_the_blanks') {
                            foreach ($answer as $q_key => $user_inputs) {
                                if (is_array($user_inputs)) {
                                    $is_correct_count = 0;
                                    $total_correct_answers = Canswer::where('q_id', $q_key)->pluck('answer')->map(function ($item) {
                                        return strtolower(trim($item));
                                    });
                                    
                                    foreach ($user_inputs as $user_input) {
                                        $normalized_input = strtolower(trim($user_input));
                                        if ($total_correct_answers->contains($normalized_input)) {
                                            $is_correct_count++;
                                        }
                                    }
                                    
                                    if ($is_correct_count > 0) {
                                        $total_correct_answer++;
                                        $total_obtain_mark += $total_marks[$q_key] ?? 0;
                                    } else {
                                        $total_incorrect_answer++;
                                        $total_obtain_mark -= $negativeMarkingPenalty; 
                                    }
                                }
                            }
                        }
                    }
                }        
                $result_status = 'failed'; 
                $obtain_mark_percent = 0;
        
                if ($total_obtain_mark > 0 && isset($exam->ex_pass_mark) && $exam->ex_pass_mark > 0) {
                    $obtain_mark_percent = $total_obtain_mark; 
                    $result_status = ($obtain_mark_percent >= $exam->ex_pass_mark) ? 'passed' : 'failed';
                }
        
                $studentId = session('user')['id'];
                $section = session('user')['section'];
        
                $total_answered = $total_correct_answer + $total_incorrect_answer;
        
                $not_answered = $total_question - $total_answered;
                if ($request->hasFile('image')) {
                        $request->validate([
        'image' => 'image|mimes:jpeg,png,jpg|max:2048', // File size can be adjusted
    ]);

    // Retrieve the uploaded image file
    $image = $request->file('image');
    
    // Define the image path
    $path = 'images/student_images'; // Define the storage path
    
    // Save the image to the specified path
    $imagePath = $image->storeAs($path, time() . '.' . $image->getClientOriginalExtension(), 'public');

    // Save the image path to the database
    $student = new StudentImage(); // Replace with the actual model
    $student->image_path = $imagePath;
    $student->save();

}
        






                // Create a new ExamResult instance
                $examResult = new ExamResult;
                $examResult->school_id = $exam->school_id;
                $examResult->student_id = $studentId;
                $examResult->exam_id = $exam->id;
                $examResult->class_id = $exam->ex_class_id;
                $examResult->section = $section; 
                $examResult->subject_id = $exam->ex_course_id;
                $examResult->total_question = $total_question;
                $examResult->total_answer = $total_answered; // Total answered
                $examResult->total_mark = $total_score;
                $examResult->total_correct_answer = $total_correct_answer;
                $examResult->total_incorrect_answer = $total_incorrect_answer;
                $examResult->total_obtain_mark = $total_obtain_mark;
                $examResult->obtain_mark_percent = $obtain_mark_percent;
                $examResult->not_answer = $not_answered; // Save not answered questions
                $examResult->result_status = $result_status;
                $examResult->exam_status = 1;
                $examResult->end_time = Carbon::now()->toDateTimeString();
                $examResult->start_time = $request->start_time;

$startTime = Carbon::parse($examResult->start_time);
$endTime = Carbon::parse($examResult->end_time);
$totalSeconds = $startTime->diffInSeconds($endTime);

$hours = floor($totalSeconds / 3600);
$minutes = floor(($totalSeconds % 3600) / 60);
$seconds = $totalSeconds % 60;

// Save time taken in HH:MM:SS format
$timeTaken = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
$examResult->time_taken = $timeTaken; // Save in TIME format



$total_questions = $request->input('total_question', []);





foreach ($request->input('answer') as $questionType => $answers) {
    foreach ($answers as $questionId => $studentAnswer) {
        $examAnswer = new ExamAnswer;
        $examAnswer->exam_id = $request->input('exam_id'); 
        $examAnswer->student_id = $studentId; 
        $examAnswer->q_id = $questionId;
        // $examAnswer->time_taken = Carbon::now()->toTimeString();;
        // $examAnswer->start_time = Carbon::now()->toTimeString();;
        // $examAnswer->end_time = Carbon::now()->toTimeString();


        if ($questionType === 'mcqs' || $questionType === 'true_false') {
            if (is_array($studentAnswer)) {
                $studentAnswer = $studentAnswer[0]; 
            }
            $result = Canswer::find($studentAnswer); 
            if ($result) {
                $examAnswer->answer = $result->answer; 
            } else {
                $examAnswer->answer = null; 
            }
        }

        if ($questionType === 'fill_in_the_blanks') {
            $examAnswer->answer = implode(', ', $studentAnswer); 
        }
        $examAnswer->save();
    }
}
$examResult->save();
                
                $schools = School::all();
         $examschapter = ExamChapter::join('exam', 'exam.id', '=', 'exam_chapter.exam_id') 
        ->join('tchapters', 'tchapters.id', '=', 'exam_chapter.chapter_id')

        ->select(
            'exam_chapter.*', 
            'tchapters.chapter_title as chapter_name'
        )
        ->paginate(10);
   
        $result = ExamResult::join('school', 'school.id', '=', 'exam_taken_exams.school_id')
        ->join('exam', 'exam.id', '=', 'exam_taken_exams.exam_id')
        ->join('students', 'exam_taken_exams.student_id', '=', 'students.id') 
        ->join('tclasses', 'exam_taken_exams.class_id', '=', 'tclasses.id') 
        ->join('tcourse', 'exam_taken_exams.subject_id', '=', 'tcourse.id')
        ->select(
            'exam_taken_exams.*',
            'school.school_name as school_name',
            'students.name as student_name',
            'tclasses.class_name as class_name', 
            'exam.ex_title as exam_title' ,
            'tcourse.course_name as course_name' 
    
        )
                ->paginate(50);

        
                return view('dashboard.students.cbts.exam.result')
                ->with('examschapter', $examschapter)
                ->with('schools', $schools)
                ->with('result', $result)
                ->with('TCourses', $TCourses);
            }
          
        }
        

















   // ----------------------Start Exam-------------------------------------
   public function DemoStudentViewCBTSStartExam(Request $request)
        {
            $boards = Tboards::all();
            $tclasses = TClasses::all();
            $TCourses = TCourses::all();
            $schools = School::all();
            $exam= Exam::where('id', $request->exam_id)->first(); 

            if (!$exam) {
                return redirect()->back()->with('error', 'Exam not found.');
            }
            $currentDate = date('Y-m-d');
            if ($exam->ex_end_date < $currentDate) {
    return redirect()->back()->withErrors(['message' => "Exam time already expired"]);
}

// Check if the exam has not started yet
if ($exam->ex_start_date > $currentDate) {
    return redirect()->back()->withErrors(['message' => "Please wait for the exam to start"]);
}

    // Check if the student has already completed the exam in the exam_taken_exam table
    $studentId = session('user')['id'];
    $examTaken = ExamResult::where('student_id', $studentId)
        ->where('exam_id', $exam->id)
        ->where('exam_status', 1) 
        ->first();

    if ($examTaken) {
        return redirect()->back()->withErrors(['message' => "You have already completed this exam."]);
    }
            if ($request->isMethod('GET')) {
        
                $exams = Exam::join('tboards', 'tboards.id', '=', 'exam.ex_board_id')
                    ->join('tclasses', 'tclasses.id', '=', 'exam.ex_class_id')
                    ->join('tcourse', 'tcourse.id', '=', 'exam.ex_course_id')
                    ->join('school', 'school.id', '=', 'exam.school_id')

                    ->select(
                        'exam.*',
                        'school.school_name as school',
                        'tclasses.class_name',
                        'exam.ex_title AS title',
                        'tboards.board_name',
                        'tcourse.course_name'
                    )

                    ->paginate(10);
        
                $examQuestion = ExamQuestion::join('c_questionbank', 'c_questionbank.id', '=', 'exam_question.q_id')
                    ->select('exam_question.*', 'c_questionbank.*', 'c_questionbank.cquestion AS question')
                    ->where('exam_question.exam_id', $request->exam_id)
                    ->inRandomOrder() 
                    ->get();
        
                $examAnswers = Canswer::join('exam_question', 'exam_question.q_id', '=', 'c_answer.q_Id')
                    ->join('c_questionbank', 'c_questionbank.id', '=', 'c_answer.q_Id')
                    ->select('exam_question.*', 'c_questionbank.*', 'c_answer.*')
                    ->where('exam_question.exam_id', $request->exam_id )
                    ->inRandomOrder() 
                    ->get();
                    $exam= Exam::where('id', $request->exam_id)->get(); 

        
                return view('dashboard.students.cbts.exam.startexam', [
                    'schools' => $schools,
                    'exam' => $exam,
                    'examQuestion' => $examQuestion,
                    'examanswers' => $examAnswers,
                    'boards' => $boards,
                    'tclasses' => $tclasses,
                    'TCourses' => $TCourses,
                ]);
            }
            if ($request->isMethod('POST')) {
                $exam = Exam::find($request->exam_id);

                if (!$exam) {
                    return redirect()->back()->with('error', 'Exam not found.');
                }
                
               
                
                $answers = $request->input('answer');
                $total_correct_answer = 0;
                $total_incorrect_answer = 0;
                $total_obtain_mark = 0;
                $total_marks = $request->input('total_marks', []);
                
                $total_score = array_sum($total_marks); 
                $total_question = count($total_marks);
                
                if (!empty($answers)) {
                    foreach ($answers as $ans_key => $answer) {
                        if (in_array($ans_key, ['mcqs', 'true_false'])) {
                            foreach ($answer as $q_key => $obj) {
                                $answer_id = $obj[0];
                                $result = Canswer::find($answer_id);
                                if ($result && $result->is_correct) {
                                    $total_correct_answer++;
                                    $total_obtain_mark += $total_marks[$q_key] ?? 0;
                                } else {
                                    $total_incorrect_answer++;
                                }
                            }
                        } elseif ($ans_key == 'fill_in_the_blanks') {
                            foreach ($answer as $q_key => $user_inputs) {
                                if (is_array($user_inputs)) {
                                    $is_correct_count = 0;
                                    $total_correct_answers = Canswer::where('q_id', $q_key)->pluck('answer')->map(function ($item) {
                                        return strtolower(trim($item)); // Normalize correct answers
                                    });
                                    
                                    foreach ($user_inputs as $user_input) {
                                        $normalized_input = strtolower(trim($user_input)); 
                                        if ($total_correct_answers->contains($normalized_input)) {
                                            $is_correct_count++;
                                        }
                                    }
                                    
                                    if ($is_correct_count > 0) {
                                        $total_correct_answer++;
                                        $total_obtain_mark += $total_marks[$q_key] ?? 0; 
                                    } else {
                                        $total_incorrect_answer++;
                                    }
                                }
                            }
                        }
                    }
                }
        
                $result_status = 'failed'; 
                $obtain_mark_percent = 0;
        
                if ($total_obtain_mark > 0 && isset($exam->ex_pass_mark) && $exam->ex_pass_mark > 0) {
                    $obtain_mark_percent = $total_obtain_mark; 
                    $result_status = ($obtain_mark_percent >= $exam->ex_pass_mark) ? 'passed' : 'failed';
                }
        
                $studentId = session('user')['id'];
                $section = session('user')['section'];
        
                $total_answered = $total_correct_answer + $total_incorrect_answer;
        
                $not_answered = $total_question - $total_answered;
        

// Check if there’s an image file in the request
if ($request->hasFile('image')) {
    // Validate the image
    $request->validate([
        'image' => 'image|mimes:jpeg,png,jpg|max:2048', // File size can be adjusted
    ]);

    // Retrieve the uploaded image file
    $image = $request->file('image');
    
    // Define the image path
    $path = 'images/student_images'; // Define the storage path
    
    // Save the image to the specified path
    $imagePath = $image->storeAs($path, time() . '.' . $image->getClientOriginalExtension(), 'public');

    // Save the image path to the database
    $student = new StudentImage(); // Replace with the actual model
    $student->image_path = $imagePath;
    $student->save();

}
        






                // Create a new ExamResult instance
                $examResult = new ExamResult;
                $examResult->school_id = $exam->school_id;
                $examResult->student_id = $studentId;
                $examResult->exam_id = $exam->id;
                $examResult->class_id = $exam->ex_class_id;
                $examResult->section = $section; 
                $examResult->subject_id = $exam->ex_course_id;
                $examResult->total_question = $total_question;
                $examResult->total_answer = $total_answered; // Total answered
                $examResult->total_mark = $total_score;
                $examResult->total_correct_answer = $total_correct_answer;
                $examResult->total_incorrect_answer = $total_incorrect_answer;
                $examResult->total_obtain_mark = $total_obtain_mark;
                $examResult->obtain_mark_percent = $obtain_mark_percent;
                $examResult->not_answer = $not_answered; // Save not answered questions
                $examResult->result_status = $result_status;
                $examResult->exam_status = 1;
                

// Set the end time as the current timestamp
$examResult->end_time = Carbon::now()->toDateTimeString();

// Set the start time from the request
$examResult->start_time = $request->start_time;

// Convert start_time and end_time to Carbon instances for time calculation
$startTime = Carbon::parse($examResult->start_time);
$endTime = Carbon::parse($examResult->end_time);

// Calculate the difference in total seconds
$totalSeconds = $startTime->diffInSeconds($endTime);

// Convert the total seconds into HH:MM:SS format
$hours = floor($totalSeconds / 3600);
$minutes = floor(($totalSeconds % 3600) / 60);
$seconds = $totalSeconds % 60;

// Save time taken in HH:MM:SS format
$timeTaken = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
$examResult->time_taken = $timeTaken; // Save in TIME format



$total_questions = $request->input('total_question', []);





foreach ($request->input('answer') as $questionType => $answers) {
    foreach ($answers as $questionId => $studentAnswer) {
        $examAnswer = new ExamAnswer;
        $examAnswer->exam_id = $request->input('exam_id'); 
        $examAnswer->student_id = $studentId; 
        $examAnswer->q_id = $questionId;
         $examAnswer->time_taken = Carbon::now()->toTimeString();;
        $examAnswer->start_time = Carbon::now()->toTimeString();;
        $examAnswer->end_time = Carbon::now()->toTimeString();

        if ($questionType === 'mcqs' || $questionType === 'true_false') {
            if (is_array($studentAnswer)) {
                $studentAnswer = $studentAnswer[0]; 
            }
            $result = Canswer::find($studentAnswer); 
            if ($result) {
                $examAnswer->answer = $result->answer; 
            } else {
                $examAnswer->answer = null; 
            }
        }

        // Handle Fill-in-the-Blanks answers
        if ($questionType === 'fill_in_the_blanks') {
            // Assuming $studentAnswer is an array, take the first answer
            $examAnswer->answer = implode(', ', $studentAnswer); // If multiple inputs are allowed, join them
        }

        // Save the answer to the database
        $examAnswer->save();
    }
}
                // Save the result to the database
                $examResult->save();
                
                $schools = School::all();
         $examschapter = ExamChapter::join('exam', 'exam.id', '=', 'exam_chapter.exam_id') 
        ->join('tchapters', 'tchapters.id', '=', 'exam_chapter.chapter_id')

        ->select(
            'exam_chapter.*', 
            'tchapters.chapter_title as chapter_name'
        )
        ->paginate(10);
   
        $result = ExamResult::join('school', 'school.id', '=', 'exam_taken_exams.school_id')
        ->join('exam', 'exam.id', '=', 'exam_taken_exams.exam_id')
        ->join('democbts', 'exam_taken_exams.student_id', '=', 'democbts.id') 
        ->join('tclasses', 'exam_taken_exams.class_id', '=', 'tclasses.id') 
        ->join('tcourse', 'exam_taken_exams.subject_id', '=', 'tcourse.id')
        ->select(
            'exam_taken_exams.*',
            'school.school_name as school_name',
            'democbts.user_name as student_name',
            'tclasses.class_name as class_name', 
            'exam.ex_title as exam_title' ,
            'tcourse.course_name as course_name' 
    
        )
                ->paginate(50);

        
                return view('dashboard.students.cbts.exam.result')
                ->with('examschapter', $examschapter)
                ->with('schools', $schools)
                ->with('result', $result)
                ->with('TCourses', $TCourses);
            }
          
        }
        















public function SuperAdminViewCBTSResult(Request $request)
{
    $rqMethod = $request->method();

    $schools = School::all();
    
    $examschapter = ExamChapter::join('exam', 'exam.id', '=', 'exam_chapter.exam_id') 
        ->join('tchapters', 'tchapters.id', '=', 'exam_chapter.chapter_id')

        ->select(
            'exam_chapter.*', 
            'tchapters.chapter_title as chapter_name'
        )
        ->paginate(10);
        
    if ($rqMethod === 'GET') {
        $result = ExamResult::join('school', 'school.id', '=', 'exam_taken_exams.school_id')
        ->join('exam', 'exam.ex_class_id', '=', 'exam_taken_exams.class_id')
        ->leftJoin  ('students', 'exam_taken_exams.student_id', '=', 'students.id') 
        ->leftJoin('democbts', 'exam_taken_exams.student_id', '=', 'democbts.id')  
        ->join('tclasses', 'exam_taken_exams.class_id', '=', 'tclasses.id') 
        ->join('tcourse', 'exam_taken_exams.subject_id', '=', 'tcourse.id')
        ->select(
            'exam_taken_exams.*',
            'school.school_name as school_name',
            'students.name as student_name',                  
            'democbts.user_name as username',          
            'tclasses.class_name as class_name', 
            'exam.ex_title as exam_title',
            'tcourse.course_name as course_name'
        )       
    ->distinct()
    ->paginate(10);

    return view('dashboard.superadmin.cbts.exam.result')
    ->with('schools', $schools)
    ->with('result', $result)
    ->with('examschapter', $examschapter);
}

    // ----------------------Exam filter-------------------------------------
       elseif ($rqMethod === 'POST') {
            
           $result = ExamResult::where('exam_taken_exams.class_id', $request->class_id)
            ->where('exam_taken_exams.subject_id', $request->course_id)
            ->where('exam_taken_exams.school_id', $request->school)
            ->join('exam', 'exam.id', '=', 'exam_taken_exams.exam_id')
            ->join('school', 'school.id', '=', 'exam_taken_exams.school_id')
            ->join('students', 'exam_taken_exams.student_id', '=', 'students.id') 
            ->join('tclasses', 'exam_taken_exams.class_id', '=', 'tclasses.id') 
            ->join('tcourse', 'exam_taken_exams.subject_id', '=', 'tcourse.id')
            ->select(
                'exam_taken_exams.*',
                'school.school_name as school_name',
                'students.name as student_name',
                'tclasses.class_name as class_name', 
                'exam.ex_title as exam_title' ,
                'tcourse.course_name as course_name' 
        
            )
            ->paginate(50);
        
     
    
            return view('dashboard.superadmin.cbts.exam.result')
                ->with('result', $result)
                ->with('examschapter', $examschapter)
                ->with('schools', $schools);

        }


}

public function SchoolAdminViewCBTSResult(Request $request)
{
    $rqMethod = $request->method();

    $schools = HelperFunctionsController::getUserSchools();
    $schoolId = HelperFunctionsController::getUserSchoolsIds();

    $examschapter = ExamChapter::join('exam', 'exam.id', '=', 'exam_chapter.exam_id') 
        ->join('tchapters', 'tchapters.id', '=', 'exam_chapter.chapter_id')

        ->select(
            'exam_chapter.*', 
            'tchapters.chapter_title as chapter_name'
        )
        ->paginate(10);
        
    if ($rqMethod === 'GET') {
    $result =ExamResult::whereIn('exam_taken_exams.school_id', $schoolId)
    ->join('school', 'school.id', '=', 'exam_taken_exams.school_id')
    ->join('exam', 'exam.ex_class_id', '=', 'exam_taken_exams.class_id')
    ->join('students', 'exam_taken_exams.student_id', '=', 'students.id') 
    ->join('tclasses', 'exam_taken_exams.class_id', '=', 'tclasses.id') 
    ->join('tcourse', 'exam_taken_exams.subject_id', '=', 'tcourse.id')
    ->select(
        'exam_taken_exams.*',
        'school.school_name as school_name',
        'students.name as student_name',
        'tclasses.class_name as class_name', 
        'exam.ex_title as exam_title' ,
        'tcourse.course_name as course_name' 

    )
    ->distinct()
    ->paginate(10);

    return view('dashboard.admin.cbts.exam.result')
    ->with('schools', $schools)
    
    ->with('result', $result)
    ->with('examschapter', $examschapter);
}

    // ----------------------Exam filter-------------------------------------
       elseif ($rqMethod === 'POST') {
            
           $result = ExamResult::where('exam_taken_exams.class_id', $request->class_id)
            ->where('exam_taken_exams.subject_id', $request->course_id)
            ->where('exam_taken_exams.school_id', $request->school)
            ->join('exam', 'exam.id', '=', 'exam_taken_exams.exam_id')
            ->join('school', 'school.id', '=', 'exam_taken_exams.school_id')
            ->join('students', 'exam_taken_exams.student_id', '=', 'students.id') 
            ->join('tclasses', 'exam_taken_exams.class_id', '=', 'tclasses.id') 
            ->join('tcourse', 'exam_taken_exams.subject_id', '=', 'tcourse.id')
            ->select(
                'exam_taken_exams.*',
                'school.school_name as school_name',
                'students.name as student_name',
                'tclasses.class_name as class_name', 
                'exam.ex_title as exam_title' ,
                'tcourse.course_name as course_name' 
        
            )
            ->paginate(50);
        
     
    
            return view('dashboard.admin.cbts.exam.result')
                ->with('result', $result)
                ->with('examschapter', $examschapter)
                ->with('schools', $schools);

        }


}

public function StudentViewCBTSResult(Request $request)
{
    $rqMethod = $request->method();

    $tclasses = Tclasses::all();
    $TCourses = Tcourses::all();
    $schools = School::all();
    
    $examschapter = ExamChapter::join('exam', 'exam.id', '=', 'exam_chapter.exam_id') 
        ->join('tchapters', 'tchapters.id', '=', 'exam_chapter.chapter_id')

        ->select(
            'exam_chapter.*', 
            'tchapters.chapter_title as chapter_name'
        )
        
        ->paginate(10);
        
    if ($rqMethod === 'GET') {
    $result = ExamResult::join('school', 'school.id', '=', 'exam_taken_exams.school_id')
    ->join('exam', 'exam.id', '=', 'exam_taken_exams.exam_id')
    ->join('students', 'exam_taken_exams.student_id', '=', 'students.id') 
    ->join('tclasses', 'exam_taken_exams.class_id', '=', 'tclasses.id') 
    ->join('tcourse', 'exam_taken_exams.subject_id', '=', 'tcourse.id')
    ->select(
        'exam_taken_exams.*',
        'school.school_name as school_name',
        'students.name as student_name',
        'tclasses.class_name as class_name', 
        'exam.ex_title as exam_title' ,
        'tcourse.course_name as course_name' 

    )
    ->distinct()
    ->paginate(10);

    return view('dashboard.students.cbts.exam.result')
    ->with('schools', $schools)
    ->with('result', $result)
    ->with('TCourses', $TCourses)
    ->with('examschapter', $examschapter);
}

    // ----------------------Exam filter-------------------------------------
       elseif ($rqMethod === 'POST') {
            
           $result = ExamResult::where('exam_taken_exams.class_id', $request->class_id)
            ->where('exam_taken_exams.subject_id', $request->course_id)
            ->where('exam_taken_exams.school_id', $request->school)
            ->join('exam', 'exam.id', '=', 'exam_taken_exams.exam_id')
            ->join('school', 'school.id', '=', 'exam_taken_exams.school_id')
            ->join('students', 'exam_taken_exams.student_id', '=', 'students.id') 
            ->join('tclasses', 'exam_taken_exams.class_id', '=', 'tclasses.id') 
            ->join('tcourse', 'exam_taken_exams.subject_id', '=', 'tcourse.id')
            ->select(
                'exam_taken_exams.*',
                'school.school_name as school_name',
                'students.name as student_name',
                'tclasses.class_name as class_name', 
                'exam.ex_title as exam_title' ,
                'tcourse.course_name as course_name' 
        
            )
            ->paginate(50);
        
     
    
            return view('dashboard.students.cbts.exam.result')
                ->with('result', $result)
                ->with('tclasses', $tclasses)
                ->with('TCourses', $TCourses)
                ->with('examschapter', $examschapter)
                ->with('schools', $schools);

        }


}



public function DemoStudentViewCBTSResult(Request $request)
{
    $rqMethod = $request->method();

    $tclasses = Tclasses::all();
    $TCourses = Tcourses::all();
    $schools = School::all();
    
    $examschapter = ExamChapter::join('exam', 'exam.id', '=', 'exam_chapter.exam_id') 
        ->join('tchapters', 'tchapters.id', '=', 'exam_chapter.chapter_id')

        ->select(
            'exam_chapter.*', 
            'tchapters.chapter_title as chapter_name'
        )
        
        ->paginate(10);
        
    if ($rqMethod === 'GET') {
    $result = ExamResult::join('school', 'school.id', '=', 'exam_taken_exams.school_id')
    ->join('exam', 'exam.id', '=', 'exam_taken_exams.exam_id')
    ->join('democbts', 'exam_taken_exams.student_id', '=', 'democbts.id') 
    ->join('tclasses', 'exam_taken_exams.class_id', '=', 'tclasses.id') 
    ->join('tcourse', 'exam_taken_exams.subject_id', '=', 'tcourse.id')
    ->select(
        'exam_taken_exams.*',
        'school.school_name as school_name',
        'democbts.user_name as student_name',
        'tclasses.class_name as class_name', 
        'exam.ex_title as exam_title' ,
        'tcourse.course_name as course_name' 

    )
    ->distinct()
    ->paginate(10);

    return view('dashboard.demostudents.cbts.exam.result')
    ->with('schools', $schools)
    ->with('result', $result)
    ->with('TCourses', $TCourses)
    ->with('examschapter', $examschapter);
}



}




public function StudentViewCBTSExamResult(Request $request)
{
    $examschapter = ExamChapter::join('exam', 'exam.id', '=', 'exam_chapter.exam_id') 
    ->join('tchapters', 'tchapters.id', '=', 'exam_chapter.chapter_id')

    ->select(
        'exam_chapter.*', 
        'tchapters.chapter_title as chapter_name'
    )
    ->paginate(10);


    $result = ExamResult::join('school', 'school.id', '=', 'exam_taken_exams.school_id')
        ->join('students', 'students.id', '=', 'exam_taken_exams.student_id') 
        ->join('tclasses', 'tclasses.id', '=', 'exam_taken_exams.class_id') 
        ->join('exam', 'exam.id', '=', 'exam_taken_exams.exam_id') 
        ->join('tcourse', 'tcourse.id', '=', 'exam.ex_course_id') 
        ->select(
            'exam_taken_exams.*',
            'exam.*',
            'school.school_name as school_name',
            'students.name as student_name', 
            'tclasses.class_name as class', 
            'exam.ex_title as exam_name', 
            'tcourse.course_name as subject_name'
        )
        ->where('exam_taken_exams.exam_id', $request->exam_id )
        ->get();

        $examquestion = ExamQuestion::join('c_questionbank', 'c_questionbank.id', '=', 'exam_question.q_id')
        ->select('exam_question.*', 'c_questionbank.*', 'c_questionbank.cquestion AS question')
        ->where('exam_question.exam_id', $request->exam_id)
        ->get();

    $examanswers = Canswer::join('exam_question', 'exam_question.q_id', '=', 'c_answer.q_Id')
        ->join('c_questionbank', 'c_questionbank.id', '=', 'c_answer.q_Id')
        ->select('exam_question.*', 'c_questionbank.*', 'c_answer.*')
        ->where('exam_question.exam_id', $request->exam_id )
        ->get();

        $studentanswers = ExamAnswer::where('exam_id',$request->exam_id)->where('student_id',$request->student_id)
        ->get();

    return view('dashboard.students.cbts.exam.examresult')
        ->with('result', $result)
        ->with('examchapter', $examschapter)
        ->with('examquestions', $examquestion)
        ->with('examanswers', $examanswers)
        ->with('studentanswers', $studentanswers)

        ->with('exam_id', $request->exam_id);
}


public function DemoStudentViewCBTSExamResult(Request $request)
{
    $examschapter = ExamChapter::join('exam', 'exam.id', '=', 'exam_chapter.exam_id') 
    ->join('tchapters', 'tchapters.id', '=', 'exam_chapter.chapter_id')

    ->select(
        'exam_chapter.*', 
        'tchapters.chapter_title as chapter_name'
    )
    ->paginate(10);


    $result = ExamResult::join('school', 'school.id', '=', 'exam_taken_exams.school_id')
        ->join('democbts', 'democbts.id', '=', 'exam_taken_exams.student_id') 
        ->join('tclasses', 'tclasses.id', '=', 'exam_taken_exams.class_id') 
        ->join('exam', 'exam.id', '=', 'exam_taken_exams.exam_id') 
        ->join('tcourse', 'tcourse.id', '=', 'exam.ex_course_id') 
        ->select(
            'exam_taken_exams.*',
            'exam.*',
            'school.school_name as school_name',
            'democbts.user_name as student_name', 
            'tclasses.class_name as class', 
            'exam.ex_title as exam_name', 
            'tcourse.course_name as subject_name'
        )
        ->where('exam_taken_exams.exam_id', $request->exam_id )
        ->get();

        $examquestion = ExamQuestion::join('c_questionbank', 'c_questionbank.id', '=', 'exam_question.q_id')
        ->select('exam_question.*', 'c_questionbank.*', 'c_questionbank.cquestion AS question')
        ->where('exam_question.exam_id', $request->exam_id)
        ->inRandomOrder() 
        ->get();

    $examAnswers = Canswer::join('exam_question', 'exam_question.q_id', '=', 'c_answer.q_Id')
        ->join('c_questionbank', 'c_questionbank.id', '=', 'c_answer.q_Id')
        ->select('exam_question.*', 'c_questionbank.*', 'c_answer.*')
        ->inRandomOrder() 
        ->get();

        $examquestion = ExamQuestion::join('c_questionbank', 'c_questionbank.id', '=', 'exam_question.q_id')
        ->select('exam_question.*', 'c_questionbank.*', 'c_questionbank.cquestion AS question')
        ->where('exam_question.exam_id', $request->exam_id)
        ->get();

    $examanswers = Canswer::join('exam_question', 'exam_question.q_id', '=', 'c_answer.q_Id')
        ->join('c_questionbank', 'c_questionbank.id', '=', 'c_answer.q_Id')
        ->select('exam_question.*', 'c_questionbank.*', 'c_answer.*')
        ->where('exam_question.exam_id', $request->exam_id )
        ->get();

        $studentanswers = ExamAnswer::where('exam_id',$request->exam_id)->where('student_id',$request->student_id)
        ->get();
    return view('dashboard.demostudents.cbts.exam.examresult')
        ->with('result', $result)
        ->with('examchapter', $examschapter)
        ->with('examquestions', $examquestion)
        ->with('examAnswers', $examAnswers)
        ->with('examquestions', $examquestion)
        ->with('examanswers', $examanswers)
        ->with('studentanswers', $studentanswers)

        ->with('exam_id', $request->exam_id);
}



public function SuperAdminViewCBTSExamResult(Request $request)
{

    $examschapter = ExamChapter::join('exam', 'exam.id', '=', 'exam_chapter.exam_id') 
    ->join('tchapters', 'tchapters.id', '=', 'exam_chapter.chapter_id')

    ->select(
        'exam_chapter.*', 
        'tchapters.chapter_title as chapter_name'
    )
    ->paginate(10);


    $result = ExamResult::join('school', 'school.id', '=', 'exam_taken_exams.school_id')
        ->join('students', 'students.id', '=', 'exam_taken_exams.student_id') 
        ->join('tclasses', 'tclasses.id', '=', 'exam_taken_exams.class_id') 
        ->join('exam', 'exam.id', '=', 'exam_taken_exams.exam_id') 
        ->join('tcourse', 'tcourse.id', '=', 'exam.ex_course_id') 
        ->select(
            'exam_taken_exams.*',
            'exam.*',

            'school.school_name as school_name',
            'students.name as student_name', 
            'tclasses.class_name as class', 
            'exam.ex_title as exam_name', 
            'tcourse.course_name as subject_name' 
        )
        ->where('exam_taken_exams.exam_id', $request->exam_id)
        ->get();

     $examquestion = ExamQuestion::join('c_questionbank', 'c_questionbank.id', '=', 'exam_question.q_id')
        ->select('exam_question.*', 'c_questionbank.*', 'c_questionbank.cquestion AS question')
        ->where('exam_question.exam_id', $request->exam_id)
        ->get();

    $examanswers = Canswer::join('exam_question', 'exam_question.q_id', '=', 'c_answer.q_Id')
        ->join('c_questionbank', 'c_questionbank.id', '=', 'c_answer.q_Id')
        ->select('exam_question.*', 'c_questionbank.*', 'c_answer.*')
        ->where('exam_question.exam_id', $request->exam_id )
        ->get();

        $studentanswers = ExamAnswer::where('exam_id',$request->exam_id)->where('student_id',$request->student_id)
        ->get();
    return view('dashboard.superadmin.cbts.exam.examresult')
        ->with('result', $result)
        ->with('examchapter', $examschapter)
        ->with('examquestions', $examquestion)
        ->with('examanswers', $examanswers)
        ->with('studentanswers', $studentanswers)

        ->with('exam_id', $request->exam_id);
}
public function SchoolAdminViewCBTSExamResult(Request $request)
{

    $examschapter = ExamChapter::join('exam', 'exam.id', '=', 'exam_chapter.exam_id') 
    ->join('tchapters', 'tchapters.id', '=', 'exam_chapter.chapter_id')

    ->select(
        'exam_chapter.*', 
        'tchapters.chapter_title as chapter_name'
    )
    ->paginate(10);



    $result = ExamResult::join('school', 'school.id', '=', 'exam_taken_exams.school_id')
        ->join('students', 'students.id', '=', 'exam_taken_exams.student_id') 
        ->join('tclasses', 'tclasses.id', '=', 'exam_taken_exams.class_id') 
        ->join('exam', 'exam.id', '=', 'exam_taken_exams.exam_id') 
        ->join('tcourse', 'tcourse.id', '=', 'exam.ex_course_id') 
        ->select(
            'exam_taken_exams.*',
            'school.school_name as school_name',
            'students.name as student_name', 
            'tclasses.class_name as class',
            'exam.ex_title as exam_name', 
            'tcourse.course_name as subject_name' 
        )
        ->where('exam_taken_exams.exam_id', $request->exam_id)
        ->get();

    return view('dashboard.admin.cbts.exam.examresult')
        ->with('result', $result)
        ->with('examchapter', $examschapter)

        ->with('exam_id', $request->exam_id)
;
}


public function StudentdownloadExamResultPDF(Request $request)
{
    $result = ExamResult::join('school', 'school.id', '=', 'exam_taken_exams.school_id')
        ->join('students', 'students.id', '=', 'exam_taken_exams.student_id')
        ->join('tclasses', 'tclasses.id', '=', 'exam_taken_exams.class_id')
        ->join('exam', 'exam.id', '=', 'exam_taken_exams.exam_id')
        ->join('tcourse', 'tcourse.id', '=', 'exam.ex_course_id')
        ->select(
            'exam_taken_exams.*',
            'exam.*',
            'school.school_name as school_name',
            'students.name as student_name',
            'tclasses.class_name as class',
            'exam.ex_title as exam_name',
            'exam.ex_duration as duration',
            'exam.ex_pass_mark as pass_mark',
            'exam.ex_start_date as start_date',
            'exam.ex_end_date as end_date',
            'tcourse.course_name as subject_name'
        )
        ->where('exam_taken_exams.exam_id',$request->exam_id)
        ->get();

    if ($result->isEmpty()) {
        return response()->json(['message' => 'No results found for this exam.'], 404);
    }

    $totalCorrect = $result->sum('total_correct_answer');
    $totalIncorrect = $result->sum('total_incorrect_answer');

    $pdf = PDF::loadView('dashboard.students.cbts.exam.exam_result_pdf', [
        'result' => $result,
        'totalCorrect' => $totalCorrect,
        'totalIncorrect' => $totalIncorrect
    ]);

    $filename = sprintf('exam_result_%s.pdf', date('Ymd'));

    return $pdf->download($filename);
}


public function DemoStudentdownloadExamResultPDF(Request $request)
{
    $result = ExamResult::join('school', 'school.id', '=', 'exam_taken_exams.school_id')
        ->join('democbts', 'democbts.id', '=', 'exam_taken_exams.student_id')
        ->join('tclasses', 'tclasses.id', '=', 'exam_taken_exams.class_id')
        ->join('exam', 'exam.id', '=', 'exam_taken_exams.exam_id')
        ->join('tcourse', 'tcourse.id', '=', 'exam.ex_course_id')
        ->select(
            'exam_taken_exams.*',
            'exam.*',
            'school.school_name as school_name',
            'democbts.user_name as student_name',
            'tclasses.class_name as class',
            'exam.ex_title as exam_name',
            'tcourse.course_name as subject_name'
        )
        ->where('exam_taken_exams.exam_id',$request->exam_id)
        ->get();

    if ($result->isEmpty()) {
        return response()->json(['message' => 'No results found for this exam.'], 404);
    }

    $totalCorrect = $result->sum('total_correct_answer');
    $totalIncorrect = $result->sum('total_incorrect_answer');

    $pdf = PDF::loadView('dashboard.demostudents.cbts.exam.exam_result_pdf', [
        'result' => $result,
        'totalCorrect' => $totalCorrect,
        'totalIncorrect' => $totalIncorrect
    ]);

    $filename = sprintf('exam_result_%s.pdf', date('Ymd'));

    return $pdf->download($filename);
}



public function SuperadmindownloadExamResultPDF(Request $request)
{
    $result = ExamResult::join('school', 'school.id', '=', 'exam_taken_exams.school_id')
        ->join('students', 'students.id', '=', 'exam_taken_exams.student_id')
        ->join('tclasses', 'tclasses.id', '=', 'exam_taken_exams.class_id')
        ->join('exam', 'exam.id', '=', 'exam_taken_exams.exam_id')
        ->join('tcourse', 'tcourse.id', '=', 'exam.ex_course_id')
        ->select(
            'exam_taken_exams.*',
            'exam.*',
            'school.school_name as school_name',
            'students.name as student_name',
            'tclasses.class_name as class',
            'exam.ex_title as exam_name',
            'tcourse.course_name as subject_name'
        )
        ->where('exam_taken_exams.exam_id',$request->exam_id)
        ->get();

    if ($result->isEmpty()) {
        return response()->json(['message' => 'No results found for this exam.'], 404);
    }

    $totalCorrect = $result->sum('total_correct_answer');
    $totalIncorrect = $result->sum('total_incorrect_answer');

    $pdf = PDF::loadView('dashboard.superadmin.cbts.exam.exam_result_pdf', [
        'result' => $result,
        'totalCorrect' => $totalCorrect,
        'totalIncorrect' => $totalIncorrect
    ]);

    $filename = sprintf('exam_result_%s.pdf', date('Ymd'));

    return $pdf->download($filename);
}


public function SchooladmindownloadExamResultPDF(Request $request)
{
    $result = ExamResult::join('school', 'school.id', '=', 'exam_taken_exams.school_id')
        ->join('students', 'students.id', '=', 'exam_taken_exams.student_id')
        ->join('tclasses', 'tclasses.id', '=', 'exam_taken_exams.class_id')
        ->join('exam', 'exam.id', '=', 'exam_taken_exams.exam_id')
        ->join('tcourse', 'tcourse.id', '=', 'exam.ex_course_id')
        ->select(
            'exam_taken_exams.*',
            'school.school_name as school_name',
            'students.name as student_name',
            'tclasses.class_name as class',
            'exam.ex_title as exam_name',
            'tcourse.course_name as subject_name'
        )
        ->where('exam_taken_exams.exam_id',$request->exam_id)
        ->get();

    if ($result->isEmpty()) {
        return response()->json(['message' => 'No results found for this exam.'], 404);
    }

    $totalCorrect = $result->sum('total_correct_answer');
    $totalIncorrect = $result->sum('total_incorrect_answer');

    $pdf = PDF::loadView('dashboard.admin.cbts.exam.exam_result_pdf', [
        'result' => $result,
        'totalCorrect' => $totalCorrect,
        'totalIncorrect' => $totalIncorrect
    ]);

    $filename = sprintf('exam_result_%s.pdf', date('Ymd'));

    return $pdf->download($filename);
}



    public function SuperAdminViewCBTSExamQuestion(Request $request)
    {
        $boards = Tboards::all();
        $rqMethod = $request->method();

        $examChapters = ExamChapter::join('exam', 'exam.id', '=', 'exam_chapter.exam_id')
        ->where('exam.id', '=', $request->id) 
        ->select('exam_chapter.*') 
        ->distinct()
        ->get();

if ($rqMethod === 'GET') {
$chapterIds = $examChapters->pluck('chapter_id');            

$questionsbank = Cquestion::join('school', 'school.id', '=', 'c_questionbank.school_id')
            ->join('exam', 'exam.ex_class_id', '=', 'c_questionbank.cclass_id')
            ->join('exam_chapter', 'exam_chapter.chapter_id', '=', 'c_questionbank.cchapter_id') 
            ->join('tchapters', 'tchapters.id', '=', 'c_questionbank.cchapter_id') 
            ->select('c_questionbank.*', 'tchapters.chapter_title') 
            ->whereIn('exam_chapter.chapter_id', $chapterIds) 

            ->distinct()
            ->paginate(10);
        



            $examquestions = ExamQuestion::join('c_questionbank', 'c_questionbank.id', '=', 'exam_question.q_id')
                ->select('exam_question.*', 'c_questionbank.*', 'c_questionbank.cquestion AS question')
                ->where('exam_question.exam_id', $request->id)
                ->paginate(10);

            $examanswers = Canswer::join('exam_question', 'exam_question.q_id', '=', 'c_answer.q_Id')
                ->join('c_questionbank', 'c_questionbank.id', '=', 'c_answer.q_Id')
                ->select('c_questionbank.*', 'c_answer.*')
                ->where('exam_question.exam_id', $request->id)
                ->get();

            return view('dashboard.superadmin.cbts.examquestion.view', ['exam_id' => $request->id])
                ->with('questionsbank', $questionsbank)
                ->with('examquestions', $examquestions)
                ->with('examanswers', $examanswers)
                ->with('boards', $boards);
        } 

       
    }



    public function SchoolAdminViewCBTSExamQuestion(Request $request)
    {
        $boards = Tboards::all();

        $rqMethod = $request->method();



        $examChapters = ExamChapter::join('exam', 'exam.id', '=', 'exam_chapter.exam_id')
        ->where('exam.id', '=', $request->id) 
        ->select('exam_chapter.*') 
        ->distinct()
        ->get();

if ($rqMethod === 'GET') {
$chapterIds = $examChapters->pluck('chapter_id'); 

$questionsbank = Cquestion::join('school', 'school.id', '=', 'c_questionbank.school_id')
        ->join('exam', 'exam.ex_class_id', '=', 'c_questionbank.cclass_id')
        ->join('exam_chapter', 'exam_chapter.chapter_id', '=', 'c_questionbank.cchapter_id') 
        ->join('tchapters', 'tchapters.id', '=', 'c_questionbank.cchapter_id') 
        ->join('tcourse', 'tcourse.id', '=', 'c_questionbank.ccourse_id') 
        ->whereIn('exam_chapter.chapter_id', $chapterIds) 
        ->select('c_questionbank.*', 'tchapters.chapter_title', 'tcourse.course_name') 
        ->distinct()
        ->paginate(10);


        



            $examquestions = ExamQuestion::join('c_questionbank', 'c_questionbank.id', '=', 'exam_question.q_id')
                ->select('exam_question.*', 'c_questionbank.*', 'c_questionbank.cquestion AS question')
                ->where('exam_question.exam_id', $request->id)
                ->paginate(10);

            $examanswers = Canswer::join('exam_question', 'exam_question.q_id', '=', 'c_answer.q_Id')
                ->join('c_questionbank', 'c_questionbank.id', '=', 'c_answer.q_Id')
                ->select('c_questionbank.*', 'c_answer.*')
                ->where('exam_question.exam_id', $request->id)
                ->get();

            return view('dashboard.admin.cbts.examquestion.view', ['exam_id' => $request->id])
                ->with('questionsbank', $questionsbank)
                ->with('examquestions', $examquestions)
                ->with('examanswers', $examanswers)
                ->with('boards', $boards);
        } 

       
    }

    // ----------------------Add-------------------------------------

    public function SuperAdminCreateCBTSExam(Request $request)
    {
        $requestMethod = $request->method();
    
        if ($requestMethod === 'POST') {
            $exam = new Exam;
            $exam->ex_board_id = $request->ex_board_id;
            $exam->ex_course_id = $request->ex_course_id;
            $exam->ex_class_id = $request->ex_class_id;
            $exam->ex_title = $request->ex_title;
            $exam->ex_duration = $request->ex_duration;
            $exam->ex_end_date = $request->ex_end_date;
            $exam->ex_start_date = $request->ex_start_date;
            $exam->ex_pass_mark = $request->ex_pass_mark;
            $exam->ex_total_question = $request->ex_total_question;
            $exam->school_id = $request->school;
            $exam->ex_school_class_id = $request->ex_school_class_id;
            $exam->ex_instraction= $request->ex_instraction;

            if (!empty($request->chapters) && is_array($request->chapters)) {
                $allQuestions = collect();
                $totalQuestionsNeeded = $request->ex_total_question;
            
                foreach ($request->chapters as $chapter) {
                    $questions = Cquestion::where('cchapter_id', $chapter)->get();
                    
                    if ($questions->isEmpty()) {
                        return redirect()->back()->withErrors(['message' => "No questions available for chapter ID: $chapter. Please select a different chapter."]);
                    }
                    
                    $allQuestions = $allQuestions->merge($questions);
                }
            
                if ($allQuestions->count() < $totalQuestionsNeeded) {
                    return redirect()->back()->withErrors(['message' => "Insufficient questions across all selected chapters. Available: " . $allQuestions->count() . ", Required: $totalQuestionsNeeded."]);
                }
            
                $selectedQuestions = $allQuestions->random($totalQuestionsNeeded);
            
                $exam->save();
            
                foreach ($request->chapters as $chapter) {
                    $examChapter = new ExamChapter;
                    $examChapter->chapter_id = $chapter;
                    $examChapter->exam_id = $exam->id;
                    $examChapter->course_id = $request->ex_course_id;
                    $examChapter->save();
                }
            
                foreach ($selectedQuestions as $question) {
                    $examQuestion = new ExamQuestion;
                    $examQuestion->exam_id = $exam->id;
                    $examQuestion->q_id = $question->id;
                    $examQuestion->save();
                }
            } else {
                return redirect()->back()->withErrors(['message' => 'Please select at least one chapter.']);
            }
                        

            return redirect()->route('superadmin.cbts.exam.view')->with('success', 'Exam created successfully.');
        } else {
            $boards = Tboards::all();
            $classes = TClasses::all();
            $sclasses = Classes::all();
            $courses = TCourses::all();
            $schools = School::all();
    
            return view('dashboard.superadmin.cbts.exam.create')
                ->with('boards', $boards)
                ->with('classes', $classes)
                ->with('sclasses', $sclasses)
                ->with('schools', $schools)
                ->with('courses', $courses);                    }
    }
        // ----------------------Add Exam Question-------------------------------------

         public function SuperAdminCreateCBTSExamQuestion(Request $request)
    {

        $existingQuestion = ExamQuestion::where('exam_id',  $request->exam_id)
            ->where('q_id', $request->id)
            ->first();

        if ($existingQuestion) {
            return redirect()->back()->withErrors(['message' => 'This exam question already exists.']);
        }

        $examQuestion = new ExamQuestion; 
        $examQuestion->exam_id = $request->exam_id; 
        $examQuestion->q_id = $request->id; 
        $exam =  Exam::find($request->exam_id);
        $ex_total_question=$exam->ex_total_question;
        $exam->ex_total_question=$ex_total_question+1;
        $exam->save();
        $examQuestion->save();
      

        return redirect()->route('superadmin.cbts.examquestion.view', ['id' => $request->exam_id]);
    }


    public function SchoolAdminCreateCBTSExam(Request $request)
    {
        $requestMethod = $request->method();
    
        if ($requestMethod === 'POST') {
            $exam = new Exam;
            $exam->ex_board_id = $request->ex_board_id;
            $exam->ex_course_id = $request->ex_course_id;
            $exam->ex_class_id = $request->ex_class_id;
            $exam->ex_title = $request->ex_title;
            $exam->ex_duration = $request->ex_duration;
            $exam->ex_end_date = $request->ex_end_date;
            $exam->ex_start_date = $request->ex_start_date;
            $exam->ex_pass_mark = $request->ex_pass_mark;
            $exam->ex_total_question = $request->ex_total_question;
            $exam->school_id = $request->school;
            $exam->ex_instraction= $request->ex_instraction;

            if (!empty($request->tchapters) && is_array($request->tchapters)) {
                $allQuestions = collect(); 
                $totalQuestionsNeeded = $request->ex_total_question; 
    
                foreach ($request->tchapters as $tchapters) {
                    $questions = Cquestion::where('cchapter_id', $tchapters)
                        ->inRandomOrder()
                        ->get(); 
                        if ($questions->isEmpty()) {
                        return redirect()->back()->withErrors(['message' => "No questions available for tchapters ID: $tchapters. Please select different tchapters."]);
                    }
                        if ($questions->count() < $totalQuestionsNeeded) {
                        return redirect()->back()->withErrors(['message' => "Insufficient questions in tchapters ID: $tchapters. Available: " . $questions->count() . ", Required: $totalQuestionsNeeded."]);
                    }
    
                    $selectedQuestions = $questions->random($totalQuestionsNeeded);
                    
                    $allQuestions = $allQuestions->merge($selectedQuestions);
                    $exam->save();

                    $examChapter = new ExamChapter;
                    $examChapter->chapter_id = $tchapters;
                    $examChapter->exam_id = $exam->id; 
                    $examChapter->course_id = $request->ex_course_id;
                    $examChapter->save();


                }
    
                foreach ($allQuestions as $question) {
                    $examQuestion = new ExamQuestion; 
                    $examQuestion->exam_id = $exam->id; 
                    $examQuestion->q_id = $question->id; 
                    $examQuestion->save();
                   

                }
            } else {
                return redirect()->back()->withErrors(['message' => 'Please select at least one tchapters.']);
            }
        
            return redirect()->route('schooladmin.cbts.exam.view')->with('success', 'Exam created successfully.');
        } else {
            $boards = Tboards::all();
            $schools = HelperFunctionsController::getUserSchools();
    
            return view('dashboard.admin.cbts.exam.create')
                ->with('boards', $boards)
                ->with('schools', $schools);
                    }
    }
        // ----------------------Add Exam Question-------------------------------------

         public function SchooladminCreateCBTSExamQuestion(Request $request)
    {

        $existingQuestion = ExamQuestion::where('exam_id',  $request->exam_id)
            ->where('q_id', $request->id)
            ->first();

        if ($existingQuestion) {
            return redirect()->back()->withErrors(['message' => 'This exam question already exists.']);
        }

        $examQuestion = new ExamQuestion; 
        $examQuestion->exam_id = $request->exam_id; 
        $examQuestion->q_id = $request->id; 
        $exam =  Exam::find($request->exam_id);
        $ex_total_question=$exam->ex_total_question;
        $exam->ex_total_question=$ex_total_question+1;
        $exam->save();
        $examQuestion->save();
      

        return redirect()->route('schooladmin.cbts.examquestion.view', ['id' => $request->exam_id]);
    }













    // ----------------------Delete Exam -------------------------------------

    public function SuperAdminDeleteCBTSExam(Request $request)
    {
        if ($request->id) {
            $deletedRows2 = ExamQuestion::where('exam_id', $request->id)->delete(); 
            $deletedRows3 = ExamChapter::where('exam_id', $request->id)->delete(); 
            $deletedRows = Exam::destroy($request->id);

            if ($deletedRows > 0) {
                return response()->json([
                    'status' => 200,
                    'deleted' => true
                ]); 
            } else {
                return response()->json([
                    'status' => 200,
                    'deleted' => false,
                    'message' => 'Failed To Delete Record'
                ]);
            }
        } else {
            return response()->json([
                'status' => 200,
                'deleted' => false,
                'message' => 'Record Id is not Provided',
                'form' => $request->all()
            ]);
        }
    }



    public function SchoolAdminDeleteCBTSExam(Request $request)
    {
        if ($request->id) {
            $deletedRows2 = ExamQuestion::where('exam_id', $request->id)->delete(); 
            $deletedRows3 = ExamChapter::where('exam_id', $request->id)->delete(); 
            $deletedRows = Exam::destroy($request->id);

            if ($deletedRows > 0) {
                return response()->json([
                    'status' => 200,
                    'deleted' => true
                ]); 
            } else {
                return response()->json([
                    'status' => 200,
                    'deleted' => false,
                    'message' => 'Failed To Delete Record'
                ]);
            }
        } else {
            return response()->json([
                'status' => 200,
                'deleted' => false,
                'message' => 'Record Id is not Provided',
                'form' => $request->all()
            ]);
        }
    }
   
    // ----------------------Delete Exam Question -------------------------------------

    public function SuperAdminDeleteCBTSExamQuestion(Request $request)
    {

        $exam_id =   $request->input('exam_id');
        $question_id =  $request->input('question_id');
        if ($exam_id && $question_id) {
            $deletedRows = ExamQuestion::where('exam_id', $exam_id)
                ->where('q_id', $question_id)
                ->delete();
                $exam = Exam::find($exam_id);
                if ($exam) {
                    $exam->ex_total_question = max(0, $exam->ex_total_question - 1);
                    $exam->save();
            }}
}
    

    
    public function SuperAdminEditCBTSQuestionbank(Request $request){
        $requestMethod = $request->method();
        if($requestMethod === 'PUT'){

            $exam =  Exam::find($request->id);
            $exam->ex_board_id = $request->ex_board_id;
            $exam->ex_title = $request->ex_title;
            $exam->ex_duration = $request->ex_duration;
            $exam->ex_end_date = $request->ex_end_date;
            $exam->ex_start_date = $request->ex_start_date;
            $exam->ex_pass_mark = $request->ex_pass_mark;
            $exam->ex_instraction= $request->ex_instraction;
            $exam->save();

            return redirect()->route('superadmin.cbts.exam.view');
        }else{
         
                $boards = Tboards::all();
                $TCourses = Course::all();
                $tclasses = Classes::all();
                $schools = School::all();
                $exam = Exam::findOrFail($request->id); 
                $tchapters = ExamChapter::all();
                return view('dashboard.superadmin.cbts.exam.edit')
                    ->with('boards', $boards)
                    ->with('schools', $schools)
                    ->with('TCourses', $TCourses)
                    ->with('exam', $exam) 
                    ->with('examchapters', $tchapters) 
                    ->with('tclasses', $tclasses);
            }
            
        }




        public function SchoolAdminViewCBTSExam(Request $request)
        {
            $boards = Tboards::all();
            $schools = HelperFunctionsController::getUserSchools();
            $schoolId = HelperFunctionsController::getUserSchoolsIds();
    
            $rqMethod = $request->method();
        
            if ($rqMethod === 'GET') {
                $exams = Exam::whereIn('exam.school_id', $schoolId)
                ->join('tboards', 'tboards.id', '=', 'exam.ex_board_id')
        ->join('tclasses', 'tclasses.id', '=', 'exam.ex_class_id')
        ->join('tcourse', 'tcourse.id', '=', 'exam.ex_course_id')
        ->join('school', 'school.id', '=', 'exam.school_id')       
        ->select(
            'exam.*',
            'school.school_name as school',
            'tclasses.class_name',
            'exam.ex_title AS title',
            'tboards.board_name',
            'tcourse.course_name'
        )
        ->paginate(10);
    
    
        $examschapter = ExamChapter::join('exam', 'exam.id', '=', 'exam_chapter.exam_id') 
            ->join('tchapters', 'tchapters.id', '=', 'exam_chapter.chapter_id')
    
            ->select(
                'exam_chapter.*', 
                'tchapters.chapter_title as chapter_name'
            )
            ->paginate(10);
        
    
    return view('dashboard.admin.cbts.exam.view')
        ->with('schools', $schools)
        ->with('exams', $exams)
        ->with('examschapter', $examschapter) 
        ->with('boards', $boards);    
        }
            
            // ----------------------Exam filter-------------------------------------
            elseif ($rqMethod === 'POST') {
                
        $examschapter = ExamChapter::join('exam', 'exam.id', '=', 'exam_chapter.exam_id') 
        ->join('tchapters', 'tchapters.id', '=', 'exam_chapter.chapter_id')
    
        ->select(
            'exam_chapter.*', 
            'tchapters.chapter_title as chapter_name'
        )
        ->paginate(10);
                $exams = Exam::where('exam.ex_board_id', $request->ex_board_id)
                ->where('exam.ex_class_id', $request->ex_class_id)
                ->where('exam.ex_course_id', $request->ex_course_id)
                ->where('exam.school_id', $request->school)
                ->join('tboards', 'tboards.id', '=', 'exam.ex_board_id')
                ->join('school', 'school.id', '=', 'exam.school_id')       
                ->join('tclasses', 'tclasses.id', '=', 'exam.ex_class_id')
                ->join('tcourse', 'tcourse.id', '=', 'exam.ex_course_id')
                ->select(
                    'exam.*', 
                    'tclasses.class_name', 
                    'tboards.board_name',
                    'school.school_name as school',
                    'exam.ex_title AS title', 
                    'tcourse.course_name'
                )
                ->paginate(50);
            
         
        
                return view('dashboard.admin.cbts.exam.view')
                    ->with('exams', $exams) 
                    ->with('examschapter', $examschapter) 
                    ->with('boards', $boards)
                    ->with('schools', $schools);
    
            }
        }
    


        public function SchoolAdminEditCBTSExam(Request $request){
            $requestMethod = $request->method();
            if($requestMethod === 'PUT'){
    
                $exam =  Exam::find($request->id);
                $exam->ex_board_id = $request->ex_board_id;
                $exam->ex_title = $request->ex_title;
                $exam->ex_duration = $request->ex_duration;
                $exam->ex_end_date = $request->ex_end_date;
                $exam->ex_start_date = $request->ex_start_date;
                $exam->ex_pass_mark = $request->ex_pass_mark;
                $exam->ex_instraction= $request->ex_instraction;
                $exam->save();
    
                return redirect()->route('schooladmin.cbts.exam.view')->with('success', 'Exam created successfully.');
            }else{
                $schools = HelperFunctionsController::getUserSchools();
                $schoolId = HelperFunctionsController::getUserSchoolsIds();

             
                    $boards = Tboards::all();
                    $TCourses = Course::where('school_id', $schoolId)->get();
                    $tclasses = Classes::where('school_id', $schoolId)->get();
                    $exam = Exam::findOrFail($request->id); 
                    $tchapters = ExamChapter::all();
                    return view('dashboard.admin.cbts.exam.edit')
                        ->with('boards', $boards)
                        ->with('schools', $schools)
                        ->with('TCourses', $TCourses)
                        ->with('exam', $exam) 
                        ->with('tchapters', $tchapters) 
                        ->with('tclasses', $tclasses);
                }
                
            }
    
        }        
    
