<?php namespace App\Http\Controllers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash;
use App;
use App\User;
use App\Libraries\Helpers;
use DB;
use App\Models\Country;
use App\Models\City;
use App\Models\ConfirmationPayment;
class HotelAdminController extends Controller {

	public function getIndex(){
		return view('hoteladmin.hotel-admin-booking');
	}

}
