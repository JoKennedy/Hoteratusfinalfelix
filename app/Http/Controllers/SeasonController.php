<?php

namespace App\Http\Controllers;

use App\Season;
use App\SeasonAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class SeasonController extends Controller
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
            $season = Season::with('season_attribute')->where('hotel_id', '=',  $hotel_id)

            ->orderby('start', 'asc');
            if ($request->active != '') {
                $season->where('active',  $request->active);
            }

            return datatables()->of($season)
                ->addColumn('btn', 'pages.season.actions')
                ->addColumn('seasonattribute', function(Season $season){
                    return $season->season_attribute->name;
                })
                ->addColumn('startdate', function (Season $season) {
                    return date('d/m/Y',strtotime($season->start));
                })
                ->addColumn('enddate', function (Season $season) {
                    return date('d/m/Y', strtotime($season->end));
                })
                ->addColumn('duration', function (Season $season) {
                    return $season->duration();
                })
                ->addColumn('delete', 'pages.season.status')
                ->rawColumns(['seasonattribute', 'startdate', 'enddate',  'duration', 'btn', 'delete',])
                ->make();
        } else {

            return view('pages.season.index');
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
        $seasonAttribute = SeasonAttribute::where('hotel_id', $hotel_id)->get();

        return view('pages.season.create', compact('seasonAttribute'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $start = $this->formatDate($request->start);
        $end =  $this->formatDate($request->end);
        $hotel_id = $request->session()->get('hotel_id');
        $request->validate([
            'name' => 'required',
            'season_attribute_id' => 'required',
            'start' => 'required|date_format:d/m/Y',
            'end' => 'required|date_format:d/m/Y|after:start',
        ]);

        $valStart = Season::whereRaw(" ('$start' between seasons.start and seasons.end
        or '$end' between seasons.start and seasons.end  ) and hotel_id = $hotel_id")->count();

        if($valStart > 0){

            $season = $request->all();
            $hotel_id = $request->session()->get('hotel_id');
            $seasonAttribute = SeasonAttribute::where('hotel_id', $hotel_id)->get();
            $message_error =  'The specified season cannot be added as the dates overlap the existing season.';
            return view('pages.season.create', compact('seasonAttribute', 'season', 'message_error' ));
        }


        $season = Season::create([
            'hotel_id' =>  $hotel_id,
            'name' => $request->name,
            'start' => $start,
            'end' => $end,
            'season_attribute_id' => $request->season_attribute_id
        ]);

       return redirect('admin-season')->with('message_success', 'Season was created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function show(Season $season)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,  $id)
    {
        $season = Season::findOrFail($id);

        $hotel_id = $request->session()->get('hotel_id');

        if ( ($season->hotel_id??'') != $hotel_id  ){
            return   redirect('admin-season')->with('message_success', "You do not have access through this hotel");
        }
        $season['start'] = date('d/m/Y', strtotime($season['start']));
        $season['end'] = date('d/m/Y', strtotime($season['end']));
        $seasonAttribute = SeasonAttribute::where('hotel_id', $hotel_id)->get();
        return view('pages.season.update', compact('seasonAttribute', 'season'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {


        $season = Season::findOrFail($id);
        $hotel_id = $request->session()->get('hotel_id');
        $request->validate([
            'name' => 'required',
            'season_attribute_id' => 'required',
            'start' => 'required|date_format:d/m/Y',
            'end' => 'required|date_format:d/m/Y|after:start',
        ]);

        $start = $this->formatDate($request->start);
        $end =  $this->formatDate($request->end);

        $valStart = Season::whereRaw(" ('$start' between seasons.start and seasons.end
        or '$end' between seasons.start and seasons.end  ) and hotel_id = $hotel_id and id != $id ")->count();

        if ($valStart > 0) {

            $season->name = $request->name;
            $season->start = $request->start;
            $season->end = $request->end;
            $season->season_attribute_id = $request->season_attribute_id;
            $hotel_id = $request->session()->get('hotel_id');
            $seasonAttribute = SeasonAttribute::where('hotel_id', $hotel_id)->get();
            $message_error =  'The specified season cannot be added as the dates overlap the existing season.';
            return view('pages.season.update', compact('seasonAttribute', 'season', 'message_error'));
        }


        if (($season->hotel_id ?? '') != $hotel_id) {
            return   redirect('admin-season')->with('message_success', "You do not have access through this hotel");
        }

         $season->update([
            'name' => $request->name,
            'start' => $start,
            'end' => $end,
            'season_attribute_id' => $request->season_attribute_id
        ]);


        return redirect('admin-season')->with('message_success', "Season [$season->name] has been updated");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $season = Season::findOrFail($id);
        $season->active =  ($season->active ? 0 : 1);
        $season->save();
        return response()->json($season);
    }
    private function formatDate(string $date){
        return substr($date, 6, 4).'-'.substr($date, 3, 2) . '-'. substr($date, 0, 2) ;
    }
}
