<?php

//route khusus untuk user hotel
Route::group(['prefix' => 'admin', 'middleware' => 'role:Admin'], function() {
	Route::get('/', function()
	{
	    return redirect('admin/profile');
	});
	Route::controller('profile', 'Admin\ProfileController');
	Route::controller('booking', 'Admin\BookingController');
	Route::controller('hotel', 'Admin\HotelController');
	Route::controller('rate', 'Admin\RateController');
	Route::controller('agent', 'Admin\AgentController');
	Route::controller('agent-deposit', 'Admin\AgentDepositController');
	Route::controller('agent-payment-statement', 'Admin\AgentPaymentStatementController');
	Route::controller('report-booking', 'Admin\ReportBookingController');
	Route::controller('agent-booking', 'Admin\AgentBookingController');
	Route::controller('hotel-vs-user', 'Admin\HotelVsUserController');
	Route::controller('display-confirmation-payment', 'Admin\DisplayConfirmationPaymentController');
	Route::controller('notification', 'Admin\NotificationController');
});

?>
