<?php namespace App\Http\Controllers\Hotel;

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
use App\Http\Traits\CityFromCountry;
class ReportBookingController extends Controller {

	use CityFromCountry;

	public function getIndex(Request $request)
	{

		$query = BalanceOrderBooking::from('BLNC001 as a')
						->join('BLNC002 as b', 'a.id', '=', 'b.blnc001_id')
						->join('MST020 as c', 'c.id', '=', 'b.mst020_id');

		$query = $query->select('a.order_no', 'a.order_date', 'a.no_conf_order',
						DB::RAW("concat(b.title, ',', b.first_name, ' ', b.last_name) as quest"),
						'b.room_name', 'b.check_in_date', 'b.check_out_date', 'b.night', 'a.status_flag',
						'a.tot_payment');

		$query = $query->where('c.mst001_id', '=', Auth::user()->id);

		if($request->has('conf_number')){
			$query = $query->where('a.no_conf_order', 'like', $request->conf_number);
		}

		if($request->has('check_in_start')){
			$query = $query->where('b.check_in_date', '<=', $request->check_in_start);
		}

		if($request->has('check_in_end')){
			$query = $query->where('b.check_in_date', '>=', $request->check_in_end);
		}

		if($request->has('check_out_start')){
			$query = $query->where('b.check_out_date', '>=', $request->check_out_start);
		}

		if($request->has('check_out_end')){
			$query = $query->where('b.check_out_date', '<=', $request->check_out_end);
		}

		if($request->has('country')){
			$query = $query->where('c.mst002_id', '=', $request->country);
		}

		if($request->has('city')){
			$query = $query->where('c.mst003_id', '=', $request->city);
		}

		if($request->has('status')){
			$query = $query->where('a.status_flag', '<=', $request->status);
		}

		$result = $query->paginate('20');

		$indonesia = Country::where('country_name', '=', 'Indonesia')->first();
    $countries = Country::where('country_name', '=', 'Indonesia')->orderBy('country_name', 'asc')->lists('country_name', 'id');
    $countries2 = Country::orderBy('country_name', 'asc')->lists('country_name', 'country_name');
		return view('hotel.reportbooking.hotel-report-booking-browse')
			->with('bookingList', $result)
			->with('countries', $countries)
			->with('countries2', $countries2)
			->with('indonesia', $indonesia);
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
							DB::raw("CONCAT(b.title, ',', b.first_name,' ', b.last_name)"),
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
	private function printInvoice(Request $request)
	{
		$queryInvoice = "SELECT A.order_no,A.order_date,B.market, CONCAT(B.title, ',', B.first_name,' ', B.last_name) AS guest,
					       D.country_name,G.transfer_date As payment_date,
					       C.hotel_name,B.room_name,B.num_adults,B.num_child,B.num_breakfast,
					       B.room_num,B.cut_off, B.tot_payment
						FROM BLNC001 A
						INNER JOIN BLNC002 B ON B.blnc001_id = A.id
						INNER JOIN MST020 C ON C.id = B.mst020_id
						INNER JOIN MST002 D ON D.id = C.mst002_id
						INNER JOIN MST023 F ON F.id = B.mst023_id
						INNER JOIN TRX001 G ON G.order_no = A.order_no
						WHERE A.order_no = ?
						AND A.mst001_id = ?
		";

		$queryInvoiceDetails = "SELECT A.check_in_date,A.nett_value as daily_price,A.nett_value*B.room_num as total
								FROM BLNC004 A
								INNER JOIN BLNC002 B ON B.id = A.blnc002_id
								INNER JOIN BLNC001 C ON C.id = B.blnc001_id
								WHERE C.order_no = ?
								AND C.mst001_id = ?
		";

		$resultInvoice = DB::select($queryInvoice, array('201603080001', Auth::user()->id));
		$resultInvoiceDetails = DB::select($queryInvoiceDetails, array('201603080001', Auth::user()->id));

		$paramereter = array();
		$parameter['invoice'] = $resultInvoice[0];
		$parameter['details'] = $resultInvoiceDetails;
		$parameter['helpers'] = new Helpers();

		$pdf = PDF::setPaper('a4')->loadView('agent.bookinghistory.agent-booking-history-invoice-layout', $parameter);
		return $pdf->stream('voucher.pdf');
	}


}
