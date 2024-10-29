<?php

namespace App\Http\Controllers;

use App\Models\Cquestion;
use App\Models\Canswer;
use Illuminate\Http\Request;
use App\Models\Tboards;
use App\Models\TCourses;
use App\Models\TClasses;
use App\Models\Tchapters;
use App\Models\school;

class QuestionbankController extends Controller
{
    public function filterChapter(Request $request)
    {
      
        $chapters = Tchapters::where('tcourse_id', $request->course_id)
            ->where('tclass_id', $request->class_id) 
            ->get();
    
        return response()->json(['chapters' => $chapters]);
    }
   
    // ----------------------View-------------------------------------
    public function SuperAdminViewCBTSQuestionbank(Request $request)
    {
        $boards = Tboards::all();
        $classes = TClasses::all();
        $courses = TCourses::all();
        $schools = school::all();

        $rqMethod = $request->method();

        if ($rqMethod === 'GET') {
            $questions = Cquestion::join('tboards', 'tboards.id', '=', 'c_questionbank.cboard_id')
                ->join('tclasses', 'tclasses.id', '=', 'c_questionbank.cclass_id')
                ->join('tchapters', 'tchapters.id', '=', 'c_questionbank.cchapter_id')
                ->join('tcourse', 'tcourse.id', '=', 'c_questionbank.ccourse_id')
                ->join('school', 'school.id', 'c_questionbank.school_id')
                ->select('c_questionbank.*', 'tclasses.class_name', 'school.school_name as school', 
                         'tchapters.chapter_title', 'tboards.board_name', 'tcourse.course_name')
                ->paginate(10);

            return view('dashboard.superadmin.cbts.questionbank.view')
                ->with('questions', $questions)
                ->with('boards', $boards)
                ->with('classes', $classes)
                ->with('schools', $schools)
                ->with('courses', $courses);
        } 
        
        // ----------------------filter-------------------------------------
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

    // ----------------------Add-------------------------------------
    public function SuperAdminCreateCBTSQuestionbank(Request $request)
    {
    if ($request->isMethod('POST')) {
        // Create and save the question
        $question = new CQuestion;
        $question->cboard_id = $request->cboard_id;
        $question->ccourse_id = $request->ccourse_id;
        $question->cclass_id = $request->cclass_id;
        $question->cchapter_id = $request->cchapter_id;
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

    return redirect()->route('schooladmin.cbts.questionbank.view');
} else {
    $boards = Tboards::all();
     $schools = HelperFunctionsController::getUserSchools();

    return view('dashboard.admin.cbts.questionbank.create')
        ->with('boards', $boards)
        ->with('schools', $schools);
    }
}

    // ----------------------Delete-------------------------------------
    public function SuperAdminDeleteCBTSQuestion(Request $request)
    {
        if ($request->id) {
            // Delete the answers associated with the question
            Canswer::where('q_Id', $request->id)->delete(); 
        
            // Delete the question itself
            $deletedRows = Cquestion::destroy($request->id);
        
            if ($deletedRows > 0) {
                return response()->json([
                    'status' => 200,
                    'deleted' => true,
                    'message' => 'Question and associated answers deleted successfully.'
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'deleted' => false,
                    'message' => 'Failed to delete the question.'
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

    public function SchoolAdminDeleteCBTSQuestion(Request $request)
    {
        if ($request->id) {
            // Delete the answers associated with the question
            Canswer::where('q_Id', $request->id)->delete(); 
        
            // Delete the question itself
            $deletedRows = Cquestion::destroy($request->id);
        
            if ($deletedRows > 0) {
                return response()->json([
                    'status' => 200,
                    'deleted' => true,
                    'message' => 'Question and associated answers deleted successfully.'
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'deleted' => false,
                    'message' => 'Failed to delete the question.'
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





    public function SuperAdminEditCBTSQuestionbank(Request $request)
    {
        // Fetch the question by ID
        $question = Cquestion::findOrFail($request->id);
    
        // Fetch the answers associated with the question
        $answers = Canswer::where('q_id', $question->id)->get();
    
        // Fetch related data for dropdowns
        $boards = Tboards::all();
        $tclasses = TClasses::all();
        $tcourses = Course::all();
        $schools = School::all();
    
        if ($request->isMethod('POST')) {
            // Update the question
            $question->cboard_id = $request->cboard_id;
            $question->ctcourse_id = $request->ctcourse_id;
            $question->cclass_id = $request->cclass_id;
            $question->ctchapters_id = $request->ctchapters_id;
            $question->cquestion = $request->cquestion;
            $question->school_id = $request->school;
            $question->mark = $request->mark;
            $question->cqtype_id = $request->cqtype_id; // corrected to cqtype_id
    
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($question->image) {
                    unlink(public_path('images/' . $question->image));
                }
    
                // Upload new image
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension(); 
                $image->move(public_path('images'), $filename); 
                $question->image = $filename; 
            }
    
            $question->save();
    
            // Clear existing answers for the question
            Canswer::where('q_id', $question->id)->delete(); // Ensure consistency in naming
    
            // Add new answers based on question type
            $qtype = $request->cqtype_id;
    
            if ($qtype === "mcqs") {
                foreach ($request->answer as $index => $answerText) {
                    $answer = new Canswer; 
                    $answer->q_id = $question->id; 
                    $answer->answer = $answerText; 
                    $answer->is_correct = in_array($index + 1, $request->correct_answer) ? 1 : 0; 
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
            } elseif ($qtype === "fill_in_the_blanks" || $qtype === "single_line_answer") {
                $answer = new Canswer; 
                $answer->q_id = $question->id; 
                $answer->answer = $request->answer; // Make sure this corresponds to the input name in your view
                $answer->is_correct = 1; 
                $answer->save();
            }
    
            return redirect()->route('superadmin.cbts.questionbank.view')->with('success', 'Question updated successfully.');
        }
    
        return view('dashboard.superadmin.cbts.questionbank.edit', compact('question', 'boards', 'schools', 'tcourses', 'answers', 'tclasses'));
    }
    
   
    
}    