@extends('layouts.frontangular')
@section('content')
<div class="row" ng-controller="MainCtrl">

<form method="post" action="{{App::make('url')->to('/hotel/hotel-room')}}">
	<div class="form-group">
		<label class="control-label">Hotels</label>
		 <select class="form-control" name="hotel">
			@if(isset($hotels->Hotels))
				@foreach($hotels->Hotels As $key=>$value)
				<option value="{{$value->HotelID}}">{{ $value->HotelName }}</option>
				@endforeach
			@endif
		 </select>
	</div>

	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<button type="submit" class="btn btn-primary">Get Hotel Detail</button>
</form>


@if(isset($hotels->Hotels))

	@foreach($hotels->Hotels As $key=>$value)
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">{{ $value->HotelName }} - {{ $value->Star }} Star</h3>
	  </div>
	  <div class="panel-body">
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
	@endforeach
@endif

	
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