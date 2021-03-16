<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'orders';

    /**
     * The attributes to be fillable from the model.
     *
     * A dirty hack to allow fields to be fillable by calling empty fillable array
     *
     * @var array
     */

    protected $fillable = [];
    protected $guarded = ['id'];

    /**
     * this function will add all user order into order tabel
     */
    public function checkOutOrder($orderData)
    {
        return Order::insert($orderData);

    }

}
