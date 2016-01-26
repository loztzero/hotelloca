<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;
use App\Emodel;
class HotelFacility extends Emodel {
	protected $table = 'MST024';

	public function rules(Request $request)
	{
		$error = array();
		$messages = array();

		$rules = array(
			'facility'    => 'required',
		);

		$messages = array(
			'facility.required' => 'Facility must be filled',
		);

		// print_r($request->file('files')->getSize());
		// die();

		$v = Validator::make($request->all(), $rules, $messages);
		if($v->fails()){
			$error = $v->errors()->all();
			
		}

		return $error;
	}

	public function doParams($object, Request $request)
	{
		$object->facility = $request->facility;
		return $object;
	}

	private function getMaxLineNumber($idHotelDetail){
		$lineNumber = HotelPicture::where('mst020_id', '=', $idHotelDetail)
		->max('line_number');
		// ->get('line_number');

		// print_r($lineNumber);
		// die();

		if($lineNumber){
			return $lineNumber + 1;
		} else {
			return 1;
		}
	}
}