<?php

namespace App\Http\Controllers;

use App\TaxApplied;
use Illuminate\Http\Request;

class TaxAppliedController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $accountCodes = TaxApplied::where('tax_type_id', '=', $request->tax_type_id)->get();

            return response()->json($accountCodes, 200);
        }
    }
}
