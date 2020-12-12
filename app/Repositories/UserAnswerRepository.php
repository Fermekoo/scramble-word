<?php 
namespace App\Repositories;

use Log;
use App\Models\UserAnswer;
use Illuminate\Database\QueryException;

class UserAnswerRepository
{
    public function create(array $payloads)
    {
        try {

            $create = UserAnswer::create($payloads);

        } catch (QueryException $e) {

            Log::warning(__CLASS__.' line '.__LINE__.' : '. $e->getMessage());
            throw $e;
        }

        return $create;
    }

    public function getByUserId($user_id, $status = null)
    {
        $user_answer = UserAnswer::where('user_id', $user_id)
                        ->when($status, function($query) use($status){
                            return $query->where('status',$status);
                        })
                        ->with('user','question')
                        ->orderBy('created_at','asc')
                        ->get();

        return $user_answer;
    }
}