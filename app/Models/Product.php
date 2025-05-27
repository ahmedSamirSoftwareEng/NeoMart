<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image', 'description', 'price', 'compare_price', 'status', 'category_id', 'store_id'];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
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
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://motobros.com/wp-content/uploads/2024/09/no-image.jpeg';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }

    public function getSalePercentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }
        return round((($this->compare_price - $this->price) / $this->compare_price) * 100);
    }
}
