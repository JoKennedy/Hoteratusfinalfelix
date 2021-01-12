<?php

namespace App\Http\Middleware;

use Closure;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        \Menu::make('MyNavBar', function($menu){
            $menu->add('Home');
            $menu->add('Dashboard',"dashboard");
            $menu->add('Hotel', "hotel-manager");
            $menu->add('Amenities', "amenities");
            $menu->add('Blocks', "blocks");
            $menu->add('Floors', "floors");
            $menu->add('Rooms', "rooms");
            $menu->add('Phone Extensions', "phone-extensions");
            $menu->add('Product', "products");
            $menu->add('Product Price', "posproduct/current_price");


        });
        return $next($request);
    }
}
