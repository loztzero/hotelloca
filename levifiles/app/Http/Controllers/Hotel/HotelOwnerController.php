<?php namespace App\Http\Controllers\HotelOwner;

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
use App\Models\HotelRoom;
use App\Models\HotelDetail;
use App\Models\HotelPicture;
use App\Http\Controllers\Controller;
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
			Session::flash('error', $errorBag);
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

	public function getRoom(){
		$user = User::where('email', '=', Auth::user()->email)->first();
		$hotel = HotelDetail::where('mst001_id', '=', $user->id)->first();
		$hotelRooms = HotelRoom::orderBy('from_date', 'desc')->get();
		return view('hotelowner.hotel-owner-room')
				->with('profile', $hotel)
				->with('rooms', $hotelRooms);
	}

	public function getRoomInput(){
		$numberPerson = array();
		for($i=1;$i<=10;$i++){
			$numberPerson[$i] = $i;
		}

		$user = User::where('email', '=', Auth::user()->email)->first();
		$hotel = HotelDetail::where('mst001_id', '=', $user->id)->first();
		return view('hotelowner.hotel-owner-room-input')->with('profile', $hotel)->with('numberPerson', $numberPerson);
	}

	public function postSaveRoom(Request $request){
		$data = $request->all();
		$hotelRoom = new HotelRoom();
		$errorBag = $hotelRoom->rules($request);

		DB::beginTransaction();

		try {

			if(count($errorBag) > 0){
				DB::rollback();

				Session::flash('error', $errorBag);
	   			return Redirect::to('hotel-owner/room-input')->withInput($request->all());

			} else {

				if(isset($request->id)){
					//edit mode
					$hotelRoom = HotelRoom::find($request->id);
					if($hotelRoom == null){
						$hotelRoom = new HotelRoom();
					}
				}

	    		$hotelRoom = $hotelRoom->doParams($hotelRoom, $data);

	    		//start handle image here
				$idHotelDetail = HotelDetail::where('mst001_id', '=', Auth::user()->id)->first();
				$path = './uploads/hotels/' .$idHotelDetail->id . '/' . $hotelRoom->room_id;
				if(!File::exists($path)) {
				   File::makeDirectory($path, $mode = 0777, true, true);
				}

				$request->file('image')->move($path, 'room.jpg');
				//end handle image here

	        	$hotelRoom->save();

			}
			
		} catch (Exception $e) {
			
			DB::rollback();			
			Session::flash('error', array($e->getMessage()));
			return Redirect::to('hotel-owner/room-input')->withInput(Input::all());
		}

		DB::commit();
    	Session::flash('message', array('Successfully saved your hotel room'));
        return Redirect::to('hotel-owner/room');
	}

	public function postLoadRoom(Request $request){
		// $passValue = $request->all();
		if(isset($request->id)){
			$room = HotelRoom::find($request->id);
			$room->from_date = Helpers::dateFormatter($room->from_date);
			$room->end_date = Helpers::dateFormatter($room->end_date);
			return Redirect::to('hotel-owner/room-input')->withInput($room->toArray());
		}
	}

	public function postDeleteRoom(){

	}
}
