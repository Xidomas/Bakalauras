<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendor';
    public function rentOffers(){
        return $this->hasMany('App\rentOffer');
    }
}