<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        $indonesia = Country::where('country_name', '=', 'Indonesia')->first();
        $countries = Country::lists('country_name', 'id');
        return view('auth.register')->with('countries', $countries)
        ->with('indonesia', $indonesia->id);
        //echo "<pre>";
        //print_r($countries->toArray());
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        Auth::login($this->create($request->all()));

        return redirect($this->redirectPath());
    }
}
