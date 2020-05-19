<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rentOffer extends Model
{
    protected $table = 'rent_offers';
    public function categories()
    {
        return $this->belongsTo('App\Category');
    }

    public function towns()
    {
        return $this->belongsTo('App\Town');
    }

    public function vendors()
    {
        return $this->belongsTo('App\Vendor');
    }

    protected $fillable = ['name','slug','year','category_id','details','price','description','town_id','featured','quantity','vendor_id'];
}