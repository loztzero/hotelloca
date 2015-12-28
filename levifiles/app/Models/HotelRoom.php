<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Emodel;
class HotelRoom extends Emodel {
	protected $table = 'MST022';

	public function rules($data)
	{
		$error = array();
		$messages = array();

		$rules = array(
			'mst020_id'    => 'required',
			'room_id'      	=> 'required',
			'from_date'      	=> 'required',
			'end_date'      	=> 'required',
			'room_name'      	=> 'required',
			'bed_type'      	=> 'required',
			'breakfast_no'      	=> 'required',
			'allotment'      	=> 'required',
			'cut_off'      	=> 'required',
			'room_desc'      	=> 'required',
			'mst004_id'      	=> 'required',
			'price'      	=> 'required|numeric',
			// 'description'      	=> 'required',
		);

		$messages = array(
			'mst020_id.required' => 'Hotel detail data required',
			'room_id.required' => 'Room id required',
			'from_date.required' => 'Price from date must be filled',
			'end_date.required' => 'Price end date must be filled',
			'room_name.required' => 'Room name must be filled',
			'bed_type.required' => 'Bed type must be selected',
			'breakfast_no.required' => 'Number of breakfast required',
			'allotment.required' => 'Allotment required',
			'cut_off.required' => 'Cut off required',
			'room_desc.required' => 'Room description required',
			'mst004_id.required' => 'Currency must be selected',
			'price.required' => 'Price must be filled',
			'price.numeric' => 'Price must be number',
		);

		$v = Validator::make(Input::all(), $rules, $messages);
		if($v->fails()){
			$error = $v->errors()->all();
		}

		return $error;
	}

	public function $doParams($object, $data)
	{
		$object->mst020_id = $data['mst020_id'];
		$object->line_number = $data['line_number'];
		$object->pict = $data['pict'];
		$object->description = $data['description'];
		return $object;
	}
}