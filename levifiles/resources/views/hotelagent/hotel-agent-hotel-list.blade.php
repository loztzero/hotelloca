@extends('layouts.foundation-login')
@section('content')
<div class="row" ng-controller="MainCtrl">
	
	<div class="panel" style="background-color:white;">
		<div class="row">
			<div class="large-3 column">
				<img src="http://www.travelmart.com.cn//images/hotel/pic1/140324212020200755538.jpg" width="100%">
			</div>
			<div class="large-6 column">
				<a href="">
				<b style="font-size:18px;">Ayana Resort & Spa Bali - 5 Star</b>
				</a>

				<p style="font-size:13px;">
					Jl. Kartika Plaza 92, Kuta, Badung
				</p>
				<p style="font-size:14px;height:90px;overflow-y:hidden;text-align:justify;">
					Temukan penginapan nyaman dan terjangkau di jantung keramaian Kuta bersama Grand Ixora Kuta Resort. Hotel bintang 4 bergaya tropis ini terletak sekitar 15 menit berkendara dari Bandara Internasional Ngurah Rai, sehingga menjadi pilihan ideal untuk anda yang melakukan perjalanan wisata maupun bisnis. Setiap kamar didesain sedemikian rupa untuk kenyamanan anda beristirahat dan telah dilengkapi peralatan mandi, TV, mini bar serta jaringan internet nirkabel gratis. Grand Ixora Kura Resort juga memiliki akses mudah ke berbagai pusat hiburan di sekitar Kuta seperti Discovery Mall (10 menit berjalan kaki) maupun Waterboom dan Sirkus Water Park (15 menit berjalan kaki). Pantai Kuta bisa ditempuh dalam waktu 10 menit berjalan kaki.
				</p>
			</div>
			<div class="large-3 column">
				Harga Permalam<br>
				<button class="button alert">
					<b style="font-size:1.1em;font-family: Arial 'San serif';">Rp. 100,000,000</b>
				</button>
			</div>
		</div>
	</div>

	@if($hotels)
		@foreach($hotels as $hotel)
			<div class="panel" style="background-color:white;">
				<div class="row">
					<div class="large-3 column">
						<img src="http://www.travelmart.com.cn/{{ $hotel->PICTURE_PATH }}" width="100%">
					</div>
					<div class="large-6 column">
						<a href="">
						<b style="font-size:18px;">{{ $hotel->HOTEL_NAME }} - {{ $hotel->STAR }} Star</b>
						</a>

						<p style="font-size:13px;">
							{{ $hotel->ADDRESS }}
						</p>
						<p style="font-size:14px;height:90px;overflow-y:hidden;text-align:justify;">
							{{ $hotel->DESCRIPTION }}
						</p>
					</div>
					<div class="large-3 column">
						Harga Permalam<br>
						<a href="{{ url('hotel-agent/room?') }}hotel={{ $hotel->HOTEL_ID }}&checkIn={{ $checkIn }}&checkOut={{ $checkOut }}" class="button alert">
							<b style="font-size:1.2em;font-family: Arial 'San serif';">Rp. {{ $helpers::currencyFormat($hotel->LOW_PRICE * 2300) }}</b>
						</a>
					</div>
				</div>
			</div>
		@endforeach
	@endif

	<div class="large-12 column paging">
		@if(count($hotels) > 0)
		{!! $hotels->appends(Request::only('city', 'checkIn', 'checkOut'))->render() !!}
		@endif
	</div>
</div>

@stop

@section('script')
<script>
var app = angular.module("ui.hotelloca", []);
app.controller("MainCtrl", function ($scope, $http, $filter) {


});
</script>
@stop