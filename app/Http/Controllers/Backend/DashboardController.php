<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Menu;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index(){

      // $user = User::findOrFAil();

        return view('pages.dashboard.index');
    }
}
