<?php namespace App\Http\Controllers\Register;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash, Form;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, StdClass;
use App\Models\Country;
use App\Models\City;
use App\Models\Currency;
use App\Models\HotelDetail;
use App\Http\Controllers\Controller;
class AgentController extends Controller {

	public function getIndex()
    {
        $indonesia = Country::where('country_name', '=', 'Indonesia')->first();
        $countries = Country::lists('country_name', 'id');
        return view('register.agent.register-agent')->with('countries', $countries)
        ->with('indonesia', $indonesia->id);
        //echo "<pre>";
        //print_r($countries->toArray());
    }

	public function getSuccess(){
		return view('register.agent.register-agent-success');
	}

	public function postSave(Request $request)
    {
        $agent = new Agent();
        $errorBag = $agent->rules($request->all());
        if(count($errorBag) > 0){
            Session::flash('error', $errorBag);
            return redirect('auth/register')->withInput($request->all());
        } else {

            DB::beginTransaction();

            try {
                
                $user = new User();
                $user->email = $request->email;
                $user->password = Hash::make(str_random(6));
                $user->role = config('enums.role.Agent');
                $user->save();

                $agent = $agent->doParams($agent, $request->all());
                $agent->user_id = $user->id;
                $agent->save();
                DB::commit();

                return redirect('auth/success-register');


            } catch (Exception $e) {

                DB::rollback();
                Session::flash('error', array('error' => $e));
                return redirect('auth/register')->withInput($request->all());
            }

            
        }
        
    }

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
