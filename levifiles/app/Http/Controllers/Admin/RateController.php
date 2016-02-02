<?php namespace App\Http\Controllers\Admin;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash, DB;
use App;
use App\User;
use App\Libraries\Helpers;
use App\Models\Currency;
use App\Models\AdminRate;
use App\Http\Controllers\Controller;
class RateController extends Controller {

	public function getIndex(Request $request){
		$rates = AdminRate::orderBy('daily_period', 'desc');

		try {
			if(isset($request->date_from) && !empty($request->date_from)){
				$date = Helpers::dateFormatter($request->date_from);
				$rates = $rates->where('daily_period', '>=', $date);
			}

			if(isset($request->date_end) && !empty($request->date_end)){
				$date = Helpers::dateFormatter($request->date_end);
				$rates = $rates->where('daily_period', '<=', $date);
			}
			
		} catch (\Exception $e) {
			Session::flash('error', array('Please use the correct format date on date period from or date period to'));
		}

		$rates = $rates->get();
		return view('admin.rate.admin-rate')
				->with('rates', $rates)
				->with('helpers', new Helpers());
	}

	public function getInput(){
		$currencies = Currency::orderBy('curr_name')->lists('curr_name', 'id');
		$idr = Currency::where('curr_name', '=', 'IDR')->first();
		return view('admin.rate.admin-rate-input')
				->with('currencies', $currencies)
				->with('idr', $idr);
	}

	public function postSave(Request $request){
		$data = $request->all();

		/*echo '<pre>';
		print_r($data);
		die();*/
		$adminRate = new AdminRate();
		$errorBag = $adminRate->rules($request->all());

		DB::beginTransaction();

		try {

			if(count($errorBag) > 0){
				DB::rollback();

				Session::flash('error', $errorBag);
	   			return Redirect::to('admin/rate/input')->withInput($request->all());

			} else {

				if(isset($request->id)){
					//edit mode
					$adminRate = AdminRate::find($request->id);
					if($adminRate == null){
						$adminRate = new AdminRate();
					}
				}

	    		$adminRate = $adminRate->doParams($adminRate, $data);
	        	$adminRate->save();

			}
			
		} catch (Exception $e) {
			
			DB::rollback();			
			Session::flash('error', array($e->getMessage()));
			return Redirect::to('admin/rate/input')->withInput(Input::all());
		}

		DB::commit();
    	Session::flash('message', array('Successfully saved today\'s rate '));
        return Redirect::to('admin/rate');
	}

	public function postLoadData(Request $request){
		// $passValue = $request->all();
		if(isset($request->id)){
			$rate = AdminRate::find($request->id);
			return Redirect::to('admin/rate/input')->withInput($rate->toArray());
		}
	}

}
