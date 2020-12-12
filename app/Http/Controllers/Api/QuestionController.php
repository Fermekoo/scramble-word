<?php

namespace App\Http\Controllers\Api;

use App\Services\QuestionService;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyAnswer;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    protected $question;
    public function __construct(QuestionService $question)
    {
        $this->middleware('auth');
        $this->question = $question;
    }

    public function getQuestion()
    {
        
        $user_id = Auth::user()->id;

        $question = $this->question->findQuestion($user_id);

        return response()->json($question);
    }

    public function verify(VerifyAnswer $request)
    {
        $validate = $request->validated();

        $user_id     = Auth::user()->id;
        $question_id = $request->questionId;
        $answer      = $request->answer;
        
        try {
           $check = $this->question->verify($user_id, $question_id, $answer);
        } catch (\Exception $e) {
            return false;
        }

        return $check;
    }
}
