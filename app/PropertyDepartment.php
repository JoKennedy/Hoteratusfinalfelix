<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyDepartment extends Model
{
    protected $fillable = ['hotel_id', 'name', 'code', 'description', 'editable'];
}
