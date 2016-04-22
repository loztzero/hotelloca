<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Emodel;
use DB;
class LogDeposit extends Emodel {
	protected $table = 'LOG010';

	public function getMaxCounter(){
		$record = LogDeposit::where('log_no', 'like', 'add' . date('Ymd').'%')->max('log_no');

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
