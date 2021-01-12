<?php

namespace App;

//use Illuminate\Database\Eloquent\Facctories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
	//use HasFactory;

	protected $table = 'reservation';
	//public $timestamps = true;

	// protected $casts = [
	// 	'cost' => 'float'
	// ];

	protected $fillable = [
		"name",    "phone", "email", "fecha_entrda", "fecha_salida", "adrees", "country", "gender", "nationality", "state", "zip_code", "tim", "created_at", "updated_at"
	];

	 
}

