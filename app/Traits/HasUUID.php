<?php 
namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait HasUUID 
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }
} 