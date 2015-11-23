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
use App\Models\TempHotel;
use App\Models\TempHotelDetail;
use App\Models\Hotel;
use App\Models\HotelPic;
class HotelAgentController extends Controller {

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

	public function getIndex(){
		$indonesia = Country::where('country_name', '=', 'China')->first();
        $countries = Country::orderBy('country_name', 'asc')->lists('country_name', 'country_name');
		return view('hotelagent.hotel-agent-browse')->with('countries', $countries)->with('indonesia', $indonesia);
	}

	public function getBasicSearchHotel(){
		$indonesia = Country::where('country_name', '=', 'Indonesia')->first();
        $countries = Country::lists('country_name', 'country_name');
		return view('hotelagent.hotel-agent-basic-search')->with('countries', $countries)->with('indonesia', $indonesia);	
	}

	private function getTempData($cityDetail, $checkIn){
		// DB::enableQueryLog();
		// jika data nya di temukan maka 
		$query = '
			SELECT MIN( B.PRICE ) AS LOW_PRICE , A.HOTEL_NAME
			FROM TEMP001 A
			INNER JOIN TEMP002 B ON A.ID = B.TEMP001_ID
			WHERE A.CITY = ?
				AND B.CHECK_IN_DATE = ?
			GROUP BY A.HOTEL_NAME
			ORDER BY A.HOTEL_NAME
		';

		$result = DB::select($query, array($cityDetail->city_code, $checkIn));
		// print_r($result);
		// print_r(DB::getQueryLog());

		return $result;
	}

	public function postDataHotel(Request $request){

		$city = $request->city;
		$checkIn = $request->checkIn;
		$checkOut = $request->checkOut;
		
		$checkIn = Helpers::dateFormatter($checkIn);
		$checkOut = Helpers::dateFormatter($checkOut);
		$cityDetail = null;
		if($city != null){

			$cityDetail = City::where('id', '=', $city)->first();
			$country = Country::where('id', '=', $cityDetail->mst002_id)->first();
			
			//jika temp data di temukan maka langsung lempar data hotel
			//diluar itu lanjutkan penyimpanan data
			$tempDataResult = $this->getTempData($cityDetail, $checkIn);
			if(count($tempDataResult) > 0){
				return redirect('hotel-agent/hotel')->with('hotels', $tempDataResult);
			}


			$url = 'http://api.travelmart.com.cn/webservice.asmx/GetRate?UserID=api&Password=888888&Lang=en&Country='.$country->country_code.'&Province=&City='.$cityDetail->city_code.'&SupplyID=&HotelID=&Prod=&roomid=&checkin='.$checkIn.'&checkout='.$checkOut;
			
			$return = Helpers::xmlToJson($url);
			$result = json_decode($return);
			// echo '<pre>';
			// print_r($result);
			// die();

			/*echo '<pre>';
			print_r($result);
			die();*/
			// print_r($hotelList);

			DB::beginTransaction();
			try {

				if(isset($result->Supply)){
					$supply = $result->Supply;
					if(is_array($supply)){

						foreach($supply as $miniSupply){

							//try {
								$hotelList = $miniSupply->Hotels;
								$this->handleHotel($hotelList, $cityDetail, $checkIn);		
							// } catch (\Exception $e) {
							// 	echo '<pre>';
							// 	print_r($hotelList);
							// 	die();
							// }
							
						}

					} else {

						$hotelList = $supply->Hotels;
						$this->handleHotel($hotelList, $cityDetail, $checkIn);	
					}
				} else {
					echo 'no hotel found';
					die();
				}
				

			} catch (Exception $e) {
				DB::rollback();
				// print_r($e);
			}

			DB::commit();

			$tempDataResult = $this->getTempData($cityDetail, $checkIn);
			if(count($tempDataResult) > 0){
				return redirect('hotel-agent/hotel')->with('hotels', $tempDataResult);
			}

			return redirect('hotel-agent/hotel')->with('hotels', $result);

		} else {
			abort(500, 'Unauthorized action.');
		}

	}

