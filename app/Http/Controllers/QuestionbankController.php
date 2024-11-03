<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator; 
use App\Models\Cquestion;
use App\Models\Question;
use App\Models\Canswer;
use Illuminate\Http\Request;
use App\Models\Tboards;
use App\Models\TCourses;
use App\Models\TClasses;
use App\Models\Classes;

use App\Models\Tchapters;
use Illuminate\Support\Facades\Response;

use App\Models\school;


use Maatwebsite\Excel\Facades\Excel;
use App\Imports\QuestionImport;

class QuestionbankController extends Controller
{

        public function filterClasses(Request $request)
        {
        
            $classes = Classes::where('school_id', $request->school_id)->get();
        
            return response()->json(['classes' => $classes]);
        }
    public function filterChapter(Request $request)
    {
      
        $chapters = Tchapters::where('tcourse_id', $request->course_id)
            ->where('tclass_id', $request->class_id) 
            ->get();
    
        return response()->json(['chapters' => $chapters]);
    }
   
    // ----------------------View Question Bank-------------------------------------
    public function SuperAdminViewCBTSQuestionbank(Request $request)
    {
        $boards = Tboards::all();
        $classes = TClasses::all();
        $courses = TCourses::all();
        $schools = school::all();

        $rqMethod = $request->method();

        if ($rqMethod === 'GET') {
              $questions = Question::join('tboards', 'tboards.id', '=', 'questionbank.board_id')
                ->join('tclasses', 'tclasses.id', '=', 'questionbank.class_id')
                ->join('tchapters', 'tchapters.id', '=', 'questionbank.chapter_id')
                ->join('tcourse', 'tcourse.id', '=', 'questionbank.course_id')
                ->join('school', 'school.id', 'questionbank.school_id')->select('questionbank.*', 'tclasses.class_name', 'school.school_name as school', 
                          'tchapters.chapter_title', 'tboards.board_name', 'tcourse.course_name')                ->paginate(10);

            return view('dashboard.superadmin.cbts.questionbank.view')
                ->with('questions', $questions)
                ->with('boards', $boards)
                ->with('classes', $classes)
                ->with('schools', $schools)
                ->with('courses', $courses);
        } 
        
        // ----------------------filter Question bank -------------------------------------
        elseif ($rqMethod === 'POST') {
            $questions = Cquestion::where('c_questionbank.cboard_id', $request->cboard_id)
                ->where('c_questionbank.cclass_id', $request->cclass_id)
                ->where('c_questionbank.ccourse_id', $request->ccourse_id)
                ->join('tboards', 'tboards.id', '=', 'c_questionbank.cboard_id')
                ->join('tclasses', 'tclasses.id', '=', 'c_questionbank.cclass_id')
                ->join('tchapters', 'tchapters.id', '=', 'c_questionbank.cchapter_id')
                ->join('tcourse', 'tcourse.id', '=', 'c_questionbank.ccourse_id')
                ->join('school', 'school.id', 'c_questionbank.school_id')

                ->select('c_questionbank.*', 
                         'c_questionbank.cquestion as topic_title', 
                         'school.school_name as school',
                         'tclasses.class_name', 
                         'tchapters.chapter_title', 
                         'tboards.board_name', 
                         'tcourse.course_name')
                ->paginate(50);

            return view('dashboard.superadmin.cbts.questionbank.view')
                ->with('questions', $questions)
                ->with('boards', $boards)
                ->with('classes', $classes)
                ->with('schools', $schools)
                ->with('courses', $courses);
        }
    }
  
    // ----------------------Add  Question Bank-------------------------------------
    public function SuperAdminCreateCBTSQuestionbank(Request $request)
    {
    if ($request->isMethod('POST')) {
        $question = new Question;
        $question->board_id = $request->cboard_id;
        $question->course_id = $request->ccourse_id;
        $question->class_id = $request->cclass_id;
        $question->chapter_id = $request->cchapter_id;
        $question->school_id = $request->school;
        $question->save();
        $boards = Tboards::find($request->cboard_id);
        $courses = TCourses::find($request->ccourse_id);
        $classes = TClasses::find($request->cclass_id);          
        $schools = school::find( $request->school); 
        $chapters = TChapters::find( $request->cchapter_id); 
        return redirect()->route('superadmin.cbts.questionbank.view');
    } else {
        $boards = Tboards::all();
        $courses = TCourses::all();
        $classes = TClasses::all();     
        $schools = school::all();
        return view('dashboard.superadmin.cbts.questionbank.create')
            ->with('boards', $boards)
            ->with('classes', $classes)
            ->with('schools', $schools)
            ->with('courses', $courses);
    }   
}

