<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ["url", 'caption'];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function getGetImageAttribute()
    {
            return url("storage/$this->url");
    }
}