	private function handleHotel($hotelList, $cityDetail, $checkIn){

		if(is_array($hotelList)){

			foreach($hotelList as $key){

				$tempHotel = TempHotel::where('hotel_id', '=', $key->HotelID)->first();
				if(!$tempHotel){
					$tempHotel = new TempHotel();
					$tempHotel->hotel_id = $key->HotelID;
					$tempHotel->hotel_name = $key->HotelName;
					$tempHotel->curr_code = $key->Curr;
					$tempHotel->city = $cityDetail->city_code;
					$tempHotel->save();
				}

				//details
				$product = $key->Product;
			// 	print_r($product);

				//handling product jika dia array 
				if(is_array($product)){

					foreach($product as $miniProduct){
						$rooms = $miniProduct->Rooms;
						$this->handleRoom($rooms, $tempHotel, $checkIn);
					}

				} else {

					$rooms = $product->Rooms;
					$this->handleRoom($rooms, $tempHotel, $checkIn);

				}

				
				
			// 	echo '-------<br />';
			// }
			//return view('hotel.hotel-browse-list')->with('hotels', $result);

			} 

		} else {

			//try {
				
				$tempHotel = TempHotel::where('hotel_id', '=', $hotelList->HotelID)->first();
			// } catch (\Exception $e) {
			// 	echo '<pre>';
			// 	print_r($hotelList);
			// 	die();
			// }
			if(!$tempHotel){
				$tempHotel = new TempHotel();
				$tempHotel->hotel_id = $hotelList->HotelID;
				$tempHotel->hotel_name = $hotelList->HotelName;
				$tempHotel->curr_code = $hotelList->Curr;
				$tempHotel->city = $cityDetail->city_code;
				$tempHotel->save();
			}

			//details
			$product = $hotelList->Product;
		// 	print_r($product);

			//handling product jika dia array 
			if(is_array($product)){

				foreach($product as $miniProduct){
					$rooms = $miniProduct->Rooms;
					$this->handleRoom($rooms, $tempHotel, $checkIn);
				}

			} else {

				$rooms = $product->Rooms;
				$this->handleRoom($rooms, $tempHotel, $checkIn);

			}

		}
		
	}

	private function handleRoom($rooms, $tempHotel, $checkIn){
		
		if(is_array($rooms)){
			
			foreach($rooms as $key2){

				$stay = $key2->Stay;
				if(is_array($stay)){

					$counter = 0;
					foreach($stay as $smallStay){
						$counter++;
						$this->handleStay($key2, $checkIn, $tempHotel, $smallStay, $counter);
					}
					
				} else {
					$this->handleStay($key2, $checkIn, $tempHotel, $stay, 1);
				}

				

				// echo $key2->Stay->Price;
				// echo '<br />';
			}

		} else {

			$stay = $rooms->Stay;
			if(is_array($stay)){

				$counter = 0;
				foreach($stay as $smallStay){
					$counter++;
					$this->handleStay($rooms, $checkIn, $tempHotel, $smallStay, $counter);
				}

			} else {

				$this->handleStay($rooms, $checkIn, $tempHotel, $stay, 1);

			}
			/*$tempHotelDetail = TempHotelDetail::where('temp001_id', '=', $tempHotel->id)
									->where('room_id', '=',$rooms->RoomID)
									->where('check_in_date', '=',$checkIn)->first();

			if(!$tempHotelDetail){
				$tempHotelDetail = new TempHotelDetail();
				$tempHotelDetail->temp001_id = $tempHotel->id;
				$tempHotelDetail->room_id = $rooms->RoomID;
				$tempHotelDetail->check_in_date = $checkIn;
				$tempHotelDetail->price = $rooms->Stay->Price;
				$tempHotelDetail->save();
			}*/

		}
	}

	private function handleStay($rooms, $checkIn, $tempHotel, $stay, $lineNumber){

		$tempHotelDetail = TempHotelDetail::where('temp001_id', '=', $tempHotel->id)
									// ->where('room_id', '=',$rooms->RoomID) - telah di handle dengan line number
									->where('line_number', '=',$lineNumber)
									->where('check_in_date', '=',$checkIn)
									->where('price', '=', $stay->Price)->first();

		if(!$tempHotelDetail){
			$tempHotelDetail = new TempHotelDetail();
			$tempHotelDetail->temp001_id = $tempHotel->id;
			$tempHotelDetail->line_number = $lineNumber;//$rooms->RoomID;
			$tempHotelDetail->check_in_date = $checkIn;
			$tempHotelDetail->price = $stay->Price;	
			$tempHotelDetail->save();
		}

	}

	public function getHotel(){

		$hotels = Session::get('hotels');
		// echo '<pre>';
		// print_r($hotels);
		echo '<html>  
				<head>
			  		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				</head> 
				<body>';
		if($hotels){
			foreach($hotels as $hotel){
				echo $hotel->LOW_PRICE. '-' . $hotel->HOTEL_NAME .'<br>';
			}
		}

	}

	public function getBookingHotel(){
		return view('hotelagent.hotel-agent-booking-hotel');
	}

	public function postDataBookingHotel(){

	}

	public function getPayment(){
		return view('hotelagent.hotel-agent-payment');
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

	public function postCityFromCountry(Request $request){
        // print_r(Input::all());
        if($request->country){
        	$countryDetail = Country::where('country_code', '=', $request->country)->first();
            $cities = City::where('mst002_id', '=', $countryDetail->id)->orderBy('city_code')->get();
            return $cities;
        } 

        return json_encode(array());
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

	public function getTrialRate($country, $city){
		$url = 'http://api.travelmart.com.cn/webservice.asmx/GetRate?UserID=api&Password=888888&Lang=en&Country='.$country.'&Province=&City='.$city.'&SupplyID=&HotelID=&Prod=1&roomid=&checkin=2015-12-01&checkout=2015-12-04';
		$return = Helpers::xmlToJson($url);
		$result = json_decode($return);
		echo "<pre>";
		print_r($result);
	}

}
