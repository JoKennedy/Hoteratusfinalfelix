<?php

namespace App\Http\Controllers;

use App\Room;
use App\SortRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SortRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $rooms = Room::with('room_type')->where('hotel_id', $hotel_id)
            ->orderBy('room_type_id')
            ->orderBy('sort_order')
            ->orderBy('name')->get();

        return view('pages.sortroom.index', compact('rooms'));
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

        if($request->sort){
            foreach ($request->sort as $key => $value) {
                $room = Room::find($key);
                $room->sort_order = $value;
                $room->save();
            }
        }
       return redirect('sort-rooms')->with('message_success', 'All Rooms have been updated!!');
    }


}
