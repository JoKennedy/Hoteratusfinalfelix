<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneExtension extends Model
{
    protected $fillable = [
        'hotel_id', 'extension_number', 'title', 'comments', 'room_id', 'property_department_id',
    ];
}
