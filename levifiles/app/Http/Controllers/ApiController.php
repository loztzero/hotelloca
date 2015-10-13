<?php namespace App\Http\Controllers;

use Illuminate\Routing\UrlGenerator;
use Input, Auth, Request, Session, Redirect, Hash;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, StdClass;
use App\Models\Country;
class ApiController extends Controller {

	public function getIndex(){
		$user = Input::get('user');
		$password = Input::get('password');
		if($user == 'admin' && $password == 'admin'){

		}

		return Country::where('cntry_code', '=', 'Indonesia')->get(array('cntry_code'));
	}

	public function getCountry(){
		$user = Input::get('user');
		$password = Input::get('password');
		if($user == 'admin' && $password == 'admin'){
			return Country::all(array('cntry_code'));
		}

		return 'User Name or password fail';
		//return Country::where('cntry_code', '=', 'Indonesia')->get(array('cntry_code'));
	}

	public function getCity(){
		$user = Input::get('user');
		$password = Input::get('password');
		$country = Input::get('country');
		if($user == 'admin' && $password == 'admin'){

			if($country != null){
				return $this->cities($country);
			} else {
				return 'Fill the country first';
			}

		} else {
			return 'User Name or password fail';
		}

	}

	private function cities($country){
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

	public function getHotel(){

		$user = Input::get('user');
		$password = Input::get('password');
		$city = Input::get('city');
		if($user == 'admin' && $password == 'admin'){

			if($city != null){
				return $this->hotels($city);
			} else {
				return 'Fill the city first';
			}

		} else {
			return 'User Name or password fail';
		}

	}

	private function hotels($city){

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

	public function getHotelDetail(){
		//JD91737

		$user = Input::get('user');
		$password = Input::get('password');
		$hotelId = Input::get('hotelId');
		if($user == 'admin' && $password == 'admin'){

			if($hotelId != null){
				return $this->hotelDetails($hotelId);
			} else {
				return 'hotel id is needed';
			}

		} else {
			return 'User Name or password fail';
		}

	}

	private function hotelDetails($hotelId){

		//hotel detail
		$url = 'http://api.travelmart.com.cn/webservice.asmx/GetHotel?UserID=api&Password=888888&Lang=en&Country=&Province=&City=&HotelID='.$hotelId;
		$return = Helpers::xmlToJson($url);
		$result = json_decode($return);

		//hotel picture
		$urlPic = 'http://api.travelmart.com.cn/webservice.asmx/GetHotelPicture?UserID=api&Password=888888&Lang=en&Country=&Province=&City=&HotelID='.$hotelId.'&RoomID=';
		$returnPic = Helpers::xmlToJson($urlPic);
		$resultPic = json_decode($returnPic);

		//hotel room type
		$urlRoom = 'http://api.travelmart.com.cn/webservice.asmx/GetRoom?UserID=api&Password=888888&Lang=en&Country=&Province=&City=&HotelID='.$hotelId.'&RoomID=';
		$returnRoom = Helpers::xmlToJson($urlRoom);
		$resultRoom = json_decode($returnRoom);

		$returnBack = new StdClass();

		$returnBack->hotel = null;
		if(isset($result->Hotels)){
			$returnBack->hotel = $result->Hotels;
		}

		$returnBack->pictures = null;
		if(isset($resultPic->Hotel->Picture)){
			$returnBack->pictures = $resultPic->Hotel->Picture;
		}
		
		$returnBack->rooms = null;
		if(isset($resultRoom->Hotels->Rooms)){
			$returnBack->rooms = $resultRoom->Hotels->Rooms;
		}

			// $returnBack->hotel = $result->Hotels;
			// $returnBack->pictures = $resultPic;
			// $returnBack->rooms = $resultRoom;

		return json_encode($returnBack);
		// $returnedValue = $

	}

	public function getRate(){

		$user = Input::get('user');
		$password = Input::get('password');
		$hotelId = Input::get('hotelId');
		$checkIn = Input::get('checkIn');
		$checkOut = Input::get('checkOut');
		$roomId = Input::get('roomId');

		if($user == 'admin' && $password == 'admin'){

			if($hotelId != null && $checkIn != null && $checkOut != null && $roomId != null){
				return $this->rate($hotelId, $roomId, $checkIn, $checkOut);
			} else {
				return 'Please fill hotelId, roomId, checkIn, checkOut for get the result';
			}

		} else {
			return 'User Name or password fail';
		}
	}

	public function rate($hotelId, $roomId, $checkIn, $checkOut){

		$url = 'http://api.travelmart.com.cn/webservice.asmx/GetRate?UserID=api&Password=888888&Lang=en&Country=&Province=&City=&SupplyID=&HotelID='.$hotelId.'&Prod=&roomid='.$roomId.'&checkin='.$checkIn.'&checkout='.$checkOut;
		$return = Helpers::xmlToJson($url);
		$result = json_decode($return);

		if(isset($result->Supply->Hotels->Product->Rooms->Stay)){
			
			$stays = $result->Supply->Hotels->Product->Rooms->Stay;
			$supplyId = $result->Supply->SupplyID;

			$productId = $result->Supply->Hotels->Product->Prod;
			$urlProd = 'http://api.travelmart.com.cn/webservice.asmx/GetProd?UserID=api&Password=888888&Lang=en&Country=&Province=&City=&SupplyID='.$supplyId.'&HotelID='.$hotelId.'&Prod='.$productId;
			$returnProd = Helpers::xmlToJson($urlProd);
			$resultProd = json_decode($returnProd);

			//untuk mendapatkan product yg benar
			//si pemakai harus looping data product nya .. 
			//jika cocok dengan produk id baru digunakan
			$returnBack = new StdClass();
			$returnBack->stays = $stays;
			$returnBack->productId = $productId;
			$returnBack->products = $resultProd;

			echo '<pre>';
			print_r($returnBack); //json_encode($returnBack);
		} else {
			return json_encode(array());
		}
	}


}
