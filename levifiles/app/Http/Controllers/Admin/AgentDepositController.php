<?php namespace App\Http\Controllers\Admin;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Input, Auth, Session, Redirect, Hash, Form;
use App;
use App\User;
use App\Libraries\Helpers;
use DB, Config;
use App\Models\BalanceOrderBooking;
use App\Models\Currency;
use App\Models\Agent;
use App\Models\BalanceAgentDeposit;
use App\Models\LogDeposit;
use App\Http\Controllers\Controller;
class AgentDepositController extends Controller {

	public function getIndex(Request $request)
	{

		$query = Agent::from('MST010 as a')
				->join('MST001 as b', 'b.id', '=', 'a.mst001_id')
				->leftJoin('BLNC020 as c', 'c.mst001_id', '=', 'a.mst001_id')
				->leftJoin('MST004 as d', 'd.id', '=', 'c.mst004_id');

		if($request->has('email')){
			$query = $query->where('b.email', '=', $request->email);
		}

		$result = $query->select('a.comp_name', 'b.email', 'd.curr_code',
					DB::raw('COALESCE(c.deposit_value,0) as deposit_value,
					COALESCE(c.used_value,0) as used_value,
					COALESCE(c.deposit_value-c.used_value,0) as remain_value'))
				->get();

		return view('admin.agentdeposit.admin-agent-deposit-browse')->with('deposits', $result);
			// ->with('depostiAgentList', $depositAgentList);
	}

	public function getInput()
	{
		$currencies = Currency::where('curr_code', Config::get('enums.rupiah'))->lists('curr_code', 'id');
		return view('admin.agentdeposit.admin-agent-deposit-input')->with('currencies', $currencies);
	}

	public function postLoadData(Request $request){

		if($request->has('email')){
			$user = User::where('email', '=', $request->email)->first();
			if($user){
				$data = BalanceAgentDeposit::where('mst001_id', '=', $user->id)->first();
				if($data){
					$returnValue = array();
					$returnValue['email'] = $data->user->email;
					$returnValue['deposit_value'] = 0;
					$returnValue['old_deposit_value'] = $data->deposit_value;
					$returnValue['used_value'] = $data->used_value;
					return Redirect::to('admin/agent-deposit/input')->withInput($returnValue);
				} else {
					$returnValue = array();
					$returnValue['email'] = $user->email;
					return Redirect::to('admin/agent-deposit/input')->withInput($returnValue);
				}
			}
		}

		Session::flash('error', array('Data agent nya tidak valid'));
		return Redirect::to('admin/agent-deposit');

	}

	public function postSave(Request $request)
	{
		$data = $request->all();
		if($request->has('email')){
			$user = User::where('email', '=', $data['email'])->where('role', '=', 'Agent')->first();
			if(!$user){
				Session::flash('error', array('This agent email does not valid in our system'));
				return Redirect::to('admin/agent-deposit/input')->withInput(Input::all());
			} else {
				$data['mst001_id'] = $user->id;
			}
		}

		$deposit = new BalanceAgentDeposit();
		$existsDeposit = BalanceAgentDeposit::where('mst001_id', '=', $data['mst001_id'])->first();
		if($existsDeposit){
			$deposit = $existsDeposit;
		}
		$errorBag = $deposit->rules($data);

		if(count($errorBag) > 0){
			Session::flash('error', $errorBag);
			return Redirect::to('admin/agent-deposit/input')->withInput(Input::all());
		}

		DB::beginTransaction();
		try {

			$deposit->doParams($deposit, $data);
			$deposit->save();

			$log = new LogDeposit();
			$log->mst001_id = $data['mst001_id'];
			$log->type = 'Add';
			$log->log_no = 'add'.date('Ymd').$log->getMaxCounter();;
			$log->log_yrmo = date('Ym');
			$log->log_date = date('Y-m-d');
			$log->deposit_value = $data['deposit_value'];
			$log->save();

		} catch (\Exception $e) {
			DB::rollBack();
			Session::flash('error', array($e->getMessage()));
			return Redirect::to('admin/agent-deposit/input')->withInput(Input::all());
		}
		DB::commit();

		$returnValue = array();
		$returnValue['email'] = $data['email'];
		$returnValue['deposit_value'] = 0;
		$returnValue['old_deposit_value'] = $deposit->deposit_value;
		$returnValue['used_value'] = $deposit->used_value;

		Session::flash('message', array('save data success'));
		return Redirect::to('admin/agent-deposit/input')->withInput($returnValue);
	}



}
