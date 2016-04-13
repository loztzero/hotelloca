<?php namespace App\Http\Controllers\Agent;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Input, Auth, Session, Redirect, Hash, DateTime, StdClass, Validator;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, PDF;
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
use App\Models\BalanceOrderBooking;
use App\Http\Controllers\Controller;
use DateInterval, DatePeriod;
class BookingHistoryController extends Controller {

	public function getIndex(Request $request)
	{

		// echo 'kambing lewat';
		// die();
		$query = BalanceOrderBooking::from('BLNC001 as a')
						->join('BLNC002 as b', 'b.blnc001_id', '=', 'a.id')
						->join('MST020 as c', 'c.id', '=', 'b.mst020_id')
						->leftJoin('TRX001 as d', 'd.order_no', '=', 'a.order_no')
						->where('a.mst001_id', '=', Auth::user()->id);


// 		WHERE A.order_no LIKE '%123%'
// AND B.check_in_date =  STR_TO_DATE('2016-02-11', '%Y-%m-%d')
// AND B.check_out_date = STR_TO_DATE('2016-02-11', '%Y-%m-%d')
// AND C.mst002_id = '12345'
// AND C.mst003_id = '12345'
		if($request->has('order_no')){
			$query = $query->where('a.order_no', 'like', $request->order_no);
		}

		if($request->has('date_from')){
			$query = $query->whereDate('b.check_in_date', '=', Helpers::dateFormatter($request->date_from));
		}

		if($request->has('date_to')){
			$query = $query->whereDate('b.check_in_date', '=', Helpers::dateFormatter($request->date_to));
		}

		if($request->has('country')){
			$query = $query->where('a.mst002_id', 'like', $request->country);
		}

		if($request->has('city')){
			$query = $query->where('a.mst003_id', 'like', $request->city);
		}

		if($request->has('status')){
			$query = $query->where('a.status_flag', '=', $request->status);
		}

		$query = $query->orderBy('a.created_at');

		$query = $query->select('a.order_no', 'b.check_in_date', 'b.check_out_date','b.first_name' ,
					       'd.transfer_date', 'a.status_flag', 'a.tot_payment', 'a.status_pymnt',
						   DB::raw('CASE WHEN now() < ADDDATE(b.check_in_date, - (b.cut_off +1)) THEN true ELSE false END as show_cancel')
					   );
		$result = $query->paginate(20);
		$result->setPath(url('agent/booking-history')); //buat handle error paginasi pada laravel nya
		// $bookingList = DB::select($this->queryBooking($request), $params);

		$countries = Country::where('country_name', '=', 'Indonesia')->orderBy('country_name', 'asc')->lists('country_name', 'id');
		return view('agent.bookinghistory.agent-booking-history-browse')
			->with('countries', $countries)
			->with('bookingList', $result);

	}

	public function getOrderDetail($orderNo)
	{
		$order = BalanceOrderBooking::from('BLNC001 as a')
						->join('BLNC002 as b', 'b.blnc001_id', '=', 'a.id')
						->join('MST020 as c', 'c.id', '=', 'b.mst020_id')
						->join('MST002 as d', 'd.id', '=', 'c.mst002_id')
						->join('MST003 as e', 'e.id', '=', 'c.mst003_id')
						->join('MST023 as f', 'f.id', '=', 'b.mst023_id')
						->select('a.order_no', 'a.order_date', 'b.market',
							DB::raw("CONCAT(b.title, ',', b.first_name,' ', b.last_name) as quest"),
		       				'd.country_name', 'e.city_name', 'b.check_in_date', 'b.check_out_date',
		       				'a.status_flag', 'c.hotel_name', 'c.star', 'c.address', 'c.postcode', 'c.phone_number', 'b.num_adults', 'b.num_child', 'b.num_breakfast',
		       				'f.image', 'b.type')
						->where('a.mst001_id', '=', Auth::user()->id)
						->where('a.order_no', '=', $orderNo)
						->first();

		return view('agent.bookinghistory.agent-booking-history-order-detail')
				->with('order', $order)
				->with('helpers', new Helpers());

	}

	public function postVoucher(Request $request)
	{
		if($request->has('order_no'))
		{
			return $this->printVoucherAgent($request);
		}
		else
		{
			echo 'voucher fail';
		}
	}

	private function printVoucherAgent(Request $request)
	{

		 $query = "SELECT A.order_no,A.order_date,B.market, CONCAT(B.title, ',', B.first_name,' ', B.last_name) AS guest,
				       D.country_name,B.check_in_date,B.check_out_date,A.status_flag,
				       C.hotel_name,B.room_name,B.num_adults,B.num_child,B.num_breakfast,
				       B.room_num,C.address,C.postcode,C.phone_number,B.note,B.cut_off,E.city_name
					FROM BLNC001 A
					INNER JOIN BLNC002 B ON B.blnc001_id = A.id
					INNER JOIN MST020 C ON C.id = B.mst020_id
					INNER JOIN MST002 D ON D.id = C.mst002_id
					INNER JOIN MST003 E ON E.id = C.mst003_id
					INNER JOIN MST023 F ON F.id = B.mst023_id
					WHERE A.order_no = ?
					AND A.mst001_id = ? ";

		$result = DB::select($query, array($request->order_no, Auth::user()->id));
		$paramereter = array();
		$parameter['voucher'] = $result[0];
		$parameter['helpers'] = new Helpers();

		// echo '<pre>';
		// print_r($parameter);
		// die();

		$pdf = PDF::setPaper('a4')->loadView('agent.bookinghistory.agent-booking-history-voucher-layout', $parameter);
		return $pdf->stream('voucher.pdf');

	}


	//kalau tidak ada data di trx001 sepertinya data nya tidak akan muncul dech
	public function getInvoice($orderNo)
	{
		$queryInvoice = "SELECT A.order_no,A.order_date,B.market, CONCAT(B.title, ',', B.first_name,' ', B.last_name) AS guest,
					       D.country_name,G.transfer_date As payment_date,
					       C.hotel_name,B.room_name,B.num_adults,B.num_child,B.num_breakfast,
					       B.room_num,B.cut_off, B.tot_payment, A.status_pymnt
						FROM BLNC001 A
						INNER JOIN BLNC002 B ON B.blnc001_id = A.id
						INNER JOIN MST020 C ON C.id = B.mst020_id
						INNER JOIN MST002 D ON D.id = C.mst002_id
						INNER JOIN MST023 F ON F.id = B.mst023_id
						LEFT JOIN TRX001 G ON G.order_no = A.order_no
						WHERE A.order_no = ?
						AND A.mst001_id = ?
		";

		$queryInvoiceDetails = "SELECT A.check_in_date,A.nett_value as daily_price,A.nett_value*B.room_num as total
								FROM BLNC004 A
								INNER JOIN BLNC002 B ON B.id = A.blnc002_id
								LEFT JOIN BLNC001 C ON C.id = B.blnc001_id
								WHERE C.order_no = ?
								AND C.mst001_id = ?
		";

		$resultInvoice = DB::select($queryInvoice, array($orderNo, Auth::user()->id));
		$resultInvoiceDetails = DB::select($queryInvoiceDetails, array($orderNo, Auth::user()->id));

		// echo '<pre>';
		// print_r($resultInvoice);
		// die();

		$paramereter = array();
		$parameter['invoice'] = $resultInvoice[0];
		$parameter['details'] = $resultInvoiceDetails;
		$parameter['helpers'] = new Helpers();

		$pdf = PDF::setPaper('a4')->loadView('agent.bookinghistory.agent-booking-history-invoice-layout', $parameter);
		return $pdf->stream('voucher.pdf');
	}


}
