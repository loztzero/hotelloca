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
Route::get('/gambar', function()
{
    $img = Image::make('http://localhost:8080/hotelloca/assets/img/promo.jpg')->resize(300, 200);
    return $img->response('jpg');
});

Route::get('hitung', function()
{
	echo (int) ((0.1 + 0.7) * 10);
});

Route::get('/', function()
{
	//return view('layouts.underconstruction');
	if(Auth::check()){
		if(Auth::user()->role == 'Agent'){
			return redirect('hotel-agent');
		} else if(Auth::user()->role == 'Admin'){
			return redirect('hotel-admin');
		} else if(Auth::user()->role == 'Hotel'){
			return redirect('hotel-owner');
		}
	}
	return redirect('main');
});

Route::get('/password', function()
{
	return Hash::make('enter123');
});

Route::controller('main', 'MainController');
Route::controller('register-hotel', 'RegisterHotelController');
Route::controller('hotel-grab', 'HotelGrabController');

//penjagaan untuk agent dan admin
Route::controller('hotel-admin', 'HotelAdminController');

$router->group(['middleware' => 'auth'], function() {

	Route::group(['middleware' => 'role:Agent'], function() {
		Route::controller('hotel-agent', 'HotelAgentController');
	});

	Route::group(['middleware' => 'role:Admin'], function() {
	});

	Route::group(['middleware' => 'role:Hotel'], function() {
		Route::controller('hotel-owner', 'HotelOwnerController');
	});

	// Route::group(['middleware' => 'role:Hotel'], function() {
	// 	Route::controller('hotel-admin', 'HotelAdminController');
	// });
	
});
	

Route::get('/password', function()
{
	return Hash::make('enter123');
});



/*Pure Routes Start Here*/
// Route::get('/', function()
// {
// 	return redirect('auth/login');
// });
Route::controller('api', 'ApiController');



Route::get('/facebook', 'FacebookController@facebook');
Route::get('/callback', 'FacebookController@callback');

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
