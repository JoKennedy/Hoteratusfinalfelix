<?php

namespace App\Http\Controllers;


use App\Country;
use App\Salutation;
use App\Room;
use App\RoomType;
use App\RoomStatus;
use App\RoomStatusColor;
use App\HousekeepingStatus;
use App\reservation;
use App\Mail\prueba;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{


public function getMail(){
    $data = ['name' => 'yordy'];
    Mail::to('serforin@gmail.com')->send(new prueba($data));
    
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $reques)
    {



        $reservations = Reservation::all();
        $countries = Country::all();

        return view('pages.reservation.index', compact('reservations', 'countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.reservation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'fecha_entrda' => 'required',
            'fecha_salida' => 'required'

        ]);

        reservation::create($request->all());

        return redirect()->route('pages.reservation.index')->with('success', 'Reservation create success.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(reservation $reservation)
    {
        return view('pages.reservation.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(reservation $reservation)
    {
        return view('reservation.edit', compact('reservation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, reservation $reservation)
    {
        $request->validate([

            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'fecha_entrda' => 'required',
            'fecha_salida' => 'required'

        ]);

        $reservation->update($request->all());

        return redirect()->route('reservation.index')->with('success', 'Reservation update successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(reservation $reservation)
    {
        $reservation->delete()();
        return redirect()->route('reservation.index')->with('success', 'Project deleted successfully');
    }
}