    // ----------------------Add Single Question -------------------------------------

public function SuperAdminCreateCBTSQQuestionbank(Request $request)
{
    if ($request->isMethod('PUT')) {
        $existingQuestion = CQuestion::where('cquestion', $request->cquestion)
        ->where('bank_id', $request->id)->first();

        if ($existingQuestion) {
            return redirect()->back()->withErrors(['message' => 'The same question already exists in this bank']);   
        }
            $question = new CQuestion;
            $question->cboard_id = $request->cboard_id;
            $question->ccourse_id = $request->ccourse_id;
            $question->cclass_id = $request->cclass_id;
            $question->cchapter_id = $request->cchapter_id;
            $question->cquestion = $request->cquestion;
            $question->school_id = $request->school;
            $question->mark = $request->mark;
            $question->cqtype = $request->cqtype_id;
            $question->bank_id = $request->id;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension(); 
                $image->move(public_path('images'), $filename); 
                $question->image = $filename; 
                    }
        
            $question->save();
                    
            $qtype = $request->cqtype_id;
            if ($qtype === "mcqs") {
                $answers = $request->answer; 
                $correctAnswers = $request->correct_answer; 
            
                if (is_string($correctAnswers)) {
                    $correctAnswers = explode(',', $correctAnswers); 
                }
            
                $correctAnswers = array_map('intval', $correctAnswers);
            
                foreach ($answers as $index => $answerText) {
                    $answer = new CAnswer;
                    $answer->q_Id = $question->id; 
                    $answer->answer = $answerText;
            
                    $answer->is_correct = in_array($index + 1, $correctAnswers) ? 1 : 0;
        
                    $answer->save();
                }
            
            } elseif ($qtype === "true_false") {
                $trueFalseAnswers = [
                    'true' => ($request->correct_answer === 'true'),
                    'false' => ($request->correct_answer === 'false'),
                ];
        
                foreach ($trueFalseAnswers as $value => $isCorrect) {
                    $answer = new CAnswer;
                    $answer->q_Id = $question->id;
                    $answer->answer = $value;
                    $answer->is_correct = $isCorrect ? 1 : 0;
                    $answer->save();
                }
            } elseif ($qtype === "fill_in_the_blanks" || $qtype === "single_line_answer") {
                $answer = new CAnswer; 
                $answer->q_Id = $question->id; 
                $answer->answer = $request->answer; 
                $answer->is_correct = 1; 
                $answer->save();
            }
            $q = Question::find($request->id);
            $boards = Tboards::where('id', $q->board_id)->first();
            $courses = TCourses::where('id', $q->course_id)->first();
            $classes = TClasses::where('id', $q->class_id)->first();        
            $schools= School::where('id', $q->school_id)->first();
            $chapters = TChapters::where('id', $q->chapter_id)->first();
          
            $questionsbank = Cquestion::join('tboards', 'tboards.id', '=', 'c_questionbank.cboard_id')
            ->join('tclasses', 'tclasses.id', '=', 'c_questionbank.cclass_id')
            ->join('tchapters', 'tchapters.id', '=', 'c_questionbank.cchapter_id')
            ->join('tcourse', 'tcourse.id', '=', 'c_questionbank.ccourse_id')
            ->join('school', 'school.id', 'c_questionbank.school_id')
            ->select('c_questionbank.*', 'tclasses.class_name', 'school.school_name as school_name', 
                     'tchapters.chapter_title', 'tboards.board_name', 'tcourse.course_name')
            ->where('bank_id',$request->id)
            -> orderBy('c_questionbank.cquestion', 'asc')
            ->paginate(10);
    
            return view('dashboard.superadmin.cbts.questionbank.singlecreate')
                ->with('boards', $boards)
                ->with('classes', $classes)
                ->with('questionsbank', $questionsbank)
                ->with('schools', $schools)
                ->with('chapters', $chapters)

                ->with('courses', $courses);
        


    } else {
        $q = Question::find($request->id);
        $boards = Tboards::where('id', $q->board_id)->first();
        $courses = TCourses::where('id', $q->course_id)->first();
        $classes = TClasses::where('id', $q->class_id)->first();        
        $schools= School::where('id', $q->school_id)->first();
        $chapters = TChapters::where('id', $q->chapter_id)->first();

  
    $questionsbank = Cquestion::join('tboards', 'tboards.id', '=', 'c_questionbank.cboard_id')
    ->join('tclasses', 'tclasses.id', '=', 'c_questionbank.cclass_id')
    ->join('tchapters', 'tchapters.id', '=', 'c_questionbank.cchapter_id')
    ->join('tcourse', 'tcourse.id', '=', 'c_questionbank.ccourse_id')
    ->join('school', 'school.id', 'c_questionbank.school_id')
    ->select('c_questionbank.*', 'tclasses.class_name', 'school.school_name as school_name', 
             'tchapters.chapter_title', 'tboards.board_name', 'tcourse.course_name')
             ->where('bank_id',$request->id)
             -> orderBy('c_questionbank.cquestion', 'asc')

    ->paginate(10);



    return view('dashboard.superadmin.cbts.questionbank.singlecreate')
        ->with('boards', $boards)
        ->with('classes', $classes)
        ->with('questionsbank', $questionsbank)
        ->with('schools', $schools)
        ->with('chapters', $chapters)
        ->with('courses', $courses);
}   
}




    // ----------------------Add  Bulk Question -------------------------------------

