<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;
use App\Emodel;
class HotelPicture extends Emodel {
	protected $table = 'MST021';

	public function rules(Request $request)
	{
		$error = array();
		$messages = array();

		$rules = array(
			'files'    => 'required|image|max:250|mimes:jpeg',
			'title'    => 'required',
		);

		$messages = array(
			'files.required' => 'Picture is required',
			'files.image' => 'Picture must be image',
			'files.mimes' => 'Picture must be jpg file',
			'files.smaxize' => 'Picture size can not more than :max kilobytes',
			'title.required' => 'Title is required',
		);

		// print_r($request->file('files')->getSize());
		// die();

		$v = Validator::make($request->all(), $rules, $messages);
		if($v->fails()){
			$error = $v->errors()->all();
			
		}

		return $error;
	}

	public function doParams($object, $uniqId, $idHotelDetail, Request $request)
	{
		$object->mst020_id = $idHotelDetail;
		$object->line_number = $this->getMaxLineNumber($idHotelDetail);
		$object->pict = $uniqId;
		$object->description = $request->title;
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