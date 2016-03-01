<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Input;
use App\Emodel;
use Validator;
use App\User;
use App\Config;
class PaymentConfirmation extends Emodel {
	protected $table = 'TRX001';

	public static function rules($data){
		$error = array();
		$rules = array(
            'order_no'        => 'required',
            // 'order_date'      => 'required',
            'email'      	  => 'required|email',
            'transfer_to'     => 'required',
            'payment_val'     => 'required|numeric',
            'transfer_date'   => 'required',
            'bank_transfer'   => 'required',
            'account_transfer' => 'required',
            'name'             => 'required',
        );

		$messages = array(
            'order_no.required'		    => 'Order number must be filled',
            // 'order_date.required'		=> 'Address must be filled',
            'email.required'			=> 'Email must be filled',
            'email.email'               => 'Please use the correct email format',
            'transfer_to.required'		=> 'Transfer to must be selected',
            'payment_val.required'		=> 'City must be selected',
            'transfer_date.required'	=> 'Phone number must be filled',
            'bank_transfer.required'	=> 'Email must be filled',
            'account_transfer.required'	=> 'Email must valid',
            'name.required'             => 'Email must valid',
		);
		
        $v = Validator::make($data, $rules, $messages);
        if($v->fails()){
    		$error = $v->errors()->all();
        }

        // $email = isset($data['email']) ? $data['email'] : null;
        // $user = User::where('email', '=', $email)->first();
        // if($user != null){
        // 	$error = array_add($error, 'ada_bk', 'Email '.$email. ' already registered');
        // }

		return $error;
	}

	public function doParams($model, $data)
	{
		$model->order_no            = isset($data['order_no']) ? $data['order_no'] : null;
        $model->order_date          = isset($data['order_date']) ? $data['order_date'] : null;
        $model->email               = isset($data['email']) ? $data['email'] : null;
        $model->transfer_to         = isset($data['transfer_to']) ? $data['transfer_to'] : null;
        $model->payment_val         = isset($data['payment_val']) ? $data['payment_val'] : null;
        $model->transfer_date       = isset($data['transfer_date']) ? $data['transfer_date'] : null;
        $model->bank_transfer       = isset($data['bank_transfer']) ? $data['bank_transfer'] : null;
        $model->account_transfer    = isset($data['account_transfer']) ? $data['account_transfer'] : null;
        $model->name                = isset($data['name']) ? $data['name'] : null;
        $model->note                = isset($data['note']) ? $data['note'] : null;
        return $model;
	}

}