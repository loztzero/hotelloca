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
use App\Models\OrderBooking;
use App\Models\OrderSummaryDetail;
use App\Models\OrderBookingDetailPayment;
use App\Models\OrderBookingDetail;
use App\Models\BalanceAgentDeposit;
use App\Models\BalanceOrderBooking;
use App\Models\BalanceOrderBookingDetail;
use App\Models\BalanceOrderBookingPayment;
use App\Models\BalanceOrderBookingSummaryDetail;
use App\Models\LogHotelRoomAllotment;
use App\Models\LogDeposit;
use App\Http\Controllers\Controller;
use DateInterval, DatePeriod;
class BookingController extends Controller {

	public function getIndex(){

		//jika session booking datanya terdaftar maka kemungkinan ada error nie..
		if(Session::has('bookingData')){

			$bookingData = Session::get('bookingData');
			$market = $bookingData->nationality;
			$hotelDetail = $bookingData->hotel;
			$checkIn = $bookingData->checkIn;
			$checkOut = $bookingData->checkOut;
			$adults = $bookingData->adults;
			$child = $bookingData->child;
			$dateList = $bookingData->periods;
			$countDay = $bookingData->nights;
			$roomQty = $bookingData->totalRooms;
			$newRoom = $bookingData->room;
			$totalPrice = $bookingData->totalPrice;
			$averagePrice = $bookingData->averagePrice;
			$rateId = $bookingData->rateId;
			$cutOffDateAgent = $bookingData->cutOffDateAgent;
			$cutOffDateHotel = $bookingData->cutOffDateHotel;
			$numBreakfast = $bookingData->numBreakfast;

			return view('agent.booking.agent-booking')
			->with('nationality', $market)
			->with('hotel', $hotelDetail)
			->with('checkIn', $checkIn)
			->with('checkOut', $checkOut)
			->with('adults', $adults)
			->with('child', $child)
			->with('periods', $dateList)
			->with('nights', $countDay)
			->with('totalRooms', $roomQty)
			->with('room', $newRoom)
			->with('totalPrice', $totalPrice)
			->with('averagePrice', $averagePrice)
			->with('rateId', $rateId)
			->with('cutOffDateAgent', $cutOffDateAgent)
			->with('cutOffDateHotel', $cutOffDateHotel)
			->with('numBreakfast', $numBreakfast)
			->with('newsletterFlag', $bookingData->newsletterFlag)
			->with('cutOffAgentCharge', $bookingData->cutOffAgentCharge)
			->with('globalCancelFeeFlag', $bookingData->globalCancelFeeFlag)
			->with('remainingDeposit', $bookingData->remainingDeposit)
			->with('enablePendingPayment', $bookingData->enablePendingPayment);

		} else {

			$data = Session::get('data');
			$room = HotelRoom::find($data['room']);
			$hotelDetail = HotelDetail::find($room->mst020_id);
			$checkIn = $data['check_in'];
			$checkOut = $data['check_out'];
			$roomQty = $data['room_qty'];
			$adults = $data['adults'];
			$child = $data['child'];
			$rateId = $data['rate_id'];
			$market = 'Indonesia';

			$dateListObj = Helpers::getDateListBetweenTwoDates($checkIn, $checkOut);
			$dateList = $dateListObj->periodList;
			$countDay = $dateListObj->countDay;

			$query = $this->requeryBookingRoom();
			$result = DB::select($query, array($market, $market,
				$hotelDetail->id, $checkIn, $checkOut,
				$checkIn, $checkIn, $checkOut,
				$checkOut, $checkIn, $checkOut,
				$room->id,
				$checkIn, $checkIn, $checkOut,
				$checkOut, $checkIn, $checkOut,
				$room->id));

			/* old filter
			DB::select($query, array($market,
				$checkIn, $checkIn, $checkOut,
				$checkOut, $checkIn, $checkOut,
				$room->id));*/

			$counter = 0;
			$pricing = array();
			$newRoom = null;
			$totalPrice = 0;
			$longestCutOff = 0;
			$cutOffChargeDay = 0;
			$firstCheckInDate = null;
			$firstCheckInFlag = false;
			$numBreakfast = 0;// num breakfast ini berbeda karena diambil berdasarkan table room rate nya, breakfast dari room tidak bisa di jadikan acuan 100%;
			$globalCancelFeeFlag = 'Yes';

			//hanya buat ngecek cancellation flag wew ...
			//terpaksa dech
			foreach($result as $room){
				if($room->cancel_fee_flag == 'No'){
					$globalCancelFeeFlag = 'No';
				}
			}

			foreach($result as $room){



				if($longestCutOff < $room->cut_off){
					$longestCutOff = $room->cut_off;
				}

				if($cutOffChargeDay < $room->nett_value){
					$cutOffAgentCharge = $room->nett_value;
				}

				foreach($dateList as $date){

					if(!$firstCheckInFlag){
						//tanggal pertama ini buat digunakan untuk menentukan boleh cancel atau tidak berdasarkan
						//data cut off nya
						$firstCheckInFlag = true;
						$firstCheckInDate = $date;
					}

					if(Helpers::isDate1BetweenDate2AndDate3($date->format("d-m-Y"),
	                    Helpers::dateFormatter($room->from_date),
	                    Helpers::dateFormatter($room->end_date))){

						$counter++;
	                    $priceDetail = new StdClass();
	                	$priceDetail->period_date = $date->format("d-m-Y");

						//inject surcharge waktu weekend
						$day = $date->format('w');
						if($day == 5 || $day == 6){
							$priceDetail->nett_value = $room->nett_value + $room->surcharge;
						} else {
							$priceDetail->nett_value = $room->nett_value;
						}
	                	$priceDetail->from_date = $room->from_date;
	                	$priceDetail->end_date = $room->end_date;
	                	$priceDetail->num_breakfast = $room->num_breakfast;
	                	$priceDetail->cut_off = $room->cut_off;
	                	$priceDetail->allotment = $room->rate_allotment;
	                	$priceDetail->mst023_id = $room->mst023_id;

						if($day == 5 || $day == 6){
							$priceDetail->daily_price = $room->daily_price + $room->surcharge;
						} else {
							$priceDetail->daily_price = $room->daily_price;
						}

	                	$priceDetail->cancel_fee_flag = $globalCancelFeeFlag;
	                	$numBreakfast = $room->num_breakfast; //dan data numbreakfast ini global disini

	                	$totalPrice += $priceDetail->nett_value;
	                	array_push($pricing, $priceDetail);

	                }

	                if($counter == $countDay){
						$newRoom = clone $room;
						$newRoom->pricing = $pricing;
						$pricing = array();
						$counter = 0;
					}

				}

			}


			$averagePrice = $totalPrice / $countDay;

			// print_r($firstCheckInDate);
			// echo '<br>';
			// echo $longestCutOff;
			// echo '<br>';
			$cutOffDateHotel = strtotime("-$longestCutOff day", strtotime($firstCheckInDate->format("Y-m-d")));
			$cutOffDateHotel = date('d-m-Y', $cutOffDateHotel);
			$longestCutOff = $longestCutOff+1;

			// echo $longestCutOff;
			// die();
			//cut off agent
			$cutOffDateAgent = strtotime("-$longestCutOff day", strtotime($firstCheckInDate->format("Y-m-d")));
			$cutOffDateAgent = date('d-m-Y', $cutOffDateAgent);

			//untuk mengambil nilai sisa deposit agent, jika tidak ditemukan ya di session akan menlempar nilai 0
			$balanceAgentDeposit = BalanceAgentDeposit::where('mst001_id', '=', Auth::user()->id)->first();

			$bookingData = new StdClass();
			$bookingData->nationality = $market;
			$bookingData->hotel = $hotelDetail;
			$bookingData->checkIn =  $checkIn;
			$bookingData->checkOut = $checkOut;
			$bookingData->adults = $adults;
			$bookingData->child = $child;
			$bookingData->periods = $dateList;
			$bookingData->nights = $countDay;
			$bookingData->totalRooms = $roomQty;
			$bookingData->room = $newRoom;
			$bookingData->totalPrice = $totalPrice;
			$bookingData->averagePrice = $averagePrice;
			$bookingData->rateId = $rateId;
			$bookingData->cutOffDateAgent = $cutOffDateAgent;
			$bookingData->cutOffDateHotel = $cutOffDateHotel;
			$bookingData->cutOffAgentCharge = $cutOffAgentCharge;
			$bookingData->longestCutOff = $longestCutOff;
			$bookingData->numBreakfast = $numBreakfast;
			$bookingData->globalCancelFeeFlag = $globalCancelFeeFlag;
			$bookingData->remainingDeposit = $balanceAgentDeposit ? $balanceAgentDeposit->deposit_value - $balanceAgentDeposit->used_value : 0;

			//check news letter flag milik si agent, jika Yes maka centang, jika tidak maka No
			$agent = Agent::where('mst001_id', '=', Auth::user()->id)->first();
			if($agent){
				$bookingData->newsletterFlag = $agent->news_letter_flg;
			} else {
				$bookingData->newsletterFlag = 'No';
			}

			//untuk handle Pending Payment method nya harus di munculin atau tidak.
			if(strtotime("now") >= strtotime(Helpers::dateFormatter($cutOffDateAgent)))
			{
				$bookingData->enablePendingPayment = false;
			}
			else
			{
				$bookingData->enablePendingPayment = true;
			}

			Session::put('bookingData', $bookingData);
			return view('agent.booking.agent-booking')
			->with('nationality', $market)
			->with('hotel', $hotelDetail)
			->with('checkIn', $checkIn)
			->with('checkOut', $checkOut)
			->with('adults', $adults)
			->with('child', $child)
			->with('periods', $dateList)
			->with('nights', $countDay)
			->with('totalRooms', $roomQty)
			->with('room', $newRoom)
			->with('totalPrice', $totalPrice)
			->with('averagePrice', $averagePrice)
			->with('rateId', $rateId)
			->with('cutOffDateAgent', $cutOffDateAgent)
			->with('cutOffDateHotel', $cutOffDateHotel)
			->with('numBreakfast', $numBreakfast)
			->with('newsletterFlag', $bookingData->newsletterFlag)
			->with('cutOffAgentCharge', $bookingData->cutOffAgentCharge)
			->with('globalCancelFeeFlag', $globalCancelFeeFlag)
			->with('remainingDeposit', $bookingData->remainingDeposit)
			->with('enablePendingPayment', $bookingData->enablePendingPayment);
		}


	}

