<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Emodel;
class BalanceOrderBooking extends Emodel {
	protected $table = 'BLNC001';

	public function agent()
	{
		return $this->hasOne('App\User', 'id', 'mst001_id');
	}

	public function currency()
	{
		return $this->hasOne('App\Models\Currency', 'id', 'mst004_id');
	}

}
