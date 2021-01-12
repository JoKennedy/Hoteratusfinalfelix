<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservaciones_hotel extends Model
{
    
    protected $fillable = [
    	'id', 'user_reservation', 'fecha_entrada_usuerio', 'fecha_salida_usuerio', 'habitacion', 'costo_habitacion', 'created_at', 'created_at', 'status'];
}
