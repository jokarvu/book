<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Import extends Model
{
    use SoftDeletes;
    public function books()
    {
        return $this->hasMany('App\Book');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
