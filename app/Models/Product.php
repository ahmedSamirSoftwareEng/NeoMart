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

    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'image'];

    protected $appends = ['image_url'];
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
        static::creating(function (Product $product) {
            $product->slug = Str::slug($product->name);
        });
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
    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active'
        ], $filters);
        $builder->when($options['status'], function ($builder, $value) {
            $builder->where('status', $value);
        });
        $builder->when($options['store_id'], function ($builder, $value) {
            $builder->where('store_id', $value);
        });
        $builder->when($options['category_id'], function ($builder, $value) {
            $builder->where('category_id', $value);
        });
        $builder->when($options['tag_id'], function ($builder, $value) {
            $builder->whereExists(function ($query) use ($value) {
                $query->selectRaw('1')
                    ->from('product_tag')
                    ->whereRaw('product_id = products.id')
                    ->where('product_tag.tag_id', $value);
            });
        });
    }
}
