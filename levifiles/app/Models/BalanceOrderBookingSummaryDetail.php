<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Emodel;
class BalanceOrderBookingSummaryDetail extends Emodel {
	protected $table = 'BLNC002';

	public function room()
    {
    	return $this->hasOne('App\Models\HotelRoom', 'id', 'mst023_id');
    }
}
