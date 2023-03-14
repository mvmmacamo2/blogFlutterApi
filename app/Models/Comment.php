<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id', 'comment', 'user_id'
    ];

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
