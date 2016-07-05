<?php namespace App\Http\Controllers;

use Illuminate\Routing\UrlGenerator;
use Input, Auth, Request, Session, Redirect, Hash;
use App, Log;
use App\User;
use App\Libraries\Helpers;
use DB, StdClass;
use App\Models\Country;
use App\Jobs\SendCancellationEmail;
use Illuminate\Foundation\Bus\DispatchesJobs;
class CronJobController extends Controller {

	use DispatchesJobs;

	public function logInfo(){
		date_default_timezone_set('Asia/Jakarta');

		// DB::insert('INSERT INTO LOG020
		// 	(id, mst023_id, check_in_date, allotment,
		// 		used_allotment, updated_at, created_at)
		// 	SELECT
		// 		A.ID, B.mst023_id, A.check_in_date,
		// 		D.allotment, B.room_num * -1, NOW(), NOW()
		// 	FROM BLNC004 A
		// 		INNER JOIN BLNC002 B ON B.id = A.blnc002_id
		// 		INNER JOIN BLNC001 C ON C.id = B.blnc001_id
		// 		INNER JOIN BLNC003 E ON E.blnc001_id = C.id
		// 		INNER JOIN MST022 D ON D.mst023_id = B.mst023_id
		// 			AND A.check_in_date BETWEEN D.from_date AND D.end_date
		// 	WHERE DATE_ADD(E.created_at,INTERVAL 1 HOUR) < NOW()
		// 		AND E.conf_payment_date is null
		// 		AND E.payment_method = ? ', ['Transfer']);
		//
		// DB::update('UPDATE BLNC001 SET status_flag = ?,status_pymnt = ?
		// 	WHERE
		// 	EXISTS (SELECT 1 FROM BLNC003 A WHERE A.blnc001_id = BLNC001.id
		// 	AND A.payment_method = ?
		// 	AND A.conf_payment_date is null
		// 	AND DATE_ADD(A.created_at, INTERVAL 1 HOUR) < NOW())', ['Cancel', 'Failed', 'Transfer']);
		//
		// $datas = DB::select('SELECT
		// 	F.email
		// FROM BLNC004 A
		// 	INNER JOIN BLNC002 B ON B.id = A.blnc002_id
		// 	INNER JOIN BLNC001 C ON C.id = B.blnc001_id
		// 	INNER JOIN MST001 F ON C.MST001_ID = F.ID
		// 	INNER JOIN BLNC003 E ON E.blnc001_id = C.id
		// 	INNER JOIN MST022 D ON D.mst023_id = B.mst023_id
		// 		AND A.check_in_date BETWEEN D.from_date AND D.end_date
		// WHERE DATE_ADD(E.created_at,INTERVAL 1 HOUR) < NOW()
		// 	AND E.conf_payment_date is null
		// 	AND E.payment_method = ? ', ['Transfer']);

		$result = DB::select('select now() as waktu from dual');
		// if(count($datas) > 0){
		//
		// 	foreach($datas as $data){
		// 		Log::info('queue email to ' . $data->email . ' at ' . $result[0]->waktu);
		// 	}
		//
		// } else {
		Log::info('Mix Cron Job With Schedule on same Time ' . $result[0]->waktu);
		// }

		// for($i = 50; $i < 60 ; $i++) {
		// 	echo $i.'<br>';
		// 	$job = new SendCancellationEmail($i);
		// 	$this->dispatch($job);
		// }



		// echo '<pre>';
		// print_r(exec('php -c php.ini'));

		// Log::info('Try Cron Job on ' . date('d-m-Y h:i:sa'));

	}

}
