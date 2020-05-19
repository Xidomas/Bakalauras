<?php

use App\Town;
use App\Vendor;
use Carbon\Carbon;

function presentPrice($price)
{
    return '€ '.number_format($price / 100, 2);
}

function setActiveCategory($category, $output = 'active'){

    return request()->category == $category ? $output : '';
}

function setActiveTown($town, $output = 'active'){

    return request()->town == $town ? $output : '';
}

function rentOfferImage($path){

    if($path == '')
        return asset('img/not-found.png');
    else
        return asset('/storage/'.$path);
}

function newsImage($path){

    if($path == '')
		return asset('img/not-found.png');
	else
		return asset('/storage/'.$path);
}

function vendorName($vendor)
{
    $vendors = Vendor::all();
    $vendorName = $vendors -> where ('id', $vendor)->first()->name;
    return $vendorName;
}

function vendorEmail($vendor)
{
    $vendors = Vendor::all();
    $vendorEmail = $vendors -> where ('id', $vendor)->first()->email;
    return $vendorEmail;
}

function townName($town)
{
    $towns = Town::all();
    $townName = $towns -> where ('id', $town)->first()->name;
    return $townName;
}

function presentDate($date)
{
    return Carbon::parse($date)->format('M d, Y');
}