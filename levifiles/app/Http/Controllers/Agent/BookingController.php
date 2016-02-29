<?php namespace App\Http\Controllers\Agent;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Input, Auth, Session, Redirect, Hash, DateTime, StdClass;
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
use App\Models\HotelPicture;
use App\Models\HotelDetail;
use App\Models\HotelRoom;
use App\Models\HotelRoomRate;
use App\Http\Controllers\Controller;
use DateInterval, DatePeriod;
class BookingController extends Controller {

	public function getIndex(){

		$data = Session::get('data');
		$room = HotelRoom::find($data['room']);
		$hotelDetail = HotelDetail::find($room->mst020_id);
		$checkIn = $data['check_in'];
		$checkOut = $data['check_out'];
		$allotment = $data['allotment'];
		$adults = $data['adults'];
		$child = $data['child'];
		$market = 'IndOnesia';

		$dateListObj = Helpers::getDateListBetweenTwoDates($checkIn, $checkOut);
		$dateList = $dateListObj->periodList;
		$countDay = $dateListObj->countDay;

		$query = $this->requeryBookingRoom();
		$result = DB::select($query, array($market, $checkIn, $checkIn, $checkOut, $checkOut, $checkIn, $checkOut, $room->id));

		$counter = 0;
		$pricing = array();
		$newRoom = null;
		$totalPrice = 0;
		foreach($result as $room){
			
			foreach($dateList as $date){

				if(Helpers::isDate1BetweenDate2AndDate3($date->format("d-m-Y"), 
                    Helpers::dateFormatter($room->from_date), 
                    Helpers::dateFormatter($room->end_date))){

					$counter++;
                    // $newRoom->period_date = $date->format("d-m-Y");
                    // array_push($newRooms, $newRoom);
                    $priceDetail = new StdClass();
                	$priceDetail->period_date = $date->format("d-m-Y");
                	$priceDetail->nett_value = $room->nett_value;
                	$priceDetail->from_date = $room->from_date;
                	$priceDetail->end_date = $room->end_date;

                	$totalPrice += $room->nett_value;
                	// $priceDetail->nett_value_wna = $room->nett_value_wna;
                	array_push($pricing, $priceDetail);

                	// echo '<pre>';
                	// print_r($pricing);
                	// echo '</pre>';
                	// echo '<br><br>';
                }

                if($counter == $countDay){
					$newRoom = clone $room;
					$newRoom->pricing = $pricing;
					$pricing = array();
					$counter = 0;
				}

			}

		}


		// echo '<pre>';
		// print_r($newRoom);
		// die();

		

		// echo '<pre>';
		// print_r($queryResult);
		// die();

		$averagePrice = $totalPrice / $countDay;
		return view('agent.booking.agent-booking')
		->with('hotel', $hotelDetail)
		->with('checkIn', $checkIn)
		->with('checkOut', $checkOut)
		->with('adults', $adults)
		->with('child', $child)
		->with('periods', $dateList)
		->with('nights', $countDay)
		->with('totalRooms', $allotment)
		->with('room', $newRoom)
		->with('totalPrice', $totalPrice)
		->with('averagePrice', $averagePrice);

	}

	public function postIndex(Request $request){
		$hotelId = $request->hotel_id;
		$roomId = $request->room_id;
		$checkIn = $request->checkIn; 
		$checkOut = $request->checkOut;
		$adults = $request->adults;
		$child = $request->child;



		// $hotelId = 'a';
		// $roomId = 'b';
		// $checkIn = 'c';
		// $checkOut = 'd';
		// $adults = 'e';
		// $child = 'f';
		// echo '<pre>';
		// print_r($request->all());
		// die();


		return redirect('agent/booking')
				->with('data', $request->all());
				// ->with('hotelId', $hotelId)
				// ->with('roomId', $roomId)
				// ->with('checkIn', $checkIn)
				// ->with('checkOut', $checkOut)
				// ->with('adults', $adults)
				// ->with('child', $child);
	}

	public function postConfirm(Request $request){
		echo '<pre>';
		print_r($request->all());
	}

	private function requeryBookingRoom(){
		$query = " SELECT B.mst020_id, D.room_name, B.room_desc, D.num_adults, B.num_child, B.num_breakfast,
				             B.from_date, B.end_date, B.net_fee, B.net, B.cancel_fee_flag, B.cancel_fee_val,
				             B.allotment-B.used_allotment AS allotment, B.comm_value, B.cut_off, B.bed_type,
				             CASE WHEN UPPER(?) = 'INDONESIA'
				             	THEN B.nett_value
				                ELSE B.nett_value_wna
				             END as nett_value
				     FROM MST022 B 
				     inner join MST023 D on D.id = B.mst023_id
				     WHERE
				      (
				        B.from_date >= STR_TO_DATE(?, '%d-%m-%Y')
				        OR
				        B.end_date >= STR_TO_DATE(?, '%d-%m-%Y')
				      )
				 
				     AND
				      (
				        B.end_date <= STR_TO_DATE(?, '%d-%m-%Y')
				        OR
				        B.from_date <= STR_TO_DATE(?, '%d-%m-%Y')
				      )
				 
				     AND STR_TO_DATE(?, '%d-%m-%Y') >=
				      (
				        SELECT MIN(AB.from_date) FROM MST022 AB WHERE AB.mst023_id = B.mst023_id
				      )
				 
				     AND STR_TO_DATE(?, '%d-%m-%Y') <=
				      (
				        SELECT MAX(AC.end_date) FROM MST022 AC WHERE AC.mst023_id = B.mst023_id
				      )

				      AND B.mst023_id = ?
				      ORDER BY D.room_name, B.from_date;
		";

		return $query;
	}


}
