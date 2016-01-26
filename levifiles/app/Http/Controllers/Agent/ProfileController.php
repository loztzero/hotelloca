<?php namespace App\Http\Controllers\Agent;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash;
use App;
use App\User;
use App\Libraries\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Agent;
class ProfileController extends Controller {

	public function getIndex(){
    	$profile = Agent::where('mst001_id', '=', Auth::user()->id)->first();
    	return view('agent.profile.agent-profile')->with('profile', $profile);
    }

    public function postSave(Request $request){

    	$agent = new Agent();
        $errorBag = $agent->rules($request->all());

        try {

            if(count($errorBag) > 0){
                Session::flash('error', $errorBag);
                return redirect('agent/profile')->withInput($request->all());
            } else {

                if(isset($request->id)){
                    $agent = Agent::find($request->id);
                    $agent = $agent->doParams($agent, $request->all());
                    $agent->save();
                } else {

                    Session::flash('error', array('Data agent is not valid'));
                    return Redirect::to('agent/profile');
                }

            }
            
        } catch (Exception $e) {
            DB::rollback();         
            Session::flash('error', array($e->getMessage()));
            return Redirect::to('agent/profile')->withInput(Input::all());
        }

        Session::flash('message', array('Profile successfully updated'));
        return Redirect::to('agent/profile');

    }

}
