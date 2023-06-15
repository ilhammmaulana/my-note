<?php

namespace App\Models;

use App\Traits\useUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, useUUID;
    protected $fillable = ['id', 'category_name', 'created_by'];
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $table = 'categories';
    protected $keyType = 'string';


    public function noteCategory()
    {
        return $this->hasMany(NoteCategory::class, 'category_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function notes()
    {
        return $this->belongsToMany(Note::class, 'note_categories');
    }
}
