<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Emodel;
use Validator, DateTime, DB;
class HotelRoomRate extends Emodel {
	protected $table = 'MST022';

	public function room()
    {
        return $this->hasOne('App\Models\HotelRoom', 'id', 'mst023_id');
    }

	public function rules($request)
	{
		$error = array();
		$messages = array();

		$rules = array(
			// 'mst020_id'    => 'required',
			// 'room_id'      	=> 'required',
			'date_from'      	=> 'required|date_format:"d-m-Y"',
			'date_to'      	=> 'required|date_format:"d-m-Y"|after:date_from',
			'mst023_id'      	=> 'required',
			'num_adults'      	=> 'required|numeric',
			'num_child'      	=> 'required|numeric',
			'bed_type'      	=> 'required',
			'net'			=> 'required',
			'net_fee'			=> 'required|numeric',
			'num_breakfast'      	=> 'required|numeric',
			'allotment'      	=> 'required|numeric',
			'cut_off'      	=> 'required|numeric',
			'all_market_flg' 	=> 'required|in:Yes,No',
			'cancel_fee_flag' 	=> 'required|in:Yes,No',
			'cancel_fee_val' 	=> 'numeric',
			'room_desc'      	=> 'required',
			// 'mst004_id'      	=> 'required',
			'rate_type'      	=> !isset($request->id) ? 'required' : '',
			'daily_price'      	=> 'required|numeric',
			'daily_price_wna'      	=> 'required|numeric',
			'comm_type'      	=> !isset($request->id) ? 'required_if:rate_type,"Commision"' : '',
			'comm_pct'      	=> !isset($request->id) ? 'required_if:comm_type,"percentage"|numeric' : '',
			'comm_value'      	=> !isset($request->id) ? 'required_if:comm_type,"value"|numeric' : '',

			// 'image'    => 'image|max:250|mimes:jpeg',

			// 'description'      	=> 'required',
		);

		$messages = array(
			// 'mst020_id.required' => 'Hotel detail data required',
			// 'room_id.required' => 'Room id required',
			'date_from.required' => 'Price from date must be filled',
			'date_to.required' => 'Price end date must be filled',
			'date_to.after' => 'Period End must greater than Period Start',
			'mst023_id.required' => 'Room name must be selected',
			'num_adults.required' => 'Number of adults must be filled',
			'num_adults.numeric' => 'Number of adults must be numeric',
			'num_child.required' => 'Number of child must be filled',
			'num_child.numeric' => 'Number of child must be numeric',
			'bed_type.required' => 'Bed type must be selected',
			'net.required' => 'Is room get internet connection must be informed',
			'net_fee.required' => 'Room with net fee should be filled',
			'num_breakfast.required' => 'Number of breakfast required',
			'allotment.required' => 'Allotment required',
			'cut_off.required' => 'Cut off required',
			'room_desc.required' => 'Please fill few words about your room',
			// 'mst004_id.required' => 'Currency must be selected',
			'rate_type.required' => 'Rate type must be selected',
			'all_market_flg.required' => 'All market flag must be filled',
			'all_market_flg.in' => 'All market flag value must be Yes or No',
			'cancel_fee_flag.required' => 'Cancel fee flag must be filled',
			'cancel_fee_flag.in' => 'Cancel fee flag value must be Yes or No',
			'daily_price.required' => 'Daily price must be filled',
			'daily_price.numeric' => 'Daily price must be numeric',
			'daily_price_wna.required' => 'Daily price foreign must be filled',
			'daily_price_wna.numeric' => 'Daily price foreign must be numeric',

			'comm_type.required_if' => 'Commission type must be selected',
			'comm_pct.required_if' => 'Commission percentage must be filled',
			'comm_pct.numeric' => 'Commission type must be numeric',
			'comm_value.required_if' => 'Commision value must be filled',
			'comm_value.numeric' => 'Commision value must be filled', 

			// 'image.required' => 'Picture is required',
			// 'image.image' => 'Picture must be image',
			// 'image.mimes' => 'Picture must be jpg file',
			// 'image.maxsize' => 'Picture size can not more than :max kilobytes',
		);

		$v = Validator::make($request->all(), $rules, $messages);
		if($v->fails()){
			$error = $v->errors()->all();
		} else {

			$endDate = DateTime::createFromFormat('d-m-Y', $request->date_to)->format('Y-m-d');
			$exists = HotelRoomRate::where('mst023_id', '=', $request->mst023_id)
						->where('end_date', '=', $endDate)
						->first();
			if($exists){
				if($exists->id != $request->id){
					$error = array_add($error, 'exists', 'Room name and end date already exists, please change to other');
				}
			} 

			//cek apakah  tanggalnya terdaftar di periode yang sudah ada atau belum
			$dateFrom = DateTime::createFromFormat('d-m-Y', $request->date_from)->format('Y-m-d');
			$dateTo = DateTime::createFromFormat('d-m-Y', $request->date_to)->format('Y-m-d');

			// $countExists = DB::statement('select count(id) from MST022 where mst023_id = "'.$request->mst023_id.'" and "$dateFrom" between from_date and end_date');

			// print_r($countExists);
			// die();

			$fromExists = HotelRoomRate::where('mst023_id', $request->mst023_id)
						->whereRaw(" STR_TO_DATE(?, '%Y-%m-%d') between from_date and end_date", [$dateFrom])
						->first();

			// $countExists2 = DB::statement('select count(id) from MST022 where mst023_id = "'.$request->mst023_id.'" and "$dateTo" between from_date and end_date');
			$toExists = HotelRoomRate::where('mst023_id', $request->mst023_id)
						->whereRaw(" STR_TO_DATE(?, '%Y-%m-%d') between from_date and end_date", [$dateTo])
						->first();

			// DB::connection()->enableQueryLog();
			// print_r(DB::getQueryLog());
			// die();

			// echo $countExists;
			// echo ' - ' . $dateFrom;
			// die();
			if($fromExists){
				if(isset($request->id)){

					if($fromExists->id != $request->id){
						$error = array_add($error, 'exists_from', 'This from date is not valid and already exists between in a period ');
					}

				} else {
					$error = array_add($error, 'exists_from', 'This from date is not valid and already exists between in a period ');
				}
			}

			if($toExists){
				if(isset($request->id)){

					if($toExists->id != $request->id){
						$error = array_add($error, 'exists_to', 'This end date is not valid and already exists between in a period ');
					}
					
				} else {
					$error = array_add($error, 'exists_to', 'This end date is not valid and already exists between in a period ');
				}
				
			}
				

		}

		return $error;
	}

