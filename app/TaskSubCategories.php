<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskSubCategories extends Model
{
    protected $fillable = [
    "name" , "description"
     ];

     protected $table = 'tasks_sub_categories';
}
