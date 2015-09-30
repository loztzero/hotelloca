<?php namespace App\Http\Controllers;

use Illuminate\Routing\UrlGenerator;
class AngularController extends Controller {

	public function getIndex()
	{
		return view('angular.angular-test');
	}

}
