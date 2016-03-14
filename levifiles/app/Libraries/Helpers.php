<?php namespace App\Libraries;

use DB, DateTime, DatePeriod, DateInterval, StdClass;
class Helpers { 

	public static function mysqlID(){
		$results = DB::select('select uuid() as z from dual ');
		return $results[0]->z;
	}

	public static function xmlToJson($url) {
		$url = str_replace(' ', '%20', $url);
		$fileContents= file_get_contents($url);
		$fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
		$fileContents = trim(str_replace('"', "'", $fileContents));
		$simpleXml = simplexml_load_string($fileContents);
		$json = json_encode($simpleXml);

		return $json;
	} 

	/**
	parameter stringDate wajib menggunakan format ddmmyy
	Format Tanggal menyesuaikan dengan tanggal di db mysql yymmdd
	jika digunakan lagi maka akan kembali ke format ddmmyy
	*/
	public static function dateFormatter($stringDate){
		$parseTgl = explode('-', $stringDate);
		return $parseTgl[2].'-'.$parseTgl[1].'-'.$parseTgl[0];
	}

	//hanya menerima data dengan format date time dari mysql
	public static function dateFormatterMysql($mysqlDate)
	{
		return date("d M Y", strtotime($mysqlDate));
	}

	public static function currencyFormat($rate){
		return number_format($rate, 0 , '' , ',' );
	}

	//format must Y-m-d
	public static function isDate1BetweenDate2AndDate3($date1, $date2, $date3){
		return ((strtotime($date1) >= strtotime($date2)) && (strtotime($date1) <= strtotime($date3)));
	}

	//mengembalikan list tanggal antara 2 buah tanggal
	/**
	return period and count day object
	format date yang dikirim dd-mm-yyyy

	return periodList in objectList
	and countDay in integer
	**/
	public static function getDateListBetweenTwoDates($date1, $date2){

		$date1 = self::dateFormatter($date1);
		$date2 = self::dateFormatter($date2);

		$date1Obj = new DateTime($date1);
    	$date2Obj = new DateTime($date2);
    	$period = new DatePeriod(
		     $date1Obj,
		     new DateInterval('P1D'),
		     $date2Obj
		);

    	$countDay = $date2Obj->diff($date1Obj)->format("%a");

		$returnObj = new StdClass();
		$returnObj->periodList = $period;
		$returnObj->countDay = $countDay;

		return $returnObj;
	}


} 

?>