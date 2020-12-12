<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasUUID;

    protected $table      = 'questions';
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    public $incrementing  = false;
    protected $fillable   = ['id','word'];

    public function answer()
    {
        return $this->hasMany(UserAnswer::class, 'question_id');
    }
}
