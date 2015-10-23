<?php namespace App\Http\Controllers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash;
use App;
use App\User;
use App\Libraries\Helpers;
use DB;
use App\Models\Country;
use App\Models\City;
use App\Models\ConfirmationPayment;
class HotelAgentController extends Controller {

	public function getIndex(){
		$indonesia = Country::where('country_name', '=', 'Indonesia')->first();
        $countries = Country::lists('country_name', 'id');
		return view('hotelagent.hotel-agent-browse')->with('countries', $countries)->with('indonesia', $indonesia);
	}

	public function postDataHotel(){

	}

	public function getHotel(){

	}

	public function getBookingHotel(){
		return view('hotelagent.hotel-agent-booking-hotel');
	}

	public function postDataBookingHotel(){

	}

	public function getPayment(){

	}

	public function getConfirmationPayment(){
		return view('hotelagent.hotel-agent-confirmation-payment');
	}

	public function postValidateConfirmationPayment(Request $request){

		$confirmationPayment = new ConfirmationPayment();
        $errorBag = $confirmationPayment->rules($request->all());
        if(count($errorBag) > 0){
            Session::flash('error', $errorBag);
            return redirect('hotel-agent/confirmation-payment')->withInput($request->all());
        } else {

            DB::beginTransaction();

            try {

                $confirmationPayment = $confirmationPayment->doParams($confirmationPayment, $request->all());
                $confirmationPayment->save();
                DB::commit();
                Session::flash('message', array('success' => 'Confirmation payment success, we will process your data as soon as possible.'));
                return redirect('hotel-agent/confirmation-payment');


            } catch (Exception $e) {

                DB::rollback();
                Session::flash('error', array('error' => $e));
                return redirect('hotel-agent/confirmation-payment')->withInput($request->all());
            }
            
        }

	}

	// public function getInsertCountry()
	// {
	// 	$url = 'http://api.travelmart.com.cn/webservice.asmx/GetCountry?UserID=api&Password=888888&Lang=en';
	// 	$countries = Helpers::xmlToJson($url);
	// 	$countries = json_decode($countries);

	// 	echo '<pre>';
	// 	//print_r($countries->Countrys->Country);
	// 	DB::beginTransaction();
	// 	try {

	// 		foreach($countries->Countrys->Country as $key => $value):
	// 			$negara = ucfirst(strtolower($value->CountryName));
	// 			$country = new Country();
	// 			$country->cntry_code = $negara;
	// 			$country->cntry_name = $negara;
	// 			$country->save();
	// 		endforeach;	

	// 	} catch (Exception $e) {
	// 		DB::rollback();
	// 		echo 'terjadi error cuy';
	// 	}

	// 	DB::commit();

	// 	echo 'simpan telah berhasil';
	// }

	// public function getInsertCity($x){
	// 	$countries = Country::orderBy('country_code')->skip($x)->take(5)->get();
	// 	// $countries = Country::where('country_code', '=', 'China')->get();
		
	// 	DB::beginTransaction();
	// 	try {
			
	// 		foreach($countries as $country):
	// 			$negara = str_replace(' ', '%20', $country->country_name);
	// 			//echo $negara.'<br>';
	// 			$url = 'http://api.travelmart.com.cn/webservice.asmx/GetCity?UserID=api&Password=888888&Lang=en&Country='.$negara.'&Province=&City=';
	// 			$cities = Helpers::xmlToJson($url);
	// 			$cities = json_decode($cities);

	// 			// foreach($cities as $city)
	// 			echo $this->getCity($country, $cities).'<br><br>';
				
	// 		endforeach;

	// 	} catch (Exception $e) {
	// 		DB::rollback();
	// 		print_r($e);
	// 	}
	// 	DB::commit();
	// 	echo 'data kota berhasil di simpan';
	// }

	// public function getBebek(){
	// 	echo 'Chantilly/Compi鑗ne';
	// }

	// public function getCity($country, $cities){

	// 	// echo '<pre>';
	// 	//print_r($cities);
	// 	if(isset($cities->Countrys)){

	// 		if(is_array($cities->Countrys->Country->Provinces->Province)){
			
	// 			foreach($cities->Countrys->Country->Provinces->Province as $province):
	// 				if(is_array($province->Citys->CityName)){
	// 					foreach($province->Citys->CityName as $key):
	// 						$key = str_replace("Chantilly/Compi鑗ne", "Chantilly/Compié‘—ne", $key);
	// 						$key = str_replace("Montlu鏾n", "Montlué¾n", $key);
	// 						if(!City::where('city_name', '=', $key)->first()){
	// 							$kota = new City();
	// 							$kota->city_code = $key;
	// 							$kota->city_name = $key;
	// 							$kota->mst002_id = $country->id;
	// 							$kota->save();
	// 						}
	// 					endforeach;
	// 				} else {
	// 					$key = str_replace("Chantilly/Compi鑗ne", "Chantilly/Compié‘—ne", $province->Citys->CityName);
	// 					$key = str_replace("Montlu鏾n", "Montlué¾n", $province->Citys->CityName);
	// 					if(!City::where('city_name', '=', $key)->first()){
	// 						$kota = new City();
	// 						$kota->city_code = $province->Citys->CityName;
	// 						$kota->city_name = $province->Citys->CityName;
	// 						$kota->mst002_id = $country->id;
	// 						$kota->save();
	// 						//echo $province->Citys->CityName.'<br>';
	// 					}
	// 				}
	// 			endforeach;

