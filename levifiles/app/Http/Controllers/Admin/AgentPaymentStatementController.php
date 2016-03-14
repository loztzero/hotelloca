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
		$query = BalanceOrderBooking::where('order_no', 'like', $request->input('order_no', '%'));
		if($request->has('start_date')){
			$query = $query->where('order_date', '>=', $request->start_date);
		}

		if($request->has('end_date')){
			$query = $query->where('order_date', '<=', $request->end_date);
		}

		if($request->has('hotel')){
			$query = $query->where('mst001_id', '=', $request->hotel);
		}

		$result = $query->get();

		return $result;

	}

}
