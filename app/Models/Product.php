<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }
    public function Store()
    {
        return $this->belongsTo(Store::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('store', new StoreScope());
    }
}
