<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            $category->products()->each(function ($product) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }

                $product->features()->delete();

                $product->delete();
            });
        });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
