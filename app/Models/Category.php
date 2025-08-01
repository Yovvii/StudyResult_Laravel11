<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    public function posts(): HasMany{
        return $this->hasMany(Post::class);
    }

        protected static function booted()
    {
        static::deleting(function ($category) {
            $defaultCategoryId = 1; // ID kategori default

            // Ganti semua post yang memakai kategori ini
            Post::where('category_id', $category->id)
                ->update(['category_id' => $defaultCategoryId]);
        });
    }
}
