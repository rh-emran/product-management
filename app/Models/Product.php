<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            // if ($product->image) {
            //     Storage::disk('public')->delete($product->image);
            // }

            $product->features()->delete();
        });
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function features()
    {
        return $this->hasMany(Feature::class);
    }
}
