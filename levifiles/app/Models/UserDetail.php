<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Input;
use App\Emodel;
class UserDetail extends Emodel {
	protected $table = 'MST003';

	public function doParams($model, $data)
	{
		//$data = Input::all();
		$model->address1 = isset($data['address1']) ? $data['address1'] : null;
		$model->address2 = isset($data['address2']) ? $data['address2'] : null;
		$model->address3 = isset($data['address3']) ? $data['address3'] : null;
		$model->city = isset($data['city']) ? $data['city'] : null;
		$model->country = isset($data['country']) ? $data['country'] : null;
		$model->zip_code = isset($data['zipCode']) ? $data['zipCode'] : null;
		$model->description = isset($data['description']) ? $data['description'] : null;
		
		return $model;
	}

}