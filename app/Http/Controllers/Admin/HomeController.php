<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserAnswerRepository;
use App\Repositories\UserRepository;

class HomeController extends Controller
{
    protected $user;
    protected $user_answer;
    public function __construct(UserRepository $user, UserAnswerRepository $user_answer)
    {
        $this->middleware('auth');
        $this->user         = $user;
        $this->user_answer  = $user_answer;
    }

    public function index()
    {
        return view('home');
    }

    public function dataUser()
    {
        $users = $this->user->getAll('USER');

        $data = DataTables::of($users)
                ->addColumn('action', function($row){
                    return route('user.detail', $row->id);
                })
                ->make(true);

        return $data;
    }

    public function userDetail($id)
    {
        $user = $this->user->findById($id);
        return view('user', compact('user'));
    }

    public function userHistory($id)
    {
        $history = $this->user_answer->getByUserId($id);

        $data = DataTables::of($history)->addColumn('question', function($row){
            return $row->question->word;
        })
        ->editColumn('created_at', function($row){
            return $row->created_at->toDateTimeString();
        })
        ->make(true);

        return $data;
    }
}
