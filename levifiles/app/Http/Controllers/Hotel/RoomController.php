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
use App\Models\HotelRoom;
use App\Models\HotelDetail;
use App\Models\HotelPicture;
use App\Http\Controllers\Hotel\ActivatedController;
class RoomController extends ActivatedController {

	public function getIndex(){
		$user = User::where('email', '=', Auth::user()->email)->first();
		$hotel = HotelDetail::where('mst001_id', '=', $user->id)->first();
		$hotelRooms = HotelRoom::where('mst020_id', '=', $hotel->id)->orderBy('room_name')->get();
		return view('hotel.room.hotel-room')
				->with('profile', $hotel)
				->with('rooms', $hotelRooms);
	}

	public function getInput(){
		$numberPerson = array();
		$numberChildren = array();
		for($i=1;$i<=10;$i++){
			$numberPerson[$i] = $i;
		}

		for($i=0;$i<=10;$i++){
			$numberChildren[$i] = $i;
		}

		$user = User::where('email', '=', Auth::user()->email)->first();
		$hotel = HotelDetail::where('mst001_id', '=', $user->id)->first();
		return view('hotel.room.hotel-room-input')->with('profile', $hotel)
				->with('numberPerson', $numberPerson)
				->with('numberChildren', $numberChildren);
	}

	public function postSave(Request $request){
		$data = $request->all();
		$hotelRoom = new HotelRoom();
		$errorBag = $hotelRoom->rules($request);

		DB::beginTransaction();

		try {

			if(count($errorBag) > 0){
				DB::rollback();

				Session::flash('error', $errorBag);
	   			return Redirect::to('hotel/room/input')->withInput($request->all());

			} else {

				if(isset($request->id)){
					//edit mode
					$hotelRoom = HotelRoom::find($request->id);
					if($hotelRoom == null){
						$hotelRoom = new HotelRoom();
					}
				}

	    		$hotelRoom = $hotelRoom->doParams($hotelRoom, $data);

	        	$hotelRoom->save();

	        	if ($request->hasFile('image')) {

	        		//start handle image here
					$idHotelDetail = HotelDetail::where('mst001_id', '=', Auth::user()->id)->first();
					$path = './uploads/hotels/' .$idHotelDetail->id . '/' . $hotelRoom->id;
					if(!File::exists($path)) {
					   File::makeDirectory($path, $mode = 0777, true, true);
					}

					$request->file('image')->move($path, 'room.jpg');
					//end handle image here

				}

			}
			
		} catch (Exception $e) {
			
			DB::rollback();			
			Session::flash('error', array($e->getMessage()));
			return Redirect::to('hotel/room/input')->withInput(Input::all());
		}

		DB::commit();
    	Session::flash('message', array('Successfully saved your hotel room'));
        return Redirect::to('hotel/room');
	}

	public function postLoadData(Request $request){
		// $passValue = $request->all();
		if(isset($request->id)){
			$room = HotelRoom::find($request->id);
			return Redirect::to('hotel/room/input')->withInput($room->toArray());
		}
	}

	public function postDelete(){

	}
}
