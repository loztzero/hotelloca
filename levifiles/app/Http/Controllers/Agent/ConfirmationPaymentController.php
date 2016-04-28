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
use App\Models\PaymentConfirmation;
use App\Models\PaymentConfirmationRate;
use App\Models\BalanceOrderBooking;
use App\Models\BalanceAgentDeposit;
use App\Models\BalanceOrderBookingPayment;
use App\Models\LogDeposit;
use App\Models\LogCancel;
use App\Models\OrderBooking;
use App\Models\OrderBookingDetailPayment;
use App\Http\Controllers\Controller;
use DateInterval, DatePeriod;
class ConfirmationPaymentController extends Controller {

	public function getIndex(Request $request){
        return view('agent.confirmationpayment.agent-confirmation-payment');
	}

	public function postIndex(Request $request){

		if($request->has('order_no')){

			$date = $this->getBalanceOrderDate($request->order_no);
			if($date){
				return Redirect::to('agent/confirmation-payment')
				->withInput(array('order_no' => $request->order_no, 'order_date' => $date));
			}
		}

		return Redirect::to('agent/confirmation-payment');

	}

    public function postSave(Request $request){
		$paymentConfirmation = new PaymentConfirmation();
		$errorBag = $paymentConfirmation->rules($request);

		DB::beginTransaction();

		try {

			if(count($errorBag) > 0){

				DB::rollback();
				Session::flash('error', $errorBag);
	   			return Redirect::to('agent/confirmation-payment')->withInput($request->all());

			} else {

				$balanceOrderBooking = BalanceOrderBooking::where('order_no', '=', $request->order_no)->first();
				if(!$balanceOrderBooking){
					Session::flash('error', array('Confirmation number is not valid'));
		   			return Redirect::to('agent/confirmation-payment')->withInput($request->all());
				} else {

					$isError = true;
					$balanceOrderBookingPayment = balanceOrderBookingPayment::where('blnc001_id', '=', $balanceOrderBooking->id)->first();
					if($balanceOrderBookingPayment){
						$balanceOrderBookingPayment->payment_method == 'Transfer';
						$isError = false;

						$balanceOrderBookingPayment->conf_payment_date = DB::raw('now()');
						$balanceOrderBookingPayment->save();
					}

					if($isError){
						Session::flash('error', array('Confirmation number is not valid'));
						return Redirect::to('agent/confirmation-payment')->withInput($request->all());
					}
				}

				$paymentConfirmation = new PaymentConfirmation();
	    		$paymentConfirmation = $paymentConfirmation->doParams($paymentConfirmation, $request);
	        	$paymentConfirmation->save();

			}

		} catch (Exception $e) {

			DB::rollback();
			Session::flash('error', array($e->getMessage()));
			return Redirect::to('agent/confirmation-payment')->withInput($request->all());
		}

		DB::commit();
    	Session::flash('message', array('Thank you for your confirmation payment, we will check and proceed it.'));
        return Redirect::to('agent/confirmation-payment');
    }

    public function getBalanceOrderDate($orderNumber){
        $order = BalanceOrderBooking::where('order_no', '=', $orderNumber)->first();
        if($order){
            return date('d-m-Y', strtotime($order->order_date));
        }
    }


}
