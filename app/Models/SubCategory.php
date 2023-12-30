<?php

namespace App\Models;

use App\Models\Books;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function books()
    {
        return $this->hasMany(Books::class, 'sub_category_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($subCategory) {
            $subCategory->books()->delete();
        });
    }
}
