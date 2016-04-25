<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Emodel;
class City extends Emodel {
	protected $table = 'MST003';

	public function locations()
	{
    	return $this->hasMany('App\Models\AreaLocation', 'mst003_id', 'id')->orderBy('area');
    }
}
