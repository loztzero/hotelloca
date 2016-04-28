<?php

Route::group(['prefix' => 'agent', 'middleware' => 'role:Agent'], function() {
	Route::controller('profile', 'Agent\ProfileController');
	Route::controller('hotel', 'Agent\HotelController');
	Route::controller('booking', 'Agent\BookingController');
	Route::controller('request', 'Agent\RequestController');
	Route::controller('booking-history', 'Agent\BookingHistoryController');
	Route::controller('confirmation-payment', 'Agent\ConfirmationPaymentController');
	//Route::controller('profile', 'Agent\ProfileController');

});

?>
