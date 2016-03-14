<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Emodel;
class OrderSummaryDetail extends Emodel {
	protected $table = 'TRX011';

public function doParams($object, Request $request)
	{
		$object->daily_price = $request->daily_price;
		$object->num_breakfast = $request->num_breakfast;
		$object->tot_commision_price = $request->tot_commision_price;
		$object->tot_gross_price = $request->tot_gross_price;
		$object->tot_disc = $request->tot_disc;
		$object->tot_tax_base_price = $request->tot_tax_base_price;
		$object->tot_tax_value = $request->tot_tax_value;
		$object->tot_payment = $request->tot_payment;
		return $object;
	}

}