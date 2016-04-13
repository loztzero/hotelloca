<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Emodel;
class OrderBookingDetailPayment extends Emodel {
	protected $table = 'TRX012';

	public function doParams($object, Request $request)
	{
		$object->check_in_date = $request->check_in_date;
		$object->cut_off = $request->cut_off;
		$object->daily_price = $request->daily_price;
		$object->nett_value = $request->nett_value;
		$object->tot_base_price = $request->tot_base_price;
		$object->commision_value = $request->commision_value;
		$object->disc = $request->disc;
		$object->tax_base_price = $request->tax_base_price;
		$object->tax_value = $request->tax_value;
		$object->tot_payment = $request->tot_payment;
		$object->cancel_fee_flag = $request->cancel_fee_flag;
		$object->cancel_fee_val = $request->cancel_fee_val;
		return $object;
	}

}