	// 		} else {

	// 			if(is_array($cities->Countrys->Country->Provinces->Province->Citys->CityName)){
	// 				foreach($cities->Countrys->Country->Provinces->Province->Citys->CityName as $key):

	// 					$key = str_replace("Chantilly/Compi鑗ne", "Chantilly/Compié‘—ne", $key);
	// 					$key = str_replace("Montlu鏾n", "Montlué¾n", $key);
	// 					if(!City::where('city_name', '=', $key)->first()){
	// 						$kota = new City();
	// 						$kota->city_code = $key;
	// 						$kota->city_name = $key;
	// 						$kota->mst002_id = $country->id;
	// 						$kota->save();
	// 					}

	// 				endforeach;
	// 			} else {

	// 				$key = str_replace("Chantilly/Compi鑗ne", "Chantilly/Compié‘—ne", $cities->Countrys->Country->Provinces->Province->Citys->CityName);
	// 				$key = str_replace("Montlu鏾n", "Montlué¾n", $cities->Countrys->Country->Provinces->Province->Citys->CityName);
	// 				if(!City::where('city_name', '=', $key)->first()){
	// 					$kota = new City();
	// 					$kota->city_code = $key;
	// 					$kota->city_name = $key;
	// 					$kota->mst002_id = $country->id;
	// 					$kota->save();
	// 					//echo $province->Citys->CityName.'<br>';
	// 				}
	// 			}	

	// 		}

	// 	}
		
	// 	// foreach($cities->Countrys->Country->Provinces->Province as $province):

	// 	// 	print_r($province).'<br>';
	// 	// endforeach;

	// 	return $country->country_name;

	// }

	// public function getCity2($country, $cities){
	// 	// $url = 'http://api.travelmart.com.cn/webservice.asmx/GetCity?UserID=api&Password=888888&Lang=en&Country='.$country->country_name.'&Province=&City=';
	// 	// $cities = Helpers::xmlToJson($url);
	// 	// $cities = json_decode($cities);
	// 	// echo '<pre>';
	// 	// print_r($cities->Countrys->Country->Provinces->Province);
	// 	foreach($cities->Countrys->Country->Provinces->Province as $province):
			
	// 		// echo '<pre>';
	// 		// print_r($province);
	// 		if(!isset($province->Citys)){

	// 			// echo '<pre>kambing';
	// 			// print_r($province);
	// 			// if(is_array($province->CityName)){

	// 			// 	foreach($province->CityName as $key):
	// 			// 		if(!City::where('city_name', '=', $key)->first()){
	// 			// 			$kota = new City();
	// 			// 			$kota->city_code = $key;
	// 			// 			$kota->city_name = $key;
	// 			// 			$kota->mst002_id = $country->id;
	// 			// 			$kota->save();
	// 			// 		}
	// 			// 	endforeach;

	// 			// } else {
	// 			// 	if(!City::where('city_name', '=', $province->CityName)->first()){
	// 			// 		$kota = new City();
	// 			// 		$kota->city_code = $province->CityName;
	// 			// 		$kota->city_name = $province->CityName;
	// 			// 		$kota->mst002_id = $country->id;
	// 			// 		$kota->save();
	// 			// 		//echo $province->Citys->CityName.'<br>';
	// 			// 	}
	// 			// }

	// 		} else {
	// 			echo '<pre>kambing';
	// 			print_r($province);
	// 			// if(is_array($province->Citys->CityName)){
	// 			// 	foreach($province->Citys->CityName as $key):

	// 			// 		if(!City::where('city_name', '=', $key)->first()){
	// 			// 			$kota = new City();
	// 			// 			$kota->city_code = $key;
	// 			// 			$kota->city_name = $key;
	// 			// 			$kota->mst002_id = $country->id;
	// 			// 			$kota->save();
	// 			// 		}
	// 			// 	endforeach;
	// 			// } else {

	// 			// 	if(!City::where('city_name', '=', $province->Citys->CityName)->first()){
	// 			// 		$kota = new City();
	// 			// 		$kota->city_code = $province->Citys->CityName;
	// 			// 		$kota->city_name = $province->Citys->CityName;
	// 			// 		$kota->mst002_id = $country->id;
	// 			// 		$kota->save();
	// 			// 		//echo $province->Citys->CityName.'<br>';
	// 			// 	}
	// 			// }	
				
	// 		}
			
	// 		// echo '<pre>';
	// 		// print_r($province);
	// 		// echo '<br><br>';
	// 	endforeach;
	// 	// echo '<pre>';
	// 	// print_r($cities);
	// 	return $country->country_name;

	// }

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
