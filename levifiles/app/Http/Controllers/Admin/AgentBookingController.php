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
use App\Models\HotelPicture;
use App\Models\AdminRate;
use App\Http\Controllers\Controller;
use App\Models\BalanceOrderBooking;
class AgentBookingController extends Controller {

	public function getIndex(Request $request)
	{
		$query = BalanceOrderBooking::from('BLNC001 as a')
						->join('BLNC002 as b', 'b.blnc001_id', '=', 'a.id')
						->join('MST020 as c', 'c.id', '=', 'b.mst020_id')
						->leftJoin('TRX001 as d', 'd.order_no', '=', 'a.order_no');


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
					       'd.transfer_date', 'a.status_flag', 'a.tot_payment');
		$result = $query->paginate(20);
		$result->setPath(url('admin/agent-booking')); //buat handle error paginasi pada laravel nya
		// $bookingList = DB::select($this->queryBooking($request), $params);

		$countries = Country::where('country_name', '=', 'Indonesia')->orderBy('country_name', 'asc')->lists('country_name', 'id');
		return view('admin.agentbooking.admin-agent-booking-browse')
				->with('countries', $countries)
				->with('bookingList', $result);
	}

}
