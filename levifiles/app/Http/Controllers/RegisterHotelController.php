<?php namespace App\Http\Controllers;

use Illuminate\Routing\UrlGenerator;
use Input, Auth, Request, Session, Redirect, Hash, Form;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, StdClass;
use App\Models\Country;
class RegisterHotelController extends Controller {

	public function getIndex()
	{
		$indonesia = Country::where('country_name', '=', 'Indonesia')->first();
        $countries = Country::lists('country_name', 'id');
		return view('registerhotel.register-hotel')->with('countries', $countries)
        ->with('indonesia', $indonesia->id)
        ->with('form', new Form());
	}

}
