<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'parent_id',
        'slug',
        'image',
        'status',

    ];
}
