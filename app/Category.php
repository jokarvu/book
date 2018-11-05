<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'category_id', 'description'];

    public function books()
    {
        return $this->hasMany('App\Book');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function children()
    {
        return $this->hasMany('App\Category');
    }

    public function setNameAttribute($value) {
        $this->attributes['name'] = ucwords($value);
        $this->attributes['slug'] = str_slug($value);
    }
}
