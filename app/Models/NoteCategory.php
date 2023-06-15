<?php

namespace App\Models;

use App\Traits\useUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteCategory extends Model
{
    use HasFactory, useUUID;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['note_id', 'category_id'];


    public function note()
    {
        return $this->belongsTo(Note::class);
    }
    function category()
    {
        return $this->belongsTo(Category::class);
    }
}
