<?php namespace App\Http\Controllers\Hotel;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, Validator, File;
use App\Models\HotelDetail;
use App\Models\HotelRoom;
use App\Models\HotelRoomFacility;
use App\Http\Controllers\Hotel\ActivatedController;
class RoomFacilityController extends ActivatedController {

	public function postIndex(Request $request){
		// echo $request->id;
		$roomExists = HotelRoom::find($request->id);
		$hotelDetail = HotelDetail::where('mst001_id', '=', Auth::user()->id)->first();
		if($roomExists->mst020_id != $hotelDetail->id){
			Session::flash('error', 'Please provide a valid room data');
			return Redirect::to('hotel/room');	
		} else {
			// echo 'numpang lewat gan';
			return Redirect::to('hotel/room-facility')->with('room', $roomExists);
		}
	}

	public function getIndex(){

		if(Session::has('room')){
			$room = Session::get('room');
			$facilities = HotelRoomFacility::where('mst023_id', '=', $room->id)
						->orderBy('facility')
						->get();
						
			return view('hotel.roomfacility.hotel-room-facility-browse')
					->with('room', $room)
					->with('facilities', $facilities);
		}

		Session::flash('error', 'Please provide a valid room data');
		return Redirect::to('hotel/room');	
		
	}

	public function postSave(Request $request){
		

		//jika data room nya tidak valid
		if(empty($request->room_id)){
			Session::flash('error', 'Please provide a valid room data');
			return Redirect::to('hotel/room');	
		}

		$room = HotelRoom::find($request->room_id);
		DB::beginTransaction();

		try {

			/*if(count($errorBag) > 0){
				DB::rollback();

				Session::flash('error', $errorBag);
	   			return Redirect::to('hotel/room-facility')->with('room', $room);
			} */

			$facilities = $request->facility;
			foreach($facilities as $record){
				if(!empty($record)){
					$facility = new HotelRoomFacility();
					$facility->mst023_id = $room->id;
					$facility->facility = $record;
					$facility->save();
				}
			}

		} catch (Exception $e) {
			
			DB::rollback();			
			Session::flash('error', array($e->getMessage()));
			return Redirect::to('hotel/room-facility')->with('room', $room);
		}

		DB::commit();
    	Session::flash('message', array('Successfully saved your facility'));
        return Redirect::to('hotel/room-facility')->with('room', $room);

	}

	public function postDelete(Request $request){

		//jika data room nya tidak valid
		if(empty($request->room_id)){
			Session::flash('error', 'Please provide a valid room data');
			return Redirect::to('hotel/room');	
		}

		$room = HotelRoom::find($request->room_id);
		if(isset($request->id)){
			$hotelFacility = HotelRoomFacility::find($request->id);
			if($hotelFacility){
				$hotelFacility->delete();
				Session::flash('message', array('Hotel Room facility successfully delete'));
				return Redirect::to('hotel/room-facility')->with('room', $room);
			}
		}

		$room = HotelRoom::find($request->room_id);
		Session::flash('error', array('The Room facility is not valid'));
		return Redirect::to('hotel/room-facility')->with('room', $room);

	}

}
