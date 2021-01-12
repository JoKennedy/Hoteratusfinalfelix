<?php

namespace App\Http\Controllers;

use App\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AmenityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $hotel_id = $request->session()->get('hotel_id');
            $amenities = Amenity::where('hotel_id', '=', $hotel_id);
            if($request->active != ''){
                $amenities->where('active',  $request->active);
            }


            return datatables()->of($amenities)->make();
        } else {

            return view('pages.amenity.index');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.amenity.create');
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
       $amenity = Amenity::create(["hotel_id" => $hotel_id] + $request->all());

        if($request->file('image')){

            foreach ($request->file('image') as $key => $value) {
                $amenity->images()->create([
                    'url' => $value->store('amenities', 'public')
                ]);
            }
        }

        return redirect(route('amenities.index'))->with('message_success', 'Amenity was created successfully');
    }

    public function show(Amenity $amenity)
    {
        return view('pages.amenity.show',  compact('amenity'));
    }

    public function edit(Amenity $amenity)
    {

        return view('pages.amenity.update',  compact('amenity'));
    }


    public function update(Request $request, Amenity $amenity)
    {
        $amenity->update( $request->all());

        if ($request->file('image')) {

            foreach ($request->file('image') as $key => $value) {
                $amenity->images()->create([
                    'url' => $value->store('amenities', 'public')
                ]);
            }
        }

        return back()->with('message_success', 'Amenity has been updated');
    }


}
