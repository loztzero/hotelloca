<?php namespace App\Http\Controllers\Register;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash, Form, Mail;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, StdClass;
use App\Models\Country;
use App\Models\City;
use App\Models\Currency;
use App\Models\HotelDetail;
use App\Http\Controllers\Controller;
use App\Models\Agent;
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
            return redirect('register/agent')->withInput($request->all());
        } else {

            DB::beginTransaction();

            try {

                // $user = new User();
                // $user->email = $request->email;
                // $user->password = Hash::make(str_random(6));
                // $user->role = config('enums.role.Agent');
                // $user->save();

				$newPassword = str_random(6);
                $activatedLink = Hash::make(str_random(10));

				$user = new User();
                $user->email = $request->email;
				$user->password = Hash::make($newPassword);
                $user->role = config('enums.role.Agent');
				$user->activation_key = $activatedLink;
                $user->save();

                $agent = $agent->doParams($agent, $request->all());
                $agent->mst001_id = $user->id;
                $agent->save();

				Mail::send('register.agent.register-agent-email',
                    array('username' => $request->email, 'newPassword' => $newPassword, 'activatedLink' => $activatedLink),
                    function($message) use ($user, $request) {
                    $message->to($request->email, $request->email)->subject('Your Email Activation');
                });
                DB::commit();

                return redirect('register/agent/success');


            } catch (Exception $e) {

                DB::rollback();
                Session::flash('error', array('error' => $e));
                return redirect('register/agent')->withInput($request->all());
            }


        }

    }

	public function getActivation(Request $request){
		if($request->has('key')){
			$key = $request->key;
			$existsKey = User::where('activation_key', '=', $key)->first();
			if($existsKey){
				$agent = Agent::where('mst001_id', '=', $existsKey->id)->first();
				if($agent->active_flg != 'Active'){
					$agent->active_flg = 'Active';
					$agent->save();
					//return redirect('register/agent/activation')
					return view('register.agent.register-agent-activation')->with('message', 'Your email successfully activated');
				}
			}
		}

		return view('register.agent.register-agent-activation')->with('message', 'The link is not valid or the activation is not valid anymore');
		// return redirect('register/agent/activation')
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
