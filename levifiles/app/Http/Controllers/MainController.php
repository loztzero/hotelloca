<?php namespace App\Http\Controllers;

use Illuminate\Routing\UrlGenerator;
use Input, Auth, Request, Session, Redirect, Hash;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, StdClass;
use App\Models\Country;
class MainController extends Controller {

	public function getIndex()
	{
		//return view('auth.login');
		//return redirect('/auth/login');
		if(Session::has('errors')){
	        Session::flash('error', Session::get('errors'));
	        return redirect('auth/login')->with('errors', Session::get('error'));
	    }
		return view('main.main-page');
	}

	public function getTest(){
		echo "\x61\x6c\x66\x69\x40\x61\x6c\x65\x78\x69\x73\x2e\x69\x64";
	}

	public function getCompanyProfile()
	{
		return view('main.main-company-profile');
	}

	public function getServices()
	{
		return view('main.main-services');
	}

	public function getContactUs()
	{
		return view('main.main-contact-us');
	}

	public function getTermAndCondition()
	{
		return view('main.main-toc');
	}

}
