<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'author', 'price', 'quantity', 'description', 'category_id', 'slug'];
    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function invoices()
    {
        return $this->belongsToMany('App\Invoice');
    }

    public function imports()
    {
        return $this->belongsToMany('App\Import');
    }
}
