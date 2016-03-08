<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Emodel;
use DB;
class LogHotelRoomAllotment extends Emodel {
	protected $table = 'LOG020';


	public function getMinAllotment($roomId, $checkIn, $checkOut){

		$params = array($roomId, $checkIn, $checkOut);
		$query = 'select min(allotment - used_allotment) as allotment from LOG020 where mst023_id = ? 
					and check_in_date between ? and ? ';
		$result = DB::select($query, $params);

		return $result[0]->allotment;

	}
}