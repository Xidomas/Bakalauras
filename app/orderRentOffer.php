<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orderRentOffer extends Model
{
    protected $table = 'order_rent_offer';
    protected $fillable = ['order_id', 'rent_offer_id', 'quantity', 'days'];
}
