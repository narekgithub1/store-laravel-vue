<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'product_id',
        'buyer_id',
        'amount',
        'count',
        'seller_id',
        'status'
    ];

    public function books()
    {
        return $this->belongsTo('App\Models\Book', 'product_id', 'id');
    }


}
