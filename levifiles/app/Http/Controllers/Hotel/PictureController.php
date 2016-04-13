<?php namespace App\Http\Controllers\Hotel;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, Validator, File;
use App\Models\HotelDetail;
use App\Models\HotelPicture;
use App\Http\Controllers\Hotel\ActivatedController;
class PictureController extends ActivatedController {

	public function getIndex(){
		// HotelDetail::with('user')->where('mst001_id', )
		// $pictures = HotelPicture

		$hotelDetail = HotelDetail::where('mst001_id', '=', Auth::user()->id)->first();
		// echo '<pre>';
		// print_r($hotelDetail->pictures);
		// die();

		return view('hotel.picture.hotel-picture')->with('hotelDetail', $hotelDetail);
	}


	public function postSave(Request $request){
		$hotelPicture = new HotelPicture();
		$errorBag = $hotelPicture->rules($request);
		if(count($errorBag) > 0){
			Session::flash('error', $errorBag);
			return Redirect::to('hotel/picture');
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
		return Redirect::to('hotel/picture');

	}

	public function postDelete(Request $request){

		if(isset($request->id)){
			$hotelPicture = HotelPicture::find($request->id);
			if($hotelPicture){
				File::delete('./uploads/hotels/'.$hotelPicture->mst020_id.'/'.$hotelPicture->pict.'.jpg');
				$hotelPicture->delete();
				Session::flash('message', array('Hotel picture successfully delete'));
				return Redirect::to('hotel/picture');
			}
		}
		Session::flash('error', array('The picture is not valid'));
		return Redirect::to('hotel/picture');

	}

}
