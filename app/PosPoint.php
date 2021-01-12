<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosPoint extends Model
{
    protected $fillable = [
     'user_id', 'hotel_id', 'name', 'code', 'property_department_id', 'account_code_id', 'logo', 'company_name', 'company_address',
     'task_emails', 'description', 'pos_type_id'
    ];


}
