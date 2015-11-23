<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Country;
use App\Models\Agent;
use Session, Form, Hash, DB;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers;
    protected $redirectPath = '/'; //kalau tidak di handle .. ntar pulang nya pasti selalu ke home .. huff dasar aneh 

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:mst001,email',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            // 'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
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

    public function getSuccessRegister(){
        return view('auth/success-register');
    }
}
