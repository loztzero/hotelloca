<?php namespace App\Http\Controllers\Register;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash, Form;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, StdClass, Config;
use App\Models\Country;
use App\Models\City;
use App\Models\Currency;
use App\Models\HotelDetail;
use App\Models\AreaLocation;
use App\Http\Controllers\Controller;
use App\Http\Traits\CityFromCountry;
class HotelController extends Controller {

	use CityFromCountry;

	public function getIndex()
	{
		$indonesia = Country::where('country_name', '=', 'Indonesia')->first();
        $countries = Country::where('country_name', '=', 'Indonesia')->lists('country_name', 'id');
        $currencies = Currency::where('curr_code', Config::get('enums.rupiah'))->lists('curr_code', 'id');
        $hotelTypes = Config::get('enums.hotelTypes');
		return view('register.hotel.register-hotel')
			->with('countries', $countries)
	        ->with('indonesia', $indonesia->id)
	        ->with('currencies', $currencies)
	        ->with('hotelTypes', $hotelTypes);
	}

	public function getSuccess(){
		return view('register.hotel.register-hotel-success');
	}

	public function postSave(Request $request){

    	$data = $request->all();

    	/*echo '<pre>';
    	print_r($data);
    	die();*/
		$hotelDetail = new HotelDetail();
		$errorBag = $hotelDetail->rules($request->all());

		DB::beginTransaction();

		try {

			if(count($errorBag) > 0){
				DB::rollback();

				Session::flash('error', $errorBag);
	   			return Redirect::to('register/hotel')->withInput(Input::all());
			} else {

				if(isset($data['email_login'])){
					$exists = User::where('email', '=', $data['email_login'])->first();
					if($exists){
						throw new \Exception($exists->email . ' on login area already registered, please choose another email');
					}
				}

				$userAccount = array();
				$userAccount['email'] = $data['email_login'];
				$password = Hash::make(uniqid());
				$userAccount['password'] = $password;
				$userAccount['repassword'] = $password;
				$user = new User();
				$errorUser = $user->rules($userAccount);
				if(count($errorUser) > 0){
					DB::rollback();

					Session::flash('error', $errorUser);
					return Redirect::to('register/hotel')->withInput(Input::all());
				} else {
					$userAccount['role'] = 'Hotel';
					$userAccount['password'] = Hash::make($data['password']);
					$userAccount['repassword'] = Hash::make($data['repassword']);
					$user = $user::create($userAccount);
				}

				//simpan data hotel detail
				$hotelDetail = $hotelDetail->doParams($hotelDetail, $data);
				$hotelDetail->mst001_id = $user->id;
	        	$hotelDetail->save();

			}

		} catch (\Exception $e) {

			DB::rollback();
			Session::flash('error', array($e->getMessage()));
			return Redirect::to('register/hotel')->withInput(Input::all());
		}

		DB::commit();

		if(isset($request->id)){
        	Session::flash('message', array('Hotel successfully updated'));
		} else {
			Session::flash('message', array('Hotel successfully created'));
		}
        return Redirect::to('register/hotel/success');

	}

}
