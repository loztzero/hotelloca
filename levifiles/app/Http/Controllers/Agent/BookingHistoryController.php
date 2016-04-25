<?php namespace App\Http\Controllers\Agent;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Input, Auth, Session, Redirect, Hash, DateTime, StdClass, Validator, Mail;
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
use App\Models\BalanceAgentDeposit;
use App\Models\BalanceOrderBookingPayment;
use App\Models\LogDeposit;
use App\Models\LogCancel;
use App\Models\OrderBooking;
use App\Models\OrderBookingDetailPayment;
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
						->leftJoin('BLNC003 as e', 'e.blnc001_id', '=', 'a.id')
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
			$query = $query->whereDate('b.check_out_date', '=', Helpers::dateFormatter($request->date_to));
		}

		if($request->has('country')){
			$query = $query->where('c.mst002_id', 'like', $request->country);
		}

		if($request->has('city')){
			$query = $query->where('c.mst003_id', 'like', $request->city);
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

	public function getPayment($orderNo)
	{
		$result = BalanceOrderBooking::where('order_no', '=', $orderNo)->first();
		$deposit = BalanceAgentDeposit::where('mst001_id', '=', Auth::user()->id)->first();

		if(!$result){
			Session::flash('error', array('Order number is not valid'));
			return redirect('agent/booking-history');
		}
		//a.order_no, a.tot_payment

		return view('agent.bookinghistory.agent-booking-history-payment')
			->with('order', $result)
			->with('deposit', $deposit);
	}

	public function postConfirmPayment(Request $request)
	{
		$v = $this->paymentValidation($request);

		DB::beginTransaction();
		try {

			if($v->fails()){
				$error = $v->errors()->all();
				Session::flash('error', $error);
				return redirect('agent/booking-history/payment/' . $request->order_no)->withInput($request->all());
			} else {

				$order = BalanceOrderBooking::where('order_no', '=', $request->order_no)->first();
				$deposit = BalanceAgentDeposit::where('mst001_id', '=', Auth::user()->id)->first();

				if($request->payment_method == 'Balance'){
					$remainingDeposit = $deposit ? $deposit->deposit_value - $deposit->used_value : 0;
					if($remainingDeposit < $order->tot_payment){
						$error = array('balance' => 'Sorry your Deposit is not enough, please Top Up or select the other payment method');
						Session::flash('error', $error);
						return redirect('agent/booking-history/payment/' . $request->order_no)->withInput($request->all());
					} else {

						$order->status_pymnt = 'Done';
						$order->status_flag = 'Done';
						$order->save();

						//potong biaya deposit
						$deposit->used_value += $order->tot_payment;
						$deposit->save();

						//bikin data ke log deposit
						$logDeposit = new LogDeposit();
						$logDeposit->mst001_id = Auth::user()->id;
						$logDeposit->type = 'Used';
						$logDeposit->log_no = $order->order_no;
						$logDeposit->log_yrmo = date('Ym');
						$logDeposit->log_date = date('Y-m-d');
						$logDeposit->deposit_value = $order->tot_payment;
						$logDeposit->save();

					}


				}

				//simpan blnc003
				$balanceOrderBookingPayment = BalanceOrderBookingPayment::where('blnc001_id', '=', $order->id)->first();
				if(!$balanceOrderBookingPayment){
					$balanceOrderBookingPayment = new BalanceOrderBookingPayment();
					$balanceOrderBookingPayment->blnc001_id	= $order->id;
				}

				$balanceOrderBookingPayment->payment_method = $request->payment_method;
				if($request->payment_method == 'CreditCard'){
					$balanceOrderBookingPayment->card_type = $request->card_type;
					$balanceOrderBookingPayment->card_number = $request->card_number;
					$balanceOrderBookingPayment->card_name = $request->card_name;
					$balanceOrderBookingPayment->ccv = $request->ccv;
				}
				$balanceOrderBookingPayment->save();

				//simpan trx012
				$trxOrder = OrderBooking::where('order_no', '=', $request->order_no)->first();
				$trxOrderBookingDetailPayment = OrderBookingDetailPayment::where('trx010_id', '=', $trxOrder->id)->first();
				if(!$trxOrderBookingDetailPayment){
					$trxOrderBookingDetailPayment = new OrderBookingDetailPayment();
					$trxOrderBookingDetailPayment->trx010_id	= $trxOrder->id;
				}

				$trxOrderBookingDetailPayment->payment_method = $request->payment_method;
				if($request->payment_method == 'CreditCard'){
					$trxOrderBookingDetailPayment->card_type = $request->card_type;
					$trxOrderBookingDetailPayment->card_number = $request->card_number;
					$trxOrderBookingDetailPayment->card_name = $request->card_name;
					$trxOrderBookingDetailPayment->ccv = $request->ccv;
				}
				$trxOrderBookingDetailPayment->save();

			}

		} catch (\Exception $e) {
			DB::rollBack();
			echo '<pre>';
			print_r($e->getMessage());
			echo '<br><br>';
			print_r($e->getLine());
			echo '<br>';
			echo 'gagal simpan';
			die();
		}

		DB::commit();
		Session::flash('message', 'Pembayaran telah berhasil dilakukan');
		return redirect('agent/booking-history');

	}

	private function paymentValidation(Request $request){

		$rules = array(
			'order_no'	=> 'required',
			'payment_method'   => 'required|in:Balance,Transfer,CreditCard',
			'card_type'   => 'required_if:payment_method,CreditCard|in:Visa,Master',
			'card_name'   => 'required_if:payment_method,CreditCard',
			'card_number'   => 'required_if:payment_method,CreditCard',
			'ccv'   => 'required_if:payment_method,CreditCard',
		);

		$messages = array(
			'payment_method.required' => 'Payment method must valid must valid',
			'payment_method.in' => 'Payment method must valid must valid',
			'card_type.required_if'   => 'Card type must be selected',
			'card_type.in'   => 'Card type value must valid',
			'card_name.required_if'   => 'Card name must be filled',
			'card_number.required_if'   => 'Card number must be filled',
			'ccv.required_if'   => 'CCV value must be filled',
		);

		$v = Validator::make($request->all(), $rules, $messages);
		return $v;
	}

	public function getCancel($orderNumber = null){

		//$balance = BalanceOrderBooking::where('order_no', '=', $orderNumber)->first();
		//$balanceDetailSum = BalanceOrderBookingSummaryDetail::where('blnc001_id', '=', $balance->id)->first();

		$orderBooking = BalanceOrderBooking::from('BLNC001 as a')
						->join('BLNC002 as b', 'b.blnc001_id', '=', 'a.id')
						->join('MST020 as c', 'c.id', '=', 'b.mst020_id')
						->leftJoin('TRX001 as d', 'd.order_no', '=', 'a.order_no')
						->select('a.id', 'a.order_no', 'b.check_in_date', 'b.check_out_date','b.first_name' ,
					       'd.transfer_date', 'a.status_flag', 'a.tot_payment', 'a.status_pymnt',
						   DB::raw('CASE WHEN now() < ADDDATE(b.check_in_date, - (b.cut_off +1)) THEN true ELSE false END as show_cancel')
					   	)
						->where('a.mst001_id', '=', Auth::user()->id)
						->where('a.order_no', '=', $orderNumber)
						->first();

		// echo '<pre>';
		// print_r($orderBooking->toArray());
		// die();

		if($orderBooking && $orderBooking->show_cancel && $orderBooking->status_pymnt == 'Pending'){

			DB::beginTransaction();
			try {

				//update flag ke cancel
				$balanceOrderBooking = BalanceOrderBooking::where('order_no', '=', $orderBooking->id);
				$balanceOrderBooking->status_flag = 'Cancel';
				$balanceOrderBooking->save();

				//tulis ke log cancel
				$logCancel = new LogCancel();
				$logCancel->order_no =  $balanceOrderBooking->order_no;
				$logCancel->order_date = $balanceOrderBooking->order_date;
				$logCancel->cancel_date = date('Y-m-d');
				$logCancel->mst001_id = Auth::user()->id;
				$logCancel->save();

				//send email

			} catch (\Exception $e) {
				DB::rollBack();
			}

			DB::commit();

			Session::flash('message', array('Your Order is successfully cancelled'));
			return redirect('agent/booking-history');

		} else {
			Session::flash('error', array('Please select a valid data for doing the cancellation'));
			return redirect('agent/booking-history');
		}

		// $date1 = strtotime(date('Y-m-d'));
		// $date2 = strtotime(date('Y-m-d', strtotime(date('Y-m-d') . '+1 day')));
		// echo $date1;
		// echo '<br>';
		// echo $date2;
		// echo '<br>';
		// echo ($date1 > $date2);


		// $error = array('balance' => 'Sorry your Deposit is not enough, please Top Up or select the other payment method');
		// Session::flash('error', $error);
		// return redirect('agent/booking-history/payment/' . $request->order_no)->withInput($request->all());

	}

	public function getSendMail(){
		// Mail::send('bookinghistory.agent-booking-history-invoice-layout',
		// 	array('key1' => $param1, 'key2' => $params2),
		// 	function($message) use ($param1, $param2){
		// 		$message->to('fredy.bambang@gmail.com', 'Fredy Bambang')->subject('Invoice From Hotelloca');
		// 	}
		// );

		// try {
		//
		// 	Mail::raw('Hello, This is just a raw email that send from hotelloca.com', function ($message) {
		// 		$message->to('fredy.bambang@gmail.com', 'Fredy Bambang')->subject('Invoice From Hotelloca');
		// 	});
		//
		// } catch (\Exception $e) {
		// 	echo $e->getFile();
		// 	echo '<br>';
		// 	echo $e->getMessage();
		// 	echo '<br>';
		// 	echo $e->getLine();
		// }


	}


}
