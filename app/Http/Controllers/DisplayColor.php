<?php

namespace App\Http\Controllers;

use App\AlphabetCoding;
use App\Color;
use App\Hotel;
use App\HousekeepingStatus;
use App\RoomStatus;
use App\RoomStatusColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisplayColor extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $roomStatus = RoomStatus::all();
        $housekeepingStatus = HousekeepingStatus::all();
        $alphabetCoding = AlphabetCoding::all();
        $colorReserva = $roomStatus->where('id',1)->first()->hotel_room_status_color($hotel_id)->color??'';
        return view('pages.displaycolor.index', compact('roomStatus', 'housekeepingStatus', 'alphabetCoding', 'hotel_id', 'colorReserva'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $roomStatus = RoomStatus::all();
        $housekeepingStatus = HousekeepingStatus::all();
        $hotel_id = $request->session()->get('hotel_id');
        $alphabetCoding = AlphabetCoding::all();
        foreach ($roomStatus  as $key => $status) {

            $status->room_status_color()->updateOrCreate(['hotel_id'=> $hotel_id], ['color'=> $request->roomStatus[$status->id]]);
        }
        foreach ($housekeepingStatus  as $key => $status) {

            $status->housekeeping_status_color()->updateOrCreate(['hotel_id' => $hotel_id], ['color' => $request->housekeeping[$status->id]]);
        }
        foreach ($alphabetCoding  as $key => $status) {
            if($status->id ==6) continue;
            $status->alphabet_coding_hotels()->updateOrCreate(['hotel_id' => $hotel_id], ['code' => $request->alpha[$status->id]]);
        }

        return redirect('display-color')->with('message_success', 'All Colors have been updated');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