	public function doParams($object, $data)
	{
		$object->mst020_id = $data['mst020_id'];
/*		if(!isset($object->id)){
			$object->room_id = uniqid();
		}*/
		$object->from_date = DateTime::createFromFormat('d-m-Y', $data['date_from'])->format('Y-m-d');
		$object->end_date = DateTime::createFromFormat('d-m-Y', $data['date_to'])->format('Y-m-d');
		$object->mst023_id = $data['mst023_id'];
		$object->num_adults = $data['num_adults'];
		$object->num_child = $data['num_child'];
		$object->bed_type = $data['bed_type'];
		$object->net = $data['net'];
		$object->net_fee = $data['net_fee'];
		$object->num_breakfast = $data['num_breakfast'];
		$object->cut_off = $data['cut_off'];
		$object->allotment = $data['allotment'];
		$object->room_desc = $data['room_desc'];
		// $object->mst004_id = 'rp';
		if(!isset($object->id)){
			$object->rate_type = $data['rate_type'];
			$object->comm_type = $data['rate_type'] == 'Nett' ? null : isset($data['comm_type']) ? $data['comm_type'] : null ;
		}
		$object->daily_price = $data['daily_price'];
		if(!isset($object->id)){
			if(isset($object->comm_type)){
				// print_r($object->comm_type);
				// die();
				if($object->comm_type == '%'){
					$object->comm_pct = $data['comm_pct'];
					$object->comm_value = 0;
				} else if($object->comm_type == 'Value'){
					$object->comm_pct = 0;
					$object->comm_value = $data['comm_value'];
				}
			}
		}

		$object->all_market_flg = $data['all_market_flg'];
		if($object->all_market_flg == 'Yes'){
			$object->daily_price_wna = $data['daily_price'];
		} else {
			$object->daily_price_wna = $data['daily_price_wna'];
		}

		$object->cancel_fee_flag = $data['cancel_fee_flag'];
		if($object->cancel_fee_flag == 'Yes'){
			$object->cancel_fee_val = $data['cancel_fee_val'];
		} else {
			$object->cancel_fee_val = 0;
		}

		$object->nett_value = 0;
		$object->nett_value_wna = 0;
		if($object->rate_type == 'Nett'){
			$object->nett_value = $object->daily_price + ($object->daily_price * 0.1);
			$object->nett_value_wna = $object->daily_price_wna + ($object->daily_price_wna * 0.1);
		} else {

			if($object->rate_type == 'Commision' && $object->comm_type == '%'){
				$object->nett_value = $object->daily_price + ($object->daily_price * $object->comm_pct);
				$object->nett_value_wna = $object->daily_price_wna + ($object->daily_price_wna * $object->comm_pct);

			} else if($object->rate_type == 'Commision' && $object->comm_type == 'Value'){
				$object->nett_value = $object->daily_price + $object->comm_value;
				$object->nett_value_wna = $object->daily_price_wna + ($object->daily_price_wna * $object->comm_pct);

			}

		}


		
		return $object;
	}
}