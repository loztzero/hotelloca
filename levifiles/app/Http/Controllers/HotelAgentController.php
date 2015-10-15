<?php namespace App\Http\Controllers;

use Illuminate\Routing\UrlGenerator;
use Input, Auth, Request, Session, Redirect, Hash;
use App;
use App\User;
use App\Libraries\Helpers;
use DB;
use App\Models\Country;
class HotelAgentController extends Controller {

	public function getIndex()
	{
		$countries = Country::all();
		return view('hotelagent.hotel-agent-browse')->with('countries', $countries);
	}

	public function getInsertCountry()
	{
		$url = 'http://api.travelmart.com.cn/webservice.asmx/GetCountry?UserID=api&Password=888888&Lang=en';
		$countries = Helpers::xmlToJson($url);
		$countries = json_decode($countries);

		echo '<pre>';
		//print_r($countries->Countrys->Country);
		DB::beginTransaction();
		try {

			foreach($countries->Countrys->Country as $key => $value):
				$negara = ucfirst(strtolower($value->CountryName));
				$country = new Country();
				$country->cntry_code = $negara;
				$country->cntry_name = $negara;
				$country->save();
			endforeach;	

		} catch (Exception $e) {
			DB::rollback();
			echo 'terjadi error cuy';
		}

		DB::commit();

		echo 'simpan telah berhasil';
	}

	public function getCities($country){

		$country = str_replace(' ', '%20', $country);
		$url = 'http://api.travelmart.com.cn/webservice.asmx/GetCity?UserID=api&Password=888888&Lang=en&Country='.$country.'&Province=&City=';
		$return = Helpers::xmlToJson($url);

		$result = json_decode($return);
		if(isset($result->Countrys)){
			$result = $result->Countrys->Country->Provinces->Province;
		} else {
			$result = null;
		}

		$cityList = array();
		if($result != null){

			if(is_array($result)){

				foreach($result as $key => $value){
					if(is_array($value->Citys->CityName)){
						foreach($value->Citys->CityName as $key2 => $value2){
							array_push($cityList, $value2 . ', ' . $value->ProvinceName);
						}
					} else {
						array_push($cityList, $value->Citys->CityName . ', ' . $value->ProvinceName);
					}
				}

			} else {

				if(is_array($result->Citys->CityName)){
					foreach($result->Citys->CityName as $key3 => $value3){
						array_push($cityList, $value3 . ', ' . $result->ProvinceName);
					}
				} else {
					array_push($cityList, $result->Citys->CityName . ', ' . $result->ProvinceName);
				}
				
			}

		}

		return json_encode($cityList);
	}

	public function getHotels($city){
		if(!empty($city)){
			$url = 'http://api.travelmart.com.cn/webservice.asmx/GetHotel?UserID=api&Password=888888&Lang=en&Country=&Province=&City='.$city.'&HotelID=';
			$return = Helpers::xmlToJson($url);
			$result = json_decode($return);

			if(isset($result->Hotels)){
				return json_encode($result->Hotels);
			} else {
				return json_encode(array());
			}

		} else {
			return json_encode(array());
		}
	}

	public function getSelectedHotel($hotelId){
		$url = 'http://api.travelmart.com.cn/webservice.asmx/GetHotel?UserID=api&Password=888888&Lang=en&Country=&Province=&City=&HotelID='.$hotelId;
		$return = Helpers::xmlToJson($url);
		$result = json_decode($return);

		$urlPic = 'http://api.travelmart.com.cn/webservice.asmx/GetHotelPicture?UserID=api&Password=888888&Lang=en&Country=&Province=&City=&HotelID='.$hotelId.'&RoomID=';
		$returnPic = Helpers::xmlToJson($urlPic);
		$resultPic = json_decode($returnPic);

		return view('hotelagent.hotel-agent-selected')
		->with('hotels', $result)
		->with('pictures', $resultPic);
	}

	public function postSearch2(){
		print_r(Input::all());
	}

	public function postSearch(){

		if(Input::get('hotel') != null){
			if(Input::get('hotel') != ''){
				return redirect('hotel/selected-hotel/'.Input::get('hotel'));
			}
		}

		$city = Input::get('city', null);
		if($city != null){

			$parser = explode(', ', $city);
			if(count($parser) < 2){
				abort(500, 'Unauthorized action.');
			} 

			$url = 'http://api.travelmart.com.cn/webservice.asmx/GetHotel?UserID=api&Password=888888&Lang=en&Country=&Province=&City='.$parser[0].'&HotelID=';
			$return = Helpers::xmlToJson($url);
			$result = json_decode($return);			

			return view('hotelagent.hotel-agent-browse-list')->with('hotels', $result);

		} else {
			abort(500, 'Unauthorized action.');
		}

	}

	public function getHotelRoomTrial($hotelId = '')
	{

		//$hotelId = Input::get('hotel', null);
		if($hotelId != null){

			$url = 'http://api.travelmart.com.cn/webservice.asmx/GetRoom?UserID=api&Password=888888&Lang=en&Country=&Province=&City=&HotelID='.$hotelId.'&RoomID=';
			$return = Helpers::xmlToJson($url);
			$result = json_decode($return);
			echo "<pre>";
			if(isset($result->Hotels)){
				print_r($result->Hotels->Rooms);
			} else {
				print_r($result);
			}

		} else {
			abort(500, 'Unauthorized action.');
		}
		
	}

	public function postHotelRoom()
	{
		$hotelId = Input::get('hotel', null);
		if($hotelId != null){

			$url = 'http://api.travelmart.com.cn/webservice.asmx/GetRoom?UserID=api&Password=888888&Lang=en&Country=&Province=&City=&HotelID='.$hotelId.'&RoomID=';
			$return = Helpers::xmlToJson($url);
			$result = json_decode($return);
			//echo "<pre>";
			if(isset($result->Hotels)){
				//print_r($result->Hotels->Rooms);
				return view('hotelagent.hotel-agent-room-list')->with('rooms', $result->Hotels);
			} else {
				//print_r($result);
				return view('hotelagent.hotel-agent-room-list')->with('rooms', array());
			}

		} else {
			abort(500, 'Unauthorized action.');
		}

	}

	public function getTrialRate(){
		$url = 'http://api.travelmart.com.cn/webservice.asmx/GetRate?UserID=api&Password=888888&Lang=en&Country=&Province=&City=&SupplyID=&HotelID=JD91737&Prod=1&roomid=&checkin=2012-12-21&checkout=2012-12-22';
		$return = Helpers::xmlToJson($url);
		$result = json_decode($return);
		echo "<pre>";
		print_r($result);
	}

}
