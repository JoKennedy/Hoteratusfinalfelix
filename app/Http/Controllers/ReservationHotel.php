<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Reservaciones_hotel;
use App\Country;
use App\Salutation;
use App\Room;
use App\RoomType;
use App\RoomStatus;
use App\RoomStatusColor;
use App\HousekeepingStatus;
use App\reservation;

class ReservationHotel extends Controller
{
    

    public function index(){
    	$tasks = Reservaciones_hotel::orderBy('fecha_entrada_usuerio')->select('id','user_reservation', 'fecha_entrada_usuerio', 'fecha_salida_usuerio', 'habitacion', 'costo_habitacion', 'status')->get();

    	$tasksCompleted = $tasks->filter(function ($tasks, $key){
    		return $tasks->status;
    	})->values();


    	$tasksNotCompleted = $tasks->filter(function ($tasks, $key){
    		return ! $tasks->status;
    	})->values();

    	return view('pages.reservationhotel.index', compact('tasksCompleted', 'tasksNotCompleted'));
    }

    public function updateTasksStatus(Request $request, $id){
    	
    	$this->validate($request, ['status' => 'required|boolean',

    	]);

    	$tasks = ReservationHotel::find($id);

    	$tasks->status = $request->status;
    	$tasks->save();

    	return response('Updated Successfully.', 200); 
    }

    public function updateTasksOrder(Request $Request){

    	$this->validate($request, [
    		'tasks.*.usuario_reservation' => 'required|numeric',
    	]);

    	$tasks = Reservaciones_hotel::all();

    	foreach ($tasks as $task) {
    		$id = $task->id;

    		foreach ($request->tasks as $tasksNew) {
    			if($tasksNew['id'] == $id){
    				$task->update(['usuario_reservation' => $tasksNew['usuario_reservation']]);
    			}
    		}
    	}

    	return response('Updated Successfully.', 200);
    }

}
