<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use App\Rules\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory ,SoftDeletes;
    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'parent_id',
        'slug',
        'image',
        'status',

    ];

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $value) {
            $query->where('categories.name', 'like', '%' . $value . '%');
        });
        $query->when($filters['status'] ?? false, function ($query, $value) {
            $query->where('categories.status', $value);
        });
    }
    public static function rules($id = null)
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:3',
                Rule::unique('categories', 'name')->ignore($id),
                'filter:laravel,php,html,css,javascript',
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'parent_id' => 'nullable|int|exists:categories,id',
            'status' => 'required|in:active,archived',
        ];
    }
}
