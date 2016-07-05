<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libraries\Helpers;
use Input, Request;
use App\Emodel;
use Validator;
use App\User;
use App\Config;
class Notification extends Emodel {
	protected $table = 'LOG040';

	protected $fillable = [
        'order_no', 'order_date', 'transfer_date',
        'payment_val', 'read_flag', 'note'
    ];

	protected $hidden = [
        'created_at', 'updated_at'
    ];

}
