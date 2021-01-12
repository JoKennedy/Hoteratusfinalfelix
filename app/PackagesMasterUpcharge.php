<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackagesMasterUpcharge extends Model
{
    protected $fillable = [ 'packages_master_room_id', 'user_id', 'persons', 'adults', 'children'];
}
