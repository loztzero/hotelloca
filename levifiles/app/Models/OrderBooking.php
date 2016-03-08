<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Emodel;
class OrderBooking extends Emodel {
	protected $table = 'TRX010';

	public function doParams($object, Request $request)
	{
		$object->order_no = date('Ymd') . $this->getMaxCounter();
		$object->order_yrmo = date('Ym');
		$object->order_date = date('Ymd');
		$object->tot_base_price = $request->tot_base_price;
		$object->tot_commision_val  = $request->tot_commision_val;
		$object->tot_gross_price = $request->tot_gross_price;
		$object->disc_value = $request->disc_value;
		$object->tot_tax_base_price = $request->tot_tax_base_price;
		$object->tot_tax_value = $request->tot_tax_value;
		$object->tot_payment = $request->tot_payment;
		return $object;
	}

	public function getMaxCounter(){
		$record = OrderBooking::where('order_no', 'like', date('Ymd').'%')->max('order_no');
		
		if($record){

			$number = intval(substr($record, -4)) + 1;
			$newNumber = '0001';
			if($number < 10){
				$newNumber = '000'.$number;
			} else if($number < 100) {
				$newNumber = '00'.$number;
			} else if($number < 1000) {
				$newNumber = '0'.$number;
			} else {
				$newNumber = $number;
			}

			return $newNumber;

		} else {

			return '0001';
		}
	}

}