<?php namespace App\Http\Controllers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Input, Auth, Session, Redirect, Hash, DateTime;
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
class HotelAgentController extends Controller {

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
			SELECT A.HOTEL_ID, MAX(D.PICTURE_PATH) AS PICTURE_PATH, MIN( B.PRICE ) AS LOW_PRICE, A.HOTEL_NAME, C.STAR, C.ADDRESS, C.DESCRIPTION
			FROM TEMP001 A
			INNER JOIN TEMP002 B ON A.ID = B.TEMP001_ID
			INNER JOIN HOTELS C ON A.HOTEL_ID = C.HOTEL_ID
			LEFT JOIN HOTELS_PIC D ON C.HOTEL_ID = D.HOTEL_ID
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
				// return redirect('hotel-agent/hotel')->with('hotels', $tempDataResult);
				
				// return redirect('hotel-agent/hotel')->with('request', $request->all());
				return redirect('hotel-agent/hotel?city='.$city.'&checkIn='.$request->checkIn.'&checkOut='.$request->checkOut);
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

					print_r($result);
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
				// return redirect('hotel-agent/hotel')->with('hotels', $tempDataResult);
				return redirect('hotel-agent/hotel?city='.$city.'&checkIn='.$request->checkIn.'&checkOut='.$request->checkOut);
			}

			// return redirect('hotel-agent/hotel')->with('hotels', $result);
			return redirect('hotel-agent/hotel?city='.$city.'&checkIn='.$request->checkIn.'&checkOut='.$request->checkOut);

		} else {
			return redirect('hotel-agent/hotel?city='.$city.'&checkIn='.$request->checkIn.'&checkOut='.$request->checkOut);
			// abort(500, 'Unauthorized action.');
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
						$market = isset($miniProduct->Market) ? $miniProduct->Market : null;
						$this->handleRoom($rooms, $tempHotel, $checkIn, $market);
					}

				} else {

					$rooms = $product->Rooms;
					$market = isset($product->Market) ? $product->Market : null;
					$this->handleRoom($rooms, $tempHotel, $checkIn, $market);

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
					$market = isset($miniProduct->Market) ? $miniProduct->Market : null;
					$this->handleRoom($rooms, $tempHotel, $checkIn, $market);
				}

			} else {

				$rooms = $product->Rooms;
				$market = isset($product->Market) ? $product->Market : null;
				$this->handleRoom($rooms, $tempHotel, $checkIn, $market);

			}

		}
		
	}

	private function handleRoom($rooms, $tempHotel, $checkIn, $market = null){
		
		if(is_array($rooms)){
			
			foreach($rooms as $key2){

				$stay = $key2->Stay;
				if(is_array($stay)){

					$counter = 0;
					foreach($stay as $smallStay){
						$counter++;
						$this->handleStay($key2, $checkIn, $tempHotel, $smallStay, $counter, $market = null);
					}
					
				} else {
					$this->handleStay($key2, $checkIn, $tempHotel, $stay, 1, $market = null);
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
					$this->handleStay($rooms, $checkIn, $tempHotel, $smallStay, $counter, $market = null);
				}

			} else {

				$this->handleStay($rooms, $checkIn, $tempHotel, $stay, 1, $market = null);

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

	private function handleStay($rooms, $checkIn, $tempHotel, $stay, $lineNumber, $market = null){

		$tempHotelDetail = TempHotelDetail::where('temp001_id', '=', $tempHotel->id)
									->where('room_id', '=', $rooms->RoomID) //- telah di handle dengan line number
									// ->where('line_number', '=',$lineNumber)
									->where('check_in_date', '=',$checkIn)
									->where('price', '=', $stay->Price)->first();

		$whatTheHeck = $tempHotelDetail;
		if(!$tempHotelDetail){

			$tempHotelDetail = new TempHotelDetail();
			$tempHotelDetail->temp001_id = $tempHotel->id;
			$tempHotelDetail->market = $market;
			// $tempHotelDetail->line_number = $lineNumber;//$rooms->RoomID;
			$tempHotelDetail->room_id = $rooms->RoomID;
			$tempHotelDetail->check_in_date = $checkIn;
			$tempHotelDetail->price = $stay->Price;	
			$tempHotelDetail->save();

			/*try {
				
			} catch (\Exception $e) {
				echo '<pre>';
				print_r($tempHotelDetail);
				echo '==========================================================<br>';
				print_r($whatTheHeck);
				die();
			}*/
		}

	}

	public function getHotel(Request $request){
		$city = $request->city;
		$checkIn = $request->checkIn;
		$checkOut = $request->checkOut;

		$checkInDate = DateTime::createFromFormat('d-m-Y', $checkIn);
		$checkOutDate = DateTime::createFromFormat('d-m-Y', $checkOut);
		$cityDetail = null;
		if($city){
			$cityDetail = City::where('id', '=', $city)->first();
			if($checkInDate && $checkOutDate){
				
				$checkIn = Helpers::dateFormatter($checkIn);
				$checkOut = Helpers::dateFormatter($checkOut);

				$country = Country::where('id', '=', $cityDetail->mst002_id)->first();
				$perPage = 30;
				$content = $this->getTempData($cityDetail, $checkIn);
				$slice = array_slice($content, $perPage * (Paginator::resolveCurrentPage() - 1), $perPage);
				$hotels = new LengthAwarePaginator($slice, 
					count($content), 
					$perPage, 
					Paginator::resolveCurrentPage(), 
					['path' => Paginator::resolveCurrentPath()]);

				return view('hotelagent.hotel-agent-hotel-list')
						->with('hotels', $hotels)
						->with('helpers', new Helpers())
						->with('checkIn', $request->checkIn)
						->with('checkOut', $request->checkOut);
			}
		}

		return view('hotelagent.hotel-agent-hotel-list')
						->with('hotels', array())
						->with('helpers', new Helpers());

	}

	public function getRoom(Request $request){

		$hotel = $request->hotel;
		$checkIn = $request->checkIn;
		$checkOut = $request->checkOut;

		$validCheckIn = DateTime::createFromFormat('d-m-Y', $checkIn);
		$validCheckOut = DateTime::createFromFormat('d-m-Y', $checkOut);

		$hotel = Hotel::where('hotel_id', '=', $hotel)->first();
		$pictures = null;
		if($hotel && $validCheckIn && $validCheckOut){
			$checkInDate = Helpers::dateFormatter($checkIn);
			$checkOutDate = Helpers::dateFormatter($checkOut);

			$url = 'http://api.travelmart.com.cn/webservice.asmx/GetRoom?UserID=api&Password=888888&Lang=en&Country=&Province=&City=&HotelID='.$hotel->hotel_id.'&RoomID=';
			$return = Helpers::xmlToJson($url);
			$result = json_decode($return);

			$pictures = HotelPic::where('hotel_id', '=', $hotel->hotel_id)->get();
			if(isset($result->Hotels)){
				if(isset($result->Hotels->Rooms)){

					$rooms = $result->Hotels->Rooms;
					
					$resultRate = array();
					if(count($rooms) > 1){
						foreach($rooms as $room){
							
							$urlRate = 'http://api.travelmart.com.cn/webservice.asmx/GetRate?UserID=api&Password=888888&Lang=en&Country=&Province=&City=&SupplyID=&HotelID='.$hotel->hotel_id.'&Prod=1&roomid='.$room->RoomID.'&checkin='.$checkInDate.'&checkout='.$checkOutDate;
							$returnRate = Helpers::xmlToJson($urlRate);
							$resultRate = json_decode($returnRate);

							if(isset($resultRate->Supply)){
								$room->stayDetail = $resultRate->Supply->Hotels->Product->Rooms->Stay;
								if(is_array($resultRate->Supply->Hotels->Product->Rooms->Stay)){
									$room->RoomRate = $resultRate->Supply->Hotels->Product->Rooms->Stay[0]->Price;
									$room->BF = $resultRate->Supply->Hotels->Product->Rooms->Stay[0]->BF;
									$room->CutOFF = $resultRate->Supply->Hotels->Product->Rooms->Stay[0]->CutOFF;
								} else {
									$room->RoomRate = $resultRate->Supply->Hotels->Product->Rooms->Stay->Price;
									$room->BF = $resultRate->Supply->Hotels->Product->Rooms->Stay->BF;
									$room->CutOFF = $resultRate->Supply->Hotels->Product->Rooms->Stay->CutOFF;
								}
							} else {
								return view('hotelagent.hotel-agent-not-found')->with('content', 'Sorry No Data Found');
							}

							/*echo '<pre>';
							print_r($resultRate);
							die();*/
						}

					} else {
						$urlRate = 'http://api.travelmart.com.cn/webservice.asmx/GetRate?UserID=api&Password=888888&Lang=en&Country=&Province=&City=&SupplyID=&HotelID='.$hotel->hotel_id.'&Prod=1&roomid='.$rooms->RoomID.'&checkin='.$checkInDate.'&checkout='.$checkOutDate;
						$returnRate = Helpers::xmlToJson($urlRate);
						$resultRate = json_decode($returnRate);
					}

					return view('hotelagent.hotel-agent-room-list')
							->with('hotel', $hotel)
							->with('pictures', $pictures)
							->with('rooms', $rooms)
							->with('rate', $resultRate);
				}
			}
		} else {

			return view('hotelagent.hotel-agent-not-found')->with('content', 'Sorry No Data Found');
		}
		

	}

	public function getHotelz(Request $request){

		//$request = Session::get('request');
		//if($request){
			// $city = $request['city'];
			// $checkIn = $request['checkIn'];
			// $checkOut = $request['checkOut'];
			
			$city = $request->city;
			$checkIn = $request->checkIn;
			$checkOut = $request->checkOut;

			// $city = '4dbf325d-33e8-4d6e-b15c-f139fddc12a9';
			// $checkIn = '28-12-2015';
			// $checkOut = '29-12-2015';

			$checkIn = Helpers::dateFormatter($checkIn);
			$checkOut = Helpers::dateFormatter($checkOut);

			$cityDetail = null;
			if($city != null){

				$cityDetail = City::where('id', '=', $city)->first();
				$country = Country::where('id', '=', $cityDetail->mst002_id)->first();
				
				//jika temp data di temukan maka langsung lempar data hotel
				//diluar itu lanjutkan penyimpanan data
				// $pageNumber = Input::get('page', 1);
				$perPage = 3;

				$content = $this->getTempData($cityDetail, $checkIn);
				$slice = array_slice($content, $perPage * (Paginator::resolveCurrentPage() - 1), $perPage);
				// $hotels = new LengthAwarePaginator($slice, count($content), $perPage, Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath(), 'request' => $request));
				$hotels = new LengthAwarePaginator($slice, 
					count($content), 
					$perPage, 
					Paginator::resolveCurrentPage(), 
					['path' => Paginator::resolveCurrentPath()]);

				return view('hotelagent.hotel-agent-hotel-list')
						->with('hotels', $hotels)
						->with('helpers', new Helpers());
			}

			return view('hotelagent.hotel-agent-hotel-list')
						->with('hotels', array())
						->with('helpers', new Helpers());
			
        
		// // echo '<pre>';
		// // print_r($hotels);
		/*echo '<html>  
				<head>
			  		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				</head> 
				<body>';
		if($hotels){
			foreach($hotels as $hotel){
				echo $hotel->LOW_PRICE. '-' . $hotel->HOTEL_NAME .'<br>';
			}
		}*/


	}

	public function getTester(){
		//0006
		$url = 'http://api.travelmart.com.cn/webservice.asmx/GetRate?UserID=api&Password=888888&Lang=en&Country=&Province=&City=&SupplyID=&HotelID=JD91737&Prod=1&roomID=&checkin=28-12-2015&checkout=29-12-2015';
		$return = Helpers::xmlToJson($url);
		$result = json_decode($return);

		echo '<pre>';
		print_r($result);
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

    public function getProfile(){

    	$profile = Agent::where('mst001_id', '=', Auth::user()->id)->first();
    	return view('hotelagent.hotel-agent-profile')->with('profile', $profile);
    }

    public function postUpdateProfile(Request $request){

    	$agent = new Agent();
        $errorBag = $agent->rules($request->all());
        if(count($errorBag) > 0){
            Session::flash('error', $errorBag);
            return redirect('hotel-agent/profile')->withInput($request->all());
        } else {

        }

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

	public function postHotelRoom(){
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

}
