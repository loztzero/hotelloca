<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Input;
use App\Emodel;
use Validator;
use App\User;
use App\Config;
class Agent extends Emodel {
	protected $table = 'MST010';

    public function user(){
        return $this->hasOne('App\User', 'id', 'mst001_id');
    }

    public function city(){
        return $this->hasOne('App\Models\City', 'id', 'mst003_id');
    }

    public function country(){
        return $this->hasOne('App\Models\Country', 'id', 'mst002_id');
    }

	public static function rules($data){
		$error = array();
		$rules = array(
            'comp_name'      	=> 'required',
            'address'      		=> 'required',
            'postcode'      	=> 'required',
            'country'      	=> isset($data['id']) ? '' : 'required',
            'city'      	=> isset($data['id']) ? '' : 'required',
            'phone_number'      => 'required',
            'email'      		=> isset($data['id']) ? '' : 'required|email',
        );

		$messages = array(
            'comp_name.required'		=> 'Company name must be filled',
            'address.required'			=> 'Address must be filled',
            'postcode.required'			=> 'Post code must be filled',
            'country.required'		=> 'Country must be filled',
            'city.required'		    => 'City must be selected',
            'phone_number.required'		=> 'Phone number must be filled',
            'email.required'		=> 'Email must be filled',
            'email.email'			=> 'Email must valid',

		);
		
        $v = Validator::make($data, $rules, $messages);
        if($v->fails()){
    		$error = $v->errors()->all();
        }

        $email = isset($data['email']) ? $data['email'] : null;
        $user = User::where('email', '=', $email)->first();
        if($user != null){
        	$error = array_add($error, 'ada_bk', 'Email '.$email. ' already registered');
        }

		return $error;
	}

	public function doParams($model, $data)
	{
		$model->comp_name   = isset($data['comp_name']) ? $data['comp_name'] : null;
        $model->address     = isset($data['address']) ? $data['address'] : null;
        $model->postcode    = isset($data['postcode']) ? $data['postcode'] : null;

        if(!isset($data['id'])){
            $model->mst002_id   = isset($data['country']) ? $data['country'] : null;
            $model->mst003_id   = isset($data['city']) ? $data['city'] : null;
            $model->email       = isset($data['email']) ? $data['email'] : null;
            $model->active_flg  = config('enums.activeState.Active');
        }
        
        $model->phone_number    = isset($data['phone_number']) ? $data['phone_number'] : null;
        $model->fax_number = isset($data['fax_number']) ? $data['fax_number'] : null;
        $model->website     = isset($data['website']) ? $data['website'] : null;
        return $model;
	}

    //accesors
    public function getUserIdAttribute()
    {
        return $this->attributes['mst001_id'];
    }

    public function setUserIdAttribute($value)
    {
        $this->attributes['mst001_id'] = $value;
    }

}