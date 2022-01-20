<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $fillable = [
        'name',
        'amount',
        'count',
        'seller_id'
    ];

    public function user()
    {
        return $this->belongsTo(Contact::class, 'id', 'seller_id');
    }

    public function authors()
    {
        return $this->belongsToMany('App\Models\Authors', 'books_author', 'book_id', 'author_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Categories', 'books_categories', 'book_id', 'category_id');
    }


}
