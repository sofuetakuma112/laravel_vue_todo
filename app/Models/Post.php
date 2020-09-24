<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'user_id', 'content',
    ];

    public function likes() {
        return $this->hasMany('App\Models\Like');
    }
}
