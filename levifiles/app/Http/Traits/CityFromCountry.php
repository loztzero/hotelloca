<?php

namespace App\Http\Traits;
use App\Models\Country;
use App\Models\City;
use Illuminate\Http\Request;

//digunakan di tempat yg mumbutuhkan
trait CityFromCountry
{
    public function postCityFromCountry(Request $request){
        // print_r(Input::all());
        if($request->country){
            $countryDetail = Country::where('id', '=', $request->country)->first();
            $cities = City::where('mst002_id', '=', $countryDetail->id)->orderBy('city_code')->get();
            return $cities;
        }

        return json_encode(array());
    }

}
