<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'author', 'price', 'quantity', 'quantity_left', 'description', 'category_id', 'slug'];
    protected $dates = ['deleted_at'];
    protected $appends = ['sold'];

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

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    public function getAuthorAttribute($value)
    {
        return ucwords($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value);
        $this->attributes['name'] = ucwords($value);
    }

    public function getSoldAttribute() {
        return $this->quantity - $this->quantity_left;
    }
}
