<?php

namespace App\Http\Controllers;

use App\MeasurementUnit;
use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductController extends Controller
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
            $product = Product::with('product_subcategory', 'product_subcategory.product_category')->where('hotel_id', $hotel_id);
            if ($request->active != '') {
                $product->where('active',  $request->active);
            }
            if($request->product_subcategory_id != ''){
                $product->where('product_subcategory_id',  $request->product_subcategory_id);
            }

            return datatables()->of($product)
                ->addColumn('btn', 'pages.product.actions')
                ->addColumn('status', 'pages.product.status')
                ->addColumn('category', function (Product $product) {
                    return $product->product_subcategory->product_category->name;
                })
                ->addColumn('subcategory', function (Product $product){
                    return $product->product_subcategory->name;
                })
                ->rawColumns(['btn', 'status', 'price', 'subcategory', 'category'])
                ->make();
        } else {
            $product_subcategory_id = $request->product_subcategory_id;
            return view('pages.product.index', compact('product_subcategory_id'));
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
        $categories = ProductCategory::where('hotel_id', $hotel_id)->where('active',1)->get();
        $measurementUnits = MeasurementUnit::where('hotel_id', $hotel_id)->where('active' , 1)->get();
        return view('pages.product.create',compact('categories', 'measurementUnits'));
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
        $request->validate([
            'name' => ['required', Rule::unique('products')->where(function ($query) use ($request, $hotel_id) {
                return $query->where('name', $request->name)->where('hotel_id', $hotel_id);
            })],
            'description' => 'required',
            'code' => 'required',
            'product_subcategory_id' => 'required',

        ]);

        $user = Auth::user();
        $product = Product::create(['user_id' => $user->id, "hotel_id" => $hotel_id]+$request->all());
        if ($request->file('image')) {

            foreach ($request->file('image') as $key => $value) {
                $product->images()->create([
                    'url' => $value->store('product', 'public'),
                    'caption' => $request->imagename[$key]
                ]);
            }
        }

        return redirect(route('products.index'))
        ->with('message_success', "Product [$product->name] has been created successfully");
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Product $product)
    {

        $hotel_id = $request->session()->get('hotel_id');
        $categories = ProductCategory::where('hotel_id', $hotel_id)->where('active', 1)->get();
        $measurementUnits = MeasurementUnit::where('hotel_id', $hotel_id)->where('active', 1)->get();
        return view('pages.product.update', compact('categories','product', 'measurementUnits' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $request->validate([
            'name' => ['required', Rule::unique('products')->where(function ($query) use ($request, $hotel_id, $product) {
                return $query->where('name', $request->name)->where('hotel_id', $hotel_id)->where('id', '!=', $product->id);
            })],
            'description' => 'required',
            'code' => 'required',
            'product_subcategory_id' => 'required',

        ]);

        $user = Auth::user();
        $product->update(['user_id' => $user->id] + $request->all());

        if ($request->file('image')) {

            foreach ($request->file('image') as $key => $value) {
                $product->images()->create([
                    'url' => $value->store('product', 'public'),
                    'caption' => $request->imagename[$key]
                ]);
            }
        }

        return redirect(route('products.index'))
        ->with('message_success', "Product [$product->name] has been update successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

        $product->active =  ($product->active ? 0 : 1);
        $product->save();
        return response()->json($product);
    }
}
