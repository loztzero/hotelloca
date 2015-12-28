<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Validator;
use App\Libraries\Helpers;
use App\Emodel;
class User extends Emodel implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'MST001';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	

	public static function rules($data)
	{
		$error = array();
		$rules = array(
			'email'      	=> 'required|email',
            'password'      => 'required|min:6',
            'repassword'    => 'required|same:password'
        );

		$messages = array(
            'password.required'		=> 'Password required',
            'password.min'			=> 'Password must at least :min character',
            'repassword.required'	=> 'Confirm password required',
            'repassword.same'		=> 'Confirm password must match with password',
			'email.required'		=> 'Email required'
		);
		
        $v = Validator::make($data, $rules, $messages);
        if($v->fails()){
    		$error = $v->errors()->all();
        }

		return $error;
	}
	

}
