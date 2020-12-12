<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasUUID;

    protected $table      = 'user_answers';
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;
    protected $fillable   = ['id','user_id','question_id','answer','status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
