<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Emodel;
use Validator;
class HotelDetail extends Emodel {
	protected $table = 'MST020';

 	public function country()
    {
        return $this->hasOne('App\Models\Country', 'id', 'mst002_id');
    }

    public function city()
    {
        return $this->hasOne('App\Models\City', 'id', 'mst003_id');
    }

    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'mst001_id');
    }

    public function pictures()
    {
    	return $this->hasMany('App\Models\HotelPicture', 'mst020_id', 'id')->orderBy('line_number', 'desc');
    }

	public function rules($data)
	{
		$error = array();
		$messages = array();

		$rules = array(
			'hotel_name'    => 'required',
			'star'      	=> 'required',
			'address'      	=> 'required',
			'mst002_id'     => 'required',
			'mst003_id'     => 'required',
			//'postcode'      => 'required',
			'phone_number'  => 'required',
			//'fax_number'    => 'required',
			//'landmark_name' => 'required',
			//'email'      	=> 'required',
			//'website'      	=> 'required',
			'mst004_id'    	=> 'required',
			'meal_price'    => 'numeric',
			'bed_price'     => 'numeric',
			// 'market'      	=> 'required',
			// 'active_flg'    => 'required',
			// 'api_flg'      	=> 'required',
			// 'mst001_id'     => 'required',
		);

		$messages = array(
			'hotel_name.required' => 'Hotel Name is required',
			'star.required' => 'Star is required',
			'address.required' => 'Address is required',
			'mst002_id.required' => 'Country must be selected',
			'mst003_id.required' => 'City must be selected',
			'phone_number.required' => 'Phone number is required',
			'meal_price.numeric' => 'Meal price must be number',
			'bed_price.numeric' => 'Bed price must be number',
			'mst004_id.required' => 'Currency must be selected',
		);

		$v = Validator::make($data, $rules, $messages);
		if($v->fails()){
			$error = $v->errors()->all();
		}

		return $error;
	}

	public function rulesOwner($data)
	{
		$error = array();
		$messages = array();

		$rules = array(
			'hotel_name'    => 'required',
			'star'      	=> 'required',
			'address'      	=> 'required',
			'phone_number'  => 'required',
			'mst004_id'    	=> 'required',
			'meal_price'    => 'numeric',
			'bed_price'     => 'numeric',
		);

		$messages = array(
			'hotel_name.required' => 'Hotel Name is required',
			'star.required' => 'Star is required',
			'address.required' => 'Address is required',
			'phone_number.required' => 'Phone number is required',
			'meal_price.numeric' => 'Meal price must be number',
			'bed_price.numeric' => 'Bed price must be number',
			'mst004_id.required' => 'Currency must be selected',
		);

		$v = Validator::make($data, $rules, $messages);
		if($v->fails()){
			$error = $v->errors()->all();
		}

		return $error;
	}

	public function doParams($object, $data, $editMode = false)
	{
		$object->hotel_name = $data['hotel_name'];
		$object->hotel_id = isset($data['hotel_id']) ? $data['hotel_id'] : uniqid();
		$object->star = $data['star'];
		$object->address = $data['address'];
		$object->mst002_id = $data['mst002_id'];
		$object->mst003_id = $data['mst003_id'];
		$object->postcode = $data['postcode'];
		$object->phone_number = $data['phone_number'];
		$object->fax_number = $data['fax_number'];
		$object->landmark_name = $data['landmark_name'];
		$object->email = $data['email'];
		$object->website = $data['website'];
		$object->mst004_id = $data['mst004_id'];
		$object->meal_price = isset($data['meal_price']);
		$object->bed_price = isset($data['bed_price']);
		$object->market = isset($data['market']) ? $data['market'] : 'All';
		if($editMode == false){
			$object->active_flg = isset($data['active_flg']) ? $data['active_flg'] : 'Inactive';
			$object->api_flg = isset($data['api_flg']) ? $data['api_flg'] : 'No';
		}
		// $object->mst001_id = $data['mst001_id'];

		return $object;
	}

	//digunakan oleh hotel owner controller
	public function doParamsOwner($object, $data)
	{
		$object->star = $data['star'];
		$object->address = $data['address'];
		$object->postcode = $data['postcode'];
		$object->phone_number = $data['phone_number'];
		$object->fax_number = $data['fax_number'];
		$object->landmark_name = $data['landmark_name'];
		$object->email = $data['email'];
		$object->website = $data['website'];
		$object->mst004_id = $data['mst004_id'];
		$object->meal_price = isset($data['meal_price']);
		$object->bed_price = isset($data['bed_price']);
		$object->market = isset($data['market']) ? $data['market'] : 'All';
		return $object;
	}

}