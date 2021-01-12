<?php

namespace App\Http\Controllers;

use App\PosProduct;
use Illuminate\Http\Request;

class PosProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PosProduct  $posProduct
     * @return \Illuminate\Http\Response
     */
    public function show(PosProduct $posProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PosProduct  $posProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(PosProduct $posProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PosProduct  $posProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PosProduct $posProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PosProduct  $posProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(PosProduct $posProduct)
    {
        //
    }

    public function list(Request $request){

        $product = PosProduct::with('product', 'price_products')->where('pos_point_id', $request->pos_point_id)->get();
        return response()->json(['data'=> $product, 'success' => true], 200);
    }
    public function current_price(Request $request){

        $product = PosProduct::find($request->pos_product_id);
        $data = $product->current_price();
        return response()->json(['data' => $data, 'success' => true], 200);
    }
}
