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

Route::get('/', function()
{
	//return view('layouts.underconstruction');

	if(Auth::check()){
		if(Auth::user()->role == 'Agent'){
			return redirect('agent/profile');
		} else if(Auth::user()->role == 'Admin'){
			return redirect('admin/profile');
		} else if(Auth::user()->role == 'Hotel'){
			return redirect('hotel/profile');
		}
	}


	//if from activated controller pass the error, the pass again from here
	//go AuthenticatesUsers->getLogout
    if(Session::has('error')){
        // print_r(Session::get('error'));
        // die();
        Session::flash('error', Session::get('error'));
    }
    
	return redirect('auth/login');
});


//khusus untuk register saja.. 
Route::group(['prefix' => 'register'], function() {
	Route::get('/', function()
	{
	    return redirect('main');
	});
	Route::controller('hotel', 'Register\HotelController');
});



//penjagaan untuk agent dan admin
// Route::controller('admin', 'AdminController');
require app_path('Http/ExtendedRoutes/admin.php');
$router->group(['middleware' => 'auth'], function() {

	require app_path('Http/ExtendedRoutes/agent.php');
	Route::group(['middleware' => 'role:Admin'], function() {
	});
	require app_path('Http/ExtendedRoutes/hotel.php');	
});
	

//OTHER SCRIPT HERE THE MAIN SCRIPT REVISION IS UPPER

Route::get('/gambar', function()
{
    $img = Image::make('http://localhost:8080/hotelloca/assets/img/promo.jpg')->resize(300, 200);
    return $img->response('jpg');
});

Route::get('hitung', function()
{
	echo (int) ((0.1 + 0.7) * 10);
});

Route::get('/password', function()
{
	return Hash::make('enter123');
});

Route::controller('generator', 'Generator\GeneratorController');
Route::controller('main', 'MainController');
Route::controller('register-hotel', 'RegisterHotelController');
Route::controller('hotel-grab', 'HotelGrabController');

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
