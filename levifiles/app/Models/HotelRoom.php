<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Emodel;
use Validator, DateTime;
class HotelRoom extends Emodel {
	protected $table = 'MST023';

	public function hotelDetail()
	{
		return $this->hasOne('App\Models\HotelDetail', 'id', 'mst020_id');
	}

	public function roomRates()
	{
		return $this->hasMany('App\Models\HotelRoomRate', 'mst023_id', 'id');
	}

	public function rules($request)
	{
		$error = array();
		$messages = array();

		$rules = array(
			'room_name'      	=> 'required',
			'num_adults'      	=> 'required|numeric',
			'num_child'      	=> 'required|numeric',
			'bed_type'      	=> 'required',
			'net'				=> 'required',
			'net_fee'			=> 'required|numeric',
			'num_breakfast'     => 'required|numeric',
			'room_desc'      	=> 'required',
			'image'    			=> 'image|max:1000|mimes:jpeg',
		);

		$messages = array(
			'room_name.required' => 'Room name must be filled',
			'num_adults.required' => 'Number of adults must be filled',
			'num_adults.numeric' => 'Number of adults must be numeric',
			'num_child.required' => 'Number of child must be filled',
			'num_child.numeric' => 'Number of child must be numeric',
			'bed_type.required' => 'Bed type must be selected',
			'net.required' => 'Is room get internet connection must be informed',
			'net_fee.required' => 'Room with net fee should be filled',
			'net_fee.numeric' => 'Net fee must be numeric',
			'num_breakfast.required' => 'Number of breakfast required',
			'room_desc.required' => 'Please fill few words about your room',
			'image.image' => 'Picture must be image',
			'image.mimes' => 'Picture must be jpg file',
			'image.maxsize' => 'Picture size can not more than :max kilobytes',
		);

		$v = Validator::make($request->all(), $rules, $messages);
		if($v->fails()){
			$error = $v->errors()->all();
		}

		return $error;
	}

	public function doParams($object, $data)
	{
		$object->mst020_id = $data['mst020_id'];
		$object->room_name = $data['room_name'];
		$object->num_adults = $data['num_adults'];
		$object->num_child = $data['num_child'];
		$object->bed_type = $data['bed_type'];
		$object->net = $data['net'];
		$object->net_fee = $data['net_fee'];
		$object->num_breakfast = $data['num_breakfast'];
		$object->room_desc = $data['room_desc'];
		$object->floor = isset($data['floor']) ? $data['floor'] : null;
		return $object;
	}
}
