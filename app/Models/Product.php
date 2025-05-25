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

    protected $fillable = ['name','slug','image', 'description', 'price', 'compare_price' ,'status', 'category_id', 'store_id'];

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

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
