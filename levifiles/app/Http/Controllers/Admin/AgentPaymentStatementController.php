<?php namespace App\Http\Controllers\Admin;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash, Form;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, Config;
use App\Models\Country;
use App\Models\City;
use App\Models\ConfirmationPayment;
use App\Models\Currency;
use App\Models\HotelDetail;
use App\Models\BalanceOrderBooking;
use App\Models\BalanceOrderBookingSummaryDetail;
use App\Models\BalanceOrderBookingDetail;
use App\Models\LogHotelRoomAllotment;
use App\Http\Controllers\Controller;
class AgentPaymentStatementController  extends Controller {

	public function getIndex(Request $request)
	{
		// echo $request->has('kambing');
		$paymentList = $this->getPaymentList($request);
		return view('admin.agentpaymentstatement.admin-agent-payment-statement-browse')
				->with('paymentList', $paymentList)
				->with('helpers', new Helpers());
	}

	private function getPaymentList(Request $request)
	{

		//payment agent dilihat nya dari order booking - blnc001
		// $balanceOrderBooking =
		$query = BalanceOrderBooking::from('BLNC001 as a')
				->join('MST001 as b', 'a.mst001_id', '=', 'b.id')
				->join('BLNC002 as c', 'a.id', '=', 'c.blnc001_id')
				->join('MST020 as d', 'c.mst020_id', '=', 'd.id')
				->join('MST004 as e', 'a.mst004_id', '=', 'e.id');

		if($request->has('order_no')){
			$query = $query->where('a.order_no', 'like', $request->order_no);
		}

		if($request->has('start_date')){
			if(Helpers::isValidDateFormat($request->start_date)){
				$query = $query->where('a.order_date', '>=', Helpers::dateFormatter($request->start_date));
			}
		}

		if($request->has('end_date')){
			if(Helpers::isValidDateFormat($request->end_date)){
				$query = $query->where('a.order_date', '<=', Helpers::dateFormatter($request->end_date));
			}
		}

		if($request->has('agent')){
			$query = $query->where('b.email', '=', $request->agent);
		}

		if($request->has('hotel')){
			$query = $query->where('d.hotel_name', '=', $request->hotel);
		}

		if($request->has('status_payment')){
			$query = $query->where('a.status_pymnt', '=', $request->status_payment);
		}

		if($request->has('status_flag')){
			$query = $query->where('a.status_flag', '=', $request->status_flag);
		}

		$result = $query->select('a.*', 'd.hotel_name', 'e.curr_code');
		$result = $query->get();

		return $result;

	}

	public function getChangeStatus($id){
		$balanceOrder = BalanceOrderBooking::find($id);
		if($balanceOrder){

			if($balanceOrder->status_pymnt != 'Pending'){
				Session::flash('error', array('Please provide a valid data'));
				return Redirect::to('admin/agent-payment-statement');
			}

			$balanceOrderBookingSummaryDetail = BalanceOrderBookingSummaryDetail::where('blnc001_id', '=', $balanceOrder->id)->first();
			return view('admin.agentpaymentstatement.admin-agent-payment-statement-change-status')
					->with('balanceOrder', $balanceOrder)
					->with('balanceOrderBookingSummaryDetail', $balanceOrderBookingSummaryDetail)
					->with('helpers', new Helpers());;

		} else {
			Session::flash('error', array('Please provide a valid data'));
			return Redirect::to('admin/agent-payment-statement');
		}

	}

	//WARNING DISINI SAMPLE TERBAIK UNTUK MELAKUKAN VALIDASI LANGSUNG DARI controller
	//CEK MESSAGE HELPER NYA JUGA YA
	public function postSaveChangedStatus(Request $request){

		$this->validate($request, [
	        'id' => 'required',
	        'status_payment' => 'required|in:Failed,Done',
	    ], $this->messages());

		$balanceOrder = BalanceOrderBooking::find($request->id);
		if($balanceOrder){
			// if($request->status_payment)
			$balanceOrder->status_pymnt = $request->status_payment;
			if($balanceOrder->status_pymnt == 'Failed') {
				$balanceOrder->status_flag = 'Cancel';

				//$balanceOrderBookingDetails = BalanceOrderBookingDetail::where('balance')

				//mau minusin delete flag nya,
				//ambil ke table blnc004 berdasarkan blnc002
				$balanceOrderBookingSummaryDetails = BalanceOrderBookingSummaryDetail::where('blnc001_id', '=', $balanceOrder->id)->get();
				foreach ($balanceOrderBookingSummaryDetails as $summaryDetail) {
					$balanceOrderBookingDetails = BalanceOrderBookingDetail::where('blnc002_id', '=', $summaryDetail->id)->get();
					foreach ($balanceOrderBookingDetails as $details) {

						//minus used allotment karena status payment nya fail
						$logAllotment = LogHotelRoomAllotment::where('mst023_id', '=', $summaryDetail->mst023_id)
										->where('check_in_date', '=', $details->check_in_date)
										->first();
						$logAllotment->used_allotment = $logAllotment->used_allotment - 1;
						$logAllotment->save();
					}
				}


			} elseif($balanceOrder->status_pymnt == 'Done') {
				$balanceOrder->status_flag = 'Confirm';
			}

			$balanceOrder->save();
			Session::flash('message', array('The agent payment statement with number <b>'.$balanceOrder->order_no.'</b> has been changed'));
			return Redirect::to('admin/agent-payment-statement');
		}

		Session::flash('error', array('Please provide a valid data'));
		return Redirect::to('admin/agent-payment-statement');
	}

	public function messages(){
	    return [
	        'id.required' => 'Data is not valid',
	    ];
	}

}
