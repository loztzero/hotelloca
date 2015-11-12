<?php namespace App\Libraries;

use DB;
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


} 

?>