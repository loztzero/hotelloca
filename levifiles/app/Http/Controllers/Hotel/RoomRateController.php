<?php namespace App\Http\Controllers\Hotel;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, Validator, File, DateTime;
use App\Models\City;
use App\Models\ConfirmationPayment;
use App\Models\Currency;
use App\Models\HotelRoom;
use App\Models\HotelRoomRate;
use App\Models\HotelDetail;
use App\Models\HotelPicture;
use App\Http\Controllers\Hotel\ActivatedController;
class RoomRateController extends ActivatedController {

	public function getIndex(){
		$user = User::where('email', '=', Auth::user()->email)->first();
		$hotel = HotelDetail::where('mst001_id', '=', $user->id)->first();
		$today = date('Y-m-d');
		$rateRates = HotelRoomRate::where('end_date', '>=', $today)
						->where('mst020_id', '=', $hotel->id)
						->orderBy('from_date', 'desc')->get();
		return view('hotel.roomrate.hotel-room-rate')
				->with('profile', $hotel)
				->with('rates', $rateRates)
				->with('helpers', new Helpers());
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
		$rooms = HotelRoom::orderBy('room_name')
				->where('mst020_id', '=', $hotel->id)
				->get();
		return view('hotel.roomrate.hotel-room-rate-input')
				->with('profile', $hotel)
				->with('numberPerson', $numberPerson)
				->with('numberChildren', $numberChildren)
				->with('rooms', $rooms->toJson());
	}

	public function postSave(Request $request){
		$data = $request->all();
		$rate = new HotelRoomRate();
		$errorBag = $rate->rules($request);

		/*echo '<pre>';
		print_r($request->mst023_id);*/

		//penambahan validasi MUNGKIN AKAN ERROR
		if(isset($request->from_date) && isset($request->end_date) && isset($request->mst023_id)){
			$fromDate = DateTime::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
			$endDate = DateTime::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');

			/*$stringFromDate = (string) $fromDate;
			$stringEndDate = (string) $endDate;*/
			/*$existHotelRoomRateFrom = HotelRoomRate::where('mst023_id', '=', $request->mst023_id)
										->whereRaw("$stringFromDate between from_date and end_date") //whereBetween($from_date, array('from_date', 'end_date'))
										->toSql();
			$existHotelRoomRateEnd = HotelRoomRate::where('mst023_id', '=', $request->mst023_id) //whereBetween($endDate, array('from_date', 'end_date'))
									->whereRaw("$stringEndDate between from_date and end_date")
									->toSql();*/



			if(isset($request->id)){
				
				$queryExists = "Select count(*) as hasil From MST022 Where mst023_id = ? 
								and ? between from_date and end_date 
								and id <> ?";

				$resultFrom = DB::select($queryExists, array($request->mst023_id, $fromDate, $request->id));
				$resultEnd = DB::select($queryExists, array($request->mst023_id, $endDate, $request->id));

				if($resultFrom[0]->hasil > 0){
					$errorBag = array_add($errorBag, 'fail_period_from', 'Periode Start with this room name must greater than latest Periode End');
				}

				if($resultEnd[0]->hasil > 0){
					$errorBag = array_add($errorBag, 'fail_period_end', 'Periode End with this room name must greater than latest Periode End');
				}

			} else {

				$queryExists = "Select count(*) as hasil From MST022 Where mst023_id = ? 
								and ? between from_date and end_date";

				$resultFrom = DB::select($queryExists, array($request->mst023_id, $fromDate));
				$resultEnd = DB::select($queryExists, array($request->mst023_id, $endDate));

				if($resultFrom[0]->hasil > 0){
					$errorBag = array_add($errorBag, 'fail_period_from', 'Periode Start with this room name must greater than latest Periode End');
				}

				if($resultEnd[0]->hasil > 0){
					$errorBag = array_add($errorBag, 'fail_period_end', 'Periode End with this room name must greater than latest Periode End');
				}
			}
			
		}


		DB::beginTransaction();

		try {

			if(count($errorBag) > 0){
				DB::rollback();

				Session::flash('error', $errorBag);
	   			return Redirect::to('hotel/room-rate/input')->withInput($request->all());

			} else {

				if(isset($request->id)){
					//edit mode
					$rate = HotelRoomRate::find($request->id);
					if($rate == null){
						$rate = new HotelRoomRate();
					}
				}

	    		$rate = $rate->doParams($rate, $data);
	    		$rate->mst004_id = Currency::where('curr_code', '=', 'IDR')->first()->id;
	        	$rate->save();

			}
			
		} catch (Exception $e) {
			
			DB::rollback();			
			Session::flash('error', array($e->getMessage()));
			return Redirect::to('hotel/room-rate/input')->withInput(Input::all());
		}

		DB::commit();
    	Session::flash('message', array('Successfully saved your hotel room'));
        return Redirect::to('hotel/room-rate');
	}

	public function postLoadData(Request $request){
		// $passValue = $request->all();
		if(isset($request->id)){
			$rate = HotelRoomRate::find($request->id);
			$rate->from_date = Helpers::dateFormatter($rate->from_date);
			$rate->end_date = Helpers::dateFormatter($rate->end_date);
			return Redirect::to('hotel/room-rate/input')->withInput($rate->toArray());
		}
	}

	public function postDelete(Request $request){
		if(isset($request->id)){
			$master = HotelRoomRate::find($request->id);
			if($master){
				$now = date('Y-m-d');
				$fromDate = DateTime::createFromFormat('Y-m-d', $master->from_date)->format('Y-m-d');
				if(strtotime($now) >= strtotime($fromDate)){

					Session::flash('error', array('Start period with ' . Helpers::dateFormatter($master->from_date) . ' can not be deleted, because its greater or equal than today'));
					return Redirect::to('hotel/room-rate');
				}

				$master->delete();
				Session::flash('message', array('Room rate succesfully deleted'));
			}
		} else {
			Session::flash('error', array('Something wrong with the data'));
		}

		return Redirect::to('hotel/room-rate');

	}
}
