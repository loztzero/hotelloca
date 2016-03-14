<?php namespace App\Http\Controllers\Admin;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash, Form;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, Config;
use App\Models\Country;
use App\Models\City;
use App\Models\ConfirmationPayment;
use App\Models\Currency;
use App\Models\HotelDetail;
use App\Models\HotelPicture;
use App\Models\AdminRate;
use App\Http\Controllers\Controller;
class ReportBookingController extends Controller {

	public function getIndex(Request $request)
	{
		return view('admin.reportbooking.admin-report-booking');
	}

}
