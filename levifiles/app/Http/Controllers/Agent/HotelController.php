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
class HotelController extends Controller {

	public function getIndex(){

		$indonesia = Country::where('country_name', '=', 'Indonesia')->first();
        $countries = Country::orderBy('country_name', 'asc')->lists('country_name', 'id');
		return view('agent.hotel.agent-hotel-browse')->with('countries', $countries)->with('indonesia', $indonesia);
	}

	public function getBasicSearchHotel(){
		$indonesia = Country::where('country_name', '=', 'Indonesia')->first();
        $countries = Country::lists('country_name', 'country_name');
		return view('agent.hotel.agent-hotel-basic-search')->with('countries', $countries)->with('indonesia', $indonesia);	
	}

	public function getSearch(Request $request){
		$hotels = $this->querySearch($request);
		return view('agent.hotel.agent-hotel-search')->with('hotels', $hotels);
	}

	//untuk query search hotel
	private function querySearch(Request $request){
		$city = $request->city;
		$country = $request->country;
		$checkIn = $request->checkIn;
		$checkOut = $request->checkOut;
		
		$checkIn = Helpers::dateFormatter($checkIn);
		$checkOut = Helpers::dateFormatter($checkOut);
		//$rooms = HotelRoom::join('mst020', 'mst020.id', '=', 'mst020_id')->get();
		/*$rooms = HotelRoom::with('hotelDetail', function($q){
					$q->where('hotel_name', 'like', '%');
				 })->get();*/

		$query = "
			select a.*, j.pict, h.nett_value
			from MST020 a	
			inner join 
			(
				select c.mst020_id, c.nett_value, c.rate_type, c.comm_type, 
				c.comm_pct,c.comm_value,c.num_adults,c.allotment,
				c.from_date, c.end_date
				from MST022 c 
				where c.id = 
				( 
					select min(f.id) 
					from MST022 f 
					where f.mst020_id = c.mst020_id
					and f.nett_value = 
					(
						select min(g.nett_value) 
						from MST022 g 
						where g.mst020_id =f.mst020_id
					)
				)

				and c.num_adults >= 0 
				and c.allotment-c.used_allotment >= 0 
				and (
						c.from_date >= STR_TO_DATE(?, '%Y-%m-%d') 
						or 
						c.end_date >= STR_TO_DATE(?, '%Y-%m-%d') 
					)
				and (
						c.end_date <= STR_TO_DATE(?, '%Y-%m-%d') 
						or 
						c.from_date <= STR_TO_DATE(?, '%Y-%m-%d') 
					)
				and STR_TO_DATE(?, '%Y-%m-%d') >= 
				(
					select min(ab.from_date) 
					from MST022 ab 
					where ab.mst020_id = c.mst020_id
				)
				and STR_TO_DATE(?, '%Y-%m-%d')  <= 
				(
					select max(ac.end_date) 
					from MST022 ac 
					where ac.mst020_id = c.mst020_id
				)
			) as h on h.mst020_id = a.id 

			left join 
			(
				select e.pict,e.mst020_id as mst020_id
				from MST021 e 
				where e.line_number =
				(
					select max(f.line_number) 
					from MST021 f 
					where f.mst020_id = e.mst020_id
				)
			) as j on j.mst020_id = a.id
			where a.mst002_id = ?
		";

		$params = array($checkIn, $checkIn, $checkOut, $checkOut, $checkIn, $checkOut, $country);
		if(!empty($cityId)){
			$query .= 'and a.mst003_id = ? ';
			array_push($params, $city);
		}

		//And b.line_number = 1
		$query .= '
				/*and a.num_adults >= 0
				and a.allotment >= 0
				and a.from_date >= ?
				and a.end_date >= ?
				group by a.id*/

				';

		// array_push($params, '$checkIn', '$checkOut');
		// DB::connection()->enableQueryLog();
		$result = DB::select($query, $params);
		return $result;
	}

