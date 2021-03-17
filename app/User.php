<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    /**
     * this function is defining many to many relationship with prodcut tabel
     * so that we can grab all the product which user has purchased
     */
    public function order()
    {
        return $this->belongsToMany('App\Product', 'orders')->withPivot('purchased_quantity', 'paid_amount');
    }

    /**
     * get all the user info with his order to show on admin side
     */
    public function getUserWithOrder()
    {
        return User::whereHas('order')->with('order:id,product_name')->get()->toArray();
    }
}
