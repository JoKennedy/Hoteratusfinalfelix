<?php

namespace App\Http\Controllers;

use App\Block;
use App\Floor;
use App\Room;
use App\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request )
    {

        $hotel_id = $request->session()->get('hotel_id');
        if ($request->ajax()) {

            $rooms = Room::with('block', 'room_type', 'floor')->where('rooms.hotel_id', '=', $hotel_id);
            if ($request->room_type_id) {
                $rooms->where('rooms.room_type_id',  $request->room_type_id);
            }
            if ($request->block_id) {
                $rooms->where('rooms.block_id',  $request->block_id);
            }
            if ($request->floor_id) {
                $rooms->where('rooms.floor_id',  $request->floor_id);
            }
            if ($request->active !='') {
                $rooms->where('rooms.active',  $request->active);
            }
            return datatables()->of($rooms)
                ->addColumn('btn', 'pages.room.actions')

                ->addColumn('roomtype', function (Room $room){
                    return $room->room_type->name ;
                })
                ->addColumn('floor', function (Room $room){
                    return $room->floor->name?? '' ;
                })
                ->addColumn('block',  function (Room $room){
                    return $room->block->name??'' ;
                })
                ->addColumn('status', 'pages.room.status')
                ->rawColumns([ 'btn', 'status'])
                ->make();
        } else {
            $roomtypes = RoomType::where('hotel_id', '=',  $hotel_id)->where('active', '1')
                ->orderBy('name', 'asc')->get();
            $floors = Floor::where('hotel_id', '=',  $hotel_id)->where('active', '1')
                ->orderBy('name', 'asc')->get();
            $blocks = Block::where('hotel_id', '=',  $hotel_id)->where('active', '1')
                ->orderBy('name', 'asc')->get();
            $room = $request->all();

            return view('pages.room.index', compact('roomtypes', 'floors', 'blocks', 'room'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $hotel_id = $request->session()->get('hotel_id');
        $roomtypes = RoomType::where('hotel_id', '=', $hotel_id)->where('active','1')
        ->orderBy('name', 'asc')->get();
        $floors = Floor::where('hotel_id', '=', $hotel_id)->where('active', '1')
            ->orderBy('name', 'asc')->get();
        $blocks = Block::where('hotel_id', '=', $hotel_id)->where('active', '1')
            ->orderBy('name', 'asc')->get();
        $room = $request->all();
        return view('pages.room.create', compact('roomtypes','floors','blocks','room'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $hotel_id = $request->session()->get('hotel_id');
        //dd($request->all());
        $request->validate([
            'name' => ['required', Rule::unique('rooms')->where(function ($query) use ($request, $hotel_id) {
                return $query->where('name', $request->name)->where('hotel_id', $hotel_id);
            })],
            'code' => ['required', Rule::unique('rooms')->where(function ($query) use ($request, $hotel_id) {
                return $query->where('code', $request->code)->where('hotel_id', $hotel_id);
            })],
            'room_type_id' => 'required',
        ]);

        $room = Room::create(['hotel_id'=> $hotel_id] + $request->all());

        if ($request->return){
            $roomtypes = RoomType::where('hotel_id', '=',  $hotel_id)->where('active', '1')
                ->orderBy('name', 'asc')->get();
            $floors = Floor::where('hotel_id', '=',  $hotel_id)->where('active', '1')
                ->orderBy('name', 'asc')->get();
            $blocks = Block::where('hotel_id', '=',  $hotel_id)->where('active', '1')
                ->orderBy('name', 'asc')->get();
            return view('pages.room.create', compact('roomtypes', 'floors', 'blocks', 'room'))->with('message_success', "Room [$room->name] was created");
        }else{
            return redirect('rooms')->with('message_success', "Room [$room->name] was created");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , Room $room)
    {
        $hotel_id = $request->session()->get('hotel_id');

        $roomtypes = RoomType::where('hotel_id', '=',  $hotel_id )->where('active', '1')
            ->orderBy('name', 'asc')->get();
        $floors = Floor::where('hotel_id', '=',  $hotel_id )->where('active', '1')
            ->orderBy('name', 'asc')->get();
        $blocks = Block::where('hotel_id', '=',  $hotel_id )->where('active', '1')
            ->orderBy('name', 'asc')->get();

        return view('pages.room.show', compact('roomtypes', 'floors', 'blocks', 'room'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Room $room)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $roomtypes = RoomType::where('hotel_id', '=', $hotel_id)->where('active', '1')
            ->orderBy('name', 'asc')->get();
        $floors = Floor::where('hotel_id', '=', $hotel_id)->where('active', '1')
            ->orderBy('name', 'asc')->get();
        $blocks = Block::where('hotel_id', '=', $hotel_id)->where('active', '1')
            ->orderBy('name', 'asc')->get();

        return view('pages.room.update', compact('roomtypes', 'floors', 'blocks', 'room'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $hotel_id = $request->session()->get('hotel_id');
        // dd($request->all());
        $request->validate([
            'name' => ['required', Rule::unique('rooms')->where(function ($query) use ($request, $hotel_id,  $room) {
                return $query->where('name', $request->name)->where('hotel_id', $hotel_id)->where('id','!=',$room->id);
            })],
            'code' => ['required', Rule::unique('rooms')->where(function ($query) use ($request, $hotel_id,  $room) {
                return $query->where('code', $request->code)->where('hotel_id', $hotel_id)->where('id', '!=', $room->id);
            })],
            'room_type_id' => 'required',
        ]);

        $room->update($request->all());
        $roomtypes = RoomType::where('hotel_id', '=',  $hotel_id)->where('active', '1')
            ->orderBy('name', 'asc')->get();
        $floors = Floor::where('hotel_id', '=',  $hotel_id)->where('active', '1')
            ->orderBy('name', 'asc')->get();
        $blocks = Block::where('hotel_id', '=',  $hotel_id)->where('active', '1')
            ->orderBy('name', 'asc')->get();
        if ($request->return) {
            return view('pages.room.create', compact('roomtypes', 'floors', 'blocks', 'room'))->with('message_success', "Room [$room->name] has been updated");
        } else {
            return view('pages.room.update', compact('roomtypes', 'floors', 'blocks', 'room'))->with('message_success', "Room [$room->name] has been updated");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $room->active = $room->active == 1? 0:1;
        $room->save();

        return response()->json($room, 200);
    }
}
