<?php namespace App\Http\Controllers;

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
use App\Models\HotelPicture;
class HotelOwnerController extends Controller {

	public function getIndex(){


		$user = User::where('email', '=', Auth::user()->email)->first();
		$hotel = HotelDetail::where('mst001_id', '=', $user->id)->first();
		// print_r($hotel->toArray());
		// die();
        $currencies = Currency::lists('curr_code', 'id');
		return view('hotelowner.hotel-owner-profile')
	        ->with('currencies', $currencies)
	        ->with('profile', $hotel);
	}

	public function postSaveHotelInput(Request $request){

    	$data = $request->all();
		$hotelDetail = new HotelDetail();
		$errorBag = $hotelDetail->rulesOwner($request->all());

		DB::beginTransaction();

		try {

			if(count($errorBag) > 0){
				DB::rollback();

				Session::flash('error', $errorBag);
	   			return Redirect::to('hotel-owner')->withInput($request->all());
			} else {

				if(isset($request->id)){

					//edit mode
					$hotelDetail = HotelDetail::find($request->id);
		    		$hotelDetail = $hotelDetail->doParamsOwner($hotelDetail, $data, true);
		        	$hotelDetail->save();

				} else {
					
					Session::flash('error', array('Data hotel is not valid'));
        			return Redirect::to('hotel-owner');
				}

			}
			
		} catch (\Exception $e) {
			
			DB::rollback();			
			Session::flash('error', array($e->getMessage()));
			return Redirect::to('hotel-owner')->withInput(Input::all());
		}

		DB::commit();
    	Session::flash('message', array('Hotel successfully updated'));
        return Redirect::to('hotel-owner');
	}

	public function getHotelPictures(){
		// HotelDetail::with('user')->where('mst001_id', )
		// $pictures = HotelPicture

		$hotelDetail = HotelDetail::where('mst001_id', '=', Auth::user()->id)->first();
		// echo '<pre>';
		// print_r($hotelDetail->pictures);
		// die();

		return view('hotelowner.hotel-owner-picture')->with('hotelDetail', $hotelDetail);
	}


	public function postHotelPicture(Request $request){
		$hotelPicture = new HotelPicture();
		$errorBag = $hotelPicture->rules($request);
		if(count($errorBag) > 0){
			Session::flash('error', $error);
			return Redirect::to('hotel-owner/hotel-pictures');
		}

		//try {			

			$uniqId = uniqid();
			$idHotelDetail = HotelDetail::where('mst001_id', '=', Auth::user()->id)->first();
			$path = './uploads/hotels/' .$idHotelDetail->id;
			if(!File::exists($path)) {
			   File::makeDirectory($path, $mode = 0777, true, true);
			}

			$request->file('files')->move($path, $uniqId.'.jpg');
			$hotelPicture = $hotelPicture->doParams($hotelPicture, $uniqId, $idHotelDetail->id, $request);
			$hotelPicture->save();

		//} catch (\Exception $e) {

			// Session::flash('error', array('Your upload is not valid'));
			// return Redirect::to('hotel-owner/hotel-pictures');
		//}

		Session::flash('message', array('Your hotel picture has been successfully uploaded'));
		return Redirect::to('hotel-owner/hotel-pictures');

	}

	public function postDeleteHotelPicture(Request $request){

		if(isset($request->id)){
			$hotelPicture = HotelPicture::find($request->id);
			if($hotelPicture){
				File::delete('./uploads/hotels/'.$hotelPicture->mst020_id.'/'.$hotelPicture->pict.'.jpg');
				$hotelPicture->delete();
				Session::flash('message', array('Hotel picture successfully delete'));
				return Redirect::to('hotel-owner/hotel-pictures');
			}
		}
		Session::flash('error', array('The picture is not valid'));
		return Redirect::to('hotel-owner/hotel-pictures');

	}
}
