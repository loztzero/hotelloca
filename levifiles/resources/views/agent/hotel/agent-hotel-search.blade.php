@extends('layouts.layout-agent')
@section('content')
<div class="row" ng-controller="MainCtrl">
	
	<div class="row">
		<div class="large-4 column">
			<div style="border:1px solid black">
				Provide Your Content Here
			</div>
		</div>
		<div class="large-8 column">
			@foreach($hotels as $hotel)
			<div class="panel" style="background-color:white;padding:10px;">
				<div class="row">
					<div class="large-3 column">
						<img src="{{ url('uploads/hotels/'.$hotel->id.'/'.$hotel->pict.'.jpg') }}" width="100%">
					</div>
					<div class="large-9 column">
						<div class="right" style="text-align:center;font-family:Arial, Helvetica, 'Sans-serif';">
							<b style="font-size:12px;">Rate Per Night</b><br>
							
							{{-- <a href="{{ url('hotel-agent/room?') }}hotel={{ $hotel->HOTEL_ID }}&checkIn={{ $checkIn }}&checkOut={{ $checkOut }}" class="button alert">
								<b style="font-size:1.2em;font-family: Arial 'San serif';">Rp. {{ $helpers::currencyFormat($hotel->LOW_PRICE * 2300) }}</b>
							</a> --}}
							<a class="button warning" style="padding:8px;border-radius:5px;margin-bottom:0px;"><b style="font-size:12px;font-family: Arial 'San serif';">Rp. {{ number_format($hotel->nett_value, 0, ',', '.') }}</b></a><br>
						</div>

						<a href="">
							<u><b style="font-size:18px;">{{ $hotel->hotel_name }}</b></u>
						</a><br>

						<div class="rateit" data-rateit-value="{{ $hotel->star }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>

						<p style="font-size:13px;">
							{{ $hotel->address }}
						</p>
						<p style="font-size:14px;height:90px;overflow-y:hidden;text-align:justify;">
							{{-- $hotel->DESCRIPTION --}}
							
							Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
						</p>
					</div>
					
				</div>
			</div>
			@endforeach
			@if(count($hotels) == 0)
			Data hotel tidak ditemukan silahkan mencoba lagi untuk kota atau negara lain.
			@endif
		</div>
	</div>
	
	
</div>
@stop

@section('script')
<script>
var app = angular.module("ui.boardingpassku", ['ngSanitize']);
app.controller("MainCtrl", function ($scope, $http, $filter) {

	$scope.cities = {};
	$scope.loading = false;
	// $scope.cities.test = 'zz';
	// console.log($scope.cities);
	$scope.getCity = function(){
		$scope.loading = true;
		$http.get("{{App::make('url')->to('/hotel/cities')}}/" + $scope.field.country).success(function(response) {

			// try {
		 //        JSON.parse(response);
		 //        var value = response.replace(/['"]+/g, '');
		 //        $scope.cities = {value};
		 //    } catch (e) {
		 //    	console.log(e);
		        $scope.cities = response;
		 //    }

			 $scope.cities = response;
			 $scope.field.city = '';
			 $scope.loading = false;

		})
	};

});
</script>
@stop