<?php namespace App\Http\Controllers\Admin;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash;
use App;
use App\User;
use App\Libraries\Helpers;
use App\Http\Controllers\Controller;
class ProfileController extends Controller {

	public function getIndex(){


		echo 'Hello go to booking hotel ';
		echo '<a href="booking">Klik Here</a>';
	}

}
