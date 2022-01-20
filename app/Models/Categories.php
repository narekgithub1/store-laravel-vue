<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{

    protected $table = 'categories';
    protected $fillable = [
        'name',
    ];

    public function books()
    {
        return $this->belongsToMany('App\Models\Book', 'books_categories', 'category_id', 'book_id');
    }

}
