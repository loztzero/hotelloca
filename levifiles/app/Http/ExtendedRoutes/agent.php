<?php

Route::group(['prefix' => 'agent', 'middleware' => 'role:Agent'], function() {
	Route::controller('profile', 'Agent\ProfileController');
	Route::controller('hotel', 'Agent\HotelController');
	Route::controller('booking', 'Agent\BookingController');
	//Route::controller('profile', 'Agent\ProfileController');

});

?>