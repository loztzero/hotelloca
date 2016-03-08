<?php namespace App\Http\Controllers\Agent;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Input, Auth, Session, Redirect, Hash, DateTime, StdClass, Validator;
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
class BookingHistoryController extends Controller {

	public function getIndex(Request $request){
		$orderNo = $request->input('orderNo');
		$orderNo = $request->input('orderNo');
		$orderNo = $request->input('orderNo');
		$orderNo = $request->input('orderNo');
		$orderNo = $request->input('orderNo');
		$bookingList = DB::select($this->queryBooking, array());
		return view('agent.bookinghistory.agent-booking-history-browse');
	}

	private function queryBookingZ(Request $request){
		// $query = "	SELECT A.order_no,B.check_in_date,B.check_out_date,B.first_name,
		// 			       D.transfer_date, A.status_flg,A.tot_payment
		// 			FROM BLNC001 A
		// 			INNER JOIN BLNC002 B ON B.blnc001_id = A.id
		// 			INNER JOIN MST020 C ON C.id = B.mst020_id
		// 			LEFT JOIN TRX001 D ON D.order_no = A.order_no
		// 			WHERE 1 = 1 
		// 			AND A.order_no LIKE ?
		// 			AND B.check_in_date =  STR_TO_DATE(?, '%Y-%m-%d')
		// 			AND B.check_out_date = STR_TO_DATE(?, '%Y-%m-%d')
		// 			AND C.mst002_id = ?
		// 			AND C.mst003_id = ? ";

		// $result 

		if(!empty($request->input('booking_number'))){

			// $query .= 

		}

		if(!empty($request->input('check_in'))){

		}

		if(!empty($request->input('check_out'))){

		}

		if(!empty($request->input('city'))){

		}

		if(!empty($request->input('country'))){

		}

		return $query;
	}

	private function queryBooking(){
		$query = "	SELECT A.order_no,B.check_in_date,B.check_out_date,B.first_name,
					       D.transfer_date, A.status_flg,A.tot_payment
					FROM BLNC001 A
					INNER JOIN BLNC002 B ON B.blnc001_id = A.id
					INNER JOIN MST020 C ON C.id = B.mst020_id
					LEFT JOIN TRX001 D ON D.order_no = A.order_no
					WHERE A.order_no LIKE ?
					AND B.check_in_date =  STR_TO_DATE(?, '%Y-%m-%d')
					AND B.check_out_date = STR_TO_DATE(?, '%Y-%m-%d')
					AND C.mst002_id = ?
					AND C.mst003_id = ? ";

		return $query;
	}

	private function queryBooking2(){
		$query = "	SELECT A.order_no,B.check_in_date,B.check_out_date,B.first_name,
					       D.transfer_date, A.status_flg,A.tot_payment
					FROM BLNC001 A
					INNER JOIN BLNC002 B ON B.blnc001_id = A.id
					INNER JOIN MST020 C ON C.id = B.mst020_id
					LEFT JOIN TRX001 D ON D.order_no = A.order_no
					WHERE A.order_no LIKE ?
					AND B.check_in_date =  STR_TO_DATE(?, '%Y-%m-%d')
					AND B.check_out_date = STR_TO_DATE(?, '%Y-%m-%d')
					AND C.mst002_id = ?
					AND C.mst003_id = ? ";

		return $query;
	}

	private function queryBooking3(){
		$query = "	SELECT A.order_no,B.check_in_date,B.check_out_date,B.first_name,
					       D.transfer_date, A.status_flg,A.tot_payment
					FROM BLNC001 A
					INNER JOIN BLNC002 B ON B.blnc001_id = A.id
					INNER JOIN MST020 C ON C.id = B.mst020_id
					LEFT JOIN TRX001 D ON D.order_no = A.order_no
					WHERE A.order_no LIKE ?
					AND B.check_in_date =  STR_TO_DATE(?, '%Y-%m-%d')
					AND B.check_out_date = STR_TO_DATE(?, '%Y-%m-%d')
					AND C.mst002_id = ?
					AND C.mst003_id = ? ";

		return $query;
	}

	private function queryBooking4(){
		$query = "	SELECT A.order_no,B.check_in_date,B.check_out_date,B.first_name,
					       D.transfer_date, A.status_flg,A.tot_payment
					FROM BLNC001 A
					INNER JOIN BLNC002 B ON B.blnc001_id = A.id
					INNER JOIN MST020 C ON C.id = B.mst020_id
					LEFT JOIN TRX001 D ON D.order_no = A.order_no
					WHERE A.order_no LIKE ?
					AND B.check_in_date =  STR_TO_DATE(?, '%Y-%m-%d')
					AND B.check_out_date = STR_TO_DATE(?, '%Y-%m-%d')
					AND C.mst002_id = ?
					AND C.mst003_id = ? ";

		return $query;
	}

}
