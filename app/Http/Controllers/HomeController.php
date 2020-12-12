<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserAnswerRepository;

class HomeController extends Controller
{
    protected $user_answer;
   public function __construct(UserAnswerRepository $user_answer)
   {
       $this->user_answer = $user_answer;
   }
    public function index()
    {
        $user       = Auth::user();
        $histories  = ($user) ? $this->user_answer->getByUserId($user->id) : null;
        return view('play', compact('histories'));
    }
}