	public function postIndex(Request $request){
		$hotelId = $request->hotel_id;
		$roomId = $request->room_id;
		$checkIn = $request->checkIn;
		$checkOut = $request->checkOut;
		$adults = $request->adults;
		$child = $request->child;


		//siklus nya jika halaman ini masuk makan booking data akan selalu kosong;
		if(Session::has('bookingData')){
			Session::forget('bookingData');
		}

		// echo '<pre>';
		// print_r($request->all());
		// echo '</pre>';
		// die();

		return redirect('agent/booking')
				->with('data', $request->all());

	}



	public function postConfirm(Request $request){

		$bookingData = Session::get('bookingData');
		// echo '<pre>';
		// print_r($bookingData);
		// die();

		DB::beginTransaction();
		$successInfo = new StdClass();


		try {

			$logAllotment = new LogHotelRoomAllotment();
			$allotment = $logAllotment->getMinAllotment($bookingData->room->mst023_id, Helpers::dateFormatter($bookingData->checkIn), Helpers::dateFormatter($bookingData->checkOut));
			if(empty($allotment)){
				$allotment = $bookingData->room->allotment;
				if(empty($allotment)){
					//antisipasi jika data allotment nya tidak di temukan di session
					$allotment = 0;
				}
			}


			//update allotment if the remaining is enought
			if($bookingData->totalRooms > $allotment){

				// echo 'gile itz stopped here ?';
				Session::flash('error', array('The room is fully booked from our sistem'));
				return redirect('agent/booking');
			} else {

				$v = $this->validation($request);
				// print_r($validation);
				if($v->fails()){
					$error = $v->errors()->all();
					Session::flash('error', $error);
					return redirect('agent/booking')->withInput($request->all());
				} else {
					if($request->payment_method == 'Balance'){
						if($bookingData->remainingDeposit < ($bookingData->totalPrice * $bookingData->totalRooms)){
							$error = array('balance' => 'Sorry your Deposit is not enough, please Top Up or select the other payment method');
							Session::flash('error', $error);
							return redirect('agent/booking')->withInput($request->all());
						}
					} elseif ($request->payment_method == 'PendingPayment') {
						if(!$bookingData->enablePendingPayment){
							$error = array('invalidPaymentMethod' => 'Sorry this payment method is not avaiable.');
							Session::flash('error', $error);
							return redirect('agent/booking')->withInput($request->all());
						}
					}

					if(!$request->has('agreement')){
						$error = array('agreement' => 'Please tick agree for do the confirmation booking');
						Session::flash('error', $error);
						return redirect('agent/booking')->withInput($request->all());
					}
				}

				//PANTEKSAN - KEDEPANNYA MUNGKIN MAU DI CABUT;
				//ambil dari mst020_id milik room lalu ke mst004 START FROM HERE
				$defaultCurrencyId = $bookingData->hotel->mst004_id;

				//save and do object mode on here...
				//save order booking - TRX010
				$orderBooking = new OrderBooking();
				$orderBooking->order_no = date('Ymd') . $orderBooking->getMaxCounter();
				$orderBooking->order_yrmo = date('Ym');
				$orderBooking->order_date = date('Y-m-d');
				$orderBooking->mst001_id = Auth::user()->id;
				$orderBooking->mst004_id = $defaultCurrencyId;
				$orderBooking->save();

				//newsletter flag
				$agent = Agent::where('mst001_id', '=', $orderBooking->mst001_id)->first();
				$agent->news_letter_flg = $request->news_letter_flg;
				$agent->save();

				$successInfo->orderNumber = $orderBooking->order_no;

				//save balance order booking - BLNC001
				$balanceOrderBooking = new BalanceOrderBooking();
				$balanceOrderBooking->order_no = $orderBooking->order_no;
				$balanceOrderBooking->order_yrmo = $orderBooking->order_yrmo;
				$balanceOrderBooking->order_date = $orderBooking->order_date;
				$balanceOrderBooking->mst001_id = $orderBooking->mst001_id;
				$balanceOrderBooking->mst004_id = $defaultCurrencyId;
				$balanceOrderBooking->save();

				//save order booking summary detail
				$orderSummaryDetail = new OrderSummaryDetail();
				$orderSummaryDetail->trx010_id = $orderBooking->id;
				$orderSummaryDetail->market = $bookingData->nationality;
				$orderSummaryDetail->mst020_id = $bookingData->hotel->id;
				$orderSummaryDetail->mst023_id = $bookingData->room->mst023_id;
				$orderSummaryDetail->check_in_date = Helpers::dateFormatter($bookingData->checkIn);
				$orderSummaryDetail->check_out_date = Helpers::dateFormatter($bookingData->checkOut);
				$orderSummaryDetail->night = $bookingData->nights;
				$orderSummaryDetail->type = $bookingData->numBreakfast > 0 ? 'Breakfast' : 'Room';
				$orderSummaryDetail->room_name = $bookingData->room->room_name;
				$orderSummaryDetail->room_id = $bookingData->room->room_name;
				$orderSummaryDetail->room_num = $bookingData->totalRooms;
				$orderSummaryDetail->num_adults = $bookingData->adults;
				$orderSummaryDetail->num_child = $bookingData->child;
				$orderSummaryDetail->num_breakfast = $bookingData->numBreakfast;
				$orderSummaryDetail->non_smoking_flag = $request->non_smoking_flag;
				$orderSummaryDetail->interconnetion_flag = $request->interconnetion_flag;
				$orderSummaryDetail->early_check_in_flag = $request->early_check_in_flag;
				$orderSummaryDetail->late_check_in_flag = $request->late_check_in_flag;
				$orderSummaryDetail->high_floor_flag = $request->high_floor_flag;
				$orderSummaryDetail->low_floor_flag = $request->low_floor_flag;
				$orderSummaryDetail->twin_flag = $request->twin_flag;
				$orderSummaryDetail->honeymoon_flag = $request->honeymoon_flag;
				$orderSummaryDetail->cancel_fee_value = $bookingData->cutOffAgentCharge;
				$orderSummaryDetail->cut_off = $bookingData->longestCutOff;
				$orderSummaryDetail->cancel_fee_flag = $bookingData->globalCancelFeeFlag;
				$orderSummaryDetail->title = $request->title;
				$orderSummaryDetail->first_name = $request->first_name;
				$orderSummaryDetail->last_name = $request->last_name;
				$orderSummaryDetail->save();

				//save balance order booking summary detail
				$balanceOrderBookingSummaryDetail = new BalanceOrderBookingSummaryDetail();
				$balanceOrderBookingSummaryDetail->blnc001_id = $balanceOrderBooking->id;
				$balanceOrderBookingSummaryDetail->market = $orderSummaryDetail->market;
				$balanceOrderBookingSummaryDetail->mst020_id = $orderSummaryDetail->mst020_id;
				$balanceOrderBookingSummaryDetail->mst023_id = $orderSummaryDetail->mst023_id;
				$balanceOrderBookingSummaryDetail->check_in_date = $orderSummaryDetail->check_in_date;
				$balanceOrderBookingSummaryDetail->check_out_date = $orderSummaryDetail->check_out_date;
				$balanceOrderBookingSummaryDetail->night = $orderSummaryDetail->night;
				$balanceOrderBookingSummaryDetail->type = $orderSummaryDetail->type;
				$balanceOrderBookingSummaryDetail->room_name = $orderSummaryDetail->room_name;
				$balanceOrderBookingSummaryDetail->room_id = $orderSummaryDetail->room_id;
				$balanceOrderBookingSummaryDetail->room_num = $orderSummaryDetail->room_num;
				$balanceOrderBookingSummaryDetail->num_adults = $orderSummaryDetail->num_adults;
				$balanceOrderBookingSummaryDetail->num_child = $orderSummaryDetail->num_child;
				$balanceOrderBookingSummaryDetail->num_breakfast = $orderSummaryDetail->num_breakfast;
				$balanceOrderBookingSummaryDetail->non_smoking_flag = $orderSummaryDetail->non_smoking_flag;
				$balanceOrderBookingSummaryDetail->interconnetion_flag = $orderSummaryDetail->interconnetion_flag;
				$balanceOrderBookingSummaryDetail->early_check_in_flag = $orderSummaryDetail->early_check_in_flag;
				$balanceOrderBookingSummaryDetail->late_check_in_flag = $orderSummaryDetail->late_check_in_flag;
				$balanceOrderBookingSummaryDetail->high_floor_flag = $orderSummaryDetail->high_floor_flag;
				$balanceOrderBookingSummaryDetail->low_floor_flag = $orderSummaryDetail->low_floor_flag;
				$balanceOrderBookingSummaryDetail->twin_flag = $orderSummaryDetail->twin_flag;
				$balanceOrderBookingSummaryDetail->honeymoon_flag = $orderSummaryDetail->honeymoon_flag;
				$balanceOrderBookingSummaryDetail->cancel_fee_value = $orderSummaryDetail->cancel_fee_value;
				$balanceOrderBookingSummaryDetail->cut_off = $orderSummaryDetail->cut_off;
				$balanceOrderBookingSummaryDetail->cancel_fee_flag = $orderSummaryDetail->cancel_fee_flag;
				$balanceOrderBookingSummaryDetail->title = $request->title;
				$balanceOrderBookingSummaryDetail->first_name = $request->first_name;
				$balanceOrderBookingSummaryDetail->last_name = $request->last_name;
				$balanceOrderBookingSummaryDetail->save();

				//params for success page
				$successInfo->title = $balanceOrderBookingSummaryDetail->title;
				$successInfo->firstName = $balanceOrderBookingSummaryDetail->first_name;
				$successInfo->lastName = $balanceOrderBookingSummaryDetail->last_name;

				$hotelDetail = HotelDetail::find($balanceOrderBookingSummaryDetail->mst020_id);
				$successInfo->city = $hotelDetail->city->city_name;
				$successInfo->country = $hotelDetail->country->country_name;

				// $orderSummaryDetail->note = ;
				// $orderSummaryDetail->tot_commision_price = ;
				// $orderSummaryDetail->tot_gross_price = ;
				// $orderSummaryDetail->tot_disc = ;
				// $orderSummaryDetail->tot_tax_base_price = ;
				// $orderSummaryDetail->tot_tax_value = ;
				// $orderSummaryDetail->tot_payment = ;
				// $orderSummaryDetail->title = ;
				// $orderSummaryDetail->first_name = $request->first_name;
				// $orderSummaryDetail->last_name = ;

				//jika metode pembayaran = PENDING PAYMENT maka tidak akan menyimpan data ke trx012 dengan blnc003
				if($request->payment_method != 'PendingPayment')
				{

					//simpan OrderBookingDetailPayment - TRX012
					$orderBookingDetailPayment = new OrderBookingDetailPayment();
					$orderBookingDetailPayment->trx010_id = $orderBooking->id;
					$orderBookingDetailPayment->payment_method = $request->payment_method;
					if($orderBookingDetailPayment->payment_method == 'CreditCard'){
						$orderBookingDetailPayment->card_type = $request->card_type;
						$orderBookingDetailPayment->card_number = $request->card_number;
						$orderBookingDetailPayment->card_name = $request->card_name;
					}
					$orderBookingDetailPayment->save();

					//selipin data success info nya lagi dech disini
					$successInfo->paymentMethod = $orderBookingDetailPayment->payment_method;

					//simpan BalanceOrderBookingPayment - BLNC003
					$balanceOrderBookingPayment = new BalanceOrderBookingPayment();
					$balanceOrderBookingPayment->blnc001_id = $balanceOrderBooking->id;
					$balanceOrderBookingPayment->payment_method = $orderBookingDetailPayment->payment_method;
					if($balanceOrderBookingPayment->payment_method == 'CreditCard'){
						$balanceOrderBookingPayment->card_type = $orderBookingDetailPayment->card_type;
						$balanceOrderBookingPayment->card_number = $orderBookingDetailPayment->card_number;
						$balanceOrderBookingPayment->card_name = $orderBookingDetailPayment->card_name;
					}
					$balanceOrderBookingPayment->save();

					//jika payment method = transfer maka status nya pending
					if($balanceOrderBookingPayment->payment_method == 'CreditCard')
					{
						// update nilai pembayaran ke done jika pembayaran dari kartu kredit berhasil
						// $balanceOrderBooking->status_flag = 'Done';
						// $balanceOrderBooking->status_pymnt = 'Done';

						//this is for temporary value only
						$balanceOrderBooking->status_flag = 'Cancel';
						$balanceOrderBooking->status_pymnt = 'Failed';
					}
					else if($balanceOrderBookingPayment->payment_method == 'Transfer')
					{
						$balanceOrderBooking->status_flag = 'Pending';
						$balanceOrderBooking->status_pymnt = 'Pending';
					}
					else if($balanceOrderBookingPayment->payment_method == 'Balance')
					{
						$balanceOrderBooking->status_flag = 'Done';
						$balanceOrderBooking->status_pymnt = 'Done';
					}
					else
					{
						$balanceOrderBooking->status_flag = 'Pending';
						$balanceOrderBooking->status_pymnt = 'Pending';
					}
					$balanceOrderBooking->save();

				} else {
					$successInfo->paymentMethod = $request->payment_method;
					$balanceOrderBooking->status_flag = 'Pending';
					$balanceOrderBooking->status_pymnt = 'Pending';
					$balanceOrderBooking->save();
				}

				//beware angka2 field untuk table TRX011 dibawah ini diupdate oleh detail nya
				// $orderSummaryDetail->note = ;
				$orderSummaryDetail->tot_commision_price = 0;
				$orderSummaryDetail->tot_gross_price = 0;
				$orderSummaryDetail->tot_disc = 0;
				$orderSummaryDetail->tot_tax_base_price = 0;
				$orderSummaryDetail->tot_tax_value = 0;
				$orderSummaryDetail->tot_payment = 0;
				//end beware

				// echo '<pre>';
				// print_r($orderSummaryDetail->toArray());
				// die();

				//simpan detail order, looping dari pricing
				foreach($bookingData->room->pricing as $pricing){

					//TRX013
					$orderBookingDetail = new OrderBookingDetail();
					$orderBookingDetail->trx011_id = $orderSummaryDetail->id;
					$orderBookingDetail->check_in_date = Helpers::dateFormatter($pricing->period_date);
					$orderBookingDetail->cut_off = $pricing->cut_off;
					$orderBookingDetail->daily_price = $pricing->daily_price;
					$orderBookingDetail->nett_value = $pricing->nett_value;
					$orderBookingDetail->tot_base_price = $orderBookingDetail->nett_value * $orderSummaryDetail->room_num;
					$orderBookingDetail->commision_value = ($pricing->nett_value - $pricing->daily_price) * $orderSummaryDetail->room_num;
					$orderBookingDetail->tot_comm_val = $orderBookingDetail->commision_value * $orderSummaryDetail->room_num;
					$orderBookingDetail->gross_price = $orderBookingDetail->nett_value * $orderSummaryDetail->room_num;
					$orderBookingDetail->disc = 0;
					$orderBookingDetail->tax_base_price = $orderBookingDetail->tot_base_price - $orderBookingDetail->disc;
					$orderBookingDetail->tax_value = 0;
					$orderBookingDetail->cancel_fee_flag = $bookingData->globalCancelFeeFlag;
					$orderBookingDetail->cancel_fee_value = $pricing->nett_value;
					$orderBookingDetail->save();

					//update table trx011 disini - TRX011
					$orderSummaryDetail->tot_commision_price += $orderBookingDetail->tot_comm_val;
					$orderSummaryDetail->tot_gross_price += $orderBookingDetail->gross_price;
					$orderSummaryDetail->tot_disc += $orderBookingDetail->disc;
					$orderSummaryDetail->tot_tax_base_price += $orderBookingDetail->tax_base_price;
					$orderSummaryDetail->tot_tax_value += $orderBookingDetail->tax_value;
					$orderSummaryDetail->tot_payment += $orderBookingDetail->tax_base_price + $orderBookingDetail->tax_value;

					//================SIMPAN SALDO DI BAWAH INI ===============================
					$balanceOrderBookingDetail = new BalanceOrderBookingDetail();
					$balanceOrderBookingDetail->blnc002_id = $balanceOrderBookingSummaryDetail->id;
					$balanceOrderBookingDetail->check_in_date = $orderBookingDetail->check_in_date;
					$balanceOrderBookingDetail->cut_off = $orderBookingDetail->cut_off;
					$balanceOrderBookingDetail->daily_price = $orderBookingDetail->daily_price;
					$balanceOrderBookingDetail->nett_value = $orderBookingDetail->nett_value;
					$balanceOrderBookingDetail->tot_base_price = $orderBookingDetail->tot_base_price;
					$balanceOrderBookingDetail->commision_value = $orderBookingDetail->commision_value;
					$balanceOrderBookingDetail->tot_comm_val = $orderBookingDetail->tot_comm_val;
					$balanceOrderBookingDetail->gross_price = $orderBookingDetail->gross_price;
					$balanceOrderBookingDetail->disc = $orderBookingDetail->disc;
					$balanceOrderBookingDetail->tax_base_price = $orderBookingDetail->tax_base_price;
					$balanceOrderBookingDetail->tax_value = $orderBookingDetail->tax_value;
					$balanceOrderBookingDetail->cancel_fee_flag = $orderBookingDetail->cancel_fee_flag;
					$balanceOrderBookingDetail->cancel_fee_val = $orderBookingDetail->cancel_fee_value;
					$balanceOrderBookingDetail->save();

					//simpan data log disini
					$logExists = LogHotelRoomAllotment::where('mst023_id', '=', $pricing->mst023_id)
													->where('check_in_date', '=', $orderBookingDetail->check_in_date)
													->first();
					if($logExists){
						$logExists->used_allotment += $bookingData->totalRooms;
						$logExists->save();
					} else {
						$logHotelRoomAllotment = new LogHotelRoomAllotment();
						$logHotelRoomAllotment->mst023_id = $pricing->mst023_id;
						$logHotelRoomAllotment->check_in_date = $orderBookingDetail->check_in_date;
						$logHotelRoomAllotment->allotment = $pricing->allotment;
						$logHotelRoomAllotment->used_allotment = $bookingData->totalRooms;
						$logHotelRoomAllotment->save();
					}

				}

				$orderSummaryDetail->save();

				$balanceOrderBookingSummaryDetail->tot_commision_price = $orderSummaryDetail->tot_commision_price;
				$balanceOrderBookingSummaryDetail->tot_gross_price = $orderSummaryDetail->tot_gross_price;
				$balanceOrderBookingSummaryDetail->tot_disc = $orderSummaryDetail->tot_disc;
				$balanceOrderBookingSummaryDetail->tot_tax_base_price = $orderSummaryDetail->tot_tax_base_price;
				$balanceOrderBookingSummaryDetail->tot_tax_value = $orderSummaryDetail->tot_tax_value;
				$balanceOrderBookingSummaryDetail->tot_payment = $orderSummaryDetail->tot_payment;
				$balanceOrderBookingSummaryDetail->save();

				//simpan order booking nya
				//karena untuk sementara ini orderSummaryDetail tidak bersifat multi data untuk 1 cart
				$orderBooking->tot_commision_val = $orderSummaryDetail->tot_commision_price;
				$orderBooking->tot_gross_price = $orderSummaryDetail->tot_gross_price;
				$orderBooking->tot_disc = $orderSummaryDetail->tot_disc;
				$orderBooking->tot_tax_base_price = $orderSummaryDetail->tot_tax_base_price;
				$orderBooking->tot_tax_value = $orderSummaryDetail->tot_tax_value;
				$orderBooking->tot_payment = $orderSummaryDetail->tot_payment;
				$orderBooking->save();

				//BLNC001
				$balanceOrderBooking->tot_commision_val = $orderBooking->tot_commision_val;
				$balanceOrderBooking->tot_gross_price = $orderBooking->tot_gross_price;
				$balanceOrderBooking->tot_disc = $orderBooking->tot_disc;
				$balanceOrderBooking->tot_tax_base_price = $orderBooking->tot_tax_base_price;
				$balanceOrderBooking->tot_tax_value = $orderBooking->tot_tax_value;
				$balanceOrderBooking->tot_payment = $orderBooking->tot_payment;
				$balanceOrderBooking->save();

				//flag untuk kirim email jika menggunakan deposit
				$settledEmail = false;
				if($request->payment_method == 'Balance'){
					//potong deposit jika pembayarannya balance
					$deposit = BalanceAgentDeposit::where('mst001_id', '=', Auth::user()->id)->first();
					$deposit->used_value += $balanceOrderBooking->tot_payment;
					$deposit->save();

					//bikin data ke log deposit
					$logDeposit = new LogDeposit();
					$logDeposit->mst001_id = Auth::user()->id;
					$logDeposit->type = 'Used';
					$logDeposit->log_no = $balanceOrderBooking->order_no;
					$logDeposit->log_yrmo = date('Ym');
					$logDeposit->log_date = date('Ymd');
					$logDeposit->deposit_value = $balanceOrderBooking->tot_payment;
					$logDeposit->save();

					$settledEmail = true;

				}


			}

			//untuk kirim email ke hotel
			$mailParams = [
				'orderNumber' => $orderBooking->order_no,
				'bookingDate' => $orderBooking->order_date,
				'title' => $orderSummaryDetail->title,
				'firstName' => $orderSummaryDetail->first_name,
				'lastName' => $orderSummaryDetail->last_name,
				'hotelName' => $bookingData->hotel->hotel_name,
				'roomName' => $orderSummaryDetail->room_name,
				'roomNums' => $orderSummaryDetail->room_num,
				'checkInDate' => $orderSummaryDetail->check_in_date,
				'checkOutDate' => $orderSummaryDetail->check_out_date,
				'nights' => $orderSummaryDetail->night,
				'type' => $orderSummaryDetail->type,
				'numAdults' => $orderSummaryDetail->num_adults,
				'numChilds' => $orderSummaryDetail->num_child,
				'numBreakfast' => $orderSummaryDetail->num_breakfast,
				'nonSmokingFlag' => $orderSummaryDetail->non_smoking_flag,
				'interConnectionFlag' => $orderSummaryDetail->interconnetion_flag,
				'earlyCheckInFlag' => $orderSummaryDetail->early_check_in_flag,
				'lateCheckInFlag' => $orderSummaryDetail->late_check_in_flag,
				'highFloorFlag' => $orderSummaryDetail->high_floor_flag,
				'lowFloorFlag' => $orderSummaryDetail->low_floor_flag,
				'twinFlag' => $orderSummaryDetail->twin_flag,
				'honeymoonFlag' => $orderSummaryDetail->honeymoon_flag
			];

			//send email to hotel
			Mail::send('agent.booking.agent-booking-success-email-to-hotel',
				$mailParams,
				function($message) use ($request, $hotelDetail) {
				$message->to($hotelDetail->email, $hotelDetail->email)->subject('Booking for Order No ' . $orderBooking->order_no);
			});

			//untuk kirim email ke agent
			$mailParamsAgent = [
				'orderNumber' => $orderBooking->order_no,
				'bookingDate' => $orderBooking->order_date,
				'title' => $orderSummaryDetail->title,
				'firstName' => $orderSummaryDetail->first_name,
				'lastName' => $orderSummaryDetail->last_name,
				'hotelName' => $bookingData->hotel->hotel_name,
				'roomName' => $orderSummaryDetail->room_name,
				'roomNums' => $orderSummaryDetail->room_num,
				'checkInDate' => $orderSummaryDetail->check_in_date,
				'checkOutDate' => $orderSummaryDetail->check_out_date,
				'nights' => $orderSummaryDetail->night,
				'type' => $orderSummaryDetail->type,
				'numAdults' => $orderSummaryDetail->num_adults,
				'numChilds' => $orderSummaryDetail->num_child,
				'numBreakfast' => $orderSummaryDetail->num_breakfast,
				'nonSmokingFlag' => $orderSummaryDetail->non_smoking_flag,
				'interConnectionFlag' => $orderSummaryDetail->interconnetion_flag,
				'earlyCheckInFlag' => $orderSummaryDetail->early_check_in_flag,
				'lateCheckInFlag' => $orderSummaryDetail->late_check_in_flag,
				'highFloorFlag' => $orderSummaryDetail->high_floor_flag,
				'lowFloorFlag' => $orderSummaryDetail->low_floor_flag,
				'twinFlag' => $orderSummaryDetail->twin_flag,
				'honeymoonFlag' => $orderSummaryDetail->honeymoon_flag
			];

			//send email to agent
			Mail::send('agent.booking.agent-booking-success-email-to-agent',
				$mailParamsAgent,
				function($message) use ($request) {
				$message->to(Auth::user()->email, Auth::user()->email)->subject('Booking for Order No ' . $orderBooking->order_no);
			});


			//jika pembayarannya balance harus mengirimkan email
			if($settledEmail){
				$mailSettledPayment = [
					'invoiceNumber' => $orderBooking->order_no,
					'bookingHistoryLink' => url('agent/booking-history/order-detail/' . $orderBooking->order_no),
				];
				Mail::send('agent.booking.agent-booking-success-email-settled-payment',
					$mailSettledPayment,
					function($message) use ($request) {
					$message->to(Auth::user()->email, Auth::user()->email)->subject('Payment for Order No ' . $orderBooking->order_no);
				});
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

		if(Session::has('bookingData')){
			Session::forget('bookingData');
		}

		//return
		// echo 'sudah berhasil di simpan';
		return redirect('agent/booking/success')
				->with('data', $successInfo);
	}

	public function postConfirm2(Request $request){
		echo '<pre>';
		print_r($request->all());

		$bookingData = Session::all();
		print_r($bookingData);

		// $hotelRoomRate = HotelRoomRate::find($bookingData->rateId);
		// print_r($hotelRoomRate->toArray());
		// if($request)
	}

	public function getSuccess(Request $request)
	{
		$data = Session::get('data');
		return view('agent.booking.agent-booking-success')->with('data', $data);
	}



	private function validation(Request $request){

		$rules = array(
			'title'    			=> 'required|in:Mr,Mrs,Ms',
			'first_name'  => 'required',
			'last_name'   => 'required',
			'non_smoking_flag'   => 'required|in:Yes,No',
			'interconnetion_flag'   => 'required|in:Yes,No',
			'early_check_in_flag'   => 'required|in:Yes,No',
			'late_check_in_flag'   => 'required|in:Yes,No',
			'high_floor_flag'   => 'required|in:Yes,No',
			'low_floor_flag'   => 'required|in:Yes,No',
			'twin_flag'   => 'required|in:Yes,No',
			'honeymoon_flag'   => 'required|in:Yes,No',
			'payment_method'   => 'required|in:Balance,Transfer,CreditCard,PendingPayment',
			'card_type'   => 'required_if:payment_method,CreditCard|in:Visa,Master',
			'card_holder'   => 'required_if:payment_method,CreditCard',
			'card_number'   => 'required_if:payment_method,CreditCard',
			'card_identification_number'   => 'required_if:payment_method,CreditCard',
		);

		$messages = array(
			'title.required' => 'Hotel Name is required',
			'first_name.required' => 'Guest First Name is required',
			'last_name.required' => 'Guest Last Name is required',
			'non_smoking_flag.required' => 'Non smoking value must valid',
			'non_smoking_flag.in' => 'Non smoking value must valid',
			'interconnetion_flag.required' => 'Interconnection must valid',
			'interconnetion_flag.in' => 'Interconnection must valid',
			'early_check_in_flag.required' => 'Early check in must valid',
			'early_check_in_flag.in' => 'Early check in must valid',
			'late_check_in_flag.required' => 'Late check in must valid',
			'late_check_in_flag.in' => 'Late check in must valid',
			'high_floor_flag.required' => 'High floor must valid',
			'high_floor_flag.in' => 'High floor must valid',
			'low_floor_flag.required' => 'Low floor value must valid',
			'low_floor_flag.in' => 'Low floor must valid',
			'twin_flag.required' => 'Twin floor value must valid',
			'twin_flag.in' => 'Twin floor value must valid',
			'honeymoon_flag.required' => 'Honeymoon must valid',
			'honeymoon_flag.in' => 'Honeymoon must valid',
			'payment_method.required' => 'Payment method must valid must valid',
			'payment_method.in' => 'Payment method must valid must valid',
		);

		$v = Validator::make($request->all(), $rules, $messages);
		return $v;
	}

	private function requeryBookingRoom(){
		$query = " SELECT B.mst020_id, D.room_name, B.room_desc, G.num_adults, G.num_child, G.num_breakfast,
                             B.from_date, B.end_date, B.net_fee, B.net, B.cancel_fee_flag, B.cancel_fee_val,
                            COALESCE(E.allotment,B.allotment) AS allotment, B.allotment as rate_allotment, B.mst023_id,
                            B.comm_value, B.cut_off, B.bed_type,
                             CASE WHEN UPPER(?) = 'INDONESIA'
                                THEN B.nett_value
                                ELSE B.nett_value_wna
                             END as nett_value,
                             CASE WHEN UPPER(?) = 'INDONESIA'
                                THEN B.daily_price
                                ELSE B.daily_price_wna
                             END as daily_price,
							 B.surcharge_value as surcharge
                     FROM MST022 B
                     inner join MST023 D on D.id = B.mst023_id
                     left join (select A.mst023_id,Min(A.allotment-A.used_allotment) as allotment
                                from LOG020 A
                                inner join MST023 F on F.id = A.mst023_id
                                where F.mst020_id = ?
                                AND A.check_in_date between STR_TO_DATE(?, '%d-%m-%Y') and STR_TO_DATE(?, '%d-%m-%Y')) E
                                 on E.mst023_id = D.id
                     inner join (select X.mst023_id,MIN(X.num_breakfast) as num_breakfast,MIN(X.num_adults) as num_adults,MIN(X.num_child) as num_child
                                 from MST022 X
                                  WHERE
                                    (   X.from_date >= STR_TO_DATE(?, '%d-%m-%Y')
                                        OR
                                        X.end_date >= STR_TO_DATE(?, '%d-%m-%Y')
                                      )

                                     AND
                                      (
                                        X.end_date <= STR_TO_DATE(?, '%d-%m-%Y')
                                        OR
                                        X.from_date <= STR_TO_DATE(?, '%d-%m-%Y')
                                      )

                                     AND STR_TO_DATE(?, '%d-%m-%Y') >=
                                      (
                                        SELECT MIN(AD.from_date) FROM MST022 AD WHERE AD.mst023_id = X.mst023_id
                                      )

                                     AND STR_TO_DATE(?, '%d-%m-%Y') <=
                                      (
                                        SELECT MAX(AE.end_date) FROM MST022 AE WHERE AE.mst023_id = X.mst023_id
                                      )
                                     AND X.mst023_id = ?
                                     group by X.mst023_id)G ON G.mst023_id = D.id
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

	private function requeryBookingRoomOld(){
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
