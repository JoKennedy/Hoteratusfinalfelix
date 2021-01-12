<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


/// COntrolador para rutas publicas
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('public.home');
    }
    public function about(){
        return view('public.about');
    }
    public function terms_of_service(){
        return view('public.termsOfService');
    }
    public function privacy_policy(){
        return view('public.privacyPolicy');
    }
    public function userLock(Request $request){


      //  dd($request->session()->get('lock'));
        return view('auth.user-lock-screen', [
            'lock' => $request->session()->get('lock')
        ]);
    }
}
