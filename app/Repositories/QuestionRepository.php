<?php 
namespace App\Repositories;

use App\Models\Question;

class QuestionRepository 
{
    public function findQuestion($except_id = [])
    {
        $question = Question::whereNotIn('id',$except_id)->inRandomOrder()->first();

        return $question;
    }

    public function verifyAnswer($answer_word)
    {
        $check = Question::where('word', $answer_word)->first();

        return $check;
    }

    public function findById($question_id)
    {
        $question = Question::find($question_id);

        return $question;
    }
}