	//untuk load kota di halaman search data hotel
	public function postCityFromCountry(Request $request){
        // print_r(Input::all());
        if($request->country){
        	$countryDetail = Country::where('id', '=', $request->country)->first();
            $cities = City::where('mst002_id', '=', $countryDetail->id)->orderBy('city_code')->get();
            return $cities;
        } 

        return json_encode(array());
    }


    //BAGIAN PERINCIAN HOTEL DETAIL DISINI
    public function getHotelDetail(Request $request){
    	
		//  cara mendapatkan relationship dengan filter query detail ya seperti ini.
	    // 	$rooms = HotelRoom::with(array('roomRates'=>function($query){
	    // 				$query->where('daily_price', '=', 200000);
					// }))
	    // 			->where('mst020_id', '=', '0597bfb1-8f57-459d-af6e-d653775a0a73')
	    // 			->get();

    	$hotel = HotelDetail::find('0597bfb1-8f57-459d-af6e-d653775a0a73');
    	$pictures = HotelPicture::where('mst020_id', '=', $hotel->id)->get();
    	
    	$query = "
    		select d.room_name, c.num_adults, c.num_child, c.num_breakfast, 
			  min(c.allotment - c.used_allotment) as allotment,
			  sum(c.nett_value) as tot_net_value
			from MST022 c 
			inner join MST023 d on d.id = c.mst023_id
			where  c.num_adults >= 0 
			  and c.allotment - c.used_allotment >= 0 
			  and 
			  (
			    c.from_date >= STR_TO_DATE('01/12/2016', '%m/%d/%Y') 
			    or 
			    c.end_date >= STR_TO_DATE('01/12/2016', '%m/%d/%Y')
			  )

			  and 
			  (
			    c.end_date <= STR_TO_DATE('02/13/2016', '%m/%d/%Y') 
			    or 
			    c.from_date <= STR_TO_DATE('02/13/2016', '%m/%d/%Y')
			  )

			  and STR_TO_DATE('01/12/2016', '%m/%d/%Y') >= 
			  (
			    select min(ab.from_date) from mst022 ab where ab.mst020_id = c.mst020_id
			  )

			  and STR_TO_DATE('02/13/2016', '%m/%d/%Y') <= 
			  (
			    select max(ac.end_date) from mst022 ac where ac.mst020_id = c.mst020_id
			  )
			group by d.room_name
    	";


    	$params = array();
    	$result = DB::select($query, $params);
    	$rooms = HotelRoom::join('MST022', 'MST023.id', '=', 'MST022.mst023_id')
					->where('MST022.mst020_id', '=', $hotel->id)
					->where('MST022.from_date', '>=', '2016-01-11')
					->where('MST022.end_date', '<=', '2016-01-12')
					->get();

    	return view('agent.hotel.agent-hotel-detail')
    		->with('hotel', $hotel)
    		->with('pictures', $pictures)
    		->with('rooms', $rooms);
    	
    }

    public function getTrialDate(){
    	$begin = new DateTime( '2015-12-31' );
		$end = new DateTime( '2016-01-09' );

		$test = new DateTime('2016-01-05');
		$test2 = new DateTime('2016-01-10');

		$price1 = 100000;
		$price2 = 120000;

		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);

		$datetime1 = new DateTime('2009-10-11');
		$datetime2 = new DateTime('2009-10-11');
		// $interval = $datetime1->diff($datetime2);
		// print_r($interval->days);
		// echo '<br>';
		$var = $test;
		$price = $price1;
		foreach ( $period as $dt ){
			$duck = $dt->format( "Y-m-d" );
			$interval = $dt->diff($var);
			echo $duck;
			echo ' | ';
			echo $interval->days;
			echo ' | ';
			echo number_format($price, 0, '.', ',');
			echo '<br>';
			if($interval->days == 0)  {
				$var = $test2;
				$price = $price2;
			}
		}
    }

}
