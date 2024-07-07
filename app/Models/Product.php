<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','slug', 'description', 'image', 'category_id', 'store_id', 'price', 'compare_price', 'status',
    ];
    protected static function booted()
    {
        static::addGlobalScope('store', function(Builder $builder) {
            $user = Auth::user();
            if ($user && $user->store_id) {
                $builder->where('store_id', '=', $user->store_id);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'product_tag',
            'product_id',
            'tag_id',
            'id',
            'id'
        );
    }

    // scope
    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }

    public function getImageUrlAttribute()
    {
        if( !$this->image )
        {
            return '';
        }

        if (Str::startsWith( $this->image, ['http://', 'https://'])){
            return $this->image;
        }

        return asset('storage/'.$this->image);
    }

    public function getSalePercentAttribute()
    {
        if (!$this->compare_price){
            return 0;
        }
        return 100 - (100 * $this->price / $this->compare_price);
    }
}
