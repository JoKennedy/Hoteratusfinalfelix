<?php

namespace App;
use Laravel\Passport\HasApiTokens;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Junges\ACL\Traits\UsersTrait;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable,UsersTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'firstname', 'lastname', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // obtener nombre completo
    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }
    // Relacion con redes sociales
    public function socials()
    {
        return $this->hasMany(Social::class);
    }
    public function company()
    {
        return $this->hasOne('App\Company', 'owner_id');
    }
    public function user_menu()
    {
        $menu = json_encode(Menu::orderBy('order1', 'ASC')
            ->orderBy('order2', 'ASC')
            ->orderBy('order3', 'ASC')
            ->orderBy('order4', 'ASC')
            ->get());

        return json_decode($menu);
    }
}
