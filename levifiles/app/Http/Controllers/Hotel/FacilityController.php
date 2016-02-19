<?php namespace App\Http\Controllers\Hotel;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, Validator, File;
use App\Models\HotelDetail;
use App\Models\HotelFacility;
use App\Http\Controllers\Hotel\ActivatedController;
class FacilityController extends ActivatedController {

	public function getIndex(){
		$hotelDetail = HotelDetail::where('mst001_id', '=', Auth::user()->id)->first();
		$facilities = HotelFacility::where('mst020_id', '=', $hotelDetail->id)
						->orderBy('facility')
						->get();
		// $facilities = 
		return view('hotel.facility.hotel-facility-browse')->with('facilities', $facilities);
	}


	public function postSave(Request $request){
		
		DB::beginTransaction();
		try {

			$hotel = HotelDetail::where('mst001_id', '=', Auth::user()->id)->first();
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
			return Redirect::to('hotel/facility');
		}

		DB::commit();
    	Session::flash('message', array('Successfully saved your facility'));
        return Redirect::to('hotel/facility');

	}

	public function postDelete(Request $request){

		if(isset($request->id)){
			$hotelFacility = HotelFacility::find($request->id);
			if($hotelFacility){
				$hotelFacility->delete();
				Session::flash('message', array('Hotel facility successfully delete'));
				return Redirect::to('hotel/facility');
			}
		}

		Session::flash('error', array('The facility is not valid'));
		return Redirect::to('hotel/facility');

	}

}
