<?php

namespace App\Models;

use App\Traits\useUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory, useUUID;
    protected $table = 'notes';
    protected $fillable = ['title', 'body', 'created_by', 'label', 'favorite'];
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public function imagesNote()
    {
        return $this->hasMany(ImageNote::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'note_categories')
            ->withPivot('id as note_category_id');
    }
}
