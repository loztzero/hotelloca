<?php

//route khusus untuk user hotel
Route::group(['prefix' => 'hotel', 'middleware' => 'role:Hotel'], function() {
	// Route::controller('hotel-owner', 'Hotel\HotelOwnerController');
	Route::controller('picture', 'Hotel\PictureController');
	Route::controller('profile', 'Hotel\ProfileController');
	Route::controller('room', 'Hotel\RoomController');
	Route::controller('room-rate', 'Hotel\RoomRateController');
	Route::controller('facility', 'Hotel\FacilityController');
	Route::controller('room-facility', 'Hotel\RoomFacilityController');
});

?>