<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    protected $fillable = [
        'title',
        'content',
        'post_url',
        'category_id',
        'author_id',
        'thumbnail'
    ];
    
}
