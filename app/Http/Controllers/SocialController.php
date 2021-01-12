<?php

namespace App\Http\Controllers;

use App\Social;
use App\User;
use App\UserManager;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;


class SocialController extends Controller
{
    public function getSocialRedirect($provider)
    {

        $providerKey = Config::get('services.' . $provider);

        if (empty($providerKey)) {
            return response()->error('invalid_social_provider', 404);
        }

        return Socialite::driver($provider)->redirect();
    }

    public function getSocialHandle(Request $request, $provider)
    {

        if ($request->has('code')) {
            $providerUser = Socialite::driver($provider)->user();

        } else {
            //return response()->error('social_access_denied', 401);
            return  redirect( route('hotel.dashboard') )->with(['message' => 'Acceso denegado']) ;
        }

        $account = Social::whereProvider($provider)
                        ->whereProviderUserId($providerUser->id)
                        ->first();
        if ($account) {

            $user = $account->user;
        } else {
            $account = new Social([
                'provider_user_id' => $providerUser->id,
                'provider'         => $provider
            ]);


            $user = User::firstOrCreate([
                'email' => $providerUser->email,
            ], [
                'role'   => 'user',
                'firstname' => $providerUser->name,
                'lastname' => '',
                'username'   =>  $providerUser->email ,
                'password' => bcrypt($providerUser->email),
                'email_verified_at' => date('Y-m-d H:i:s'),
                'avatar' => $providerUser->avatar,
                'active' => true,
            ])->company()->create([
                'name' => ''
            ]);
            $user->billing_address()->create([]);
            $user->billing_contact()->create([]);
            // para relaciones "belongTo" o "oneToMany" inversa
            $account->user()->associate($user)->where('provider','facebook')->first();
            $account->save();
        }
        try
        {

            Auth::login($user, true);

            $user->avatar = $account->avatar;

            return  redirect( route('hotel.dashboard') ) ;

        } catch (Exception $e) {
            return response()->error('error_on_login_user', $e->getStatusCode());
        }
    }
}
