<?php

namespace App\Models;

use App\Models\User;
use App\Models\BookCopy;
use App\Models\Category;
use App\Models\SubCategory;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Books extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = ['name', 'publisher', 'category_id', 'sub_category_id', 'description', 'pages', 'image', 'added_by'];
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('book_image')->singleFile();
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function copies()
    {
        return $this->hasMany(BookCopy::class);
    }

    public function bookLoans()
    {
        return $this->hasOne(BookLoans::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($book) {
            $book->copies()->delete();
        });
    }
}
