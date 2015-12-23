<?php namespace App\Http\Controllers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Input, Auth, Session, Redirect, Hash;
use App;
use App\User;
use App\Libraries\Helpers;
use DB;
use App\Models\Country;
use App\Models\City;
use App\Models\ConfirmationPayment;
use App\Models\TempHotel;
use App\Models\TempHotelDetail;
use App\Models\Hotel;
use App\Models\HotelPic;
use App\Models\Agent;
class HotelGrabController extends Controller {

	public function getKambing(){
		
		for($i = 0; $i<10;$i++){
			if($i == 3){
				continue;
			}
			echo $i.'<br>';
		}

	}

	public function getSavePictureHotel($x){

		echo '<style>body {background-color:black;color:white;}</style>';
		$hotels = Hotel::orderBy('hotel_id')->skip($x)->take(5)->get();
		foreach($hotels as $hotel){
			$url = 'http://api.travelmart.com.cn/webservice.asmx/GetHotelPicture?UserID=api&Password=888888&Lang=en&Country=&Province=&City=&HotelID='.$hotel->hotel_id.'&RoomID=';
			$return = Helpers::xmlToJson($url);
			$result = json_decode($return);


			// try {
			// 	$pics = $result->Hotel->Picture;
			// } catch (\Exception $e) {
			// 	echo '<pre>error nya disini';
			// 	echo $hotel->hotel_id;
			// 	print_r($result);
			// 	die();
			// }

			$pics = null;
			if(isset($result->Hotel)){
				$pics = $result->Hotel->Picture;
			} else {
				$pics = array();
			}
			
			foreach($pics as $pic){

				if(is_object($pic)){

					// foreach($pic as $kambing){
					// 	echo $kambing . ' - itz nothing';
					// }
					// die();

					foreach($pic as $smallPic){
						$hotelPic = HotelPic::where('hotel_id', '=', $hotel->hotel_id)
							->where('picture_path', '=', $smallPic)->first();
						if(!$hotelPic){
							$hotelPic = new HotelPic();
							$hotelPic->hotel_id = $hotel->hotel_id;
							$hotelPic->picture_path = $smallPic;
							$hotelPic->save();
						}
						echo $smallPic.'<br>';
					}

				} else {

					$hotelPic = HotelPic::where('hotel_id', '=', $hotel->hotel_id)
							->where('picture_path', '=', $pic)->first();
					if(!$hotelPic){
						$hotelPic = new HotelPic();
						$hotelPic->hotel_id = $hotel->hotel_id;
						$hotelPic->picture_path = $pic;
						$hotelPic->save();
					}
					echo $pic.'<br>';
				}
				
			}
			echo $hotel->hotel_name . ' -  gambar telah berhasil disimpan<br><br>';
		}

	}

