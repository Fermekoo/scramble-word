<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Http\Requests\UserRegister;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class AuthController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function register(UserRegister $request)
    {
       $validate = $request->validated();
    }
}
