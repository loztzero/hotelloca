<?php namespace App\Http\Middleware;

use Closure, Auth;
use Illuminate\Contracts\Auth\Guard;

class RedirectByRole {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */

	public function handle($request, Closure $next, $role)
	{
		if(Auth::user()->role == $role){
			return $next($request);
		} else {
			return redirect('/');
		}
	}

}
