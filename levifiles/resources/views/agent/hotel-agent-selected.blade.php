@extends('layouts.frontangular')
@section('content')
<div class="row" ng-controller="MainCtrl">


@if(isset($hotels->Hotels))
	<?php $value = $hotels->Hotels ;?>
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">{{ $value->HotelName }} - {{ $value->Star }} Star</h3>
	  </div>
	  <div class="panel-body">

	  	<div class="galleria" id="galleria">
	  	@foreach($pictures->Hotel->Picture As $pic)
			@if(is_object($pic))
				@if(strlen($pic->{'0'}) > 10)
				<img src="http://www.travelmart.com.cn/{{ $pic->{'0'} }}" />
				@endif
			@else
			<img src="http://www.travelmart.com.cn/{{$pic}}" />
			@endif
		@endforeach
		</div>

		{{ $value->HotelID }} <br>
		<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
		{{ $value->Address }}
		<br><br>
	    <p>
		    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
		    {{ $value->HotelDesc }}
	    </p>
	  </div>
	</div>
@endif

<?php //$test = $pictures->Hotel->Picture->Pic2->{'0'};
//print_r(ord($test)) ;?> 
	
</div>
@stop

@section('script')
<script>
	// Galleria.loadTheme('{{App::make('url')->to('/assets/js/')}}/themes/classic/galleria.classic.min.js');
 //    Galleria.run('.galleria');
 $('#galleria').galleria({
 	imageCrop : 'landscape',
	width: 560,
	height: 420 //--I made heights match
	});
</script>
	
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