<?php namespace App\Http\Controllers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash, Socialize;
use App;
use App\User;
class FacebookController extends Controller {

	public function facebook(){
		return Socialize::with('facebook')->redirect();
	}

	public function callback(){
		$user = Socialize::with('facebook')->user();
		print_r($user);
	}

}
