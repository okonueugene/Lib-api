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
        return $this->belongsTo(Category::class);
    }

    public function books()
    {
        return $this->hasMany(Books::class);
    }
}