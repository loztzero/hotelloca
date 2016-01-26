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
use App\Models\HotelDetail;
use App\Models\HotelRoom;
use App\Models\HotelRoomRate;
use App\Http\Controllers\Controller;
class RoomController extends Controller {

	//data room nanti datangnya dari post list hotel dari HotelController
	public function postIndex(Request $request){

		$hotelId = $request->hotel_id;
		$room = $request->room;
		$adults = $request->adults;
		$children = $request->children;
		$checkIn = $request->checkIn;
		$checkOut = $request->checkOut;

	}



}
