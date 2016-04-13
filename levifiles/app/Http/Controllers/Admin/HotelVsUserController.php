<?php namespace App\Http\Controllers\Admin;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash, Form;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, Config, File;
use App\Models\Country;
use App\Models\City;
use App\Models\ConfirmationPayment;
use App\Models\Currency;
use App\Models\HotelDetail;
use App\Models\HotelPicture;
use App\Models\HotelFacility;
use App\Models\HotelRoom;
use App\Models\HotelRoomFacility;
use App\Http\Controllers\Controller;
class HotelVsUserController extends Controller {

	public function getIndex(Request $request){

		$result = HotelDetail::where('api_flg', '=', 'No');
		$result->where('mst001_id', '=', null);

		$result = isset($request->hotel_name) && $request->hotel_name != '' ? $result->where('hotel_name', 'like', $request->hotel_name) : $result;

		$result = isset($request->country) && $request->country != ''
					? $result->join('MST002', 'MST002.id', '=', 'MST020.mst002_id')->where('MST002.country_code', '=', $request->country)
					: $result;

		$result = isset($request->city) && $request->city != ''
					? $result->join('MST003', 'MST003.id', '=', 'MST020.mst003_id')->where('MST003.city_code', '=', $request->city)
					: $result;

		$result = $result->orderBy('created_at', 'desc');
		$hotelList = $result->paginate(20);
		$countries = Country::orderBy('country_name', 'asc')->lists('country_name', 'country_name');
		return view('admin.hotelvsuser.admin-hotel-vs-user-browse')
				->with('hotelList', $hotelList)
				->with('countries', $countries);
	}

	public function getInput(){
		$indonesia = Country::where('country_name', '=', 'Indonesia')->first();
        $countries = Country::lists('country_name', 'id');
        $currencies = Currency::where('curr_code', Config::get('enums.rupiah'))->lists('curr_code', 'id');
        $hotelTypes = Config::get('enums.hotelTypes');
		return view('admin.hotelvsuser.admin-hotel-vs-user-input')->with('countries', $countries)
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

		if(isset($data['id'])){
			$hotelDetail = HotelDetail::find($data['id']);
			if($hotelDetail == null){
    			$hotelDetail = new HotelDetail();
    		}
		}

		$hotelDetail = $hotelDetail->doParams($hotelDetail, $data);
    	$hotelDetail->save();

		DB::commit();

		if(isset($request->id)){
        	Session::flash('message', array('Hotel successfully updated'));
		} else {
			Session::flash('message', array('Hotel successfully created'));
		}
        return Redirect::to('admin/hotel-vs-user');

	}

	public function postLoadData(Request $request){

		if(isset($request->id)){
			$hotel = HotelDetail::find($request->id);
			return Redirect::to('admin/hotel-vs-user/input')->withInput($hotel->toArray());
		}

		return Redirect::to('admin/hotel-vs-user/input');

	}

	//input facility here
	public function getFacility(Request $request)
	{
		if($request->has('hotel'))
		{
			$hotel = HotelDetail::where('id', '=', $request->get('hotel'))->first();
			$facilities = HotelFacility::where('mst020_id', '=', $request->get('hotel'))
							->orderBy('facility')
							->get();
			// $facilities =
			return view('admin.hotelvsuser.admin-hotel-vs-user-facility-browse')
			->with('hotel', $hotel)
			->with('facilities', $facilities);
		}
	}

	public function postSaveFacility(Request $request){

		DB::beginTransaction();
		try {

			$hotel = HotelDetail::where('id', '=', $request->get('hotel'))->first();
			$facilities = $request->facility;
			foreach($facilities as $record){
				if(!empty($record)){
					$facility = new HotelFacility();
					$facility->mst020_id = $hotel->id;
					$facility->facility = $record;
					$facility->save();
				}
			}

		} catch (Exception $e) {

			DB::rollback();
			Session::flash('error', array($e->getMessage()));
			return Redirect::to('admin/hotel-vs-user/facility?hotel='.$hotel->id);
		}

		DB::commit();
    	Session::flash('message', array('Successfully saved your facility'));
        return Redirect::to('admin/hotel-vs-user/facility?hotel='.$hotel->id);

	}


	public function postDeleteFacility(Request $request){

		if(isset($request->id)){
			$hotelFacility = HotelFacility::find($request->id);
			if($hotelFacility){
				$hotelFacility->delete();
				Session::flash('message', array('Hotel facility successfully delete'));
				return Redirect::to('admin/hotel-vs-user/facility?hotel='.$request->hotel);
			}
		}

		Session::flash('error', array('The facility is not valid'));
		return Redirect::to('admin/hotel-vs-user/facility?hotel='.$request->hotel);

	}

