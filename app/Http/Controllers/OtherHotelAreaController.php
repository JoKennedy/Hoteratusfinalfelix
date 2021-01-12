<?php

namespace App\Http\Controllers;

use App\Block;
use App\Floor;
use App\OtherHotelArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OtherHotelAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $hotel_id = $request->session()->get('hotel_id');
        if ($request->ajax()) {

            $otherHotelArea = OtherHotelArea::with('block', 'floor')->where('hotel_id', '=', $hotel_id);

            if ($request->block_id) {
                $otherHotelArea->where('block_id',  $request->block_id);
            }
            if ($request->floor_id) {
                $otherHotelArea->where('floor_id',  $request->floor_id);
            }
            if ($request->active != '') {
                $otherHotelArea->where('active',  $request->active);
            }
            return datatables()->of($otherHotelArea)
                ->addColumn('btn', 'pages.otherhotelarea.actions')

                ->addColumn('floor', function (OtherHotelArea $otherHotelArea) {
                    return $otherHotelArea->floor->name ?? '';
                })
                ->addColumn('block',  function (OtherHotelArea $otherHotelArea) {
                    return $otherHotelArea->block->name ?? '';
                })
                ->addColumn('status', 'pages.otherhotelarea.status')
                ->rawColumns(['btn', 'status'])
                ->make();
        } else {

            $floors = Floor::where('hotel_id', '=',  $hotel_id)->where('active', '1')
                ->orderBy('name', 'asc')->get();
            $blocks = Block::where('hotel_id', '=',  $hotel_id)->where('active', '1')
                ->orderBy('name', 'asc')->get();

            return view('pages.otherhotelarea.index', compact( 'floors', 'blocks'));
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

        $floors = Floor::where('hotel_id', '=',  $hotel_id)->where('active', '1')
            ->orderBy('name', 'asc')->get();
        $blocks = Block::where('hotel_id', '=',  $hotel_id)->where('active', '1')
            ->orderBy('name', 'asc')->get();
        return view('pages.otherhotelarea.create', compact('floors', 'blocks'));
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

        // dd($request->all());
        $request->validate([
            'name' => ['required', Rule::unique('other_hotel_areas')->where(function ($query) use ($request, $hotel_id) {
                return $query->where('name', $request->name)->where('hotel_id', $hotel_id);
            })],
            'description' => 'required'
        ]);

        $room = OtherHotelArea::create(['hotel_id' => $hotel_id] + $request->all());

        return redirect('other-hotel-area')->with('message_success', 'New Area has been created!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OtherHotelArea  $otherHotelArea
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, OtherHotelArea $otherHotelArea)
    {
        $hotel_id = $request->session()->get('hotel_id');

        $floors = Floor::where('hotel_id', '=',  $hotel_id)->where('active', '1')
            ->orderBy('name', 'asc')->get();
        $blocks = Block::where('hotel_id', '=',  $hotel_id)->where('active', '1')
            ->orderBy('name', 'asc')->get();


        return view('pages.otherhotelarea.show', compact('floors', 'blocks', 'otherHotelArea'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OtherHotelArea  $otherHotelArea
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, OtherHotelArea $otherHotelArea)
    {
        $hotel_id = $request->session()->get('hotel_id');

        $floors = Floor::where('hotel_id', '=',  $hotel_id)->where('active', '1')
            ->orderBy('name', 'asc')->get();
        $blocks = Block::where('hotel_id', '=',  $hotel_id)->where('active', '1')
            ->orderBy('name', 'asc')->get();


        return view('pages.otherhotelarea.update', compact('floors', 'blocks', 'otherHotelArea'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OtherHotelArea  $otherHotelArea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OtherHotelArea $otherHotelArea)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $request->validate([
            'name' => ['required', Rule::unique('other_hotel_areas')->where(function ($query) use ($request, $hotel_id, $otherHotelArea) {
                return $query->where('name', $request->name)->where('hotel_id', $hotel_id)->where('id','!=', $otherHotelArea->id);
            })],
            'description' => 'required'
        ]);

        $otherHotelArea->update($request->all());

        return redirect('other-hotel-area')->with('message_success', "Area [$otherHotelArea->name] has been updated!!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OtherHotelArea  $otherHotelArea
     * @return \Illuminate\Http\Response
     */
    public function destroy(OtherHotelArea $otherHotelArea)
    {
        $otherHotelArea->active = $otherHotelArea->active == 1? 0:1;

        $otherHotelArea->save();

        return response()->json($otherHotelArea, 200);
    }
}
