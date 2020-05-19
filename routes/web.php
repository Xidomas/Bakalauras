<?php

Route::get('/', 'LandingPageController@index') -> name('landingPage');

/////////////////////////////////////////////////////////////////////

Route::get('/news', function () { $news = App\Post::orderBy('created_at', 'desc')->get(); return view('news', compact('news')); }) -> name('news.index');
Route::get('/news/{slug}', function($slug){ $post = App\Post::where('slug', '=', $slug) -> firstOrFail(); return view('post', compact('post')); }) -> name('newsPost.index');

/////////////////////////////////////////////////////////////////////

Route::get('/rentOfferList', 'RentOfferListController@index') -> name('rentOfferList.index');
Route::get('/rentOfferList/{rentOffer}', 'RentOfferListController@show') -> name('rentOfferList.show');

/////////////////////////////////////////////////////////////////////

Route::view('/faq', 'faq') -> name('faq.index');

/////////////////////////////////////////////////////////////////////

Route::view('/rules', 'rules') -> name('rules.index');

/////////////////////////////////////////////////////////////////////

Route::get('/tracks', function () { $tracks = App\Track::all(); return view('tracks', compact('tracks')); }) -> name('tracks.index');

/////////////////////////////////////////////////////////////////////

Route::view('/contacts', 'contacts') -> name('contacts.index');

/////////////////////////////////////////////////////////////////////

Route::get('/home', 'HomeController@index') -> name('home');

/////////////////////////////////////////////////////////////////////

Route::get('/cart', 'CartController@index') -> name('cart.index');
Route::post('/cart', 'CartController@store') -> name('cart.store');
Route::delete('/cart/{rentOffer}', 'CartController@destroy') -> name('cart.destroy');
Route::patch('/cart/q/{rentOffer}', 'CartController@updateq') -> name('cart.updateq');
Route::patch('/cart/d/{rentOffer}', 'CartController@updated') -> name('cart.updated');
Route::post('/cart/saveForLater/{rentOffer}', 'CartController@saveForLater') -> name('cart.saveForLater');
Route::delete('/cart/saveForLater/{rentOffer}', 'SaveForLaterController@destroy') -> name('saveForLater.destroy');
Route::post('/cart/saveForLater/switchToCart/{rentOffer}', 'SaveForLaterController@switchToCart') -> name('saveForLater.switchToCart');

/////////////////////////////////////////////////////////////////////

Route::get('/checkout', 'CheckoutController@index') -> name ('checkout.index') -> middleware('auth');
Route::post('/checkout', 'CheckoutController@store') -> name ('checkout.store');
Route::get('/guestCheckout', 'CheckoutController@index')-> name('guestCheckout.index');
Route::post('/paypal-checkout', 'CheckoutController@paypalCheckout')->name('checkout.paypal');

/////////////////////////////////////////////////////////////////////

Route::post('/coupon', 'CouponsController@store') -> name('coupon.store');
Route::delete('/coupon', 'CouponsController@destroy') -> name('coupon.destroy');

/////////////////////////////////////////////////////////////////////

Route::get('/thankyou', 'ConfirmationController@index') -> name ('confirmation.index');

/////////////////////////////////////////////////////////////////////

Route::get('/vendorUpdate', 'VendorUpdateController@index') -> name ('vendorUpdate.index');

/////////////////////////////////////////////////////////////////////

Route::middleware('auth') -> group(function () {
    Route::get('/my-profile', 'UsersController@edit') -> name('users.edit');
    Route::patch('/my-profile', 'UsersController@update') -> name('users.update');
    Route::get('/my-orders', 'UserOrdersController@index') -> name('orders.index');
    Route::get('/my-orders/{order}', 'UserOrdersController@show') -> name('orders.show');
});

/////////////////////////////////////////////////////////////////////

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('/vendor/voyager/importRentOffer', 'ImportController@importRentOffer') -> name ('importRentOffer') -> middleware('admin.user');
    Route::post('/vendor/voyager/importRentOffer', 'ImportController@handleImportRentOffer') -> name ('bulk-importRentOffer') -> middleware('admin.user');
});

/////////////////////////////////////////////////////////////////////

Auth::routes();

/////////////////////////////////////////////////////////////////////