	public function getSaveHotels($x){

		$city = City::orderBy('city_code')->skip($x)->take(5)->get();
		echo '<style>body {background-color:black;color:white;}</style>';
		foreach($city as $smallCity){

			$reCity = urlencode($smallCity->city_code);
			$url = 'http://api.travelmart.com.cn/webservice.asmx/GetHotel?UserID=api&Password=888888&Lang=en&Country=&Province=&City='.$reCity.'&HotelID=';

			try {
				$return = Helpers::xmlToJson($url);
			} catch (\Exception $e) {
				continue;		
			}
			$result = json_decode($return);


			if(isset($result->Hotels)){
				$hotels = $result->Hotels;
				// echo '<pre>';
				// print_r($hotels);
				// die();
				if(is_array($hotels)){
					foreach($hotels as $hotel){
						
						$namaHotel = null;
						try {
						
							$existMaster = Hotel::where('hotel_id', '=', $hotel->HotelID)->first();
							if(!$existMaster){
								$master = new Hotel();
								$master->hotel_id = $hotel->HotelID;

								if(is_object($hotel->HotelName)){
									if(count($hotel->HotelName) > 0){
										$master->hotel_name = $hotel->HotelName->{0};
										$namaHotel = $hotel->HotelName->{0};
									} else {
										$master->hotel_name = $hotel->HotelName;
									}
								} else {
									$master->hotel_name = $hotel->HotelName;
								}

								$master->star = $hotel->Star;

								if(is_object($hotel->Address)){
									if(count($hotel->Address) > 0){
										$master->address =  $hotel->Address->{0};
									} else {
										$master->address = $hotel->Address;
									}
								} else {
									$master->address = $hotel->Address;
								}

								$master->country = $hotel->Country;
								$master->city = $hotel->City;

								// $master->telephone = count($hotel->Telephone) > 0 ? $hotel->Telephone{0} : $hotel->Telephone;
								
								if(is_object($hotel->Telephone)){
									if(count($hotel->Telephone) > 0){
										$master->telephone = $hotel->Telephone->{0};
									} else {
										$$master->telephone = $hotel->Telephone;
									}
								} else {
									$master->telephone = $hotel->Telephone;
								}
								
								if(is_object($hotel->Fax)){
									if(count($hotel->Fax) > 0){
										$master->fax = $hotel->Fax->{0};
									} else {
										$master->fax = $hotel->Fax;
									}
								} else {
									$master->fax = $hotel->Fax;
								}
								
								$master->lat = $hotel->Lat;
								$master->lon = $hotel->Lon;

								if(is_object($hotel->HotelDesc)){
									if(count($hotel->HotelDesc) > 0){
										$master->description = $hotel->HotelDesc->{0};
									} else {
										$master->description = $hotel->HotelDesc;
									}
								} else {
									$master->description = $hotel->HotelDesc;
								}

								$master->currency = $hotel->CurrNo;
								$master->meal_price = $hotel->MealPrice;
								$master->bed_price = $hotel->BedPrice;
								$master->recommend = $hotel->Recommend;
								$master->save();
							} else {
								$namaHotel = $existMaster->hotel_name;
							}

						} catch (\Exception $e) {
							echo '========================================================<br>';
							print_r($e->getMessage());
							print_r($e->getLine());
							echo '<pre>';
							print_r($hotel);
							echo '========================================================<br>';
							die();
						}
						
						if($namaHotel != null){
							echo $namaHotel .' hotel telah tersimpan<br>';	
						} else {

							try {
								echo $hotel->HotelName.' hotel telah tersimpan<br>';
								
							} catch (\Exception $e) {
								print_r($hotel->HotelName);
							}
						}
					}

				} else {

					$existMaster = Hotel::where('hotel_id', '=', $hotels->HotelID)->first();
					$namaHotel = null;
					if(!$existMaster){
						$master = new Hotel();
						$master->hotel_id = $hotels->HotelID;

						if(is_object($hotels->HotelName)){
							if(count($hotels->HotelName) > 0){
								$master->hotel_name = $hotels->HotelName->{0};
								$namaHotel = $hotels->HotelName->{0};
							} else {
								$master->hotel_name = $hotels->HotelName;
							}
						} else {
							$master->hotel_name = $hotels->HotelName;
						}

						$master->star = $hotels->Star;
						
						if(is_object($hotels->Address)){
							if(count($hotels->Address) > 0){
								$master->address =  $hotels->Address->{0};
							} else {
								$master->address = $hotels->Address;
							}
						} else {
							$master->address = $hotels->Address;
						}


						$master->country = $hotels->Country;
						$master->city = $hotels->City;

						if(is_object($hotels->Telephone)){
							if(count($hotels->Telephone) > 0){
								$master->telephone = $hotels->Telephone->{0};
							} else {
								$$master->telephone = $hotels->Telephone;
							}
						} else {
							$master->telephone = $hotels->Telephone;
						}

						if(is_object($hotels->Fax)){
							if(count($hotels->Fax) > 0){
								$master->fax = $hotels->Fax->{0};
							} else {
								$master->fax = $hotels->Fax;
							}
						} else {
							$master->fax = $hotels->Fax;
						}

						$master->lat = $hotels->Lat;
						$master->lon = $hotels->Lon;
						
						if(is_object($hotels->HotelDesc)){
							if(count($hotels->HotelDesc) > 0){
								$master->description = $hotels->HotelDesc->{0};
							} else {
								$master->description = $hotels->HotelDesc;
							}
						} else {
							$master->description = $hotels->HotelDesc;
						}

						$master->currency = $hotels->CurrNo;
						$master->meal_price = $hotels->MealPrice;
						$master->bed_price = $hotels->BedPrice;
						$master->recommend = $hotels->Recommend;
						$master->save();
					} else {
						$namaHotel = $existMaster->hotel_name;
					}

					if($namaHotel){
						echo $namaHotel .' hotel telah tersimpan<br>';	
					} else {
						echo $hotels->HotelName.' hotel telah tersimpan<br>';
					}

				}
				
			}

			echo $smallCity->city_code .' kota telah selesai di eksekusi<br><br>';

			// echo $smallCity->city_code.'<br>';
		}
		// $url = 'http://api.travelmart.com.cn/webservice.asmx/GetHotel?UserID=api&Password=888888&Lang=en&Country=&Province=&City=Beijing&HotelID=';
		// return $city;

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
	// 			$country->country_code = $negara;
	// 			$country->country_name = $negara;
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

	public function getTrialObject(){
    	$test = new \stdClass();
    	for($i = 0; $i<10; $i++){
    		$test->$i = new \stdClass();
    		$test->$i->value = $i;
    	}
    	$test->bebek = new \stdClass();
    	$test->bebek->kambing = 'wew';

    	echo '<pre>';
    	print_r($test);

    }

	public function getTrialRate($country, $city){
		$url = 'http://api.travelmart.com.cn/webservice.asmx/GetRate?UserID=api&Password=888888&Lang=en&Country='.$country.'&Province=&City='.$city.'&SupplyID=&HotelID=&Prod=1&roomid=&checkin=2015-12-01&checkout=2015-12-04';
		$return = Helpers::xmlToJson($url);
		$result = json_decode($return);
		echo "<pre>";
		print_r($result);
	}

	public function getRoomRate(){

		//http://hotelloca.com/hotel-agent/room?hotel=JD30622&checkIn=28-12-2015&checkOut=29-12-2015
		//$url = 'http://api.travelmart.com.cn/webservice.asmx/GetRate?UserID=api&Password=888888&Lang=en&Country=&Province=&City=&SupplyID=&HotelID=JD30622&Prod=1&roomid=&checkin=2015-12-23&checkout=2015-12-30';
		$url = 'http://api.travelmart.com.cn/webservice.asmx/GetRate?UserID=api&Password=888888&Lang=en&Country=&Province=&City=&SupplyID=&HotelID=JD91737&Prod=1&roomid=0010&checkin=24-12-2015&checkout=25-12-2015';
		$return = Helpers::xmlToJson($url);
		$result = json_decode($return);
		echo "<pre>";
		print_r($result);
	}


	public function getCrazySave(){
		$user = new User();
		$user->email = '2ambing@yahoo.com';
		$user->password = '112233';
		$user->save();

		$user->password = '223344';
		$user->save();

		// $user->delete();
	}

	public function getPassword(){
		echo Hash::make('sumedang');
	}

}