public function SuperAdminImportCBTSQuestionbank(Request $request)
{

    $rqMethod = $request->method();

    if ($rqMethod === 'PUT') {

    $validator = Validator::make($request->all(), [
        'cboard_id' => 'required|integer', 
        'cclass_id' => 'required|integer',
        'school_id' => 'required|integer',
        'ccourse_id' => 'required|integer',
        'cchapter_id' => 'required|integer',
    ]);

    if ($validator->fails()) {    


        return response()->json(['errors' => $validator->errors()], 422);
    }
    
    $school_id = $request->school_id;
    $cboard_id = $request->cboard_id;
    $cclass_id = $request->cclass_id;
    $ccourse_id = $request->ccourse_id;
    $cchapter_id = $request->cchapter_id;
    $cqtype = $request->cqtype_id;
    $bank_id = $request->id;

    try {
        Excel::import(new QuestionImport($school_id,$cboard_id , $cclass_id,  $ccourse_id, $cchapter_id,$bank_id, $cqtype), $request->file('file'));
    } catch (\Exception $e) {
    }
    $q = Question::find($request->id);
    $boards = Tboards::where('id', $q->board_id)->first();
    $courses = TCourses::where('id', $q->course_id)->first();
    $classes = TClasses::where('id', $q->class_id)->first();        
    $schools= School::where('id', $q->school_id)->first();
    $chapters = TChapters::where('id', $q->chapter_id)->first();
    $questionsbank = Cquestion::join('tboards', 'tboards.id', '=', 'c_questionbank.cboard_id')
    ->join('tclasses', 'tclasses.id', '=', 'c_questionbank.cclass_id')
    ->join('tchapters', 'tchapters.id', '=', 'c_questionbank.cchapter_id')
    ->join('tcourse', 'tcourse.id', '=', 'c_questionbank.ccourse_id')
    ->join('school', 'school.id', 'c_questionbank.school_id')
    ->select('c_questionbank.*', 'tclasses.class_name', 'school.school_name as school_name', 
             'tchapters.chapter_title', 'tboards.board_name', 'tcourse.course_name')
    ->where('bank_id',$request->id)
    -> orderBy('c_questionbank.cquestion', 'asc')

    ->paginate(10);
    return view('dashboard.superadmin.cbts.questionbank.bulkcreate')
        ->with('boards', $boards)
        ->with('classes', $classes)
        ->with('questionsbank', $questionsbank)
        ->with('schools', $schools)
        ->with('chapters', $chapters)
        ->with('courses', $courses);

}
if ($rqMethod === 'GET') {
    $q = Question::find($request->id);
    $boards = Tboards::where('id', $q->board_id)->first();
    $courses = TCourses::where('id', $q->course_id)->first();
    $classes = TClasses::where('id', $q->class_id)->first();        
    $schools= School::where('id', $q->school_id)->first();
    $chapters = TChapters::where('id', $q->chapter_id)->first();      
    $questionsbank = Cquestion::join('tboards', 'tboards.id', '=', 'c_questionbank.cboard_id')
    ->join('tclasses', 'tclasses.id', '=', 'c_questionbank.cclass_id')
    ->join('tchapters', 'tchapters.id', '=', 'c_questionbank.cchapter_id')
    ->join('tcourse', 'tcourse.id', '=', 'c_questionbank.ccourse_id')
    ->join('school', 'school.id', 'c_questionbank.school_id')
    ->select('c_questionbank.*', 'tclasses.class_name', 'school.school_name as school_name', 
             'tchapters.chapter_title', 'tboards.board_name', 'tcourse.course_name')
    ->where('bank_id',$request->id)
    -> orderBy('c_questionbank.cquestion', 'asc')

    ->paginate(10);
    return view('dashboard.superadmin.cbts.questionbank.bulkcreate')
        ->with('boards', $boards)
        ->with('classes', $classes)
        ->with('questionsbank', $questionsbank)
        ->with('schools', $schools)
        ->with('chapters', $chapters)
        ->with('courses', $courses);
}
}






    // ----------------------Delete Question bank -------------------------------------
    public function SuperAdminDeleteCBTSQuestion(Request $request)
    {
        if ($request->id) {
            $questions = Cquestion::where('bank_id', $request->id)->get();
            $deletedQuestionsCount = 0;
            foreach ($questions as $question) {
                Canswer::where('q_Id', $question->id)->delete();
                if ($question->delete()) {
                    $deletedQuestionsCount++;
                }
            }
            $bankDeleted = Question::where('id', $request->id)->delete();
            if ($deletedQuestionsCount > 0 && $bankDeleted) {
                return response()->json([
                    'status' => 200,
                    'deleted' => true,
                    'message' => 'Questions, associated answers, and the bank deleted successfully.'
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'deleted' => false,
                    'message' => 'No questions found or failed to delete the questions and bank.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'deleted' => false,
                'message' => 'Record ID is not provided.',
                'form' => $request->id
            ]);
        }
    }

    // ----------------------Delete Question -------------------------------------
    public function SuperAdminDeleteCBTSQQuestion(Request $request)
    {
        Cquestion::destroy($request->input('id'));
        Canswer::where('q_Id', $request->input('id'))->delete();
        return response()->json([
            'deleted' => true
        ]);
    }
    
    // ----------------------Download Mcqs Question excel file -------------------------------------
    public function downloadMcqsCsv()
    {
        $filename = "question_bank_template.csv";
        return Response::streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['question', 'mark', 'image','answer_a','answer_b','answer_c','answer_d','correct_answer']);
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }
    // ----------------------Download True False or Fill in the blanks  Question excel file -------------------------------------
    public function downloadTrueFalseCsv()
    {
        $filename = "question_bank_template.csv";
        return Response::streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['question', 'mark', 'image','answer']);
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }



    // ---------------------- Edit Question  -------------------------------------

    public function SuperAdminEditCBTSQuestionbank(Request $request)
    {
        $question = Cquestion::find($request->id);       
        $answers = Canswer::where('q_id', $question->id)->get();
        
        if ($request->isMethod('PUT')) {
            $q = Question::find($request->bank_id);       
            $question->cboard_id = $q->board_id;
            $question->ccourse_id = $q->course_id;
            $question->cclass_id = $q->class_id;
            $question->school_id = $q->school_id;
            $question->cchapter_id = $q->chapter_id;
            $question->cquestion = $request->cquestion;
            $question->mark = $request->mark;
            $question->cqtype = $request->cqtype_id;     
            if ($request->hasFile('image')) {
                if (!empty($question->image)) {
                    unlink(public_path('images/' . $question->image));
                }
                $image = $request->file('image');
                $filename = uniqid() . '.' . $image->getClientOriginalExtension(); 
                $image->move(public_path('images'), $filename); 
                $question->image = $filename; 
            }
            
            $question->save();            
            Canswer::where('q_id', $question->id)->delete();    
            $qtype = $request->cqtype_id;
            if ($qtype === "mcqs") {
                foreach ($request->answer as $index => $answerText) {
                    $answer = new Canswer;
                    $answer->q_id = $question->id;
                    $answer->answer = $answerText;
                    $answer->is_correct = in_array($index + 1, (array) $request->correct_answer) ? 1 : 0;
                    $answer->save();
                }
            } elseif ($qtype === "true_false") {
                foreach (['true', 'false'] as $value) {
                    $answer = new Canswer;
                    $answer->q_id = $question->id;
                    $answer->answer = $value;
                    $answer->is_correct = ($value === $request->correct_answer) ? 1 : 0;
                    $answer->save();
                }
            } elseif (in_array($qtype, ["fill_in_the_blanks", "single_line_answer"])) {
                $answer = new Canswer; 
                $answer->q_id = $question->id; 
                $answer->answer = $request->answer; 
                $answer->is_correct = 1; 
                $answer->save();
            }
    
            return redirect()->route('superadmin.cbts.questionbank.view')->with('success', 'Question updated successfully.');
        }
    
        return view('dashboard.superadmin.cbts.questionbank.edit', compact('question', 'answers'));
    }
    
   




    
    public function SchoolAdminViewCBTSQuestionbank(Request $request)
{
    $boards = Tboards::all();
    $schools = HelperFunctionsController::getUserSchools();
    $schoolId = HelperFunctionsController::getUserSchoolsIds();
    $rqMethod = $request->method();

    if ($rqMethod === 'GET') {
        $questions = Cquestion::whereIn('c_questionbank.school_id', $schoolId)
            ->join('tboards', 'tboards.id', '=', 'c_questionbank.cboard_id')
            ->join('tclasses', 'tclasses.id', '=', 'c_questionbank.cclass_id')
            ->join('ttchapters', 'tchapters.id', '=', 'c_questionbank.cchapter_id')
            ->join('tcourse', 'tcourse.id', '=', 'c_questionbank.ccourse_id')
            ->join('school', 'school.id', 'c_questionbank.school_id')
            ->select('c_questionbank.*', 'tclasses.class_name', 'school.school_name as school', 
                     'tchapters.tchapters_title', 'tboards.board_name', 'tcourse.tcourse_name')
            ->paginate(10);

        return view('dashboard.admin.cbts.questionbank.view')
            ->with('questions', $questions)
            ->with('boards', $boards)
            ->with('schools', $schools);
                } 
    
    // ----------------------filter-------------------------------------
    elseif ($rqMethod === 'POST') {
        $questions = Cquestion::where('c_questionbank.cboard_id', $request->cboard_id)
            ->where('c_questionbank.cclass_id', $request->cclass_id)
            ->where('c_questionbank.ctcourse_id', $request->ctcourse_id)
            ->where('c_questionbank.school_id', $schoolId)
            ->join('tboards', 'tboards.id', '=', 'c_questionbank.cboard_id')
            ->join('tclasses', 'tclasses.id', '=', 'c_questionbank.cclass_id')
            ->join('tchapters', 'tchapters.id', '=', 'c_questionbank.cchapter_id')
            ->join('tcourse', 'tcourse.id', '=', 'c_questionbank.ccourse_id')
            ->join('school', 'school.id', 'c_questionbank.school_id')


            ->select('c_questionbank.*', 
                     'c_questionbank.cquestion as topic_title', 
                     'school.school_name as school',
                     'tclasses.class_name', 
                     'tchapters.chapter_title', 
                     'tboards.board_name', 
                     'tcourse.tcourse_name')
            ->paginate(50);

        return view('dashboard.admin.cbts.questionbank.view')
            ->with('questions', $questions)
            ->with('boards', $boards)
            ->with('schools', $schools);
                }
}









