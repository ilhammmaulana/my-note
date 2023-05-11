<?php

namespace App\Models;

use App\Traits\useUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory, useUUID;
    protected $table = 'notes';
    protected $fillable = ['title', 'body', 'created_by', 'label', 'pinned'];
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
}
