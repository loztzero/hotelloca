<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libraries\Helpers;
use Input, Request;
use App\Emodel;
use Validator;
use App\User;
use App\Config;
class PaymentConfirmation extends Emodel {
	protected $table = 'TRX001';

	public static function rules($request){
		$error = array();
		$rules = array(
            'order_no'        => 'required',
            // 'order_date'      => 'required',
            'email'      	  => 'required|email',
            'transfer_to'     => 'required',
            'payment_val'     => 'required|numeric|min:1',
            'transfer_date'   => 'required|date_format:d-m-Y',
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
			'payment_val.numeric'		=> 'Payment value must be numeric',
			'payment_val.min'			=> 'Payment value must be greater than 0',
            'transfer_date.required'	=> 'Transfer date must be filled',
            'bank_transfer.required'	=> 'Bank transfer from is required',
            'account_transfer.required'	=> 'Account transfer is requireds',
            'name.required'             => 'Name is required',
		);

        $v = Validator::make($request->all(), $rules, $messages);
        if($v->fails()){
    		$error = $v->errors()->all();
        } else {
			$exists = PaymentConfirmation::where('order_no', '=', $request->order_no)->first();
			if($exists){
				$error = array_add($error, 'ada_bk', 'Confirmation payment with this order number already exists in our system.');
			}
		}

        // $email = isset($data['email']) ? $data['email'] : null;
        // $user = User::where('email', '=', $email)->first();
        // if($user != null){
        // 	$error = array_add($error, 'ada_bk', 'Email '.$email. ' already registered');
        // }

		return $error;
	}

	public function doParams($model, $request)
	{
		$model->order_no            = $request->order_no;
        $model->order_date          = $request->order_date;
        $model->email               = $request->email;
        $model->transfer_to         = $request->transfer_to;
        $model->payment_val         = $request->payment_val;
        $model->transfer_date       = Helpers::dateFormatter($request->transfer_date);
        $model->bank_transfer       = $request->bank_transfer;
        $model->account_transfer    = $request->account_transfer;
        $model->name                = $request->name;
        $model->note                = $request->input('note', null);
        return $model;
	}

}
