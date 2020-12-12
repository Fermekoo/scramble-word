<?php 
namespace App\Repositories;

use Log;
use App\Models\User;
use Illuminate\Database\QueryException;

class UserRepository 
{
    public function create(array $payloads)
    {
        try {

           $create =  User::create($payloads);

        } catch (QueryException $e) {
            Log::warning(__CLASS__.' line '.__LINE__.' : '. $e->getMessage());
            throw $e;
        }

        return $create;
    }

    public function incScore($user_id)
    {
        try {

            $user = User::find($user_id);
            $user->increment('score');

        } catch (QueryException $e) {
            Log::warning(__CLASS__.' line '.__LINE__.' : '. $e->getMessage());
            throw $e;
        }
    }

    public function decScore($user_id)
    {
        try {

            $user = User::find($user_id);
            $user->decrement('score');

        } catch (QueryException $e) {
            Log::warning(__CLASS__.' line '.__LINE__.' : '. $e->getMessage());
            throw $e;
        }
    }

    public function getAll($type = null)
    {
        return User::when($type, function($query) use($type){
            return $query->where('user_type', $type);
        })->get();
    }

    public function findById($id)
    {
        return User::find($id);
    }
}