public function SchoolAdminCreateCBTSQuestionbank(Request $request)
{
if ($request->isMethod('POST')) {
    // Create and save the question
    $question = new CQuestion;
    $question->cboard_id = $request->cboard_id;
    $question->ctcourse_id = $request->ctcourse_id;
    $question->cclass_id = $request->cclass_id;
    $question->ctchapters_id = $request->ctchapters_id;
    $question->cquestion = $request->cquestion;
    $question->school_id = $request->school;
    $question->mark = $request->mark;
    $question->cqtype = $request->cqtype_id;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension(); 
        $image->move(public_path('images'), $filename); 
        $question->image = $filename; 
            }

    $question->save();

    $qtype = $request->cqtype_id;
    if ($qtype === "mcqs") {
        $answers = $request->answer; 
        $correctAnswers = $request->correct_answer; 
    
        if (is_string($correctAnswers)) {
            $correctAnswers = explode(',', $correctAnswers); 
        }
    
        $correctAnswers = array_map('intval', $correctAnswers);
    
        foreach ($answers as $index => $answerText) {
            $answer = new CAnswer;
            $answer->q_Id = $question->id; 
            $answer->answer = $answerText;
    
            $answer->is_correct = in_array($index + 1, $correctAnswers) ? 1 : 0;

            $answer->save();
        }
     
    } elseif ($qtype === "true_false") {
        $trueFalseAnswers = [
            'true' => ($request->correct_answer === 'true'),
            'false' => ($request->correct_answer === 'false'),
        ];

        foreach ($trueFalseAnswers as $value => $isCorrect) {
            $answer = new CAnswer;
            $answer->q_Id = $question->id;
            $answer->answer = $value;
            $answer->is_correct = $isCorrect ? 1 : 0;
            $answer->save();
        }
    } elseif ($qtype === "fill_in_the_blanks" || $qtype === "single_line_answer") {
        $answer = new CAnswer; 
        $answer->q_Id = $question->id; 
        $answer->answer = $request->answer; 
        $answer->is_correct = 1; 
        $answer->save();
    }

    return redirect()->route('schooladmin.cbts.questionbank.qcreate');
} else {
    $boards = Tboards::all();
     $schools = HelperFunctionsController::getUserSchools();

    return view('dashboard.admin.cbts.questionbank.qcreate')
        ->with('boards', $boards)
        ->with('schools', $schools);
    }
}


    
}    