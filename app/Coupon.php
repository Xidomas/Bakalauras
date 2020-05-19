<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';
    public static function findByCode($code){
        return self::where('code', $code)->first();
    }

    public function discount($total){
        if($this -> type == 'fixed'){
            return $this -> amount_off;
        }
        elseif ($this -> type == 'percent'){
            return round(($this -> percent_off / 100) * $total);  
        }
        else{
            return 0;
        }
    }
}