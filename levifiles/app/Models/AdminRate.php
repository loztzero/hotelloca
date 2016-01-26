<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libraries\Helpers;
use App\Emodel;
use Validator;
class AdminRate extends Emodel {
	protected $table = 'MST005';

	public function currency1()
    {
        return $this->hasOne('App\Models\Currency', 'id', 'curr1_id');
    }

    public function currency2()
    {
        return $this->hasOne('App\Models\Currency', 'id', 'curr2_id');
    }

    public function rules($data)
	{
		$error = array();
		$messages = array();

		$rules = array(
			'curr1_id'    => 'required|different:curr2_id',
			//'kurs1_val'   => 'required|numeric|min:1',
			//'curr2_id'    => 'required|different:curr1_id',
			'kurs2_val'   => 'required|numeric|min:1',
		);

		$messages = array(
			'curr1_id.required' => 'Currency 1 must be selected',
			'curr1_id.different' => 'Currency 1 must different with currency 2',
			//'kurs1_val.required' => 'Currency 1 value must be filled',
			//'kurs1_val.numeric' => 'Currency 1 value must be numeric',
			//'kurs1_val.min' => 'Currency 1 value must greater than 0',
			//'curr2_id.required' => 'Currency 2 must be selected',
			'kurs2_val.required' => 'Currency 2 value must be filled',
			'kurs2_val.numeric' => 'Currency 2 value must be numeric',
			'kurs2_val.min' => 'Currency 2 value must greater than 0',
		);

		$v = Validator::make($data, $rules, $messages);
		if($v->fails()){
			$error = $v->errors()->all();
		} else {
			$adminRate = AdminRate::where('curr1_id', '=', $data['curr1_id'])
						->where('curr2_id', '=', $data['curr2_id'])
						->where('daily_period', '=', date('Y-m-d'))
						->first();

			if($adminRate){
				if($adminRate->id != $data['id']){
					$error = array_add($error, 'bkExists', 'Data with currency 1 and currency 2 already existed, please change to another currency');
				}
			}
		}

		return $error;
	}

	public function doParams($object, $data)
	{
		if(!isset($data['id'])){
			$object->daily_period = date('Y-m-d');
		}
		$object->curr1_id = $data['curr1_id'];
		$object->kurs1_val = 1;
		$object->curr2_id = $data['curr2_id'];
		$object->kurs2_val = $data['kurs2_val'];
		return $object;
	}

}