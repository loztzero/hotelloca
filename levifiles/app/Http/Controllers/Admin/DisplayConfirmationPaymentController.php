<?php namespace App\Http\Controllers\Admin;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash, Form;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, Config;
use App\Models\BalanceOrderBooking;
use App\Models\Currency;
use App\Models\Agent;
use App\Models\BalanceAgentDeposit;
use App\Models\LogDeposit;
use App\Models\PaymentConfirmation;
use App\Http\Controllers\Controller;
// use Illuminate\Pagination\Paginator;
class DisplayConfirmationPaymentController extends Controller {

	public function getIndex(Request $request)
	{

		// $paymentConfirmation = PaymentConfirmation::from()

        // $query = "select a.order_no, a.order_date, a.payment_val, a.transfer_date,
		// 			a.bank_transfer, a.account_transfer, a.name, a.note,
        //             b.status_flag, b.status_pymnt from TRX001 a
        //         	inner join BLNC001 b on a.order_no = b.order_no
        //             	and a.order_date = b.order_date
        //             where 1 = 1 ";

		$confirmations = PaymentConfirmation::from('TRX001 as a')
							->join('BLNC001 as b', 'a.order_no', '=', 'b.order_no')
							->select(DB::raw("a.order_no, a.order_date, a.payment_val, a.transfer_date,
										a.bank_transfer, a.account_transfer, a.name, a.note,
					                    b.status_flag, b.status_pymnt"));

		// $params = [];
		if($request->has('tranfer_date_from')){
			// $query .= ' and a.transfer_date >= ? ';
			// array_push($params, $request->tranfer_date_from);

			$confirmations = $confirmations->where('a.transfer_date', '>=', $request->transfer_date_from);
		}

		if($request->has('tranfer_date_to')){
			// $query .= ' and a.transfer_date <= ? ';
			// array_push($params, $request->tranfer_date_to);

			$confirmations = $confirmations->where('a.transfer_date', '>=', $request->tranfer_date_to);
		}

		if($request->has('order_no')){
			// $query .= ' and a.order_no = ? ';
			// array_push($params, $request->order_no);

			$confirmations = $confirmations->where('a.order_no', '=', $request->order_no);
		}

		if($request->has('order_date_from')){
			// $query .= ' and a.order_date >= ? ';
			// array_push($params, $request->order_date_from);

			$confirmations = $confirmations->where('a.order_date', '>=', $request->order_date_from);
		}

		if($request->has('order_date_to')){
			// $query .= ' and a.order_date <= ? ';
			// array_push($params, $request->order_date_to);

			$confirmations = $confirmations->where('a.order_date', '<=', $request->order_date_to);
		}

		// $query .= ' order by a.transfer_date desc ';
		$confirmations = $confirmations->orderBy('a.transfer_date', 'desc')->paginate(15);

		// $result = DB::select($query, $params);
		// $confirmations = new Paginator($result, count($result), 2);

		return view('admin.displayconfirmationpayment.admin-display-confirmation-payment-browse')
			->with('confirmations', $confirmations)
			->with('helpers', new Helpers());
			// ->with('depostiAgentList', $depositAgentList);
	}

}
