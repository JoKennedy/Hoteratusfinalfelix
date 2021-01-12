<?php

namespace App\Http\Controllers;

use App\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlockController extends Controller
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

            $blocks = Block::withCount(['rooms'])->where('hotel_id', '=', $hotel_id);
            if ($request->active != '') {
                $blocks->where('active',  $request->active);
            }

            return datatables()->of($blocks)
            ->addColumn('btn', 'pages.block.actions')
            ->addColumn('btnrooms', 'pages.block.rooms')
            ->addColumn('status', 'pages.block.status')
            ->rawColumns(['btnrooms', 'btn', 'status'])
            ->make();
        } else {

            return view('pages.block.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.block.create');
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
        $block = Block::create(["hotel_id" => $hotel_id] + $request->all());

        return redirect(route('blocks.index'))->with('message_success', 'Block was created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function show(Block $block)
    {
        return view('pages.block.show', compact('block'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function edit(Block $block)
    {
        return view('pages.block.update', compact('block'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Block $block)
    {
        $block->update($request->all());

        return back()->with('message_success', "Block [$request->name] has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function destroy(Block $block)
    {
        $block->active =  ($block->active ? 0 : 1);
        $block->save();
        return response()->json($block);
    }

}
