<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*Pure Routes Start Here*/
// Route::get('/', function()
// {
// 	return redirect('auth/login');
// });
Route::controller('api', 'ApiController');
Route::controller('hotel-agent', 'HotelAgentController');
Route::controller('main', 'MainController');


/*LOTS OF SAMPLE BELOW*/

Route::filter('auth', function($route, $request)
{
    // Login check (Default)
    if (Auth::guest()) return Redirect::guest('/main');

});

Route::group(array('before' => 'auth'), function(){
	Route::controller('user', 'UserController');
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


Route::controller('angular', 'AngularController');
Route::get('/bebek', function()
{
	return view('layouts.underconstruction');
});

$router->group(['middleware' => 'yolo'], function() {
	Route::get('/', function()
	{
		return view('layouts.underconstruction');
	});
});

Route::get('duck', function()
{
	echo Uuid::generate();
	
	$pdf = App::make('dompdf');
	$pdf->loadHTML('<h1>Test</h1>');
	return $pdf->stream();
});

Route::get('excel', function()
{
	 Excel::create('Laravel Excel', function($excel) {

	$excel->sheet('Excel sheet', function($sheet) {

		$sheet->setOrientation('landscape');

	});

})->export('xls'); 
});
