<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Cquestion;
use App\Models\CAnswer;

class QuestionImport implements ToModel, WithHeadingRow
{
    protected $school_id; 
    protected $cboard_id; 
    protected $cclass_id; 
    protected $ccourse_id; 
    protected $cchapter_id; 
    protected $bank_id; 
    protected $cqtype; 

    public function __construct($school_id, $cboard_id, $cclass_id, $ccourse_id, $cchapter_id, $bank_id,$cqtype)
    {
        $this->school_id = $school_id; 
        $this->cboard_id = $cboard_id; 
        $this->cclass_id = $cclass_id; 
        $this->ccourse_id = $ccourse_id; 
        $this->cchapter_id = $cchapter_id; 
        $this->bank_id = $bank_id; 
        $this->cqtype= $cqtype; 

    }

    public function model(array $row)
    {
        $question = new Cquestion([
            'cquestion' => $row['question'], 
            'mark' => (int) $row['mark'],
            'image' => $row['image'] ?? null,
            'school_id' => $this->school_id, 
            'cboard_id' => $this->cboard_id,
            'cclass_id' => $this->cclass_id,
            'ccourse_id' => $this->ccourse_id,
            'cchapter_id' => $this->cchapter_id,
            'cqtype' =>$this->cqtype, 
            'bank_id' => $this->bank_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $question->save();
        $qtype = $this->cqtype;
        if ($qtype === "mcqs") {
            $answers = [$row['answer_a'], $row['answer_b'], $row['answer_c'], $row['answer_d']]; 
            $correct_answer = $row['correct_answer'];
            foreach ($answers as $answerText) {
                $answer = new CAnswer;
                $answer->q_Id = $question->id;
                $answer->answer = $answerText;
                $answer->is_correct = ($answerText === $correct_answer) ? 1 : 0;
                $answer->save();
            }
        }
        elseif ($qtype === "fill_in_the_blanks" || $qtype === "single_line_answer") {
         
            $answer = new CAnswer;
            $answer->q_Id = $question->id;
            $answer->answer = $row['answer'];
            $answer->is_correct = 1;
            $answer->save();
        }
        elseif ($qtype === "true_false") {
            $providedAnswer = $row['answer']; 
            $trueAnswer = new CAnswer;
            $trueAnswer->q_Id = $question->id;
            $trueAnswer->answer = 'true';
            $trueAnswer->is_correct = ($providedAnswer === '"true"' || $providedAnswer === '1') ? 1 : 0; 
            $trueAnswer->save();
        
            $falseAnswer = new CAnswer;
            $falseAnswer->q_Id = $question->id;
            $falseAnswer->answer = 'false';
            $falseAnswer->is_correct = ($providedAnswer === '"false"' || $providedAnswer === '0') ? 1 : 0; 
            $falseAnswer->save();
        
        }
        return $question;
    }
}
