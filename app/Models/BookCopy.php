<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCopy extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'copy_number',
        'is_available',
    ];

    public function book()
    {
        return $this->belongsTo(Books::class);
    }

    public function bookLoans()
    {
        return $this->hasMany(BookLoans::class, 'book_id');
    }



}
