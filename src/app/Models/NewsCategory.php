<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    //
    protected $table = 'news_categories';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail'
    ];
    public function news(){
        return $this->hasMany(News::class, 'category_id');
    }
}
