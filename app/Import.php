<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    public function books()
    {
        return $this->hasMany('App\Book');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
