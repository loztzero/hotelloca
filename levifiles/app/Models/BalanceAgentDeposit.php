<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Emodel;
use Validator;
class BalanceAgentDeposit extends Emodel {
	protected $table = 'BLNC020';

	public function user()
    {
    	return $this->hasOne('App\User', 'id', 'mst001_id');
    }

	public function currency()
    {
    	return $this->hasOne('App\Models\Currency', 'id', 'mst004_id');
    }

	public function rules($data)
	{
		$error = array();
		$messages = array();

		$rules = array(
			'mst001_id'    		=> 'required',
			'mst004_id'    		=> 'required',
			'deposit_value'     => 'required|numeric|min:1',
		);

		$messages = array(
			'mst001_id.required'    	=> 'Agent not found',
			'mst004_id.required'    	=> 'Please select a currency',
			'deposit_value.required'    => 'Deposit value must be filled',
			'deposit_value.numeric'     => 'Deposit value must be number',
			'deposit_value.min'     	=> 'Deposit value must greater than 0',
		);

		$v = Validator::make($data, $rules, $messages);
		if($v->fails()){
			$error = $v->errors()->all();
		}

		return $error;
	}

	public function doParams($object, $data)
	{
		if(!empty($object->id)){
			$object->deposit_value += $data['deposit_value'];
		} else {
			$object->mst001_id = $data['mst001_id'];
			$object->mst004_id = $data['mst004_id'];
			$object->deposit_value = $data['deposit_value'];
		}
		return $object;
	}

}
