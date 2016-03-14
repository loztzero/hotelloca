<?php namespace App\Http\Controllers\Admin;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash, Form;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, Config;
use App\Models\Country;
use App\Models\City;
use App\Models\ConfirmationPayment;
use App\Models\Currency;
use App\Models\HotelDetail;
use App\Models\HotelPicture;
use App\Http\Controllers\Controller;
class HotelController extends Controller {

	public function getIndex(Request $request){

		$result = HotelDetail::where('api_flg', '=', 'No');
		$result = isset($request->hotel_name) && $request->hotel_name != '' ? $result->where('hotel_name', 'like', $request->hotel_name) : $result;

		$result = isset($request->country) && $request->country != ''  
					? $result->join('MST002', 'MST002.id', '=', 'MST020.mst002_id')->where('MST002.country_code', '=', $request->country) 
					: $result;

		$result = isset($request->city) && $request->city != '' 
					? $result->join('MST003', 'MST003.id', '=', 'MST020.mst003_id')->where('MST003.city_code', '=', $request->city) 
					: $result;

		$hotelList = $result->paginate(20);
		$countries = Country::orderBy('country_name', 'asc')->lists('country_name', 'country_name');
		return view('admin.hotel.admin-hotel-browse')
				->with('hotelList', $hotelList)
				->with('countries', $countries);
	}

	public function getInput(){
		$indonesia = Country::where('country_name', '=', 'Indonesia')->first();
        $countries = Country::lists('country_name', 'id');
        $currencies = Currency::where('curr_code', Config::get('enums.rupiah'))->lists('curr_code', 'id');
        $hotelTypes = Config::get('enums.hotelTypes');
		return view('admin.hotel.admin-hotel-input')->with('countries', $countries)
	        ->with('indonesia', $indonesia->id)
	        ->with('currencies', $currencies)
	        ->with('hotelTypes', $hotelTypes);
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
	   			return Redirect::to('admin/hotel/input')->withInput(Input::all());
			} else {

				if(isset($request->id) && !empty($request->id)){

					//edit mode
					$hotelDetail = HotelDetail::find($request->id);
		    		$hotelDetail = $hotelDetail->doParams($hotelDetail, $data, true);
		        	$hotelDetail->save();

				} else {

					$userAccount = array();
					$userAccount['email'] = $data['email_login'];
					$userAccount['password'] = $data['password'];
					$userAccount['repassword'] = $data['repassword'];
					$user = new User();
					$errorUser = $user->rules($userAccount);
					if(count($errorUser) > 0){
						DB::rollback();

						Session::flash('error', $errorUser);
						return Redirect::to('admin/hotel/input')->withInput(Input::all());
					} else {
						$userAccount['role'] = 'Hotel';
						$userAccount['password'] = Hash::make($data['password']);
						$userAccount['repassword'] = Hash::make($data['repassword']);
						$user = $user::create($userAccount);
					}

					//simpan data hotel detail
					if(isset($data['id'])){
						$hotelDetail = HotelDetail::find($data['id']);
						if($hotelDetail == null){
			    			$hotelDetail = new HotelDetail();
			    		}
					}

					$hotelDetail = $hotelDetail->doParams($hotelDetail, $data);
					$hotelDetail->mst001_id = $user->id;
		        	$hotelDetail->save();
				}

			}
			
		} catch (\Exception $e) {
			
			DB::rollback();			
			Session::flash('error', array($e->getMessage()));
			return Redirect::to('admin/hotel/input')->withInput(Input::all());
		}

		DB::commit();

		if(isset($request->id)){
        	Session::flash('message', array('Hotel successfully updated'));
		} else {
			Session::flash('message', array('Hotel successfully created'));
		}
        return Redirect::to('admin/hotel');

	}

	public function postLoadData(Request $request){

		if(isset($request->id)){
			$hotel = HotelDetail::find($request->id);
			$user = User::find($hotel->mst001_id);
			$hotel->email_login = $user->email;
			return Redirect::to('admin/hotel/input')->withInput($hotel->toArray());
		}

		return Redirect::to('admin/hotel/input');

	}

	public function postActivateHotel(Request $request){
		if(isset($request->id)){
			$hotel = HotelDetail::find($request->id);

			if($hotel->active_flg == 'Active'){
				Session::flash('error', array('Hotel '.$hotel->hotel_name.' already activated'));
				return Redirect::to('admin/hotel');	
			}

			$hotel->active_flg = 'Active';
			$hotel->save();
			Session::flash('message', array('Hotel '.$hotel->hotel_name.' is activated'));
			return Redirect::to('admin/hotel');
		}

		return Redirect::to('admin/hotel');
	}

	public function postDeactivateHotel(Request $request){
		if(isset($request->id)){
			$hotel = HotelDetail::find($request->id);

			if($hotel->active_flg == 'Inactive'){
				Session::flash('error', array('Hotel '.$hotel->hotel_name.' already inactive'));
				return Redirect::to('admin/hotel');	
			}

			$hotel->active_flg = 'Inactive';
			$hotel->save();
			Session::flash('message', array('Hotel '.$hotel->hotel_name.' is inactive'));
			return Redirect::to('admin/hotel');
		}

		return Redirect::to('admin/hotel/input');
	}

	public function postCityFromCountry(Request $request){
        // print_r(Input::all());
        if($request->country){
        	//$countryDetail = Country::where('country_code', '=', $request->country)->first();
        	$countryDetail = Country::where('country_name', '=', $request->country)->first();
            $cities = City::where('mst002_id', '=', $countryDetail->id)->orderBy('city_code')->get();
            return $cities;
        } 

        return json_encode(array());
    }

}
