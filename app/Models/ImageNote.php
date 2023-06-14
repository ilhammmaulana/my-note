<?php

namespace App\Models;

use App\Traits\useUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageNote extends Model
{
    use HasFactory, useUUID;
    protected $fillable = ['note_id', 'image'];
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}
