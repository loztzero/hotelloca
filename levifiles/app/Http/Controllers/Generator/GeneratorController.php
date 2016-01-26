<?php namespace App\Http\Controllers\Generator;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash, Form;
use App;
use App\User;
use App\Libraries\Helpers;
use DB;
use App\Http\Controllers\Controller;
class GeneratorController extends Controller {

	public function getIndex(){
		$tables = DB::select('SHOW TABLES');
		//echo '<pre>';
		echo '<form method="post" action="generator/generate">';
		echo '<input type="hidden" name="_token" value="'.csrf_token().'">';
		echo 'Table List : <select name="table">';
			foreach($tables as $table => $key){
				echo '<option value='.$key->Tables_in_hotelloca.'>'.$key->Tables_in_hotelloca.'</option>';
			}
		echo '</select><br>';
		echo 'Tentukan Nama Controller : <input type="text" name="controller" />';
		echo '<input type="submit" value="generate" />';
		echo '</form>';
	}

	public function postGenerate(Request $request){
		echo '<pre>';
		// print_r($request->all());
		$table = $request->table;
		$columns = DB::select("SHOW COLUMNS FROM ". $table);
		//print_r($columns);
		foreach($columns as $column=>$key){
			echo $key->Field;
			echo '<br>';
			echo $key->Type;
			echo '<br>';
			echo $key->Null;
			echo '<br><br>';
		}
	}


}
