<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Import extends Model
{
    use SoftDeletes;
    protected $fillable = ['supplier_id', 'note'];
    public function books()
    {
        return $this->belongsToMany('App\Book');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
