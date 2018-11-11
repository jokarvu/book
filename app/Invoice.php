<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'address', 'status_id', 'shipping_tax', 'note'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function books()
    {
        return $this->belongsToMany('App\Book');
    } 
}
