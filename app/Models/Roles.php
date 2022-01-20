<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{

    protected $table = 'roles';
    protected $fillable = [
        'name',
    ];

    public function user()
    {
        return $this->hasMany('App\Models\Contact', 'id', 'role_id');
    }


}
