<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{

    protected $table = 'authors';
    protected $fillable = [
        'name',
    ];

    public function books()
    {
        return $this->belongsToMany('App\Models\Book', 'books_author', 'author_id', 'book_id');
    }


}
