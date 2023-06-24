<?php

namespace App\Traits;

use Illuminate\Support\Str;

/**
 * 
 */
trait useUUID
{
    public static function booted()
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });
    }
    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
