<?php namespace App\Http\Controllers\Agent;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Input, Auth, Session, Redirect, Hash, DateTime;
use App;
use App\User;
use App\Libraries\Helpers;
use DB;
use App\Models\Country;
use App\Models\City;
use App\Models\ConfirmationPayment;
use App\Models\TempHotel;
use App\Models\TempHotelDetail;
use App\Models\Hotel;
use App\Models\HotelPic;
use App\Models\Agent;
use App\Models\HotelPicture;
use App\Models\HotelDetail;
use App\Models\HotelRoom;
use App\Models\HotelRoomRate;
use App\Http\Controllers\Controller;
use DateInterval, DatePeriod;
class BookingController extends Controller {

	public function getIndex(){
		return view('agent.booking.agent-booking');
	}

	public function postConfirm(Request $request){
		echo '<pre>';
		print_r($request->all());
	}

}
