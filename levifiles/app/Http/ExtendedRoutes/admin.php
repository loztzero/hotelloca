<?php

//route khusus untuk user hotel
Route::group(['prefix' => 'admin'], function() {
	Route::get('/', function()
	{
	    return redirect('admin/profile');
	});
	Route::controller('profile', 'Admin\ProfileController');
	Route::controller('booking', 'Admin\BookingController');
	Route::controller('hotel', 'Admin\HotelController');
	Route::controller('rate', 'Admin\RateController');
	Route::controller('agent', 'Admin\AgentController');
});

?>