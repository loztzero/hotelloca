<?php namespace App\Http\Controllers\Hotel;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, Validator, File;
use App\Models\Country;
use App\Models\City;
use App\Models\ConfirmationPayment;
use App\Models\Currency;
use App\Models\HotelDetail;
use App\Models\HotelRoom;
use App\Models\HotelPicture;
use App\Http\Controllers\Hotel\ActivatedController;
class ProfileController extends ActivatedController {

	public function getIndex(){

		$user = User::where('email', '=', Auth::user()->email)->first();
		$hotel = HotelDetail::where('mst001_id', '=', $user->id)->first();
		// print_r($hotel->toArray());
		// die();
        $currencies = Currency::lists('curr_code', 'id');
		return view('hotel.profile.hotel-profile')
	        ->with('currencies', $currencies)
	        ->with('profile', $hotel);
	}

	public function postSave(Request $request){

    	$data = $request->all();
		$hotelDetail = new HotelDetail();
		$errorBag = $hotelDetail->rulesOwner($request->all());

		DB::beginTransaction();

		try {

			if(count($errorBag) > 0){
				DB::rollback();

				Session::flash('error', $errorBag);
	   			return Redirect::to('hotel/profile')->withInput($request->all());
			} else {

				if(isset($request->id)){

					//edit mode
					$hotelDetail = HotelDetail::find($request->id);
		    		$hotelDetail = $hotelDetail->doParamsOwner($hotelDetail, $data, true);
		        	$hotelDetail->save();

				} else {

					Session::flash('error', array('Data hotel is not valid'));
        			return Redirect::to('hotel/profile');
				}

			}

		} catch (\Exception $e) {

			DB::rollback();
			Session::flash('error', array($e->getMessage()));
			return Redirect::to('hotel/profile')->withInput(Input::all());
		}

		DB::commit();
    	Session::flash('message', array('Hotel successfully updated'));
        return Redirect::to('hotel/profile');
	}

	public function getLogout(){
		Auth::logout();
	}
}
