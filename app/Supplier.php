<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'slug'];
    public function imports()
    {
        return $this->hasMany('App\Import');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value);
        $this->attributes['name'] = ucwords($value);
    }
}
