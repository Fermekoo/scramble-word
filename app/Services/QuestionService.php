<?php 
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\QuestionRepository;
use App\Repositories\UserAnswerRepository;
use App\Repositories\UserRepository;

class QuestionService 
{
    protected $question;
    protected $user_answer;
    protected $user;

    public function __construct(
        QuestionRepository $question, 
        UserAnswerRepository $user_answer,
        UserRepository $user
        )
    {
        $this->question     = $question;
        $this->user_answer  = $user_answer;
        $this->user         = $user;
    }

    public function findQuestion($user_id)
    {
        $user_answer_id_arr = $this->user_answer->getByUserId($user_id, true)->pluck('id');

        $question = $this->question->findQuestion($user_answer_id_arr);
        if($question) {
            $question->word = str_shuffle($question->word);

            return $question;
        }
    }

    public function verify($user_id, $question_id, $answer)
    {
        $question = $this->question->findById($question_id);

        if($question) :
            $check_word = (strtoupper($question->word) == strtoupper($answer)) ? true : false;
            $user_answer_payloads = [
                'user_id'       => $user_id,
                'question_id'   => $question_id,
                'answer'        => strip_tags($answer),
                'status'        => $check_word
            ];

            DB::beginTransaction();

            try {

               $save_answer = $this->user_answer->create($user_answer_payloads);

            } catch (\Exception $e) {

                DB::rollBack();
                throw $e;

            }

            try {

                $score = ($check_word) ? $this->user->incScore($user_id) : $this->user->decScore($user_id);

            } catch (\Exception $e) {

                DB::rollBack();
                throw $e;

            }

            DB::commit();

            return $save_answer;

        endif;

        return false;
    }
}