	//get rooms
	public function getRoom(Request $request)
	{
		if($request->has('hotel'))
		{
			$hotel = HotelDetail::where('id', '=', $request->get('hotel'))->first();
			$hotelRooms = HotelRoom::where('mst020_id', '=', $hotel->id)->orderBy('room_name')->get();
			return view('admin.hotelvsuser.admin-hotel-vs-user-room-browse')
					->with('profile', $hotel)
					->with('rooms', $hotelRooms);
		}
	}

	//get rooms
	public function getRoomInput(Request $request)
	{
		if($request->has('hotel'))
		{
			$numberPerson = array();
			$numberChildren = array();
			for($i=1;$i<=10;$i++){
				$numberPerson[$i] = $i;
			}

			for($i=0;$i<=10;$i++){
				$numberChildren[$i] = $i;
			}
			$hotel = HotelDetail::where('id', '=', $request->get('hotel'))->first();
			$hotelRooms = HotelRoom::where('mst020_id', '=', $hotel->id)->orderBy('room_name')->get();
			return view('admin.hotelvsuser.admin-hotel-vs-user-room-input')
					->with('profile', $hotel)
					->with('numberPerson', $numberPerson)
					->with('numberChildren', $numberChildren);
		}
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
	   			return Redirect::to('admin/hotel-vs-user/room-input?hotel='.$request->hotel)->withInput($request->all());

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
					$idHotelDetail = HotelDetail::where('id', '=', $request->hotel)->first();
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
			return Redirect::to('admin/hotel-vs-user/room-input?hotel='.$request->hotel)->withInput(Input::all());
		}

		DB::commit();
    	Session::flash('message', array('Successfully saved your hotel room'));
        return Redirect::to('admin/hotel-vs-user/room?hotel='.$request->hotel);
	}

	public function getLoadDataRoom(Request $request){
		// $passValue = $request->all();
		if(isset($request->id)){
			$room = HotelRoom::find($request->id);
			return Redirect::to('admin/hotel-vs-user/room-input?hotel='.$request->hotel)->withInput($room->toArray());
		}
	}

	public function getPicture(Request $request){
		if($request->has('hotel'))
		{
			$hotel = HotelDetail::where('id', '=', $request->get('hotel'))->first();
			return view('admin.hotelvsuser.admin-hotel-vs-user-picture')
					->with('hotel', $hotel);
		}
	}

	public function postSavePicture(Request $request){
		$hotelPicture = new HotelPicture();
		$errorBag = $hotelPicture->rules($request);
		if(count($errorBag) > 0){
			Session::flash('error', $errorBag);
			return Redirect::to('admin/hotel-vs-user/picture?'. 'hotel=' . $request->hotel);
		}

		//try {
		$uniqId = uniqid();
		$path = './uploads/hotels/' .$request->hotel;
		if(!File::exists($path)) {
		   File::makeDirectory($path, $mode = 0777, true, true);
		}

		$request->file('files')->move($path, $uniqId.'.jpg');
		$hotelPicture = $hotelPicture->doParams($hotelPicture, $uniqId, $request->hotel, $request);
		$hotelPicture->save();

		//} catch (\Exception $e) {

			// Session::flash('error', array('Your upload is not valid'));
			// return Redirect::to('hotel-owner/hotel-pictures');
		//}

		Session::flash('message', array('Your hotel picture has been successfully uploaded'));
		return Redirect::to('admin/hotel-vs-user/picture?'. 'hotel=' . $request->hotel);

	}

	public function postDeletePicture(Request $request){

		if(isset($request->id)){
			$hotelPicture = HotelPicture::find($request->id);
			if($hotelPicture){
				File::delete('./uploads/hotels/'.$hotelPicture->mst020_id.'/'.$hotelPicture->pict.'.jpg');
				$hotelPicture->delete();
				Session::flash('message', array('Hotel picture successfully delete'));
				return Redirect::to('admin/hotel-vs-user/picture?'. 'hotel=' . $request->hotel);
			}
		}
		Session::flash('error', array('The picture is not valid'));
		return Redirect::to('admin/hotel-vs-user/picture?'. 'hotel=' . $request->hotel);

	}

	//area untun nambah room facility
	public function getRoomFacility(Request $request)
	{
		if($request->has('room'))
		{
			$room = HotelRoom::where('id', '=', $request->get('room'))->first();
			$facilities = HotelRoomFacility::where('mst023_id', '=', $request->get('room'))
							->orderBy('facility')
							->get();
			// $facilities =
			return view('admin.hotelvsuser.admin-hotel-vs-user-room-facility-browse')
			->with('room', $room)
			->with('facilities', $facilities);
		}
	}


	public function postSaveRoomFacility(Request $request){

		DB::beginTransaction();
		try {

			// echo $request->get('room');
			$room = HotelRoom::where('id', '=', $request->get('room'))->first();
			// print_r($room);
			// die();
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
			return Redirect::to('admin/hotel-vs-user/room-facility?room='.$room->id);
		}

		DB::commit();
    	Session::flash('message', array('Successfully saved your facility'));
        return Redirect::to('admin/hotel-vs-user/room-facility?room='.$room->id);

	}


}
