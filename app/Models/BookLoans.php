<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookLoans extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'book_id', 'user_id', 'can_date', 'due_date', 'return_date', 'extended', 'extension_tale_cate',
        'penalty_amount', 'penalty_status', 'added_by', 'updated_by', 'status'
    ];

    public function book()
    {
        return $this->belongsTo(Books::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
