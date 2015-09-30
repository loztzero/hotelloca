<?php namespace App\Http\Controllers;

use Illuminate\Routing\UrlGenerator;
use Input, Request, Uuid, Hash, Auth, Redirect, Session;
use App\User;
use App\Models\UserDetail;
use App\Models\Passenger;
use App\Libraries\Helpers;
class Usercontroller extends Controller {

	public function getIndex()
	{
		$userDetail = UserDetail::where('mst001_id', '=', Auth::user()->id)->first();
		return view('user.user-browse', array('page' => 'user'))->with('userDetail', $userDetail);
	}

	public function getPassengerList()
	{

		$passengers = Passenger::where('mst001_id', '=', Auth::user()->id)->orderBy('first_name', 'ASC')->get()->toJson();
		return view('user.user-detail', array('page' => 'detail'))->with('passengers', $passengers);
	}

	public function postSaveDetailUser(){

		$data = Input::all();
		$userDetail = new UserDetail();
		if(isset($data['id']) && $data['id'] != null && $data['id'] != '' ){

			$userDetail = UserDetail::find($data['id']);

			if($userDetail == null){
				Session::flash('error', 'Maaf Data user tidak ditemukan.. silahkan reload halaman ini.');
				return Redirect::to('user'); 				
			}

			$userDetail = $userDetail->doParams($userDetail, $data);
			$userDetail->save();


			Session::flash('message', 'Data anda berhasil di modifikasi');
			return Redirect::to('user')->with('userDetail', $userDetail); 

		} else {
			$userDetail = $userDetail->doParams($userDetail, $data);
			$userDetail->mst001_id = Auth::user()->id;
			//$userDetail->id = 'kambing';
			$userDetail->save();

			Session::flash('message', 'Data anda berhasil di input');
			return Redirect::to('user')->with('userDetail', $userDetail); 
		}

	}

	public function postSavePassenger(){

		$data = Input::all();
		$passenger = new Passenger();
		if(isset($data['id'])  && $data['id'] != null && $data['id'] != '' ){

			$passenger = Passenger::find($data['id']);

			if($passenger == null){
				Session::flash('error', 'Maaf Data user tidak ditemukan..'.$data['id'].' silahkan reload halaman ini.');
				return Redirect::to('user/passenger-list'); 				
			}

			$passenger = $passenger->doParams($passenger, $data);
			$passenger->save();


			Session::flash('message', 'Data anda berhasil di modifikasi');
			return Redirect::to('user/passenger-list');//->with('passen', $userDetail); 

		} else {
			$passenger = $passenger->doParams($passenger, $data);
			$passenger->mst001_id = Auth::user()->id;
			$passenger->line_number = $passenger->getMaxLineNumber($passenger->mst001_id);
			$passenger->save();

			Session::flash('message', 'Data anda berhasil di input');
			return Redirect::to('user/passenger-list'); //->with('userDetail', $userDetail); 
		}

	}

	public function postDeletePassenger(){
        $data = Input::all();
        if(isset($data['ID'])){
            $trans = Passenger::find($data['ID']);
            if($trans != null){
                $trans->delete();
                Session::flash('message', 'Data berhasil di hapus');
            } else {
                Session::flash('error', 'Tidak ada data yang dapat di hapus');
            }
            
        } else {
            Session::flash('error', 'Maaf permintaan anda tidak dapat di proses, silahkan dicoba kembali');
        }
        return Redirect::to('user/passenger-list');
	}

	public function getTrial(){
		$passenger = new Passenger();
		print_r($passenger->getMaxLineNumber('7f76ada7-2d0e-451f-a7dc-8a24fec34171'));
	}

	public function getTampil(){
		//Helpers::mysqlID();

		$uuid = Uuid::generate(4);
		echo $uuid;
	}


}
