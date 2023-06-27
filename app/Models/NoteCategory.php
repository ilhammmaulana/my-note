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
    protected $fillable = ['id', 'note_id', 'category_id'];


    public function note()
    {
        return $this->belongsTo(Note::class, {
            onDelete: 'CASCADE'
        });
    }
    function category()
    {
        return $this->hasOne(Category::class);
    }
}
