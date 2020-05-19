<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    public function rentOffers(){
        return $this->hasMany('App\rentOffer');
    }
}