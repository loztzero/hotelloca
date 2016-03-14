<?php namespace App\Http\Controllers\Admin;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash, Form;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, Config;
use App\Models\balanceOrderBooking;
use App\Models\Currency;
use App\Http\Controllers\Controller;
class AgentDepositController extends Controller {

	public function getIndex(Request $request)
	{
		return view('admin.agentdeposit.admin-agent-deposit-browse');
			// ->with('depostiAgentList', $depositAgentList);
	}

	public function getInput()
	{
		$currencies = Currency::where('curr_code', Config::get('enums.rupiah'))->lists('curr_code', 'id');
		return view('admin.agentdeposit.admin-agent-deposit-input')->with('currencies', $currencies);
	}

	

}
