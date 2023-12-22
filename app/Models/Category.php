<?php

namespace App\Models;

use App\Models\Books;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function books()
    {
        return $this->hasManyThrough(Books::class, SubCategory::class);
    }



}