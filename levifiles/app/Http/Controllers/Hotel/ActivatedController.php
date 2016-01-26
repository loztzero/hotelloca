<?php namespace App\Http\Controllers\Hotel;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash;
use App;
use App\User as User;
use App\Libraries\Helpers;
use DB, Validator, File;
use App\Models\HotelDetail;
use App\Models\HotelFacility;
use App\Http\Controllers\Controller;
class ActivatedController extends Controller {

	public function __construct()
    {
        $activeHotel = HotelDetail::where('mst001_id', '=', Auth::user()->id)->first();
        if($activeHotel->active_flg != 'Active'){
        	Session::flash('error', 'Sorry Your Account Has not Activated yet, please contact our support');
	        return Redirect::to('/auth/logout')->send();	
        }

        // echo $activeHotel->active_flg;
    }

}
